<?php namespace BusinessLogic\General;
    require_once("../../DataAccess/DbConn.php");
    require_once("../../DataAccess/DAL_Main.php");
    require_once("../../Mappers/Mapper_Main.php");
    require_once("../../Models/Model_Main.php");
    use DataAccess\General\DAL_Main;
    use Mappers\General\Mapper_Main;
    use Models\General\Quotation;

    class BLL_Main {
        #region Insert
        function BLL_Insert_AL_Quotation(Quotation $obj) {
            $dal = new DAL_Main();
            return $dal->DAL_Insert_AL_Quotation($obj);
        }
        #endregion

        #region Select
        function BLL_Select_AL_AgeLoad() {            
            $map = new Mapper_Main();
            $dal = new DAL_Main();
            $result = $map->Map_AL_AgeLoad($dal->DAL_Select_AL_AgeLoad());
            return $result;
        }

        function BLL_Select_AL_Quotation_ById($id) {            
            $map = new Mapper_Main();
            $dal = new DAL_Main();
            $result = $map->Map_AL_Quotation($dal->DAL_Select_AL_Quotation_ById($id));
            return $result;
        }
        #endregion

        #region Log
        function BLL_Write_Log_File_Obj($type, $description) {
            $dal = new DAL_Main();
            $dal->DAL_Write_Log_File($type, $description);
        }
        #endregion
    }
?>