<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Minion Jump Game</title>
  <style>

    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #fef1d2;
    }

    h1 {
      text-align: center;
      color: #1a1a1a; 
      margin-top: 50px;
      font-family: 'Fredoka One', cursive; 
      font-size: 3em; 
    }

    #game-container {
      position: relative;
      width: 600px;
      height: 300px;
      background-image: url('/assets/town.gif'); 
      border: 1px solid #ccc;
      margin: 0 auto;
      overflow: hidden; 
      margin-top: 20px;
    }

    
    #minion {
      position: absolute;
      bottom: 0;
      left: 50px;
      width: 100px; 
      height: 100px;
      background-image: url('/assets/game.png'); 
      background-size: cover;
    }

    .obstacle {
      position: absolute;
      bottom: 0;
      width: 30px; 
      height: 30px; 
      background-color: red; 
    }

    form {
    text-align: center;
    margin-top: 20px;
  }

  label {
    font-size: 18px;
    color: #1a1a1a;
    font-family: 'Comic Sans MS', cursive; 
    margin-right: 10px;
  }

  .btn-container {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

  #minion-game-btn {
    background-color: #ffcc00;
    border: none;
    color: #fff;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
    transition: transform 0.2s ease-in-out;
    text-align: center;
    background-image: linear-gradient(to bottom, #ffcc00, #ffd633);
    border: 2px solid #ff9900;
    font-family: 'Comic Sans MS', cursive;
  }

  #minion-game-btn:hover {
    transform: scale(1.1);
  }
</style>


  </style>
</head>
<body>
  <h1>Minion Jump Game</h1>
  <div id="game-container">
    <div id="minion"></div>
  </div>

 
  <div class="btn-container">
    <button type="button" id="minion-game-btn" onclick="viewScores()">View Your Scores</button>
  </div>
  <script>
    
    const minion = document.getElementById('minion');
    const gameContainer = document.getElementById('game-container');
    let isJumping = false;
    let gameStarted = false; 
    let score = 0;

    function startGame() {
      if (!gameStarted) {
        gameStarted = true;
        setInterval(createObstacle, 3000);
      }
    }

    function jump() {
      if (!isJumping && gameStarted) {
        isJumping = true;
        let position = 0;
        const jumpInterval = setInterval(() => {
          if (position >= 150) {
            clearInterval(jumpInterval);
            let downInterval = setInterval(() => {
              if (position === 0) {
                clearInterval(downInterval);
                isJumping = false;
              }
              position -= 5;
              minion.style.bottom = position + 'px';
            }, 20);
          }
          position += 30;
          minion.style.bottom = position + 'px';
          score += 1;
        }, 20);
      }
    }


    function viewScores() {
      let username = localStorage.getItem('username');
      fetchAndDisplayScores(username);
    }

    document.addEventListener('keydown', (event) => {
      if (event.code === 'Space') {
        event.preventDefault(); 
        startGame();
        jump();
      }
    });

    function createObstacle() {
      if (gameStarted) {
        const obstacle = document.createElement('div');
        obstacle.classList.add('obstacle');
        obstacle.style.left = '600px'; 
        gameContainer.appendChild(obstacle);

        let obstaclePosition = 600;
        const obstacleMove = setInterval(() => {
          obstaclePosition -= 5; 
          obstacle.style.left = obstaclePosition + 'px';

          if (obstaclePosition <= 50 && obstaclePosition >= 0) {
            const minionBottom = parseInt(getComputedStyle(minion).getPropertyValue('bottom'));
            if (minionBottom <= 30) { 
              clearInterval(obstacleMove);
              let username = localStorage.getItem('username');
              if (!username) {
                getUsername();
}

function getUsername() {
    let usernameInput = prompt('Enter your username:');

    checkIfUsernameExists(usernameInput)
        .then(exists => {
            if (exists) {
                alert ('Username already exists');
                return getUsername(); 
            } else {
                localStorage.setItem('username', usernameInput);
            }
        })
        .catch(error => {
            console.error('Error checking username:', error);
        });
}
              
              gameOver(score);

            }
          }

          if (obstaclePosition <= -30) { 
            clearInterval(obstacleMove);
            gameContainer.removeChild(obstacle);
          }
        }, 20);
      }
    }

    function gameOver(score) {
      let username = localStorage.getItem('username');
      sendScoreToServer(score, username);
      alert(`Game Over! Your Score: ${score}`);
      window.location.reload(); 
    }

    function sendScoreToServer(score, username) {
    
    const xhr = new XMLHttpRequest();
    const url = '/0/send-score.php'; 
    const params = `score=${score}&username=${username}`; 
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        console.log('Score saved successfully');
      }
    };

    xhr.send(params);
  }
  function checkIfUsernameExists(username) {
  return new Promise((resolve, reject) => {
    fetch(`/0/check-username.php?username=${username}`, {
      method: 'GET',
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      resolve(data.exists);
    })
    .catch(error => {
      console.error('Error checking username:', error);
      reject(error);
    });
  });
}



    function fetchAndDisplayScores(username) {
      const xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
          const scores = xhr.responseText;
          displayScores(scores);
        }
      };
      xhr.open('GET', `/0/value-score.php?username=${username}`, true);
      xhr.send();

      function displayScores(scores) {
        alert(`Scores : \n${scores}`);
      }
    }


  </script>
</body>
</html>