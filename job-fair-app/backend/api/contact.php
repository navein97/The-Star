<?php
/**
 * Contact Form API Endpoint
 * Handles contact form submissions
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../config/database.php';
require_once '../utils/Validator.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Method not allowed"]);
    exit();
}

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Validate required fields
if (empty($data->name) || empty($data->email) || empty($data->message)) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Please fill in all required fields (name, email, message)"
    ]);
    exit();
}

// Sanitize inputs
$name = Validator::sanitizeString($data->name);
$email = Validator::sanitizeString($data->email);
$phone = isset($data->phone) ? Validator::sanitizeString($data->phone) : null;
$message = Validator::sanitizeString($data->message);

// Validate email
if (!Validator::validateEmail($email)) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Invalid email format"
    ]);
    exit();
}

// Validate phone if provided
if ($phone && !Validator::validatePhone($phone)) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Invalid phone number format"
    ]);
    exit();
}

// Validate lengths
if (!Validator::validateLength($name, 2, 255)) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Name must be between 2 and 255 characters"
    ]);
    exit();
}

if (!Validator::validateLength($message, 10, 5000)) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Message must be between 10 and 5000 characters"
    ]);
    exit();
}

// Database connection
$database = new Database();
$db = $database->getConnection();

if ($db === null) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed"
    ]);
    exit();
}

try {
    // Prepare SQL statement
    $query = "INSERT INTO contacts (name, email, phone, message) VALUES (:name, :email, :phone, :message)";
    $stmt = $db->prepare($query);

    // Bind parameters
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone", $phone);
    $stmt->bindParam(":message", $message);

    // Execute query
    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode([
            "success" => true,
            "message" => "Thank you for contacting us! We will get back to you soon."
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Unable to submit contact form. Please try again."
        ]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    error_log("Contact form error: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => "An error occurred. Please try again later."
    ]);
}
?>
