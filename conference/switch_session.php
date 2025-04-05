<?php
include 'db_connect.php';
include 'navbar.php';
?>

<h2>Update a Session's Time or Room</h2>
<!-- stylign -->
<style>
    form {
        margin-top: 20px;
        max-width: 500px;
    }

    label {
        font-weight: bold;
        display: block;
        margin-top: 15px;
    }

    input, select {
        width: 100%;
        padding: 8px;
        font-size: 14px;
        margin-top: 5px;
        box-sizing: border-box;
    }

    button {
        margin-top: 20px;
        padding: 8px 14px;
        font-size: 14px;
        font-weight: bold;
        border: 1px solid #ccc;
        background-color: #f4f4f4;
        cursor: pointer;
    }

    button:hover {
        background-color: #e4e4e4;
    }

    .success {
        color: green;
        margin-top: 20px;
    }

    .error {
        color: red;
        margin-top: 20px;
    }
</style>

<form method="POST">
    <label for="sessionID">Select a Session:</label>
    <select name="sessionID" id="sessionID" required>
        <?php
        $stmt = $pdo->query("SELECT sessionID, topic FROM Session");
        foreach ($stmt as $row) {
            echo "<option value='{$row['sessionID']}'>[{$row['sessionID']}] {$row['topic']}</option>";
        }
        ?>
    </select>

    <label for="roomNumber">New Room Number:</label>
    <input type="number" name="roomNumber" id="roomNumber" required>

    <label for="startTime">New Start Time:</label>
    <input type="time" name="startTime" id="startTime" required>

    <label for="endTime">New End Time:</label>
    <input type="time" name="endTime" id="endTime" required>

    <button type="submit">Update Session</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sessionID = $_POST['sessionID'];
    $room = $_POST['roomNumber'];
    $start = $_POST['startTime'];
    $end = $_POST['endTime'];

    try {
        $stmt = $pdo->prepare("UPDATE Session 
                               SET roomNumber = ?, startTime = ?, endTime = ?
                               WHERE sessionID = ?");
        $stmt->execute([$room, $start, $end, $sessionID]);

        echo "<p class='success'>Session updated successfully.</p>";
    } catch (PDOException $e) {
        echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>

</div> 
</body>
</html>
