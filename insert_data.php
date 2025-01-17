<?php
require 'db_connection.php';
require 'queries.php';
// Load JSON data
$jsonData = file_get_contents('data.json'); // Replace with the path to your JSON file
$data = json_decode($jsonData, true); // Decode JSON into associative array

foreach ($data as $record) {
    // insert employee only if he doesn't exist in the table
    $stmt = $conn->prepare($sql_employee_by_email);
    $stmt->bind_param("s", $record['employee_mail']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
        $employee_id = $employee['employee_id'];
    } else {
        $stmt = $conn->prepare($sql_new_employee);
        $stmt->bind_param("ss", $record['employee_name'], $record['employee_mail']);
        $stmt->execute();
        $employee_id = $conn->insert_id;
    }

    //  Check if event already exists otherwise insert in the event table
    $stmt = $conn->prepare($sql_event_byname);
    $stmt->bind_param("s", $record['event_name']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc();
        $event_id = $event['event_id'];
    } else {
        $stmt = $conn->prepare($sql_new_event);
        $stmt->bind_param("s", $record['event_name']);
        $stmt->execute();
        $event_id = $conn->insert_id;
    }

    // Adjust timezone based on version condition as required
    $eventDate = adjustTimezone($record['event_date'], $record['version']);

    //  Insert into participation table
    $stmt = $conn->prepare($sql_new_participation);
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
    // convert Europe/Berlin to UTC if version<1.0.17+60
    $timezone = new \DateTimeZone("Europe/Berlin");
    $eventDate->setTimezone($timezone);
    $eventDate->modify("-2 hours"); // Adjust for UTC
}
return $eventDate->format('Y-m-d H:i:s');

}

echo "Data inserted successfully!";
?>