<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GCES EXPO 2024 Voting System</title>
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
</head>
<body>
    <div class="container">
        <div class="welcome">
            <img src="assets/gces-it-expo-logo_social-media.jpg" alt="GCES EXPO Logo"> 
            <h1>Welcome to GCES EXPO 2024</h1>
        </div>
        <div class="container-body">
            <?php
            if (isset($_COOKIE['voted_groups'])) {
                $voteLeft = 3 - $_COOKIE['vote_count'];
                echo "<h3>Number of Votes left = $voteLeft</h3>";
                echo '<h3>You voted for the following groups:</h3>';
            ?>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>TeamSN</th>
                            <th>Project Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($_COOKIE['voted_groups'] as $group => $value) {
                            echo "<tr><td>$group</td><td>$value</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
                if ($voteLeft != 0) {
                    echo "<a href='#' class='vote-button'>Please Scan to Vote</a>";
                }
            } else {
                echo "<h3>Number of Votes left = 3</h3>";
                echo "<a href='#' class='vote-button'>Please Scan to Vote</a>";
            }
            ?>
        </div>
    </div>
</body>
</html>