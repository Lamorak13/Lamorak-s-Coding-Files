<?php
    include_once "peakscinemas_database.php";
    session_start();

    $profile_link = "personal_info_form.php";
    if (isset($_SESSION['user_id'])) {
        $profile_link = "profile_edit.php";
    }

    $Movie_ID = filter_input(INPUT_GET, 'movie_id', FILTER_VALIDATE_INT);

    if (!$Movie_ID) {
        header("Location: home.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM movie WHERE Movie_ID = ?");
    $stmt->bind_param("i", $Movie_ID);
    $stmt->execute();
    $movieDetails = ($stmt->get_result())->fetch_assoc();

    if (!$movieDetails) {
        header("Location: home.php");
        exit;
    }

    $trailerUrl = isset($movieDetails['TrailerURL']) ? $movieDetails['TrailerURL'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
<title><?= htmlspecialchars($movieDetails['MovieName']) ?> - Booking</title>
<style>
    * {margin:0; padding:0; box-sizing:border-box;}
    
    body {
        font-family: 'Outfit', sans-serif;
        background: url("movie-background-collage.jpg") no-repeat center center fixed;
        background-size: cover;
        color: #F9F9F9;
        padding-top: 100px;
        padding-bottom: 40px;
        display:flex;
        flex-direction:column;
        min-height: 100vh;
    }

    /* HEADER */
    header {
        background-color: #1C1C1C;
        display:flex;
        justify-content:space-between;
        align-items:center;
        padding:10px 30px;
        position:fixed;
        top:0; left:0;
        width:100%;
        z-index:1000;
        box-shadow: 0 2px 10px rgba(0,0,0,0.5);
    }

    .logo img {
        height: 50px;
        width: auto;
        cursor: pointer;
        transition: transform 0.2s ease;
        filter: invert(1);
    }
    .logo img:hover { transform: scale(1.05); }

    .profile-btn {
        background-color:#fff;
        border:1px solid #fff;
        border-radius:50%;
        width:45px; height:45px;
        display:flex; align-items:center; justify-content:center;
        cursor:pointer; transition: all 0.3s ease;
    }
    .profile-btn:hover {
        transform:scale(1.1);
        box-shadow:0 0 8px rgba(255,255,255,0.3);
    }

    /* MAIN LAYOUT */
    main {
        margin:30px auto;
        width:90%;
        max-width:1100px;
    }

    #movieContainer {
        display:flex;
        flex-direction: column;
        gap:20px;
        backdrop-filter: blur(8px);
        padding:30px;
        border-radius:12px;
        background-color: rgba(0,0,0,0.65);
        box-shadow: 0 8px 32px rgba(0,0,0,0.5);
    }

    /* TOP SECTION: Poster + Details */
    .topSection {
        display:flex;
        flex-wrap:wrap;
        gap:30px;
        width:100%;
        border-bottom: 1px solid rgba(255,255,255,0.15);
        padding-bottom: 25px;
    }

    .posterCard {
        position: relative;
    }

    .posterCard img {
        width:220px; 
        border-radius:8px; 
        box-shadow:0 5px 20px rgba(0,0,0,0.5);
    }

    .trailer-toggle {
        position: absolute;
        left: 12px;
        bottom: 12px;
        padding: 6px 14px;
        border-radius: 999px;
        border: none;
        background-color: rgba(0,0,0,0.8);
        color: #F9F9F9;
        font-family: 'Outfit', sans-serif;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        opacity: 0;
        transform: translateY(4px);
        transition: opacity 0.2s ease, transform 0.2s ease, background 0.2s ease;
        white-space: nowrap;
    }

    .posterCard:hover .trailer-toggle,
    .trailer-toggle:focus-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .trailer-toggle:hover {
        background-color: rgba(0,0,0,0.95);
    }

    .movieInfo {
        flex:1; 
        min-width:300px;
    }

    .movieInfo h1 {
        font-size: 2.5rem;
        margin-bottom: 15px;
        font-weight: 700;
    }

    /* Description lightly bigger */
    .movieInfo p.desc {
        font-size: 1.15rem;
        line-height: 1.6;
        margin-bottom: 20px;
        color: #e0e0e0;
    }

    .bottomDetails p {
        margin: 5px 0;
        font-size: 1rem;
        color: #ccc;
    }

    .trailer-panel {
        margin-top: 10px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0,0,0,0.6);
        background-color: rgba(0,0,0,0.8);
    }

    .trailer-panel video {
        width: 100%;
        height: auto;
        display: block;
        background-color: #000;
    }

    /* BOTTOM SECTION: Selections */
    #movieSelections {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
        margin-top: 5px;
    }

    .selection {
        flex: 1;
        display:flex;
        flex-direction:column;
    }

    .selection label {
        font-size: 0.9rem;
        margin-bottom: 8px;
        margin-left: 2px;
        font-weight: 500;
        color: #fff;
    }

    /* Inputs: Fitted, Theme Colors */
    select, input[type="date"] {
        width: 100%;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 0.95rem;
        border: none;
        background-color: #F9F9F9;
        color: #1C1C1C;
        outline: none;
        font-family: 'Outfit', sans-serif;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    /* Error Message */
    #mallAdvice {
        color: #ff6b6b;
        font-size: 0.85rem;
        margin-top: 8px;
        font-weight: 600;
        display: block;
    }

    /* Next Button: match seat_selection Complete Booking */
    #nextButton {
        align-self: flex-end;
        margin-top: 10px;
        padding: 8px 22px;
        border-radius: 8px;
        border: none;
        background-color: #ff4d4d;
        color: #F9F9F9;
        font-family: 'Outfit', sans-serif;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        visibility: hidden;
        transition: background 0.2s ease, transform 0.15s ease;
        white-space: nowrap;
    }

    #nextButton:hover {
        background-color: #ff4d4d;
        transform: scale(1.02);
    }

    /* Responsive adjustments */
    @media (max-width: 850px) {
        #movieSelections {
            flex-direction: column;
            gap: 20px;
        }
        .posterCard {
            margin: 0 auto;
        }
    }
