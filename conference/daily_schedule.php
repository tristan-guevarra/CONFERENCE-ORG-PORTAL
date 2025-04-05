<?php
include 'db_connect.php';
include 'navbar.php';
?>

<h2>Full Conference Schedule</h2>

<style>
    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 15px;
        font-size: 15px;
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
        margin-top: 30px;
    }

    label {
        font-weight: bold;
        margin-right: 10px;
    }

    select, button {
        padding: 6px 12px;
        font-size: 14px;
        margin-right: 10px;
    }

    h3, h4 {
        margin-top: 30px;
    }

    ul {
        margin-left: 20px;
    }

    hr {
        margin: 40px 0;
    }
</style>

<?php
// Fetch all sessions
$sql = "SELECT S.sessionID, S.topic, S.roomNumber, S.startTime, S.endTime,
               A.firstName AS speakerFirst, A.lastName AS speakerLast
        FROM Session S
        JOIN Attendee A ON S.speakerID = A.attendeeID
        ORDER BY S.startTime ASC";

$stmt = $pdo->query($sql);
$sessions = $stmt->fetchAll();

if ($sessions) {
    echo "<table>
            <tr>
                <th>Time</th>
                <th>Topic</th>
                <th>Room</th>
                <th>Speaker</th>
            </tr>";
    foreach ($sessions as $s) {
        echo "<tr>
                <td>{$s['startTime']} – {$s['endTime']}</td>
                <td>{$s['topic']}</td>
                <td>{$s['roomNumber']}</td>
                <td>{$s['speakerFirst']} {$s['speakerLast']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No sessions scheduled yet.</p>";
}
?>

<hr>

<h2>Detailed Schedule by Start Time</h2>

<form method="POST">
    <label for="startTime">Select a Start Time:</label>
    <select name="startTime" id="startTime">
        <?php
        $stmt = $pdo->query("SELECT DISTINCT startTime FROM Session ORDER BY startTime ASC");
        foreach ($stmt as $row) {
            echo "<option value='{$row['startTime']}'>{$row['startTime']}</option>";
        }
        ?>
    </select>
    <button type="submit">View Details</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["startTime"])) {
    $time = $_POST["startTime"];

    $sql = "SELECT S.sessionID, S.topic, S.roomNumber, S.startTime, S.endTime,
                   A.firstName AS speakerFirst, A.lastName AS speakerLast
            FROM Session S
            JOIN Attendee A ON S.speakerID = A.attendeeID
            WHERE S.startTime = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$time]);
    $sessions = $stmt->fetchAll();

    echo "<h3>Detailed Schedule for $time</h3>";

    if ($sessions) {
        foreach ($sessions as $s) {
            echo "<ul>
                    <li><strong>Session ID:</strong> {$s['sessionID']}</li>
                    <li><strong>Topic:</strong> {$s['topic']}</li>
                    <li><strong>Room:</strong> {$s['roomNumber']}</li>
                    <li><strong>Start Time:</strong> {$s['startTime']}</li>
                    <li><strong>End Time:</strong> {$s['endTime']}</li>
                    <li><strong>Speaker:</strong> {$s['speakerFirst']} {$s['speakerLast']}</li>
                  </ul>";

            // Breakdown
            echo "<h4>Session Breakdown</h4><ul>";
            switch ($s['topic']) {
                case 'Database Management Systems':
                    echo "<li>8:00–8:15: Welcome & Overview</li>";
                    echo "<li>8:15–8:30: Importance of DBMS in Enterprise</li>";
                    echo "<li>8:30–8:50: Types of DBMS</li>";
                    echo "<li>8:50–9:10: Intro to Relational Model</li>";
                    echo "<li>9:10–9:30: Q&A and Wrap-Up</li>";
                    break;

                case 'ER Models':
                    echo "<li>10:00–10:05: Quick Recap</li>";
                    echo "<li>10:05–10:15: Entities and Attributes</li>";
                    echo "<li>10:15–10:25: Relationships</li>";
                    echo "<li>10:25–10:30: ER Diagrams Demo</li>";
                    break;

                case 'Relational Model and Data Definition':
                    echo "<li>11:00–11:10: What is a Relational Model?</li>";
                    echo "<li>11:10–11:20: Keys and Constraints</li>";
                    echo "<li>11:20–11:30: Creating Tables in SQL</li>";
                    break;

                case 'ER to Relational':
                    echo "<li>12:00–12:10: Mapping Entities</li>";
                    echo "<li>12:10–12:20: Mapping Relationships</li>";
                    echo "<li>12:20–12:30: Schema Design Practice</li>";
                    break;

                case 'Midterm Preparation':
                    echo "<li>13:00–13:20: Key Topics Overview</li>";
                    echo "<li>13:20–13:40: Sample Questions & Solutions</li>";
                    echo "<li>13:40–14:00: Tips + Open Q&A</li>";
                    break;

                case '12 Week Crash Course':
                    echo "<li>15:30–15:45: Syllabus Speedrun</li>";
                    echo "<li>15:45–16:15: Weekly Themes & Takeaways</li>";
                    echo "<li>16:15–16:45: Past Exam Review</li>";
                    echo "<li>16:45–17:00: Study Resources</li>";
                    break;

                default:
                    echo "<li>No breakdown available for this topic.</li>";
                    break;
            }

            echo "</ul><hr>";
        }
    } else {
        echo "<p>No sessions found for that time.</p>";
    }
}
?>

</div> <!-- close main-content -->
</body>
</html>
