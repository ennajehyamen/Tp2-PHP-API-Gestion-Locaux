<?php
header("Content-Type: application/json");
// Autoload classes
require_once 'config/Database.php';
require_once 'utils/Helper.php';
require_once 'controller/LocauxController.php';
require_once 'controller/EquipementsController.php';
require_once 'controller/DepartementsController.php';


// ROUTING
$method = $_SERVER['REQUEST_METHOD'];
$uri = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$resource = $uri[1] ?? null;
$id = $uri[2] ?? null;

// Database connection
$database = new Database();
$pdo = $database->getConnection();


// LOCALS CRUD
if ($resource === "locaux") {
    $locauxController = new LocauxController($pdo, $method, $id);
    $locauxController->handleRequest();
    exit;
}

// EQUIPMENTS CRUD
if ($resource === "equipements") {
    $equipementsController = new EquipementsController($pdo, $method, $id);
    $equipementsController->handleRequest();
    exit;
}

// DEPARTMENTS CRUD
if ($resource === "departements") {
    $departementsController = new DepartementsController($pdo, $method, $id);
    $departementsController->handleRequest();
    exit;
}


// ASSOCIATE EQUIPEMENT TO LOCAL
if ($resource === "associer" && $method === "POST") {
    $data = getBody();
    $stmt = $pdo->prepare("UPDATE equipements SET local_id = ? WHERE id = ?");
    $stmt->execute([$data['local_id'], $data['equipement_id']]);
    echo json_encode(["success" => true]);
    exit;
}

// 404
http_response_code(404);
echo json_encode(["error" => "Not found"]);


?>