</style>
</head>
<body>
<header>
    <div class="logo">
        <img src="peakscinematransparent.png" alt="PeaksCinemas Logo" onclick="window.location.href='home.php'" tabindex="0" onkeydown="if(event.key==='Enter' || event.key===' '){ event.preventDefault(); window.location.href='home.php'; }">
    </div>
    <button class="profile-btn" onclick="window.location.href='<?= $profile_link ?>'" title="Profile">👤</button>
</header>

<main>
    <div id="movieContainer">
        <div class="topSection">
            <div class="posterCard">
                <img src="/<?= htmlspecialchars($movieDetails['MoviePoster']) ?>" alt="<?= htmlspecialchars($movieDetails['MovieName']) ?>">
                <?php if (!empty($trailerUrl)): ?>
                    <button
                        type="button"
                        class="trailer-toggle"
                        id="trailerToggle"
                        aria-label="Play trailer"
                    >
                        <span id="trailerToggleIcon">▶</span>
                        <span id="trailerToggleText">Trailer</span>
                    </button>
                <?php endif; ?>
            </div>
            <div class="movieInfo">
                <h1><?= htmlspecialchars($movieDetails['MovieName']) ?></h1>
                <p class="desc"><?= htmlspecialchars($movieDetails['MovieDescription']) ?></p>
                <div class="bottomDetails">
                    <p><strong>Genre:</strong> <?= htmlspecialchars($movieDetails['Genre']) ?></p>
                    <p><strong>Rating:</strong> <?= htmlspecialchars($movieDetails['Rating']) ?></p>
                    <p><strong>Runtime:</strong> <?= htmlspecialchars($movieDetails['Runtime']) ?> minutes</p>
                </div>
            </div>
        </div>

        <?php if (!empty($trailerUrl)): ?>
            <div id="trailerPanel" class="trailer-panel" hidden>
                <video id="trailerVideo" controls preload="none">
                    <source src="<?= htmlspecialchars($trailerUrl) ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        <?php endif; ?>

        <div id="movieSelections">
            <div class="selection">
                <label for="dateSelection">1. Select a Date:</label>
                <input
                    type="date"
                    id="dateSelection"
                    value="2025-11-20"
                    min="2025-11-20"
                    max="2025-11-20"
                    onchange="getDate(this.value)"
                >
                <span id="mallAdvice" role="status" aria-live="polite"></span>
            </div>

            <div class="selection">
                <label for="mallSelection">2. Select a Mall:</label>
                <select id="mallSelection" onchange="getMall(this.value)" style="visibility:hidden;" disabled></select>
            </div>

            <div class="selection">
                <label for="theaterSelection">3. Select Theater Type:</label>
                <select id="theaterSelection" onchange="getTheaterType(this.value)" style="visibility:hidden;" disabled></select>
            </div>

            <div class="selection">
                <label for="timeslotSelection">4. Select a Time:</label>
                <select id="timeslotSelection" onchange="getTimeslot(this.value)" style="visibility:hidden;" disabled></select>
                <button id="nextButton">Next</button>
            </div>
        </div>
    </div>

    <script>
        const movieId = <?= json_encode($Movie_ID) ?>;
        const dateSelection = document.getElementById("dateSelection");
        const mallSelection = document.getElementById("mallSelection");
        const theaterSelection = document.getElementById("theaterSelection");
        const timeslotSelection = document.getElementById("timeslotSelection");
        const mallAdvice = document.getElementById("mallAdvice");
        const nextButton = document.getElementById("nextButton");
        const trailerToggle = document.getElementById("trailerToggle");
        const trailerPanel = document.getElementById("trailerPanel");
        const trailerVideo = document.getElementById("trailerVideo");
        const trailerToggleIcon = document.getElementById("trailerToggleIcon");
        const trailerToggleText = document.getElementById("trailerToggleText");

        // Trailer toggle (if trailer is available) and default date load
        document.addEventListener("DOMContentLoaded", function(){
            // auto-load default date (2025-11-20) so malls show immediately
            if (dateSelection && dateSelection.value) {
                getDate(dateSelection.value);
            }

            if (trailerToggle && trailerPanel && trailerVideo) {
                trailerToggle.addEventListener("click", function () {
                    const isHidden = trailerPanel.hasAttribute("hidden");
                    if (isHidden) {
                        trailerPanel.removeAttribute("hidden");
                        trailerVideo.play().catch(function () {});
                        if (trailerToggleIcon) trailerToggleIcon.textContent = "❚❚";
                        if (trailerToggleText) trailerToggleText.textContent = "Pause trailer";
                    } else {
                        trailerPanel.setAttribute("hidden", "");
                        trailerVideo.pause();
                        if (trailerToggleIcon) trailerToggleIcon.textContent = "▶";
                        if (trailerToggleText) trailerToggleText.textContent = "Trailer";
                    }
                });
            }
        });

        function getDate(date) {
            // Reset fields
            mallSelection.innerHTML = "";
            theaterSelection.innerHTML = "";
            timeslotSelection.innerHTML = "";
            mallAdvice.innerHTML = ""; // Clear error message immediately
            
            // Hide dependent fields
            mallSelection.style.visibility = "hidden";
            theaterSelection.style.visibility = "hidden";
            timeslotSelection.style.visibility = "hidden";
            nextButton.style.visibility = "hidden";
            mallSelection.disabled = true;
            theaterSelection.disabled = true;
            timeslotSelection.disabled = true;

            if(date !== "") {
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState === 4) {
                        if (this.status === 200) {
                            if (this.responseText.includes("<option")) {
                                // Valid malls found: Show dropdown and clear error
                                mallSelection.innerHTML = this.responseText;
                                mallAdvice.textContent = "";
                                mallSelection.style.visibility = "visible";
                                mallSelection.disabled = false;
                            } else {
                                // No malls found: Show error message
                                mallAdvice.textContent = this.responseText;
                            }
                        } else {
                            mallAdvice.textContent = "Unable to load malls. Please try another date.";
                        }
                    }
                };
                xhr.open("GET","queries.php?q=mall&dateSelection="+encodeURIComponent(date)+"&movie_id="+encodeURIComponent(movieId),true);
                xhr.send();
            }
        }

        function getMall(mall_id){
            theaterSelection.innerHTML = "";
            timeslotSelection.innerHTML = "";
            theaterSelection.style.visibility = "hidden";
            timeslotSelection.style.visibility = "hidden";
            nextButton.style.visibility = "hidden";
            theaterSelection.disabled = true;
            timeslotSelection.disabled = true;

            if(mall_id!==""){
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function(){
                    if (this.readyState === 4) {
                        if (this.status === 200) {
                            theaterSelection.innerHTML = this.responseText;
                            theaterSelection.style.visibility = "visible";
                            theaterSelection.disabled = false;
                        } else {
                            mallAdvice.textContent = "Unable to load theater types. Please try again.";
                        }
                    }
                };
                xhr.open("GET","queries.php?q=theater&dateSelection="+encodeURIComponent(dateSelection.value)+"&mall_id="+encodeURIComponent(mall_id)+"&movie_id="+encodeURIComponent(movieId),true);
                xhr.send();
            }
        }

        function getTheaterType(type){
            timeslotSelection.innerHTML = "";
            timeslotSelection.style.visibility = "hidden";
            nextButton.style.visibility = "hidden";
            timeslotSelection.disabled = true;

            if(type!==""){
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function(){
                    if (this.readyState === 4) {
                        if (this.status === 200) {
                            timeslotSelection.innerHTML = this.responseText;
                            timeslotSelection.style.visibility = "visible";
                            timeslotSelection.disabled = false;
                        } else {
                            mallAdvice.textContent = "Unable to load timeslots. Please try again.";
                        }
                    }
                };
                xhr.open("GET","queries.php?q=timeslot&dateSelection="+encodeURIComponent(dateSelection.value)+"&mall_id="+encodeURIComponent(mallSelection.value)+"&movie_id="+encodeURIComponent(movieId)+"&type="+encodeURIComponent(type),true);
                xhr.send();
            }
        }

        function getTimeslot(timeslot_id){
            if (timeslot_id !== "") {
                nextButton.style.visibility = "visible";
            } else {
                nextButton.style.visibility = "hidden";
            }
        }

        nextButton.addEventListener("click", function(){
            window.location.href = "seat_selection.php?movie_id="+encodeURIComponent(movieId)+"&mall_id=" + encodeURIComponent(mallSelection.value) + "&date=" + encodeURIComponent(dateSelection.value) + "&timeslot_id=" + encodeURIComponent(timeslotSelection.value);
        });
    </script>
</main>
</body>
</html>