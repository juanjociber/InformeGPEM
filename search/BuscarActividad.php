<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/gesman/connection/ConnGesmanDb.php');
    require_once '../Datos/InformesData.php';

    $data['data'] = array();
	$data['res'] = false;
	$data['msg'] = 'Error general.';

    try {
        // $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if(empty($_GET['id'])){throw new Exception("La informacion esta incompleta.");}

        $actividad=FnBuscarOrden($conmy,$_GET['id']);
        
        $data['data'] = $actividad;
        $data['res'] = true;
	    $data['msg'] = 'Ok.';
        echo $_GET['id'];

    } catch(PDOException $ex){
        $data['msg'] = $ex->getMessage();
    } catch (Exception $ex) {
        $data['msg'] = $ex->getMessage();
    }finally{
        $conmy=null;
    }

    echo json_encode($data);
?>