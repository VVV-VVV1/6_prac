<?php

require_once __DIR__ . '/../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        // Handle GET request (Retrieve Users)
        $stmt = $conn->query("SELECT * FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type:applicaton/json');
        echo json_encode($users);
        break;

    case 'POST':
        // Handle POST request (Create User)
        $data = json_decode(file_get_contents("php://input"));
        if (!$data) {
            http_response_code(400); // Bad Request
            header('Content-Type:applicaton/json');
            echo json_encode(['error' => 'Invalid JSON data']);
            exit;
        }
        if (!isset($data->name) || !isset($data->surname)) {
            http_response_code(400); // Bad Request
            header('Content-Type:applicaton/json');
            echo json_encode(['error' => 'Name and surname are required']);
            exit;
        }
        $sql = "INSERT INTO users (name, surname) VALUES (:name, :surname)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            http_response_code(500); // Internal Server Error
            header('Content-Type:applicaton/json');
            echo json_encode(['error' => 'Database error']);
            exit;
        }
        $stmt->bindParam(':name', $data->name);
        $stmt->bindParam(':surname', $data->surname);
        if (!$stmt->execute()) {
            http_response_code(500); // Internal Server Error
            header('Content-Type:applicaton/json');
            echo json_encode(['error' => 'Database error']);
            exit;
        }
        echo json_encode(['message' => 'User created successfully']);
        break;

    case 'PUT':
        // Handle PUT request (Update User)
        $data = json_decode(file_get_contents("php://input"));
        $sql = "UPDATE users SET name = :name, surname = :surname WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $data->name);
        $stmt->bindParam(':surname', $data->surname);
        $stmt->bindParam(':id', $data->id);
        if($stmt->execute()) {
            header('Content-Type:applicaton/json');
            echo json_encode(['message' => 'User updated successfully']);
        }
        break;

    case 'DELETE':
        // Handle DELETE request (Delete User)
        $data = json_decode(file_get_contents("php://input"));
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $data->id);
        if($stmt->execute()) {
            header('Content-Type:applicaton/json');
            echo json_encode(['message' => 'User deleted successfully']);
        }
        break;

    default:
        http_response_code(405); // Method Not Allowed
        break;
}
?>