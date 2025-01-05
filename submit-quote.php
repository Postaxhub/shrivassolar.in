<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $service = htmlspecialchars($_POST['service']);
    $note = htmlspecialchars($_POST['note']);

    // Validate the required fields
    if (empty($name) || empty($email) || empty($phone) || empty($service)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit();
    }

    // Create a new quote entry
    $newQuote = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'service' => $service,
        'note' => $note ? $note : '',
        'date' => date("Y-m-d H:i:s")
    ];

    // Path to the quotes JSON file
    $filePath = 'quotes.json';

    // Read existing data from quotes.json
    if (file_exists($filePath)) {
        $data = file_get_contents($filePath);
        $quotes = json_decode($data, true);
    } else {
        $quotes = [];
    }

    // Add the new quote to the array
    $quotes[] = $newQuote;

    // Save the updated data to quotes.json
    if (file_put_contents($filePath, json_encode($quotes, JSON_PRETTY_PRINT))) {
        echo json_encode(['success' => true, 'message' => 'Your query has been successfully submitted.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save your query. Please try again later.']);
    }
} else {
    // If the form is not submitted via POST
    echo json_encode(['success' => false, 'message' => 'Invalid form submission.']);
}
?>
