<?php
$HOSTNAME = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$DATABASE = 'stockify';

$con = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);
if (!$con) {
    die("DB connection failed.");
}

$name = "SuperUser";
$email = "superuser@gmail.com";
$username = "superuser";
$role = "Admin";
$password = "";
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $con->prepare("INSERT INTO registration (name, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $username, $email, $hashedPassword, $role);

if ($stmt->execute()) {
    echo "Admin user created successfully.";
} else {
    echo "Failed to create admin: " . $stmt->error;
}
?>
