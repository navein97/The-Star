<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

// Get the user's message
$input = json_decode(file_get_contents('php://input'), true);
$userMessage = $input['message'] ?? '';

if (empty($userMessage)) {
    http_response_code(400);
    echo json_encode(['error' => 'Message is required']);
    exit();
}

// **IMPORTANT: Replace with your actual Google Gemini API key**
$apiKey = 'AIzaSyAR_xozJEEkV4ggfwov2VEJr03oJipZ7xA';

// Prepare the request to Google Gemini
$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=' . $apiKey;

$data = [
    'contents' => [
        [
            'parts' => [
                ['text' => "You are a helpful assistant for a Job Fair event. Answer questions about the event, exhibitors, job matching sessions, and career talks. Be concise and friendly. User says: " . $userMessage]
            ]
        ]
    ]
];

// Make the API call to Google Gemini
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);
// Disable SSL verification for local development (fixes 'SSL certificate problem')
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($httpCode !== 200) {
    http_response_code(500);
    $errorDetails = $curlError ? "CURL Error: $curlError" : "API Response: $response";
    echo json_encode(['error' => 'Failed to get response from AI', 'details' => $errorDetails]);
    exit();
}

$result = json_decode($response, true);
$botReply = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Sorry, I could not process that.';

echo json_encode([
    'success' => true,
    'reply' => trim($botReply)
]);
?>
