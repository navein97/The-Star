<?php
/**
 * Reservation API Endpoint
 * Handles job matching and career talk session reservations
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../config/database.php';
require_once '../utils/Validator.php';

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

// Handle GET request - Get available slots
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $type = isset($_GET['type']) ? $_GET['type'] : null;
    $date = isset($_GET['date']) ? $_GET['date'] : null;

    if ($type === 'slots' && $date) {
        // Validate date format
        if (!Validator::validateDate($date)) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Invalid date format"
            ]);
            exit();
        }

        // Define available time slots
        $all_slots = [
            "09:00", "10:00", "11:00", "12:00",
            "14:00", "15:00", "16:00", "17:00"
        ];

        try {
            // Get booked slots for the date
            $query = "SELECT session_time FROM reservations 
                     WHERE session_date = :date AND status = 'confirmed'";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":date", $date);
            $stmt->execute();
            
            $booked_slots = [];
            while ($row = $stmt->fetch()) {
                $booked_slots[] = substr($row['session_time'], 0, 5); // Format HH:MM
            }

            // Filter available slots
            $available_slots = array_values(array_diff($all_slots, $booked_slots));

            http_response_code(200);
            echo json_encode([
                "success" => true,
                "available_slots" => $available_slots,
                "booked_slots" => $booked_slots
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            error_log("Get slots error: " . $e->getMessage());
            echo json_encode([
                "success" => false,
                "message" => "Unable to fetch available slots"
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Invalid request parameters"
        ]);
    }
    exit();
}

// Handle POST request - Create reservation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    // Validate required fields
    $required_fields = ['name', 'email', 'reservation_type', 'session_date', 'session_time'];
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
    $name = Validator::sanitizeString($data->name);
    $email = Validator::sanitizeString($data->email);
    $phone = isset($data->phone) ? Validator::sanitizeString($data->phone) : null;
    $reservation_type = Validator::sanitizeString($data->reservation_type);
    $session_date = Validator::sanitizeString($data->session_date);
    $session_time = Validator::sanitizeString($data->session_time);
    $additional_notes = isset($data->additional_notes) ? Validator::sanitizeString($data->additional_notes) : null;

    // Validate email
    if (!Validator::validateEmail($email)) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Invalid email format"
        ]);
        exit();
    }

    // Validate reservation type
    if (!in_array($reservation_type, ['job_matching', 'career_talk'])) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Invalid reservation type"
        ]);
        exit();
    }

    // Validate date
    if (!Validator::validateDate($session_date)) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Invalid date format"
        ]);
        exit();
    }

    // Validate time
    if (!Validator::validateTime($session_time)) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Invalid time format"
        ]);
        exit();
    }

    try {
        // Check for duplicate reservation
        $check_query = "SELECT id FROM reservations 
                       WHERE email = :email 
                       AND reservation_type = :reservation_type 
                       AND session_date = :session_date 
                       AND session_time = :session_time";
        $check_stmt = $db->prepare($check_query);
        $check_stmt->bindParam(":email", $email);
        $check_stmt->bindParam(":reservation_type", $reservation_type);
        $check_stmt->bindParam(":session_date", $session_date);
        $check_stmt->bindParam(":session_time", $session_time);
        $check_stmt->execute();
        
        if ($check_stmt->rowCount() > 0) {
            http_response_code(409);
            echo json_encode([
                "success" => false,
                "message" => "You already have a reservation for this session"
            ]);
            exit();
        }

        // Insert reservation
        $query = "INSERT INTO reservations (name, email, phone, reservation_type, session_date, session_time, additional_notes) 
                  VALUES (:name, :email, :phone, :reservation_type, :session_date, :session_time, :additional_notes)";
        $stmt = $db->prepare($query);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":reservation_type", $reservation_type);
        $stmt->bindParam(":session_date", $session_date);
        $stmt->bindParam(":session_time", $session_time);
        $stmt->bindParam(":additional_notes", $additional_notes);

        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode([
                "success" => true,
                "message" => "Reservation confirmed! We look forward to seeing you."
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Unable to complete reservation. Please try again."
            ]);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        error_log("Reservation error: " . $e->getMessage());
        echo json_encode([
            "success" => false,
            "message" => "An error occurred. Please try again later."
        ]);
    }
    exit();
}

http_response_code(405);
echo json_encode(["success" => false, "message" => "Method not allowed"]);
?>
