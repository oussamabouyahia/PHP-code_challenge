<?php
require 'db_connection.php';

//below the three filter inputs
$employeeFilter = isset($_POST['employeeFilter']) ? $_POST['employeeFilter'] : '';
$eventFilter = isset($_POST['eventFilter']) ? $_POST['eventFilter'] : '';
$dateFilter = isset($_POST['dateFilter']) ? $_POST['dateFilter'] : '';

// Prepare query with optional filters
$sql = "
    SELECT 
        e.employee_name, 
        ev.event_name, 
        p.event_date, 
        p.participation_fee 
    FROM 
        participation p
    JOIN 
        employees e ON p.employee_id = e.employee_id
    JOIN 
        events ev ON p.event_id = ev.event_id
    WHERE 
        (e.employee_name LIKE ? OR ? = '') AND
        (ev.event_name LIKE ? OR ? = '') AND
        (p.event_date = ? OR ? = '')
";
$stmt = $conn->prepare($sql);
$likeEmployee = '%' . $employeeFilter . '%';
$likeEvent = '%' . $eventFilter . '%';
$stmt->bind_param("ssssss", $likeEmployee, $employeeFilter, $likeEvent, $eventFilter, $dateFilter, $dateFilter);
$stmt->execute();
$result = $stmt->get_result();
?>

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
    <!-- form for the three input filter -->
    <form method="POST" action="">
        <label>Employee:</label>
        <input type="text" name="employeeFilter" value="<?php echo htmlspecialchars($employeeFilter); ?>">
        <label>Event:</label>
        <input type="text" name="eventFilter" value="<?php echo htmlspecialchars($eventFilter); ?>">
        <label>Date:</label>
        <input type="date" name="dateFilter" value="<?php echo htmlspecialchars($dateFilter); ?>">
        <button type="submit">Filter</button>
    </form>
     <!-- the table below for displaying the data  -->
    <table border="1" >
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Event Name</th>
                <th>Event Date</th>
                <th>Participation Fee</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalFee = 0;
            while ($row = $result->fetch_assoc()) {
                $totalFee += $row['participation_fee'];
                echo "<tr>
                        <td>{$row['employee_name']}</td>
                        <td>{$row['event_name']}</td>
                        <td>{$row['event_date']}</td>
                        <td>" . number_format($row['participation_fee'], 2) . "</td>
                      </tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"><strong>Total Fee</strong></td>
                <td><strong><?php echo number_format($totalFee, 2); ?></strong></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>