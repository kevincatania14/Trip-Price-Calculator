<?php namespace Models\General;

    #region Age Load
    class AgeLoad {
        public $id;
        public $lowerAge;
        public $upperAge;
        public $loadValue;
        public $createdOn;
        public $validFrom;
        public $validTo;
        public $isDeleted;
    }    
    #endregion   

    #region Quotation
    class Quotation {
        public $id;
        public $total;
        public $currency;
        public $age;
        public $startDate;
        public $endDate;
        public $createdOn;
        public $isDeleted;
    }

    class Quotation_VM {
        public $total;
        public $currency_id;
        public $quotation_id;
    }
    #endregion

    #region Error
    class Error_VM {
        public $type;
        public $description;
        
        function __construct($type, $description) {    
            $this->type = $type;  
            $this->description = $description;
        }
    }
    #endregion

    #region Log
    class Log_VM {		
		public $type;
		public $description;
		public $time;
	}
    #endregion
?>