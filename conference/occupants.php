<?php include 'db_connect.php'; ?>
<?php include 'navbar.php'; ?>

<style>
    h2 {
        margin-bottom: 20px;
    }

    form {
        margin-bottom: 15px;
    }

    label {
        font-weight: bold;
        margin-right: 10px;
    }

    select, button {
        padding: 6px 10px;
        font-size: 14px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 15px;
    }

    table, th, td {
        border: 1px solid #ccc;
    }

    th, td {
        padding: 8px 12px;
        text-align: left;
        word-break: break-word;
    }

    th {
        background-color: #f2f2f2;
    }

    .section-title {
        margin-top: 40px;
    }
</style>

<h2>Hotel Room Occupants</h2>

<!-- Select a room -->
<form method="POST">
    <label for="roomNumber">Select a Room:</label>
    <select name="roomNumber" id="roomNumber" required>
        <option value="">-- Choose --</option>
        <?php
        $stmt = $pdo->query("SELECT roomNumber FROM Hotel");
        while ($row = $stmt->fetch()) {
            echo "<option value='{$row['roomNumber']}'>{$row['roomNumber']}</option>";
        }
        ?>
    </select>
    <button type="submit" name="viewRoom">View Occupants</button>
</form>

<!-- View all rooms -->
<form method="POST">
    <button type="submit" name="viewAll">View All Hotel Rooms with Occupants</button>
</form>

<?php
// Specific room
if (isset($_POST['viewRoom'])) {
    $room = $_POST['roomNumber'];

    $sql = "SELECT A.firstName, A.lastName, A.email
            FROM Student S
            JOIN Attendee A ON S.attendeeID = A.attendeeID
            WHERE S.roomNumber = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$room]);
    $occupants = $stmt->fetchAll();

    echo "<h3 class='section-title'>Occupants in Room $room</h3>";
    if ($occupants) {
        echo "<table>
                <tr><th>First Name</th><th>Last Name</th><th>Email</th></tr>";
        foreach ($occupants as $o) {
            echo "<tr>
                    <td>{$o['firstName']}</td>
                    <td>{$o['lastName']}</td>
                    <td>{$o['email']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No students found in room $room.</p>";
    }
}

// All rooms
if (isset($_POST['viewAll'])) {
    echo "<h3 class='section-title'>All Hotel Rooms and Occupants</h3>";

    $sql = "SELECT H.roomNumber, H.beds, A.firstName, A.lastName, A.email
            FROM Hotel H
            LEFT JOIN Student S ON H.roomNumber = S.roomNumber
            LEFT JOIN Attendee A ON S.attendeeID = A.attendeeID
            ORDER BY H.roomNumber";

    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();

    if ($results) {
        echo "<table>
                <tr>
                    <th>Room Number</th>
                    <th>Beds</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                </tr>";
        foreach ($results as $r) {
            echo "<tr>
                    <td>{$r['roomNumber']}</td>
                    <td>{$r['beds']}</td>
                    <td>" . ($r['firstName'] ?? '-') . "</td>
                    <td>" . ($r['lastName'] ?? '-') . "</td>
                    <td>" . ($r['email'] ?? '-') . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No hotel rooms or students found.</p>";
    }
}
?>

</div> <!-- close main-content -->
</body>
</html>
