<?php
// === FIXED & SECURE insert.php ===
$servername = "sprevonix-db.cl6mik6om7h1.us-east-1.rds.amazonaws.com";
$username   = "admin";
$password   = "Admin123456";
$dbname     = "contactdb";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Get all form fields
$fullName      = $_POST['fullName'] ?? '';
$organization  = $_POST['organization'] ?? '';
$email         = $_POST['email'] ?? '';
$phone         = $_POST['phone'] ?? '';
$service       = $_POST['service'] ?? '';
$requestType   = $_POST['requestType'] ?? '';
$preferredDate = $_POST['preferredDate'] ?? '';
$preferredTime = $_POST['preferredTime'] ?? '';
$message       = $_POST['message'] ?? '';

// Server-side validation
if (empty($fullName) || empty($email) || empty($service) || empty($requestType) || empty($message)) {
    echo "ERROR: Please complete all required fields.";
    mysqli_close($conn);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "ERROR: Please provide a valid email address.";
    mysqli_close($conn);
    exit;
}

// Secure prepared statement
$stmt = $conn->prepare("INSERT INTO Customer 
    (fullName, organization, email, phone, service, requestType, preferredDate, preferredTime, message) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sssssssss", 
    $fullName, $organization, $email, $phone, 
    $service, $requestType, $preferredDate, $preferredTime, $message);

if ($stmt->execute()) {
    echo "data stored in the database successfully.";
} else {
    echo "ERROR: " . $stmt->error;
}

$stmt->close();
mysq
