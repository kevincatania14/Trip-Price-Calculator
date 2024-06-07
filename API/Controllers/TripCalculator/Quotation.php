<?php 
    error_reporting(E_ALL & ~E_NOTICE);
    ini_set('display_errors', 1);
    require_once("../../BusinessLogic/BLL_Main.php");
    use BusinessLogic\General\BLL_Main;
    use Models\General\Error_VM;
    use Models\General\Quotation;
    use Models\General\Quotation_VM;

    if (isset($_POST['currency_id']) && isset($_POST['age']) && isset($_POST['start_date']) && isset($_POST['end_date'])) {
        $currency = $_POST['currency_id'];
        $age = $_POST['age'];
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];

        $ctrl = new Ctrl_Quotation($currency, $age, $startDate, $endDate); /* preparing data for quote */
        $err = $ctrl->getError(); /* retrieving any errors with data for quote */

        if(count($err) == 0) {
            $quoteId = $ctrl->Ctrl_CalculateQuote(); /* creating quote */
        
            if(isset($quoteId)) {
                $bll = new BLL_Main();
                $result = $bll->BLL_Select_AL_Quotation_ById($quoteId); /* retrieving quote */

                if(isset($result[0])) {
                    $quote = new Quotation_VM(); /* response body parameters */
                    $quote->total = $result[0]->total;
                    $quote->currency_id = $result[0]->currency;
                    $quote->quotation_id = $result[0]->id;
                    echo json_encode($quote);
                    http_response_code(200);
                    exit;
                }               
            }
        }
        else {
            $bll = new BLL_Main;
            $bll->BLL_Write_Log_File_Obj('error', json_encode($err));
            echo json_encode($err);
            http_response_code(400);
            exit;
        }
    }
    else {
        $error = new Exception();        
        echo json_encode($error->getMessage());
        return;
    }

    class Ctrl_Quotation {
        private $currency;
        private $age;
        private $startDate;
        private $endDate;
        private $error;
        private $bll;

        function getError() {
            return $this->error;
        }
                
        function __construct($currency, $age, $startDate, $endDate){
            $this->currency = $currency; /* e.g. EUR */
            $this->age = explode(',', trim($age, ",")); /* e.g. 25 or 25,35 + 25,35, */
            $this->startDate = $startDate; /* e.g. 2020-10-01 */
            $this->endDate = $endDate; /* e.g. 2020-10-30 */
            $this->error = [];
            $this->bll = new BLL_Main();
            $this->Validate();
        }

        /**
        * Calculates and creates a quotation
        *
        * @return int quotation id
        */
        function Ctrl_CalculateQuote() {
            try {
                $ageLoad = $this->bll->BLL_Select_AL_AgeLoad();

                $startDate = new DateTime($this->startDate);
                $endDate = new DateTime($this->endDate);
                $tripLength = $startDate->diff($endDate)->days+1;

                $loadValue = 0;
                $total = 0;
                $result = null;
                
                for($i = 0; $i <= count($this->age); $i++) { /* iterating age */
                    for ($j = 0; $j <= count($ageLoad); $j++) { /* iterating age load */
                        if($this->age[$i] >= $ageLoad[$j]->lowerAge && $this->age[$i] <= $ageLoad[$j]->upperAge) {
                            $loadValue = $ageLoad[$j]->loadValue; /* retrieving load value for age */
                        }
                    }

                    $total += 3 * $loadValue * $tripLength; /* calculating total for age */
                }

                if($total > 0) {
                    $result = $this->CreateQuote($this->currency, implode(',', $this->age), $startDate->format('Y-m-d'), $endDate->format('Y-m-d'), $total); /* creating quote for age */
                }
                
                return $result;
            }
            catch(Exception $e) {
                return $e->getMessage();
            }
        }

        /**
        * Creates a quotation
        *
        * @param string $currency e.g. EUR
        * @param array $age e.g. 25 or 25,35
        * @param date $startDate e.g. 2020-10-01
        * @param date $endDate e.g. 2020-10-30
        * @param double $total e.g. 117
        *
        * @return int quotation id
        */
        private function CreateQuote($currency, $age, $startDate, $endDate, $total) {
            $quote = new Quotation;
            $quote->total = $total;
            $quote->currency = $currency;
            $quote->age = $age;
            $quote->startDate = $startDate;
            $quote->endDate = $endDate;
            return $this->bll->BLL_Insert_AL_Quotation($quote);
        }

        private function Validate() {
            $this->ValidateAges();
            $this->ValidateDates();
        }

        /**
        * Validates ages
        */
        private function ValidateAges() {
            $invalidArr = [];
            $ageLoad = $this->bll->BLL_Select_AL_AgeLoad();
            $lowerAge = 0;
            $upperAge = 0;
            if (isset($ageLoad[0])) {
                $lowerAge = $ageLoad[0]->lowerAge; /* retrieving lower age e.g. 18 */
                $upperAge = $ageLoad[count($ageLoad)-1]->upperAge; /* retrieving upper age e.g. 70 */
            }

            for($i=0; $i<=count($this->age)-1; $i++) {
                if($this->age[$i] < $lowerAge || $this->age[$i] > $upperAge) {
                    array_push($invalidArr, $this->age[$i]); /* determining invalid age */
                }
            }

            if(count($invalidArr) > 0) {
                $err = new Error_VM('error', 'Ages ' . $lowerAge . '-' . $upperAge . ' supported, ages ' . implode(', ', $invalidArr) . ' not supported');
                array_push($this->error, $err);
            }
        }

        /**
        * Validates dates
        */
        private function ValidateDates() {
            if($this->startDate > $this->endDate) {
                $err = new Error_VM('error', 'Start date ' . $this->startDate . ' cannot be after end date ' . $this->endDate);
                array_push($this->error, $err);
            }
        }        
    }
?>