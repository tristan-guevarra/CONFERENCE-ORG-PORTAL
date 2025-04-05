<?php
include 'db_connect.php';
include 'navbar.php';
?>

<h2>Delete a Sponsoring Company</h2>

<style>
    form {
        margin-top: 20px;
        max-width: 500px;
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 8px;
    }

    select {
        width: 100%;
        padding: 8px;
        font-size: 14px;
        margin-bottom: 20px;
        box-sizing: border-box;
    }

    button {
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
    <label for="companyID">Select Company to Delete:</label>
    <select name="companyID" id="companyID" required>
        <?php
        $stmt = $pdo->query("SELECT companyID, companyStatus FROM SponsoringCompany");
        foreach ($stmt as $row) {
            echo "<option value='{$row['companyID']}'>Company {$row['companyID']} ({$row['companyStatus']})</option>";
        }
        ?>
    </select>
    <button type="submit">Delete Company</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $companyID = $_POST['companyID'];

    try {
        $stmt = $pdo->prepare("DELETE FROM SponsoringCompany WHERE companyID = ?");
        $stmt->execute([$companyID]);
        echo "<p class='success'>Company and associated sponsor attendees successfully deleted.</p>";
    } catch (PDOException $e) {
        echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>

</div> <!-- close main-content -->
</body>
</html>
