<?php namespace Mappers\General;
    require_once("../../Models/Model_Main.php");
    use Models\General\AgeLoad;
    use Models\General\Quotation;

    class Mapper_Main {
        #region Age Load
        function Map_AL_AgeLoad($rows) {
            $objArr= [];
            if(isset($rows)) {			
                foreach($rows as $row) {				
                    $obj = new AgeLoad();
                    $obj->id = $row['id'];
                    $obj->lowerAge = $row['lower_age']; 
                    $obj->upperAge = $row['upper_age']; 
                    $obj->loadValue = $row['load_value']; 
                    $obj->createdOn = $row['created_on']; 
                    $obj->validFrom = $row['valid_from']; 
                    $obj->validTo = $row['valid_to'];
                    $obj->isDeleted = $row['is_deleted']; 
                    array_push($objArr, $obj);
                }
            }
            return ($objArr);
        }
        #endregion

        #region Quotation
        function Map_AL_Quotation($rows) {
            $objArr= [];
            if(isset($rows)) {			
                foreach($rows as $row) {				
                    $obj = new Quotation();
                    $obj->id = $row['id'];
                    $obj->total = $row['total']; 
                    $obj->currency = $row['currency']; 
                    $obj->age = $row['age']; 
                    $obj->startDate = $row['start_date']; 
                    $obj->endDate = $row['end_date']; 
                    $obj->createdOn = $row['created_on'];
                    $obj->isDeleted = $row['is_deleted']; 
                    array_push($objArr, $obj);
                }
            }
            return ($objArr);
        }
        #endregion
    }
?>