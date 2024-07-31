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

    // VALIDANDO QUE LOS PARAMETROS NO ESTÉN VACIOS
    if(empty($_GET['search']) || empty($_GET['CliId'])){
        throw new Exception("La información está incompleta.");
    }

    $search = $_GET['search'];
    $CliId = $_GET['CliId'];

    // LLAMAR FUNCION PARA OBTENER DATOS
    $equipos = FnListarEquipos($conmy, $search, $CliId);
    
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
