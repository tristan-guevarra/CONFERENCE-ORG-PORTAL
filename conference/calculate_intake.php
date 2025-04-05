<?php
include 'db_connect.php';
include 'navbar.php';
?>

<h2>Conference Income Summary</h2>

<style>
    table {
        border-collapse: collapse;
        width: 60%;
        margin-top: 20px;
        font-size: 16px;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 12px 16px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:last-child {
        font-weight: bold;
        background-color: #e9f5e9;
    }

    .note {
        margin-top: 10px;
        font-size: 14px;
        color: #666;
    }
</style>

<?php
// Constants
$registrationFee = 100; // Per attendee
$sponsorEmailRate = 200; // Per sponsor email

// Total number of attendees
$stmt = $pdo->query("SELECT COUNT(*) as count FROM Attendee");
$totalAttendees = $stmt->fetch()['count'];
$totalRegistration = $totalAttendees * $registrationFee;

// Estimate sponsorship income
$stmt = $pdo->query("SELECT SUM(NumOfEmails * {$sponsorEmailRate}) as sponsorAmount FROM SponsoringCompany");
$totalSponsorship = $stmt->fetch()['sponsorAmount'] ?? 0;

// Calculate grand total
$grandTotal = $totalRegistration + $totalSponsorship;

// Display summary
echo "<table>
        <tr>
            <th>Source</th>
            <th>Amount ($)</th>
        </tr>
        <tr>
            <td>Total Attendee Registration ({$totalAttendees} × \${$registrationFee})</td>
            <td>\${$totalRegistration}</td>
        </tr>
        <tr>
            <td>Total Sponsorship (Estimated from Emails Sent)</td>
            <td>\${$totalSponsorship}</td>
        </tr>
        <tr>
            <th>Total Conference Income</th>
            <th>\${$grandTotal}</th>
        </tr>
      </table>";

echo "<p class='note'>* Sponsorships are estimated using \$${sponsorEmailRate} per email interaction.</p>";
?>

</div> <!-- close main-content -->
</body>
</html>
