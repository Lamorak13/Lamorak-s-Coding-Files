<?php 
    include("peakscinemas_database.php");

    $q = $_GET['q'] ?? '';
    $Movie_ID = filter_input(INPUT_GET, 'movie_id', FILTER_VALIDATE_INT);

    if ($q == 'movies') {
        $stmt = $conn->prepare("SELECT DISTINCT movie.Movie_ID, movie.MovieName, movie.MoviePoster
                                FROM daterange 
                                INNER JOIN movie
                                ON movie.Movie_ID = daterange.Movie_ID");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            echo '<p>No movies are in the system. Please upload a movie to see it here.</p>';
        } else {
            while($row = $result->fetch_assoc()) {
                echo '<div class="movieCard" id="', htmlspecialchars($row['Movie_ID']), '">';
                echo '<img src=../../', htmlspecialchars($row['MoviePoster']), ' class="moviePoster">';
                echo '<div class="movieName">', htmlspecialchars($row['MovieName']), '<div>';
                echo '</div>';
            }
        }

        $stmt->free_result();
    }
    
    if ($q == 'moviedetails') {
        $stmt = $conn->prepare("SELECT * FROM movie
                                WHERE Movie_ID = ?");
        $stmt->bind_param("i", $Movie_ID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            echo "<div id=failed>Loading...</div>";
        } else {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="leftSection">';
                echo '<div class="posterCard">';
                echo '<img src=../../', htmlspecialchars($row['MoviePoster']), ' class="moviePoster">';
                echo '<h1>', htmlspecialchars($row['MovieName']), '</h1>';
                echo '<p class="desc">', htmlspecialchars($row['MovieDescription']), '</p>';
                echo '<div class="bottomDetails">';
                echo '<div><strong>Genre:</strong> ', htmlspecialchars($row['Genre']), '</div>';
                echo '<div><strong>Rating:</strong> ', htmlspecialchars($row['Rating']), '</div>';
                echo '<div><strong>Runtime:</strong> ', htmlspecialchars($row['Runtime']), ' minutes </div>';
                echo '</div></div></div>';
            }
            
        }
    }

    if ($q == 'theaternames') {
        $stmt = $conn->prepare("SELECT DISTINCT theater.Theater_ID, theater.TheaterName
                                FROM theater");
        $stmt->execute();
        $result = $stmt->get_result();
        
        while($row = $result->fetch_assoc()) {
            echo '<label>';
            echo '<input type="radio" class="theaterSelection" name="theaterSelection" value="', $row['Theater_ID'], '" onclick="getTheaterInfo()">';
            echo htmlspecialchars($row['TheaterName']);
            echo '</label><br>';
        }
    }

    if ($q == 'theaterdatetimes') {
        $id = intval($_GET['id']);
        $stmt = $conn->prepare("SELECT DISTINCT daterange.DateRange_ID, dateRange.StartDate, dateRange.EndDate
                                FROM daterange
                                INNER JOIN theater
                                ON daterange.Theater_ID = theater.Theater_ID
                                WHERE daterange.Theater_ID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        while($row = $result->fetch_assoc()) {
            echo '<div class="currentDates" id=' . $row['DateRange_ID'] . '>StartDate: ' . $row['StartDate'] . ' ' . ' - End Date: ', $row['EndDate'], '</div>';
        }
    }

    if ($q == 'datetimesent') {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if ($data) {
            $Theater_ID = $data['Theater_ID'];
            $Movie_ID = $data['Movie_ID'];
            $StartDate = $data['StartDate'];
            $EndDate = $data['EndDate'];

            $stmt = $conn->prepare("INSERT INTO daterange (Movie_ID, Theater_ID, StartDate, EndDate)
                                    VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiss", $Movie_ID, $Theater_ID, $StartDate, $EndDate);
            $stmt->execute();

            $DateRange_ID = $conn->insert_id;

            $ScreeningType = "2D"; // TEMP

            foreach ($data['timeslots'] as $timeslot) {
                echo "hello";
                $date = $timeslot['date'];
                $time = $timeslot['timeslot'];

                $stmt2 = $conn->prepare("INSERT INTO timeslot (StartTime, Date, ScreeningType, Movie_ID, Theater_ID, DateRange_ID)
                                         VALUES (?, ?, ?, ?, ?, ?)");
                $stmt2->bind_param("sssiii", $time, $date, $ScreeningType, $Movie_ID, $Theater_ID, $DateRange_ID);
                $stmt2->execute();
            }
        }
    }

    if ($q == 'datedeletion') {
        echo ("true");
    }
?>