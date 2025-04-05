<?php include 'db_connect.php'; ?>
<?php include 'navbar.php'; ?>

<style>
    h2, h3 {
        margin-top: 20px;
    }

    form {
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
        margin-right: 8px;
    }

    select, input[type="text"], input[type="number"], button {
        padding: 6px 10px;
        margin-right: 10px;
        font-size: 14px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 15px;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 10px 14px;
        text-align: left;
        word-break: break-word;
    }

    th {
        background-color: #f9f9f9;
    }

    .success {
        color: green;
        margin-bottom: 15px;
    }

    hr {
        margin: 30px 0;
    }

    .filter-highlight {
        font-style: italic;
        color: #555;
        margin-top: -10px;
        margin-bottom: 10px;
    }
</style>

<h2>Job Postings by Sponsoring Companies</h2>

<!-- Add New Job -->
<h3>Add a New Job</h3>
<form method="POST">
    <label>Company:</label>
    <select name="new_companyID" required>
        <?php
        $stmt = $pdo->query("SELECT companyID FROM SponsoringCompany");
        foreach ($stmt as $row) {
            echo "<option value='{$row['companyID']}'>Company {$row['companyID']}</option>";
        }
        ?>
    </select><br><br>

    <label>Job Title:</label>
    <input type="text" name="jobTitle" required><br><br>

    <label>City:</label>
    <input type="text" name="jobCity" required><br><br>

    <label>Province:</label>
    <input type="text" name="jobProvince" required><br><br>

    <label>Pay ($):</label>
    <input type="number" name="jobPay" required><br><br>

    <button type="submit" name="addJob">Add Job</button>
</form>

<?php
if (isset($_POST["addJob"])) {
    $stmt = $pdo->prepare("INSERT INTO JobPost (jobID, companyID, jobTitle, jobCity, jobProvince, jobPay) 
                           VALUES ((SELECT IFNULL(MAX(jobID), 0) + 1 FROM JobPost), ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST["new_companyID"],
        $_POST["jobTitle"],
        $_POST["jobCity"],
        $_POST["jobProvince"],
        $_POST["jobPay"]
    ]);
    echo "<p class='success'>✅ Job added successfully.</p>";
}
?>

<hr>

<!-- Filter Jobs -->
<h3>Filter Jobs</h3>
<form method="POST">
    <label>Company:</label>
    <select name="companyID">
        <option value="">-- All Companies --</option>
        <?php
        $stmt = $pdo->query("SELECT companyID FROM SponsoringCompany");
        foreach ($stmt as $row) {
            $selected = ($_POST["companyID"] ?? '') == $row['companyID'] ? 'selected' : '';
            echo "<option value='{$row['companyID']}' $selected>Company {$row['companyID']}</option>";
        }
        ?>
    </select>

    <label>Province:</label>
    <input type="text" name="filterProvince" placeholder="e.g., Ontario" value="<?php echo $_POST["filterProvince"] ?? ''; ?>">

    <label>Min Pay ($):</label>
    <input type="number" name="minPay" value="<?php echo $_POST["minPay"] ?? ''; ?>">

    <button type="submit" name="filterJobs">Apply Filter</button>
</form>

<?php
// Setup filtering logic
$where = [];
$params = [];

if (isset($_POST["filterJobs"])) {
    if (!empty($_POST["companyID"])) {
        $where[] = "J.companyID = ?";
        $params[] = $_POST["companyID"];
    }

    if (!empty($_POST["filterProvince"])) {
        $where[] = "J.jobProvince = ?";
        $params[] = $_POST["filterProvince"];
    }

    if (!empty($_POST["minPay"])) {
        $where[] = "J.jobPay >= ?";
        $params[] = $_POST["minPay"];
    }
}

$sql = "SELECT J.jobTitle, J.jobCity, J.jobProvince, J.jobPay, C.companyID, C.companyStatus
        FROM JobPost J
        JOIN SponsoringCompany C ON J.companyID = C.companyID";

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY J.jobPay DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$jobs = $stmt->fetchAll();

echo "<h3>Job Listings</h3>";

// Display applied filters
if (isset($_POST["filterJobs"])) {
    $filters = [];

    if (!empty($_POST["companyID"])) {
        $filters[] = "Company {$_POST['companyID']}";
    }

    if (!empty($_POST["filterProvince"])) {
        $filters[] = "Province: {$_POST['filterProvince']}";
    }

    if (!empty($_POST["minPay"])) {
        $filters[] = "Min Pay: \${$_POST['minPay']}";
    }

    if ($filters) {
        echo "<p class='filter-highlight'><strong>Filters applied:</strong> " . implode(" | ", $filters) . "</p>";
    }
}

// Render results
if ($jobs) {
    echo "<table>
            <tr><th>Job Title</th><th>Company</th><th>City</th><th>Province</th><th>Pay ($)</th></tr>";
    foreach ($jobs as $j) {
        echo "<tr>
                <td>{$j['jobTitle']}</td>
                <td>{$j['companyID']} ({$j['companyStatus']})</td>
                <td>{$j['jobCity']}</td>
                <td>{$j['jobProvince']}</td>
                <td>{$j['jobPay']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No jobs found with current filters.</p>";
}
?>

</div> <!-- close main-content -->
</body>
</html>
