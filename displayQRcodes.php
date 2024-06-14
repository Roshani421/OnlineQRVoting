<?php
require_once "dbCon.php";

//Ip address of the host
$ip = gethostbyname(gethostname());

$query = "SELECT teaminfo.TeamID, teaminfo.ProjectName FROM teaminfo";
$result = $con->query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Voting</title>
    <style>
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .card {
            width: 100px;
            height: 100px;
            margin-right: 1rem;
            margin-bottom: 2.5rem;
            border: 3px solid lime;
        }

        .info {
            margin-bottom: 1rem;
        }

        .slider-container {
            width: 80%;
            margin: 20px 0;
        }

        .slider {
            width: 50%;
        }

        .controls {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="qrcode.min.js"></script>

<body>
    <div class="container">
        <div class="controls">
            <div class="slider-container">
                <input type="range" min="80" max="200" value="90" class="slider" id="sizeSlider">
            </div>
            <div>
                <button class="fullscreen-button" onclick="toggleFullscreen()">Toggle Fullscreen</button>
            </div>
            <div>
                <button onclick="toggleControls()">Hide</button>
            </div>
        </div>

        <div class=" cards-container" id="cardsContainer">
                    <?php
                    while ($row = $result->fetch_assoc()) { ?>
                        <div class="card" title="<?= $row["ProjectName"]; ?>">
                            <div class="card-body">
                                <?php
                                $data = "http://" . $ip . "/voting.php?GroupSN=" . $row["TeamID"];

                                echo '<img src="https://api.qrserver.com/v1/create-qr-code/?data=' . urlencode($data) . '&amp;size=100x100" alt="QR Code" class="qr-code">';
                                ?>
                            </div>
                            <div class="info">
                                <?php echo $row["ProjectName"]; ?>
                            </div>
                        </div>
                    <?php }
                    ?>
            </div>
        </div>
</body>
<script>
    const sizeSlider = document.getElementById('sizeSlider');
    const cards = document.querySelectorAll('.card');

    sizeSlider.addEventListener('input', () => {
        const newSize = sizeSlider.value + 'px';
        cards.forEach(card => {
            card.style.width = newSize;
            card.style.height = newSize;
            const qrCode = card.querySelector('.qr-code');
            qrCode.style.width = newSize;
            qrCode.style.height = newSize;
        });
    });
    function toggleFullscreen() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
    }
    function toggleControls() {
        var controls = document.querySelector('.controls');
        controls.style.display = 'none'; 
    }
</script>

</html>