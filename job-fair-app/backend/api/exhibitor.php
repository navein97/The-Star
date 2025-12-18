<?php
/**
 * Exhibitor Registration API Endpoint
 * Handles exhibitor registration submissions
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../config/database.php';
require_once '../utils/Validator.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Method not allowed"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"));

// Validate required fields
$required_fields = ['company_name', 'contact_person', 'email', 'phone'];
foreach ($required_fields as $field) {
    if (empty($data->$field)) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Please fill in all required fields"
        ]);
        exit();
    }
}

// Sanitize inputs
$company_name = Validator::sanitizeString($data->company_name);
$contact_person = Validator::sanitizeString($data->contact_person);
$email = Validator::sanitizeString($data->email);
$phone = Validator::sanitizeString($data->phone);
$industry = isset($data->industry) ? Validator::sanitizeString($data->industry) : null;
$booth_preference = isset($data->booth_preference) ? Validator::sanitizeString($data->booth_preference) : null;
$additional_info = isset($data->additional_info) ? Validator::sanitizeString($data->additional_info) : null;

// Validate email
if (!Validator::validateEmail($email)) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Invalid email format"
    ]);
    exit();
}

// Validate phone
if (!Validator::validatePhone($phone)) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Invalid phone number format"
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
    // Check if email already exists
    $check_query = "SELECT id FROM exhibitors WHERE email = :email";
    $check_stmt = $db->prepare($check_query);
    $check_stmt->bindParam(":email", $email);
    $check_stmt->execute();
    
    if ($check_stmt->rowCount() > 0) {
        http_response_code(409);
        echo json_encode([
            "success" => false,
            "message" => "This email is already registered as an exhibitor"
        ]);
        exit();
    }

    // Insert new exhibitor
    $query = "INSERT INTO exhibitors (company_name, contact_person, email, phone, industry, booth_preference, additional_info) 
              VALUES (:company_name, :contact_person, :email, :phone, :industry, :booth_preference, :additional_info)";
    $stmt = $db->prepare($query);

    $stmt->bindParam(":company_name", $company_name);
    $stmt->bindParam(":contact_person", $contact_person);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone", $phone);
    $stmt->bindParam(":industry", $industry);
    $stmt->bindParam(":booth_preference", $booth_preference);
    $stmt->bindParam(":additional_info", $additional_info);

    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode([
            "success" => true,
            "message" => "Thank you for registering! We will contact you soon with booth details."
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Unable to complete registration. Please try again."
        ]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    error_log("Exhibitor registration error: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => "An error occurred. Please try again later."
    ]);
}
?>
