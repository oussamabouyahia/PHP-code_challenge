<?php
$sql_employee_by_email="SELECT employee_id FROM employees WHERE employee_mail = ?";
$sql_new_employee="INSERT INTO employees (employee_name, employee_mail) VALUES (?, ?)";
$sql_event_byname="SELECT event_id FROM events WHERE event_name = ?";
$sql_new_event="INSERT INTO events (event_name) VALUES (?)";
$sql_new_participation="INSERT INTO participation (participation_id, employee_id, event_id, participation_fee, event_date, version) 
                        VALUES (?, ?, ?, ?, ?, ?)";
$sql_filter_query="
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
?>