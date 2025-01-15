<?php
require 'db_connection.php';

// Load JSON data
$jsonData = file_get_contents('data.json'); // Replace with the path to your JSON file
$data = json_decode($jsonData, true); // Decode JSON into associative array

foreach ($data as $record) {
    // insert employee only if he doesn't exist in the table
    $stmt = $conn->prepare("SELECT employee_id FROM employees WHERE employee_mail = ?");
    $stmt->bind_param("s", $record['employee_mail']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
        $employee_id = $employee['employee_id'];
    } else {
        $stmt = $conn->prepare("INSERT INTO employees (employee_name, employee_mail) VALUES (?, ?)");
        $stmt->bind_param("ss", $record['employee_name'], $record['employee_mail']);
        $stmt->execute();
        $employee_id = $conn->insert_id;
    }

    //  Check if event already exists
    $stmt = $conn->prepare("SELECT event_id FROM events WHERE event_name = ?");
    $stmt->bind_param("s", $record['event_name']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc();
        $event_id = $event['event_id'];
    } else {
        $stmt = $conn->prepare("INSERT INTO events (event_name) VALUES (?)");
        $stmt->bind_param("s", $record['event_name']);
        $stmt->execute();
        $event_id = $conn->insert_id;
    }

    // Step 3: Adjust timezone based on version
    $eventDate = adjustTimezone($record['event_date'], $record['version']);

    // Step 4: Insert into participation table
    $stmt = $conn->prepare("INSERT INTO participation (participation_id, employee_id, event_id, participation_fee, event_date, version) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "iiidss",
        $record['participation_id'],
        $employee_id,
        $event_id,
        $record['participation_fee'],
        $eventDate,
        $record['version']
    );
    $stmt->execute();
}

// Timezone adjustment function
function adjustTimezone($dateStr, $version) {
    $eventDate = new \DateTime($dateStr);
if (version_compare($version, "1.0.17+60", "<")) {
    // Before version 1.0.17+60, convert Europe/Berlin to UTC
    $timezone = new \DateTimeZone("Europe/Berlin");
    $eventDate->setTimezone($timezone);
    $eventDate->modify("-2 hours"); // Adjust for UTC
}
return $eventDate->format('Y-m-d H:i:s');

}

echo "Data inserted successfully!";
?>