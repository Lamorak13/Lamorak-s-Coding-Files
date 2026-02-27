<?php
include("peakscinemas_database.php");
session_start();

$profile_link = "personal_info_form.php";

if(isset($_SESSION['user_id'])) {
    $profile_link = "profile_edit.php";

    $stmt = $conn->prepare("SELECT Name, PhoneNumber, Email FROM customer WHERE Customer_ID = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $user_result = $stmt->get_result();
    if($user_result->num_rows > 0){
        $user = $user_result->fetch_assoc();
    }
}

if(isset($_GET['ajax_search']) && !empty($_GET['ajax_search'])){
    $term = "%{$_GET['ajax_search']}%";
    $stmt = $conn->prepare("SELECT Movie_ID, MovieName, MoviePoster FROM movie WHERE MovieName LIKE ?");
    $stmt->bind_param("s", $term);
    $stmt->execute();
    $result = $stmt->get_result();

    $movies = [];
    while($row = $result->fetch_assoc()){
        $movies[] = $row;
    }

    echo json_encode($movies);
    exit;
}

function getAvailableMovies($conn, $availability) {
    $stmt = $conn->prepare("SELECT * FROM movie WHERE MovieAvailability = ?");
    $stmt->bind_param("s", $availability);
    $stmt->execute();
    return $stmt->get_result();
}

$now_showing_results = getAvailableMovies($conn, 'Now Showing');
$coming_soon_results = getAvailableMovies($conn, 'Coming Soon');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
  <title>PeaksCinemas - Home</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; scroll-behavior: smooth; }

    body {
      font-family: 'Outfit', sans-serif;
      background: url("movie-background-collage.jpg") no-repeat center center fixed;
      background-size: cover;
      color: #F9F9F9;
      background-color: #1C1C1C;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    header {
      background-color: #1C1C1C;
      color: #F9F9F9;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 30px;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 4px 10px rgba(0,0,0,0.5);
    }

    .logo img {
      height: 50px;
      cursor: pointer;
      transition: transform 0.2s ease;
      filter: invert(1);
    }

    .logo img:hover { transform: scale(1.05); }

    .search-container { position: relative; margin: 0 20px; }

    .search-container input {
      width: 350px;
      padding: 10px 20px;
      border-radius: 25px;
      border: none;
      background: #F9F9F9;
      color: #1C1C1C;
      font-family: 'Outfit', sans-serif;
      font-size: 0.95rem;
      outline: none;
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .header-actions { display: flex; align-items: center; }

    .profile-btn {
      background-color: #F9F9F9;
      border: none;
      border-radius: 50%;
      width: 45px; height: 45px;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer;
      font-size: 1.2rem;
      transition: all 0.3s ease;
      box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .profile-btn:hover {
      transform: scale(1.1);
      box-shadow: 0 0 12px rgba(255,255,255,0.3);
    }

    .glassbox {
      margin: 30px auto;
      width: 90%;
      max-width: 1200px;
      padding: 30px 20px;
      backdrop-filter: blur(3px);
      background-color: rgba(0,0,0,0.5);
      border-radius: 8px;
      box-shadow: 0 8px 32px rgba(0,0,0,0.6);
      color: #F9F9F9;
    }

    .tabs {
      display: flex;
      justify-content: center;
      margin-bottom: 25px;
      gap: 10px;
      flex-wrap: wrap;
    }

    .tab {
      background: rgba(255,255,255,0.05);
      color: #F9F9F9;
      padding: 8px 22px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 600;
      font-size: 0.9rem;
      border: 1px solid rgba(255,255,255,0.1);
      transition: all 0.3s ease;
      white-space: nowrap;
    }

    .tab.active {
      background: #ff4d4d;
      border-color: #ff4d4d;
      box-shadow: 0 0 15px rgba(255,77,77,0.3);
    }

    .tab:hover:not(.active) {
      background: rgba(255,255,255,0.15);
      transform: translateY(-2px);
    }

    /* Smaller movie cards */
    .movies-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(185px, 1fr));
      gap: 16px;
    }

    .movie-card {
      background: rgba(255,255,255,0.03);
      border-radius: 8px;
      padding: 10px;
      text-align: center;
      transition: all 0.3s ease;
    }

    .movie-card:hover {
      background: rgba(255,255,255,0.08);
      transform: translateY(-5px);
    }

    .movie-card img {
      width: 100%;
      height: 260px;
      object-fit: cover;
      border-radius: 6px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.5);
    }

    .movie-title {
      margin: 10px 0 8px;
      font-weight: 600;
      font-size: 0.92rem;
      min-height: 2.2em;
      display: flex;
      align-items: center;
      justify-content: center;
      line-height: 1.3;
    }

    .buy-btn {
      background: #F9F9F9;
      color: #1C1C1C;
      border: none;
      padding: 7px 12px;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s;
      font-family: "Outfit", sans-serif;
      font-weight: 700;
      font-size: 0.85rem;
      width: 100%;
    }

    .buy-btn:hover {
      background: #ffffff;
      transform: scale(1.02);
      box-shadow: 0 4px 12px rgba(255,255,255,0.2);
    }

    .tab-content { display: none; }
    .tab-content.active { display: block; }

    footer {
      background-color: #1F1F1F;
      color: #F9F9F9;
      text-align: center;
      padding: 30px 20px;
      margin-top: auto;
      border-top: 1px solid rgba(255,255,255,0.05);
    }

    footer h2 { color: #F9F9F9; font-size: 1.3rem; margin-bottom: 8px; }
    footer p { font-size: 0.85rem; max-width: 600px; margin: 0 auto; line-height: 1.6; }

    @media (max-width: 768px) {
      .movies-container { grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 10px; }
      .movie-card img { height: 160px; }
      .glassbox { padding: 15px 10px; }
    }
  </style>
</head>
<body>

  <header>
    <div class="logo">
      <img src="peakscinematransparent.png" alt="PeaksCinemas Logo" onclick="window.location.href='home.php'">
    </div>
    <div class="search-container">
      <form id="searchForm" action="javascript:void(0);" method="get">
        <input type="text" id="searchInput" name="search" placeholder="Search Movies..." autocomplete="off">
      </form>
      <div id="searchResults" style="position:absolute; top:45px; width:100%; background:#fff; color:#000; border-radius:8px; max-height:300px; overflow-y:auto; display:none; z-index:1000; box-shadow: 0 4px 15px rgba(0,0,0,0.3);"></div>
    </div>
    <div class="header-actions">
      <button class="profile-btn" onclick="window.location.href='<?= $profile_link ?>'" title="Profile">👤</button>
    </div>
  </header>

  <div class="glassbox">
    <main id="home">
      <div class="tabs">
        <div class="tab active" onclick="showTab(event, 'now-showing')">Now Showing</div>
        <div class="tab" onclick="showTab(event, 'coming-soon')">Coming Soon</div>
      </div>

      <div id="now-showing" class="tab-content active">
        <div class="movies-container">
          <?php while ($row = $now_showing_results->fetch_assoc()): ?>
            <div class="movie-card">
              <img src="/<?= htmlspecialchars($row['MoviePoster']) ?>" alt="<?= htmlspecialchars($row['MovieName']) ?>">
              <div class="movie-title"><?= htmlspecialchars($row['MovieName']) ?></div>
              <button class="buy-btn" data-id="<?= htmlspecialchars($row['Movie_ID']) ?>">Buy Tickets</button>
            </div>
          <?php endwhile; ?>
        </div>
      </div>

      <div id="coming-soon" class="tab-content">
        <div class="movies-container">
          <?php while ($row = $coming_soon_results->fetch_assoc()): ?>
            <div class="movie-card">
              <img src="/<?= htmlspecialchars($row['MoviePoster']) ?>" alt="<?= htmlspecialchars($row['MovieName']) ?>">
              <div class="movie-title"><?= htmlspecialchars($row['MovieName']) ?></div>
              <button class="buy-btn" data-id="<?= htmlspecialchars($row['Movie_ID']) ?>">Details</button>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
    </main>
  </div>

  <footer>
    <h2>About Us</h2>
    <p>Welcome to <strong>PeaksCinemas</strong>, where Peak Movies meet Peak Experiences. Immerse yourself in the ultimate cinematic journey with state-of-the-art visuals and sound.</p>
  </footer>

  <script>
    function showTab(event, tabId) {
      document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
      document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
      event.currentTarget.classList.add('active');
      document.getElementById(tabId).classList.add('active');
    }

    function attachBuyButtons() {
      document.querySelectorAll('.buy-btn').forEach(button => {
        button.onclick = () => {
          const movieId = button.getAttribute('data-id');
          window.location.href = `movie.php?movie_id=${movieId}`;
        };
      });
    }
    attachBuyButtons();

    const searchInput = document.getElementById("searchInput");
    const searchResults = document.getElementById("searchResults");

    searchInput.addEventListener("input", function() {
      const query = searchInput.value.trim();
      if(query.length === 0){ searchResults.style.display = "none"; return; }

      fetch(`home.php?ajax_search=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(data => {
          if(data.length === 0){
            searchResults.innerHTML = "<div style='padding:15px; color:#888;'>No movies found</div>";
          } else {
            searchResults.innerHTML = data.map(movie =>
              `<div class='result-item' style='display:flex; align-items:center; padding:10px; cursor:pointer; border-bottom:1px solid #eee;'
                   onclick="window.location.href='movie.php?movie_id=${movie.Movie_ID}'">
                   <img src='/${movie.MoviePoster}' style='width:35px; height:48px; object-fit:cover; margin-right:10px; border-radius:4px;'>
                   <span style='font-weight:500;'>${movie.MovieName}</span>
              </div>`
            ).join("");
          }
          searchResults.style.display = "block";
        });
    });

    document.addEventListener("click", function(e){
      if(!searchResults.contains(e.target) && e.target !== searchInput){
        searchResults.style.display = "none";
      }
    });
  </script>
</body>
</html>