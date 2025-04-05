<?php
include 'db_connect.php';
include 'navbar.php';
?>

<h2>Add a New Sponsoring Company</h2>

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
        margin-top: 20px;
        color: green;
    }

    .error {
        margin-top: 20px;
        color: red;
    }
</style>

<form method="POST">
    <label for="companyID">Company ID (must be unique):</label>
    <input type="number" name="companyID" id="companyID" required>

    <label for="NumOfEmails">Number of Emails:</label>
    <input type="number" name="NumOfEmails" id="NumOfEmails" required>

    <label for="companyStatus">Sponsorship Level:</label>
    <select name="companyStatus" id="companyStatus" required>
        <option value="Bronze">Bronze</option>
        <option value="Silver">Silver</option>
        <option value="Gold">Gold</option>
        <option value="Platinum">Platinum</option>
    </select>

    <button type="submit">Add Company</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['companyID'];
    $emails = $_POST['NumOfEmails'];
    $status = $_POST['companyStatus'];

    try {
        $stmt = $pdo->prepare("INSERT INTO SponsoringCompany (companyID, NumOfEmails, companyStatus) VALUES (?, ?, ?)");
        $stmt->execute([$id, $emails, $status]);
        echo "<p class='success'>Sponsoring company added successfully.</p>";
    } catch (PDOException $e) {
        echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>

</div> <!-- close main-content -->
</body>
</html>
