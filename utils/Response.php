<?php

function sendResponse($data, $code = 200) {
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function sendError($message, $code = 400) {
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode(["error" => $message]);
    exit;
}

function getJsonInput() {
    $input = json_decode(file_get_contents("php://input"), true);
    return (json_last_error() === JSON_ERROR_NONE) ? $input : null;
}
