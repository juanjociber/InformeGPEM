<?php 
include($_SERVER['DOCUMENT_ROOT'].'/informes/gesman/connection/ConnGesmanDb.php');
require_once '../Datos/InformesData.php';

// $data['data'] = array();
// $data['res'] = false;
// $data['msg'] = 'Error general.';

$data = [
    'data' => [],
    'res' => false,
    'msg' => 'Error general.'
];

try {
    $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(empty($_POST['id'])){
        throw new Exception("La informacion esta incompleta.");
    }

    $actividad = FnBuscarActividad($conmy, $_POST['id']);
    
    if ($actividad) {
        $data['data'] = $actividad;
        $data['res'] = true;
        $data['msg'] = 'Ok.';
    } else {
        $data['msg'] = 'No se encontró la actividad.';
    }

} catch(PDOException $ex){
    $data['msg'] = $ex->getMessage();
} catch (Exception $ex) {
    $data['msg'] = $ex->getMessage();
} finally {
    $conmy = null;
}

header('Content-Type: application/json');
echo json_encode($data);
?>


