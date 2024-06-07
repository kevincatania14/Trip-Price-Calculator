<?php namespace DataAccess\General;
    require_once("../../config.php");
	use Models\General\Log_VM;
	use Models\General\Quotation;

    class DAL_Main extends DbConn {
        private $conn = null;

        function __construct() {
            $dbConn = new DbConn();
            $this->conn = $dbConn->getConn();
        }

		#region Insert
		function DAL_Insert_AL_Quotation(Quotation $obj) {
			$result = $this->conn->query("INSERT INTO `trip_calculator`.`quotation` (`total`, `currency`, `age`, `start_date`, `end_date`)
				VALUES ('$obj->total', '$obj->currency', '$obj->age', '$obj->startDate', '$obj->endDate');");

            if ($error = mysqli_error($this->conn)) {
				$this->DAL_Write_Log_File('error', 'DAL_Insert_AL_Quotation: ' . $error);
				return $error;
			}
			else {
				return $this->conn->insert_id;
			}
		}
		#endregion
		
		#region Select
		function DAL_Select_AL_AgeLoad() {
            $result = $this->conn->query("select *
				from trip_calculator.age_load
				where 1=1
				and valid_from <= NOW()
				and valid_to >= NOW()
				or valid_to is null
				and is_deleted = 0;");

            if ($error = mysqli_error($this->conn)) {
				$this->DAL_Write_Log_File('error', 'DAL_Select_AL_AgeLoad: ' . $error);
				return $error;
			}
            else if (isset($result) && isset($result->num_rows)) {
				$rows = [];

				if ($result->num_rows > 0) {					
					while ($row = $result->fetch_assoc()) {
						$rows[] = $row;
					}
				}

				return $rows;
			}
			else {
				return null;
			}
        }

		function DAL_Select_AL_Quotation_ById($id) {
            $result = $this->conn->query("select *
				from trip_calculator.quotation
				where 1=1
				and id = '$id'
				and is_deleted = 0;");

            if ($error = mysqli_error($this->conn)) {
				$this->DAL_Write_Log_File('error', 'DAL_Select_AL_Quotation_ById: ' . $error);
				return $error;
			}
            else if (isset($result) && isset($result->num_rows)) {
				$rows = [];

				if ($result->num_rows > 0) {					
					while ($row = $result->fetch_assoc()) {
						$rows[] = $row;
					}
				}

				return $rows;
			}
			else {
				$this->DAL_Write_Log_File('warning', 'DAL_Select_AL_Quotation_ById: no rows; id: ' . $id);
				return null;
			}
        }
		#endregion	
		
		#region Log
		function DAL_Write_Log_File($type, $description) {
			$log = new Log_VM;
			$log->type = $type;
			$log->description = $description;
			$log->time	= date("h:i:sa");
			
			$logFile = LOG_DIR . 'log-'.date("Y-m-d").'.txt';
		
			// $file;
			if(!(file_exists($logFile))) {
				$file =fopen($logFile, 'w');

				if($file != null) {
					fclose($file);
					chmod($logFile, (int)0777); /* 0664 */
				}
			}

			if((file_exists($logFile))) {	
				$logFileContent = json_decode(file_get_contents($logFile));

				if(!is_array($logFileContent)) {
					$logArr = [$log];
					file_put_contents($logFile, json_encode($logArr));
				}
				else {
					array_push($logFileContent, $log);					
					file_put_contents($logFile, json_encode($logFileContent));
				}

				return;
			}
			else {
				echo 'log file could not be opened/written';
			}
			
			return;
		}
		#endregion
    }
?>