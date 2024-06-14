<?php
require_once "dbCon.php";


$sql = "SELECT teaminfo.TeamID, teaminfo.ProjectName, COUNT(votinginfo.VotingID) AS TotalVotes, (SELECT COUNT(VotingID) FROM votinginfo) AS TotalVotesOverall
        FROM teaminfo
        LEFT JOIN votinginfo ON teaminfo.TeamID = votinginfo.TeamID
        GROUP BY teaminfo.TeamID, teaminfo.ProjectName
        ORDER BY TotalVotes DESC, teaminfo.TeamID ASC";
$result = $con->query($sql);

// Initialize variables to keep track of previous row's vote count and rank
$prevVotes = -1; // Set to an invalid value to ensure it doesn't match the first row
$rank = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Votes</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="theme-default.css" class="template-customizer-theme-css" />
    </script>
    <script>
        // Function to refresh the table every 5 seconds
        $(document).ready(function () {
            setInterval(function () {
                $('#tableContainer').load(location.href + ' #voteTable');
            }, 3000);
        });
    </script>
    <style>
        body {
            background-color: white;
        }

        .table th {
            font-size: 1rem;
        }
    </style>
    <script src="bootstrap.js"></script>
</head>

<body>

    <h2 class="m-3 text-center">Voting Standings</h2>
    <?php
    $row = $result->fetch_assoc();
    echo "<h4>Total Votes = " . $row['TotalVotesOverall'] . "</h4>";
    $result->data_seek(0); // Rewind the result set pointer to the beginning
    ?>

    <div class="table-responsive p-3" id="tableContainer">

        <table class="table table-hover" id="voteTable">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>TeamSN</th>
                    <th>Project Name</th>
                    <th>Votes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    // Check if the current row has the same number of votes as the previous row
                    if ($row["TotalVotes"] != $prevVotes) {
                        $prevVotes = $row["TotalVotes"]; // Update previous votes count
                
                        echo "<tr ";
                        if ($rank == 1) {
                            echo 'class="table-dark"';
                        } else if ($rank == 2) {
                            echo 'class="table-info"';
                        } else if ($rank == 3) {
                            echo 'class=table-warning';
                        }

                        echo "><td>" . $rank . "</td><td>" . $row["TeamID"] . "</td><td>" . $row["ProjectName"] . "</td><td>" . $row["TotalVotes"] . "</td></tr>";
                        $rank++; // Increment rank if votes are different from previous row
                    } else {
                        echo "<tr ";
                        if ($rank - 1 == 1) {
                            echo 'class="table-dark"';
                        } else if ($rank - 1 == 2) {
                            echo 'class="table-info"';
                        } else if ($rank - 1 == 3) {
                            echo 'class=table-warning';
                        }
                        // If votes are the same as previous row, assign the same rank
                        echo "><td>" . $rank - 1 . "</td><td>" . $row["TeamID"] . "</td><td>" . $row["ProjectName"] . "</td><td>" . $row["TotalVotes"] . "</td></tr>";
                    }
                }
                ?>

            </tbody>
        </table>
    </div>



    <!-- <table id="voteTable">
        <tr>

        </tr>
        <?php
        // Output data of each row with rank
        /*while ($row = $result->fetch_assoc()) {
            // Check if the current row has the same number of votes as the previous row
            if ($row["TotalVotes"] != $prevVotes) {
                $prevVotes = $row["TotalVotes"]; // Update previous votes count
                echo "<tr><td>" . $rank . "</td><td>" . $row["TeamID"] . "</td><td>" . $row["ProjectName"] . "</td><td>" . $row["TotalVotes"] . "</td></tr>";
                $rank++; // Increment rank if votes are different from previous row
            } else {
                // If votes are the same as previous row, assign the same rank
                echo "<tr><td>" . $rank - 1 . "</td><td>" . $row["TeamID"] . "</td><td>" . $row["ProjectName"] . "</td><td>" . $row["TotalVotes"] . "</td></tr>";
            }
        } */
        ?>
    </table> -->

</body>

</html>

<?php
// Close database connection
$con->close();
?>