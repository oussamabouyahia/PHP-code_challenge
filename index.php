
<!DOCTYPE html>
<html>
<head>
    <title>Event Participation</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        padding: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f4f4f4;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    form {
        margin-bottom: 20px;
    }
    label {
        margin-right: 10px;
    }
    input {
        padding: 5px;
        margin-right: 10px;
    }
    button {
        padding: 6px 12px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    button:hover {
        background-color: #45a049;
    }
</style>

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
