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
        $stmt = $conn->prepare("SELECT DISTINCT theater.Theater_ID, daterange.Theater_ID, theater.TheaterName
                                FROM daterange
                                INNER JOIN theater
                                ON theater.Theater_ID = daterange.Theater_ID");
        $stmt->execute();
        $result = $stmt->get_result();
        
        while($row = $result->fetch_assoc()) {
            echo '<input type="radio" class="theaterSelection" name="theaterSelection" value="', $row['Theater_ID'], '" onclick="theaterSelection()">', $row['TheaterName'], '</input>';
        }
    }
    
    
?>