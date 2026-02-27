<?php 
    include("peakscinemas_database.php");
    
    $Mall_ID = filter_input(INPUT_GET, 'mall_id', FILTER_VALIDATE_INT);
    $Theater_ID = filter_input(INPUT_GET, 'theater_id', FILTER_VALIDATE_INT);

    $movie_search = $conn -> query("SELECT Movie_ID, MovieName FROM movie");

    if ($Mall_ID && $Theater_ID) {
        $stmt = $conn -> prepare("SELECT * FROM mall WHERE Mall_ID = ?");
        $stmt -> execute([$Mall_ID]);
        $mallDetails = ($stmt -> get_result()) -> fetch_assoc();

        $theater_stmt = $conn -> prepare("SELECT * FROM theater WHERE Theater_ID = ?");
        $theater_stmt -> execute([$Theater_ID]);
        $theaterDetails = $theater_stmt -> get_result() -> fetch_assoc();

        $seats_stmt = $conn -> prepare("SELECT * FROM seats WHERE Theater_ID = ?");
        $seats_stmt -> execute([$Theater_ID]);
        $seatLayout = $seats_stmt -> get_result();

        if ($seatLayout) {
            $layoutProper = [];

            while ($seat = $seatLayout -> fetch_assoc()) {
                $rows = $seat['SeatRow'];
                $cols = $seat['SeatColumn'];
                $layoutProper[$rows][] = $seat;
            }
        }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $StartTime = $EndTime = $Date = $ScreeningType = $Movie_ID = $Theater_ID = "";
        // input cleanup func for later use   
        function input_cleanup($data) {
        $data = trim($data);
        $data = stripslashes($data);
        return $data;
        }

        $StartTime = input_cleanup($_POST['startTime']);
        $Date = input_cleanup($_POST['Date']);
        $ScreeningType = input_cleanup($_POST['screeningType']);
        $Movie_ID = input_cleanup($_POST['movie_id']);
        $Theater_ID = input_cleanup($_POST['theater_id']);

        $stmt = $conn -> prepare("INSERT INTO timeslot(StartTime, Date, ScreeningType, Movie_ID, Theater_ID)
                                  VALUES (?, ?, ?, ?, ?)");
        $stmt -> bind_param("sssii", $StartTime, $Date, $ScreeningType, $Movie_ID, $Theater_ID);
        $stmt -> execute();
    }

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
    <head>
        <style>
            #theaterInformation {
                display: flex;
                align-items: stretch;
            }

            section {
                border: 2px solid black;
                display: inline-block;
                width: auto;
                padding: 20px;
            }

            #screeningFormSection {
                height: auto;
            }

            .theaterScreen {
                border: 3px solid black;
                background-color: #9eb0ecff;
                width: 100%;
                text-align: center;
                font-weight: bold;
                margin-bottom: 10px;
                border-radius: 5%;
            }

            .theaterSeat {
                border: 1px solid black;
                background-color: #be6363ff;
                width: 25px;
                height: 25px;
                text-align: center;
                vertical-align: middle;
                border-radius: 20%;
            }

            .emptySeat {                
                width: 25px;
                height: 25px;
                background-color: transparent;
                border: 1px solid transparent;
            }
        </style>
    </head>
    <body>
        <header>
            <nav>
                <a href="dashboard.php" target="_self">Dashboard</a>
                <a href="malls_selection_admin.php" target="_self">Malls</a>
                <a href="movie_upload.php" target="_self">Movie Upload</a>
                <a href="theater_upload.php" target="_self">Theater Upload</a>
                <a href="mall_upload.php" target="_self">Mall Upload</a>
            </nav>            
        </header>
        <main>
            <div> <?= htmlspecialchars($mallDetails['MallName']) ?> - <?= htmlspecialchars($theaterDetails['TheaterName']) ?> </div>
            
            <div id = "theaterInformation">
                <section id = "theaterLayoutSection">

                    <span>Layout Preview:</span><br><br>
                    <div class = "theaterScreen">SCREEN</div>

                    <table>
                        <?php foreach ($layoutProper as $row => $columns): ?> 
                            <tr class = "seatRows">
                                <th><?= htmlspecialchars($row) ?></th>
                                <?php foreach ($columns as $seat): ?>
                                    <?php if ($seat['SeatType'] === 'Empty' || $seat['SeatColumn'] == 0): ?>
                                        <td class = "emptySeat"></td>
                                    <?php else: ?>
                                        <td class = "theaterSeat"><?=htmlspecialchars($seat['SeatColumn'])?></td>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <th><?= htmlspecialchars($row) ?></th>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                </section>
                <section id = "screeningFormSection">
                    <form id = "screeningForm" name = "screeningForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?mall_id=' . urlencode($Mall_ID) . '&theater_id=' . urlencode("$Theater_ID"); ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <div>
                            <label for="Date">Date of screening: </label>
                            <input type="date" id="Date" name="Date" required>
                        </div>
                        <div>
                            <label for="startTime">Time of screening: </label>
                            <input type="time" id="startTime" name="startTime" required>
                        </div>
                        <br>
                        
                        <div>
                            <label for = "movie_id">Select a movie: </label>
                            <select id = "movie_id" name = "movie_id">
                                <option value = "">Select a movie</option>
                                <?php if($movie_search -> num_rows > 0): ?>
                                    <?php while($row = $movie_search -> fetch_assoc()): ?>
                                        <option value =' <?= htmlspecialchars($row['Movie_ID']) ?> '>
                                            <?= htmlspecialchars($row['MovieName']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <br>
                        <div>
                            <label for="screeningType">Screening Type: </label>
                            <select id="screeningType" name="screeningType">
                                <option value = "">Screening Type</option>
                                <option value = "2D">2D</option>
                                <option value = "3D">3D</option>
                            </select>
                        </div>
                        <input type="hidden" name="theater_id" id="theater_id" value="<?= htmlspecialchars($Theater_ID) ?>">

                        <div>
                            <button type="submit" name="screeningDetails" value="screeningDetails">Upload</button>
                        </div>
                    </form>
                </section>
            </div>
        </main>

        <script>
            const date = new Date();
            date.setDate(date.getDate() + 1);
            const tomorrow = date.toISOString().split('T')[0];
            document.getElementById('screeningDate').setAttribute("min", tomorrow)

            //

            const screeningDate = document.getElementById("screeningDate")
        </script>
    </body>
</html>