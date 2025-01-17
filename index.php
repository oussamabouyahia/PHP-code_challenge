
<!DOCTYPE html>
<html>
<head>
    <title>Event Participation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Event Participation</h1>
<?php
require 'db_connection.php';
require 'queries.php';
//below the three filter inputs
$employeeFilter = isset($_POST['employeeFilter']) ? $_POST['employeeFilter'] : '';
$eventFilter = isset($_POST['eventFilter']) ? $_POST['eventFilter'] : '';
$dateFilter = isset($_POST['dateFilter']) ? $_POST['dateFilter'] : '';

// Prepare query with optional filters
$sql = $sql_filter_query;
$stmt = $conn->prepare($sql);
$likeEmployee = '%' . $employeeFilter . '%';
$likeEvent = '%' . $eventFilter . '%';
$stmt->bind_param("ssssss", $likeEmployee, $employeeFilter, $likeEvent, $eventFilter, $dateFilter, $dateFilter);
$stmt->execute();
$result = $stmt->get_result();
require 'filter.php';
require __DIR__ . '/table.php';

?> 
</body>
</html>
