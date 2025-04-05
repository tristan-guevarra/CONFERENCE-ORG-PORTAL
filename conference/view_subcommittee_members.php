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
        margin-top: 10px;
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

    hr {
        margin: 25px 0;
    }

    .grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .grid-box {
        flex: 1 1 calc(33.333% - 20px);
        border: 1px solid #ccc;
        padding: 10px;
        box-sizing: border-box;
        min-width: 280px;
        max-width: 100%;
        overflow-x: auto;
        background-color: #fafafa;
    }

    .grid-box h4 {
        margin-top: 0;
        margin-bottom: 8px;
    }
</style>

<h2>Subcommittee Members</h2>

<!-- Subcommittee dropdown selection -->
<form method="POST">
    <label for="subCommitteeID">Select Subcommittee:</label>
    <select name="subCommitteeID" id="subCommitteeID" required>
        <option value="">-- Choose --</option>
        <?php
        $stmt = $pdo->query("SELECT subCommitteeID, name FROM SubCommittee");
        $selected = $_POST['subCommitteeID'] ?? '';
        while ($row = $stmt->fetch()) {
            $isSelected = $selected == $row['subCommitteeID'] ? 'selected' : '';
            echo "<option value='{$row['subCommitteeID']}' $isSelected>{$row['name']}</option>";
        }
        ?>
    </select>
    <button type="submit" name="view">View Members</button>
</form>

<!-- View All Subcommittees -->
<form method="POST">
    <button type="submit" name="viewAll">View All Subcommittees with Members</button>
</form>

<hr>

<?php
// View selected subcommittee
if (isset($_POST["view"]) && !empty($_POST["subCommitteeID"])) {
    $id = $_POST["subCommitteeID"];

    // Get subcommittee info
    $infoStmt = $pdo->prepare("SELECT name, committeeID FROM SubCommittee WHERE subCommitteeID = ?");
    $infoStmt->execute([$id]);
    $info = $infoStmt->fetch();

    echo "<h3>{$info['name']} (Committee ID: {$info['committeeID']})</h3>";

    $sql = "SELECT M.firstName, M.lastName, M.email
            FROM Member M
            JOIN CommitteeMembership CM ON M.memberID = CM.memberID
            JOIN SubCommittee SC ON CM.subCommitteeName = SC.name
            WHERE SC.subCommitteeID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $members = $stmt->fetchAll();

    if ($members) {
        echo "<table>
                <tr><th>First Name</th><th>Last Name</th><th>Email</th></tr>";
        foreach ($members as $m) {
            echo "<tr>
                    <td>{$m['firstName']}</td>
                    <td>{$m['lastName']}</td>
                    <td>{$m['email']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No members found for this subcommittee.</p>";
    }
}

// View all subcommittees with members
if (isset($_POST["viewAll"])) {
    echo "<h3>All Subcommittees & Members</h3>";

    $sql = "SELECT SC.subCommitteeID, SC.name AS subName, SC.committeeID, M.firstName, M.lastName, M.email
            FROM SubCommittee SC
            LEFT JOIN CommitteeMembership CM ON SC.name = CM.subCommitteeName
            LEFT JOIN Member M ON CM.memberID = M.memberID
            ORDER BY SC.subCommitteeID";

    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();

    if ($results) {
        $subcommitteeGroups = [];
        foreach ($results as $row) {
            $key = $row['subCommitteeID'] . '|' . $row['subName'] . '|' . $row['committeeID'];
            $subcommitteeGroups[$key][] = $row;
        }

        echo "<div class='grid'>";

        foreach ($subcommitteeGroups as $key => $members) {
            [$id, $name, $committeeID] = explode('|', $key);

            echo "<div class='grid-box'>";
            echo "<h4>$name <span style='font-weight: normal;'>(Committee ID: $committeeID)</span></h4>";

            echo "<table>
                    <tr><th>First Name</th><th>Last Name</th><th>Email</th></tr>";
            foreach ($members as $m) {
                echo "<tr>
                        <td>" . ($m['firstName'] ?? '-') . "</td>
                        <td>" . ($m['lastName'] ?? '-') . "</td>
                        <td>" . ($m['email'] ?? '-') . "</td>
                      </tr>";
            }
            echo "</table>";
            echo "</div>";
        }

        echo "</div>"; // Close grid
    } else {
        echo "<p>No subcommittees or members found.</p>";
    }
}
?>

</div> <!-- close main-content -->
</body>
</html>
