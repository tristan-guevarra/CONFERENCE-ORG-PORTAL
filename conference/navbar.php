<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 200px;
            background-color: #f4f4f4;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            overflow-y: auto;
        }

        .sidebar h2 {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            padding: 10px 0;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .sidebar a:hover {
            color:rgb(0, 255, 242);
            /* my fav colour as the hover heheheheheheh */
        }

        .main-content {
            margin-left: 220px; 
            padding: 40px;
            flex-grow: 1;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2 style="color: rgba(16, 49, 48, 0.76);">Navigation Bar</h2>
    <a href="conference.php">Homepage</a>
    <a href="view_subcommittee_members.php">View Members</a>
    <a href="occupants.php">Occupant Rooms</a>
    <a href="daily_schedule.php">Daily Schedule</a>
    <a href="sponsor_list.php">Sponsors List</a>
    <a href="company_jobs.php">Company Jobs</a>
    <a href="list_attendees.php">Attendees</a>
    <a href="add_attendee.php">Add an Attendee</a>
    <a href="calculate_intake.php">Conference Income</a>
    <a href="add_sponsor.php">Add a Sponsor</a>
    <a href="delete_sponsor.php">Delete Sponsor</a>
    <a href="switch_session.php">Switch Sessions</a>
</div>

<div class="main-content">
