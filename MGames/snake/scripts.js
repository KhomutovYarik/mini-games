const theGame = document.getElementById('main-game');
const canvas = document.getElementById('game-canvas');
const ctx = canvas.getContext("2d");
var gameOver = document.getElementById('game-over');
var score = document.getElementById('score');
var record = document.getElementById('record');
var restart = document.getElementById('restart');
var reloadButton = document.getElementById('reload-game');
var recordNumber = Number(record.textContent);
var game


const ground = new Image();
ground.src = "img/ground.png";

const foodImg = new Image();
foodImg.src = "img/food.png";

let box = 32;

var levelnumber

var food

var snake

document.addEventListener("keydown", direction);

let dir;

function direction(event) {
  if(event.keyCode == 37 && dir != "right")
    dir = "left";
  else if(event.keyCode == 38 && dir != "down")
    dir = "up";
  else if(event.keyCode == 39 && dir != "left")
    dir = "right";
  else if(event.keyCode == 40 && dir != "up")
    dir = "down";
}

function eatTail(head, arr) {
  for(let i = 0; i < arr.length; i++) {
    if(head.x == arr[i].x && head.y == arr[i].y)
      lose();
  }
}

function drawGame() {
  ctx.drawImage(ground, 0, 0);

  ctx.drawImage(foodImg, food.x, food.y);

  for(let i = 0; i < snake.length; i++) {
    ctx.fillStyle = i == 0 ? "green" : "red";
    ctx.fillRect(snake[i].x, snake[i].y, box, box);
  }

  ctx.fillStyle = "white";
  ctx.font = "50px Arial";
  ctx.fillText(levelnumber, box * 2.5, box * 1.7);

  let snakeX = snake[0].x;
  let snakeY = snake[0].y;

  if(snakeX == food.x && snakeY == food.y) {
    levelnumber++;
    food = {
      x: Math.floor((Math.random() * 17 + 1)) * box,
      y: Math.floor((Math.random() * 15 + 3)) * box,
    };
  } else
    snake.pop();

  if(snakeX < box || snakeX > box * 17
    || snakeY < 3 * box || snakeY > box * 17)
    {
      lose();
    }

  if(dir == "left") snakeX -= box;
  if(dir == "right") snakeX += box;
  if(dir == "up") snakeY -= box;
  if(dir == "down") snakeY += box;

  let newHead = {
    x: snakeX,
    y: snakeY
  };

  eatTail(newHead, snake);

  snake.unshift(newHead);
}

function start(){
  theGame.style.display = "block"
  gameOver.style.display = "none"
  levelnumber = 0;
  food = {
    x: Math.floor((Math.random() * 17 + 1)) * box,
    y: Math.floor((Math.random() * 15 + 3)) * box,
  };
  snake = [];
    snake[0] = {
      x: 9 * box,
      y: 10 * box
    };
  dir = ""
  clearInterval(game)
  game = setInterval(drawGame, 150);
  }

function lose(){
  clearInterval(game);
      score.textContent = levelnumber
      if (levelnumber > recordNumber){
        recordNumber = levelnumber
        record.textContent = recordNumber
        $.ajax({
      url: '../php/newrecord.php',
      type: 'POST',
      data: ({game: 3, record: recordNumber}),
      dataType: 'html'
    })
      }
      theGame.style.display = "none"
      gameOver.style.display = "block"
}

start();
restart.onclick = start;
reloadButton.onclick = start;
