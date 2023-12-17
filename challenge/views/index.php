<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Minions Theme</title>
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/static/css/styles.css">
</head>
<body>
  <div id="main">
    <div id="title">
      <i class="fab fa-stumbleupon-circle"></i>
      <h2>Welcome to Minions World!</h2>
      <i class="fab fa-stumbleupon-circle"></i>
    </div>
    <div class="form-group">
      <p id="time">It's Minion Time: <span id="current-time"></span></p>
    </div>
    <img id="minion-image" alt="Minion Image" class="pulse">
    <p id="minion-quote"></p>

    <button id="minion-game-btn">Play Minion Game</button>
  </div>

  <script src="/static/js/minions.js"></script>
  <script>

    document.getElementById('minion-game-btn').addEventListener('click', function() {
      window.location.href = '1/minions-game.php';
    });
  </script>
</body>
</html>
