<?php
include 'db_connect.php';
include 'navbar.php';
?>

<h2>Add a New Attendee</h2>

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
        margin-top: 5px;
        box-sizing: border-box;
        font-size: 14px;
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
    <label for="firstName">First Name:</label>
    <input type="text" name="firstName" id="firstName" required>

    <label for="lastName">Last Name:</label>
    <input type="text" name="lastName" id="lastName" required>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>

    <label for="type">Type:</label>
    <select name="type" id="type" onchange="toggleFields()" required>
        <option value="">Select type</option>
        <option value="student">Student</option>
        <option value="professional">Professional</option>
        <option value="sponsor">Sponsor</option>
    </select>

    <div id="studentFields" style="display:none;">
        <label for="roomNumber">Assign to Room:</label>
        <select name="roomNumber" id="roomNumber">
            <?php
            $stmt = $pdo->query("SELECT roomNumber FROM Hotel");
            foreach ($stmt as $row) {
                echo "<option value='{$row['roomNumber']}'>{$row['roomNumber']}</option>";
            }
            ?>
        </select>
    </div>

    <div id="sponsorFields" style="display:none;">
        <label for="companyID">Assign to Company:</label>
        <select name="companyID" id="companyID">
            <?php
            $stmt = $pdo->query("SELECT companyID, companyStatus FROM SponsoringCompany");
            foreach ($stmt as $row) {
                echo "<option value='{$row['companyID']}'>Company {$row['companyID']} ({$row['companyStatus']})</option>";
            }
            ?>
        </select>
    </div>

    <button type="submit">Add Attendee</button>
</form>

<script>
function toggleFields() {
    const type = document.getElementById("type").value;
    document.getElementById("studentFields").style.display = (type === "student") ? "block" : "none";
    document.getElementById("sponsorFields").style.display = (type === "sponsor") ? "block" : "none";
}
</script>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first = $_POST['firstName'];
    $last = $_POST['lastName'];
    $email = $_POST['email'];
    $type = $_POST['type'];

    try {
        // Get new unique ID
        $stmt = $pdo->query("SELECT MAX(attendeeID) AS maxID FROM Attendee");
        $row = $stmt->fetch();
        $newID = $row['maxID'] + 1;

        // Insert into Attendee
        $insertAttendee = $pdo->prepare("INSERT INTO Attendee (attendeeID, firstName, lastName, email) VALUES (?, ?, ?, ?)");
        $insertAttendee->execute([$newID, $first, $last, $email]);

        // Insert into type-specific table
        if ($type === "student") {
            $room = $_POST["roomNumber"];
            $stmt = $pdo->prepare("INSERT INTO Student (studentID, attendeeID, roomNumber) VALUES (?, ?, ?)");
            $stmt->execute([$newID, $newID, $room]);
        } elseif ($type === "professional") {
            $stmt = $pdo->prepare("INSERT INTO Professional (professionalID, attendeeID) VALUES (?, ?)");
            $stmt->execute([$newID, $newID]);
        } elseif ($type === "sponsor") {
            $companyID = $_POST["companyID"];
            $stmt = $pdo->prepare("INSERT INTO Sponsor (sponsorID, attendeeID, companyID) VALUES (?, ?, ?)");
            $stmt->execute([$newID, $newID, $companyID]);
        }

        echo "<p class='success'>Attendee successfully added.</p>";
    } catch (PDOException $e) {
        echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>

</div> <!-- close main-content -->
</body>
</html>
