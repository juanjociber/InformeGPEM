<?php
// ENCABEZADO HTTP
header('Content-Type: application/json');

// CONFIGURACIÓN DE CONEXIÓN A BASE DE DATOS
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "mydb";

try {
    // CREAR CONEXIÓN PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // OBTENER EL PARÁMETRO DE BUSQUEDA.
    $search = $_GET['search'] ?? '';

    if ($search) {
        $stmt = $conn->prepare("SELECT nombre FROM equipos WHERE nombre LIKE :search");
        $search_param = "%{$search}%";
        $stmt->bindParam(':search', $search_param);
        $stmt->execute();

        $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($equipos);
    } else {
        echo json_encode([]);
    }

} catch (PDOException $e) {
    echo json_encode(['error' => 'Conexión fallida: ' . $e->getMessage()]);
}
?>
