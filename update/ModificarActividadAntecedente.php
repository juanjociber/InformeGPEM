<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Authorization, Content-Type, Accept");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

$data = [
    'data' => [],
    'res' => false,
    'msg' => 'Error general.'
];

try {
    include($_SERVER['DOCUMENT_ROOT'].'/informes/gesman/connection/ConnGesmanDb.php');
    require_once '../Datos/InformesData.php';

    $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (empty($_POST['id']) || empty($_POST['actividad']) || empty($_POST['infid'])) {
        throw new Exception("La información está incompleta.");
    }

    $actividad = new stdClass();
    $actividad->id = $_POST['id'];
    $actividad->actividad = $_POST['actividad'];
    $actividad->infid = $_POST['infid'];

    if (FnModificarAntecedenteActividad($conmy, $actividad)) {
        $data['res'] = true;
        $data['msg'] = 'Antecedente modificada con éxito.';
    } else {
        $data['msg'] = 'Error modificando el antecedente.';
    }
} catch (PDOException $ex) {
    $data['msg'] = $ex->getMessage();
} catch (Exception $ex) {
    $data['msg'] = $ex->getMessage();
} finally {
    $conmy = null;
}

echo json_encode($data);
?>
