<?php
include 'db_connect.php';
include 'navbar.php';
?>

<h2>All Available Job Listings</h2>

<?php
$sql = "SELECT J.jobTitle, J.jobCity, J.jobProvince, J.jobPay, C.companyID, C.companyStatus
        FROM JobPost J
        JOIN SponsoringCompany C ON J.companyID = C.companyID";
$stmt = $pdo->query($sql);
$jobs = $stmt->fetchAll();

if ($jobs) {
    echo "<table border='1'>
            <tr><th>Job Title</th><th>Company ID</th><th>Status</th><th>City</th><th>Province</th><th>Pay ($)</th></tr>";
    foreach ($jobs as $j) {
        echo "<tr>
                <td>{$j['jobTitle']}</td>
                <td>{$j['companyID']}</td>
                <td>{$j['companyStatus']}</td>
                <td>{$j['jobCity']}</td>
                <td>{$j['jobProvince']}</td>
                <td>{$j['jobPay']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No job listings found.</p>";
}
?>

</div> <!-- close main-content -->
</body>
</html>
