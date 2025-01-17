<form method="POST" action="">
        <label>Employee:</label>
        <input type="text" name="employeeFilter" value="<?php echo htmlspecialchars($employeeFilter); ?>">
        <label>Event:</label>
        <input type="text" name="eventFilter" value="<?php echo htmlspecialchars($eventFilter); ?>">
        <label>Date:</label>
        <input type="date" name="dateFilter" value="<?php echo htmlspecialchars($dateFilter); ?>">
        <button type="submit">Filter</button>
    </form>