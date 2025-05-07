<?php
// ==== CORS HEADERS ====
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// ==== JSON INPUT ====
$input = json_decode(file_get_contents("php://input"), true);

$name = $input['name'] ?? '';
$email = $input['email'] ?? '';
$password = $input['password'] ?? '';
$role = $input['role'] ?? '';

if (!$name || !$email || !$password || !$role) {
    http_response_code(400);
    echo json_encode(["message" => "All fields are required."]);
    exit;
}

// ==== DB CONNECTION ====
$HOSTNAME = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$DATABASE = 'stockify';

$con = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);
if (!$con) {
    http_response_code(500);
    echo json_encode(["message" => "Database connection failed."]);
    exit;
}

// ==== VALIDATE DUPLICATE EMAIL ====
$check = $con->prepare("SELECT id FROM registration WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$result = $check->get_result();
if ($result->num_rows > 0) {
    http_response_code(409);
    echo json_encode(["message" => "Email already registered."]);
    exit;
}

// ==== HASH PASSWORD ====
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// ==== INSERT USER ====
$username = explode('@', $email)[0]; // Auto-generate username from email since it's not provided when registering
//$role = $role === 'admin' ? 'admin' : 'user'; // Default to 'user' if not 'admin'
$insert = $con->prepare("INSERT INTO registration (name, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
$insert->bind_param("sssss", $name, $username, $email, $hashedPassword, $role);

if ($insert->execute()) {
    echo json_encode(["message" => "User registered successfully."]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Registration failed."]);
}
?>
