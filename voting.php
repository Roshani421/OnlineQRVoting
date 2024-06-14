<?php
require_once "dbCon.php";
$data = (isset($_GET['GroupSN'])) ? $_GET['GroupSN'] : null;
// echo $data;
$voteCount = isset($_COOKIE['vote_count']) ? $_COOKIE['vote_count'] : 0;
$votedGroup = [];
$message = "";

function hasVotedForGroup($groupId)
{
    return isset($_COOKIE['voted_groups'][$groupId]);
}
function hasReachedMaxVotes()
{
    return isset($_COOKIE['vote_count']) && $_COOKIE['vote_count'] >= 3;
}

if (isset($_GET['GroupSN'])) {

    if (is_numeric($_GET['GroupSN'])) {
        $selectedGroup = $_GET['GroupSN'];
    } else {
        echo '<div class="error"><p>Invalid Group Number!!!</p></div>';
        exit();
    }
    $selectedGroup = htmlspecialchars($selectedGroup, ENT_QUOTES, 'UTF-8');

    if (hasVotedForGroup($selectedGroup)) {
        $message = "You have already voted for <b>Group Number $selectedGroup</b>." . '</p><p>' . "Number of Votes left = " . (3 - $voteCount) . '</p>';
        // print_r($_COOKIE);
    } elseif (hasReachedMaxVotes()) {
        $message = "You have reached the maximum number of votes." . '</p><p>' . "Number of Votes left = " . (3 - $voteCount) . '</p>';
        // print_r($_COOKIE);
    } else {

        $queryGroupID = "SELECT * FROM teamInfo WHERE TeamID = ?";
        $groupIDstmt = mysqli_prepare($con, $queryGroupID);
        mysqli_stmt_bind_param($groupIDstmt, "i", $selectedGroup);
        mysqli_stmt_execute($groupIDstmt);
        mysqli_stmt_store_result($groupIDstmt);

        if (mysqli_stmt_num_rows($groupIDstmt) > 0) {

            $stmt = mysqli_prepare($con, "INSERT INTO votingInfo (TeamID) VALUES (?)");
            mysqli_stmt_bind_param($stmt, "i", $selectedGroup);
            $resultQuery = mysqli_stmt_execute($stmt);

            if ($resultQuery) {
                if (isset($_COOKIE['vote_count'])) {
                    $voteCount = $_COOKIE['vote_count'] + 1;
                    setcookie('vote_count', $voteCount, time() + (24 * 60 * 60 * 3), '/');
                } else {
                    setcookie('vote_count', 1, time() + (24 * 60 * 60 * 3), '/');
                    $voteCount++;
                }
                // Bind the result variables
                mysqli_stmt_bind_result($groupIDstmt, $teamID, $projectName);

                // Fetch the result (assuming you're fetching a single row)
                mysqli_stmt_fetch($groupIDstmt);
                echo $projectName;
                setcookie('voted_groups[' . $selectedGroup . ']', $projectName, time() + (24 * 60 * 60 * 3), '/');
                // print_r($_COOKIE);

                if (!isset($_COOKIE['voted_groups'])) {
                    $votedGroup[$selectedGroup] = $projectName;
                    // echo 'SIngle =';
                } else if (isset($_COOKIE['voted_groups']) && (count($_COOKIE['voted_groups']) == $_COOKIE['vote_count'])) {
                    $votedGroup = $_COOKIE['voted_groups'];
                    $votedGroup[$selectedGroup] = $projectName;
                    // echo 'not equal =';
                } else {
                    $votedGroup = $_COOKIE['voted_groups'];
                    // echo 'equal =';
                }
                // print_r($votedGroup);
                $message = "<p>Thank you for voting <b>Group Number $selectedGroup</b> </p><p> Number of Votes left = " . 3 - $voteCount . '</p>';
            } else {
                $message = "<p><h2>Error : Insertion Failed !!!</h2></p>";
            }
            mysqli_stmt_close($stmt);
        } else {
            $message = "<p><h2>Group $selectedGroup does not exists !!!</h2></p>";
        }
        mysqli_stmt_close($groupIDstmt);
        mysqli_close($con);
    }
} else {
    header('Location: index.php');
    exit;
}
?>

<html>

<head>
    <title>Voting System</title>
</head>
<link rel="stylesheet" href="core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="theme-default.css" class="template-customizer-theme-css" />
<script src="bootstrap.js"></script>

<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            height: 100vh; /* Full height of the viewport */
            margin: 0;
        }

        .container {
    width: 90%;
    max-width: 1000px;
    padding: 40px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4); /* Modified box-shadow */
}


        .welcome {
            text-align: center;
            margin-bottom: 30px;
        }

        .welcome img {
            width: 150px;
            height: auto;
        }

        .welcome h1 {
            font-family: 'Times New Roman', Times, serif;
            color: #1565c0;
            margin-top: 10px;
            margin-bottom: 0;
        }


        .container-body {
            text-align: center;
        }

        h3 {
            color: #1976d2;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .vote-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2196f3;
            box-shadow: 0 5px 8px rgba(0, 0, 0, 0.3); /* Modified box-shadow */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.3s; /* Added transform for hover effect */
            animation: pulse 1.5s infinite;

        }

        .vote-button:hover {
            background-color: #1976d2;
            transform: scale(1.05); /* Slightly scale up on hover */
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.6); /* Modified box-shadow */

        }


        /* Responsive Styles */
        @media only screen and (max-width: 600px) {
            .container {
                width: 90%;
            }
        }
    </style>

<body>
    <div class="container">
        <div class="welcome">
        <img src="assets/gces-it-expo-logo_social-media.jpg" alt="GCES EXPO Logo"> 
            <h1>Welcome to GCES EXPO 2024</h1>
        </div>
        <div class="container-body">
            <?php if (isset($message))
                echo "<p>$message</p>";
            if ((strpos($message, 'already voted') != false) || (strpos($message, 'maximum number') != false)) {
                echo '<h3>You have voted for the following groups :</h3>'; ?>

                <div class="table-responsive p-3" id="tableContainer">
                    <table class="table table-hover" id="voteTable">
                        <thead>
                            <tr>
                                <th>TeamSN</th>
                                <th>Project Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($_COOKIE['voted_groups'] as $group => $value) {
                                echo "<tr><td>" . $group. "</td><td>" . $value . "</td></tr>";
                                // echo "<p>Group Numer : " . $group . '</p>';
                            } ?>
                        </tbody>
                    </table>
                </div>

            <?php }


            if (count($votedGroup) != 0) {
                echo '<h3>You have voted for the following groups :</h3>'; ?>

                <div class="table-responsive p-3" id="tableContainer">
                    <table class="table table-hover" id="voteTable">
                        <thead>
                            <tr>
                                <th>TeamSN</th>
                                <th>Project Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($votedGroup as $group => $value) {
                                echo "<tr><td>" . $group. "</td><td>" . $value . "</td></tr>";
                                // echo "<p>Group Numer : " . $group . '</p>';
                            } ?>
                        </tbody>
                    </table>
                </div>
                <?php 
            }
            ?>
        </div>
    </div>
</body>

</html>
