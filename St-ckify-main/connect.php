<?php
$HOSTNAME = 'localhost'; // Database host name
$USERNAME = 'root'; // Database username
$PASSWORD = ''; // Database password
$DATABASE = 'stockify'; // Database name

$con=mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected Genesis successfully";
}

?>