<?php 
include($_SERVER['DOCUMENT_ROOT'].'/informes/gesman/connection/ConnGesmanDb.php');
require_once '../Datos/InformesData.php';

$data = [
    'data' => [],
    'res' => false,
    'msg' => 'Error general.'
];

try {
    $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(empty($_GET['search'])){
        throw new Exception("La información está incompleta.");
    }

    $equipos = FnListarEquipos($conmy, $_GET['search']);
    
    if ($equipos) {
        $data['data'] = $equipos;
        $data['res'] = true;
        $data['msg'] = 'Ok.';
    } else {
        $data['msg'] = 'No se encontraron equipos.';
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
