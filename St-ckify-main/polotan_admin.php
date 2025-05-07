<?php
$HOSTNAME = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$DATABASE = 'stockify';

$con = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);
if (!$con) {
    die("DB connection failed.");
}

$name = "Genesis Polotan";
$email = "superuser@proton.me";
$username = "adminpolotan";
$role = "Admin";
$password = "@Superuser123";
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $con->prepare("INSERT INTO registration (name, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $username, $email, $hashedPassword, $role);

if ($stmt->execute()) {
    echo "Admin user created successfully.";
} else {
    echo "Failed to create admin: " . $stmt->error;
}
?>
