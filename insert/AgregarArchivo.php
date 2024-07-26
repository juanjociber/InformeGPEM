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

        if(empty($_POST['refid']) || empty($_POST['archivo'])){throw new Exception("La información esta incompleta.");}
        
        $USUARIO=date('Ymd-His (').'msarabia'.')';

        $FileName = 'INF'.'_'.$_POST['refid'].'_'.uniqid().'.jpeg';
        $FileType = 'IMG';
        $FileEncoded = str_replace("data:image/jpeg;base64,", "", $_POST['archivo']);
        $FileDecoded = base64_decode($FileEncoded);
        file_put_contents($_SERVER['DOCUMENT_ROOT']."/mycloud/gesman/files/".$FileName, $FileDecoded);

        $imagen = new stdClass();
        $imagen->refid = $_POST['refid'];
        $imagen->tabla = 'INF';
        $imagen->nombre = $FileName;
        $imagen->titulo = empty($_POST['titulo'])? $FileName : $_POST['titulo'];
        $imagen->descripcion = empty($_POST['descripcion'])? null : $_POST['descripcion'];
        $imagen->usuario = $USUARIO;

        if(FnRegistrarImagen($conmy, $imagen)){
            $msg="Se registró el Archivo.";
            $res=true;
        }else{
            $msg="Error registrando el Archivo.";
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