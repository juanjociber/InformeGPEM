<?php 
    header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Authorization, Content-Type, Accept");
    header("Access-Control-Allow-Methods: POST");
	header("Content-Type: application/json");

    if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {    
		http_response_code(200);
		exit();
	}

	$res=false;
	$msg='Error general.';

    include($_SERVER['DOCUMENT_ROOT'].'/gesman/connection/ConnGpemDb.php');
    require_once '../datos/InformesData.php';

    try {
        $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if(empty($_POST['infid']) || empty($_POST['actividad'])){throw new Exception("La información esta incompleta.");}
        $USUARIO=date('Ymd-His (').'msarabia'.')';

        $actividad = new stdClass();
        $actividad->infid = $_POST['infid'];
        $actividad->ownid=empty($_POST['ownid'])? 0 : $_POST['ownid'];
        $actividad->actividad=$_POST['actividad'];
        $actividad->diagnostico=empty($_POST['diagnostico'])? null : $_POST['diagnostico'];
        $actividad->trabajos=empty($_POST['trabajos'])? null : $_POST['trabajos'];
        $actividad->observaciones=empty($_POST['observaciones'])? null : $_POST['observaciones'];
        $actividad->usuario=$USUARIO;

        if(FnRegistrarActividad($conmy, $actividad)){
            $msg="Se registró la Actividad.";
            $res=true;
        }else{
            $msg="Error registrando la Actividad.";
        }
    } catch(PDOException $ex){
        $msg=$ex->getMessage();
    } catch (Exception $ex) {
        $msg=$ex->getMessage();
    }finally{
        $conmy=null;
    }

    echo json_encode(array('res'=>$res, 'msg'=>$msg));
?>