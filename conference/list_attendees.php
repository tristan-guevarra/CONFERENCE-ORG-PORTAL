<?php
include 'db_connect.php';
include 'navbar.php';

// this is for the handling of the delete button
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteAttendee'])) {
    $id = $_POST['deleteAttendee'];
    $stmt = $pdo->prepare("DELETE FROM Attendee WHERE attendeeID = ?");
    $stmt->execute([$id]);
    echo "<p class='success'>Attendee ID $id deleted successfully.</p>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteMember'])) {
    $id = $_POST['deleteMember'];
    $stmt = $pdo->prepare("DELETE FROM Member WHERE memberID = ?");
    $stmt->execute([$id]);
    echo "<p class='success'>Committee member ID $id deleted successfully.</p>";
}
?>

<h2>List of All Attendees</h2>

<style>
    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 15px;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 10px 14px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    form {
        display: inline;
    }

    button.delete-btn {
        padding: 4px 8px;
        font-size: 13px;
        background-color: #f8f8f8;
        border: 1px solid #ccc;
        cursor: pointer;
    }

    button.delete-btn:hover {
        background-color: #eaeaea;
    }

    .success {
        color: green;
        font-weight: bold;
        margin-bottom: 10px;
    }
</style>

<!-- students part of it -->
<h3>Students</h3>
<?php
$sql = "SELECT A.attendeeID, A.firstName, A.lastName, A.email, S.roomNumber,
               (SELECT GROUP_CONCAT(DISTINCT CM.subCommitteeName SEPARATOR ', ')
                FROM CommitteeMembership CM
                JOIN Member M ON M.memberID = CM.memberID
                WHERE M.email = A.email) AS subcommittees
        FROM Attendee A
        JOIN Student S ON A.attendeeID = S.attendeeID";
$stmt = $pdo->query($sql);
$students = $stmt->fetchAll();

if ($students) {
    echo "<table>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Room #</th><th>Subcommittees</th><th>Delete</th></tr>";
    foreach ($students as $s) {
        echo "<tr>
                <td>{$s['attendeeID']}</td>
                <td>{$s['firstName']} {$s['lastName']}</td>
                <td>{$s['email']}</td>
                <td>{$s['roomNumber']}</td>
                <td>" . ($s['subcommittees'] ?? '-') . "</td>
                <td>
                    <form method='POST'>
                        <input type='hidden' name='deleteAttendee' value='{$s['attendeeID']}'>
                        <button class='delete-btn' type='submit'>Delete</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No students found.</p>";
}
?>

<!-- prof -->
<h3>Professionals</h3>
<?php
$sql = "SELECT A.attendeeID, A.firstName, A.lastName, A.email,
               (SELECT GROUP_CONCAT(DISTINCT CM.subCommitteeName SEPARATOR ', ')
                FROM CommitteeMembership CM
                JOIN Member M ON M.memberID = CM.memberID
                WHERE M.email = A.email) AS subcommittees
        FROM Attendee A
        JOIN Professional P ON A.attendeeID = P.attendeeID";
$stmt = $pdo->query($sql);
$pros = $stmt->fetchAll();

if ($pros) {
    echo "<table>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Subcommittees</th><th>Action</th></tr>";
    foreach ($pros as $p) {
        echo "<tr>
                <td>{$p['attendeeID']}</td>
                <td>{$p['firstName']} {$p['lastName']}</td>
                <td>{$p['email']}</td>
                <td>" . ($p['subcommittees'] ?? '-') . "</td>
                <td>
                    <form method='POST'>
                        <input type='hidden' name='deleteAttendee' value='{$p['attendeeID']}'>
                        <button class='delete-btn' type='submit'>Delete</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No professionals found.</p>";
}
?>

<!-- sponsoring -->
<h3>Sponsors</h3>
<?php
$sql = "SELECT A.attendeeID, A.firstName, A.lastName, A.email, SC.companyStatus,
               (SELECT GROUP_CONCAT(DISTINCT CM.subCommitteeName SEPARATOR ', ')
                FROM CommitteeMembership CM
                JOIN Member M ON M.memberID = CM.memberID
                WHERE M.email = A.email) AS subcommittees
        FROM Attendee A
        JOIN Sponsor S ON A.attendeeID = S.attendeeID
        JOIN SponsoringCompany SC ON S.companyID = SC.companyID";
$stmt = $pdo->query($sql);
$sponsors = $stmt->fetchAll();

if ($sponsors) {
    echo "<table>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Status</th><th>Subcommittees</th><th>Action</th></tr>";
    foreach ($sponsors as $s) {
        echo "<tr>
                <td>{$s['attendeeID']}</td>
                <td>{$s['firstName']} {$s['lastName']}</td>
                <td>{$s['email']}</td>
                <td>{$s['companyStatus']}</td>
                <td>" . ($s['subcommittees'] ?? '-') . "</td>
                <td>
                    <form method='POST'>
                        <input type='hidden' name='deleteAttendee' value='{$s['attendeeID']}'>
                        <button class='delete-btn' type='submit'>Delete</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No sponsors found.</p>";
}
?>

<!-- committee members, not needed but wanted to put it -->
<h3>Organizing Committee Members</h3>
<?php
$sql = "SELECT M.memberID, M.firstName, M.lastName, M.email,
               GROUP_CONCAT(DISTINCT CM.subCommitteeName SEPARATOR ', ') AS subcommittees
        FROM Member M
        LEFT JOIN CommitteeMembership CM ON M.memberID = CM.memberID
        GROUP BY M.memberID, M.firstName, M.lastName, M.email";
$stmt = $pdo->query($sql);
$members = $stmt->fetchAll();

if ($members) {
    echo "<table>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Subcommittees</th><th>Action</th></tr>";
    foreach ($members as $m) {
        echo "<tr>
                <td>{$m['memberID']}</td>
                <td>{$m['firstName']} {$m['lastName']}</td>
                <td>{$m['email']}</td>
                <td>" . ($m['subcommittees'] ?? '-') . "</td>
                <td>
                    <form method='POST'>
                        <input type='hidden' name='deleteMember' value='{$m['memberID']}'>
                        <button class='delete-btn' type='submit'>Delete</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No committee members found.</p>";
}
?>

</div> 
</body>
</html>
