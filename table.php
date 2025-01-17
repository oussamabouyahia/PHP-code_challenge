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
    if ($result && $result->num_rows > 0) { 
        while ($row = $result->fetch_assoc()) {
            $totalFee += $row['participation_fee'];
            echo "<tr>
                    <td>{$row['employee_name']}</td>
                    <td>{$row['event_name']}</td>
                    <td>{$row['event_date']}</td>
                    <td>" . number_format($row['participation_fee'], 2) . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No records found</td></tr>";
    }
    ?>        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"><strong>Total Fee</strong></td>
                <td><strong><?php echo number_format($totalFee, 2); ?></strong></td>
            </tr>
        </tfoot>
    </table>