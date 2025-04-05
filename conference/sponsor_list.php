<?php
include 'db_connect.php';
include 'navbar.php';

// Store confirmation message
$confirmationMessage = "";

// Handle email count updates
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["increment_company"])) {
        $id = $_POST["increment_company"];
        $pdo->prepare("UPDATE SponsoringCompany SET NumOfEmails = NumOfEmails + 1 WHERE companyID = ?")->execute([$id]);
        $confirmationMessage = "<p style='color: green; margin-top: 10px;'>Updates: for Company ID $id</p>";
    }

    if (isset($_POST["decrement_company"])) {
        $id = $_POST["decrement_company"];
        $pdo->prepare("UPDATE SponsoringCompany SET NumOfEmails = GREATEST(NumOfEmails - 1, 0) WHERE companyID = ?")->execute([$id]);
        $confirmationMessage = "<p style='color: orange; margin-top: 10px;'>Updates: for Company ID $id</p>";
    }
}
?>

<h2>List of Sponsoring Companies</h2>

<style>
    table {
        border-collapse: collapse;
        width: 80%;
        margin: 20px 0;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 12px 16px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    button {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        margin: 0 2px;
    }

    .add-btn {
        background-color: #28a745;
        color: white;
    }

    .subtract-btn {
        background-color: #dc3545;
        color: white;
    }

    button:hover {
        opacity: 0.85;
    }
</style>

<?php
$stmt = $pdo->query("SELECT companyID, companyStatus, NumOfEmails FROM SponsoringCompany");
$companies = $stmt->fetchAll();

if ($companies) {
    echo "<table>
            <tr>
                <th>Company ID</th>
                <th>Status</th>
                <th># of Emails</th>
                <th>Actions</th>
            </tr>";
    foreach ($companies as $c) {
        echo "<tr>
                <td>{$c['companyID']}</td>
                <td>{$c['companyStatus']}</td>
                <td>{$c['NumOfEmails']}</td>
                <td>
                    <form method='POST' style='display:inline;'>
                        <input type='hidden' name='increment_company' value='{$c['companyID']}'>
                        <button class='add-btn' type='submit'>+1 Email</button>
                    </form>
                    <form method='POST' style='display:inline;'>
                        <input type='hidden' name='decrement_company' value='{$c['companyID']}'>
                        <button class='subtract-btn' type='submit'>-1 Email</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No sponsoring companies found.</p>";
}

// Display confirmation message after the table
echo $confirmationMessage;
?>

</div> <!-- close main-content -->
</body>
</html>
