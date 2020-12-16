var theGame = document.getElementById('main-game')
var gameOver = document.getElementById('game-over')
var score = document.getElementById('score')
var record = document.getElementById('record')
var square = document.getElementsByClassName("square")[0]
var lvl = document.getElementById("lvl")
var restart = document.getElementById('restart')
var timeblock = document.getElementsByClassName('Time')[0]
var timer = document.getElementById('timer')
var allsquares = document.getElementsByClassName('square-cell')
var reloadButton = document.getElementById('reload-game')
var recordNumber = Number(record.textContent)
var levelnumber
var numberofsquares
var timeleft
var timerId
var randsquare

function start(){
    theGame.style.display = "block"
    gameOver.style.display = "none"
    square.innerHTML = `<div class="square-row">
          <div class="square-cell">
          </div>
          <div class="square-cell">
          </div>
        </div>
        <div class="square-row">
          <div class="square-cell">
          </div>
          <div class="square-cell">
          </div>
        </div>`
    levelnumber = 1
    numberofsquares = 4
    timeleft = 5
    clearInterval(timerId)
    NewLevel()
    timeblock.style.display = "none"
    lvl.textContent = "Уровень: 1"
}

var Rand = function(val1, val2)
{
  var ran = Math.random() * (val2 - val1) + val1
  if (ran % 1 > 0.5)
    return Math.floor(ran) + 1;
  else
    return Math.floor(ran);
}

var RandColor = function()
{
  var red = Rand(0, 255)
  var green = Rand(0, 255)
  var blue = Rand(0, 255)
  return [red, green, blue]
}

toRGB = function(r, g, b)
{
  return "rgb(" + r + ", " + g + ", " + b + ")"
}

var NewLevel = function()
{
  var randcolor = RandColor()
  randsquare = Rand(1, numberofsquares)
  var speccolor = new Array()
  for (i = 0; i <= 2; i++)
  {
    if (levelnumber < 10)
      var harder = "0" + levelnumber
    else
      var harder = levelnumber
    speccolor[i] = randcolor[i] * Number("0.9" + harder)
  }
  for (i = 0; i < allsquares.length; i++)
  {
    if (i != randsquare-1)
      allsquares[i].style.backgroundColor = toRGB(randcolor[0], randcolor[1], randcolor[2])
    else
      allsquares[i].style.backgroundColor = toRGB(speccolor[0], speccolor[1], speccolor[2])
  }
  for (i = 0; i < numberofsquares; i++)
  {
      if (i != randsquare-1)
        allsquares[i].onclick = function()
        {
          gameover()
        }
      else
        allsquares[i].onclick = function()
        {
            Next()
            NewLevel()
            clearInterval(timerId)
            levelnumber++
            timeleft = 4
            lvl.textContent = "Уровень: " + levelnumber
            timer.textContent = "5 секунд"
            timerId = setInterval(() => {timer.textContent = timeleft + " секунд"; timeleft--; if (timer.textContent == "0 секунд"){ clearInterval(timerId);
            gameover()}}, 1000)
        }
    }
}

var Next = function()
{
  timeblock.style.display = "block"
  var rows = document.getElementsByClassName("square-row")
  for (i = 0; i < rows.length; i++)
  {
    var newcell = document.createElement("div")
    newcell.className = "square-cell"
    rows[i].appendChild(newcell)
  }
  var newrow = document.createElement("div")
  newrow.className = "square-row"
  square.appendChild(newrow)
  for (i = 0; i < rows.length; i++)
  {
    var newcell = document.createElement("div")
    newcell.className = "square-cell"
    rows[rows.length-1].appendChild(newcell)
  }
  numberofsquares = rows.length * rows.length
}

function gameover(){
      clearInterval(timerId)
      var newScore = levelnumber-1
      score.textContent = newScore
      if (newScore > recordNumber){
        recordNumber = newScore
        record.textContent = recordNumber
        $.ajax({
      url: '../php/newrecord.php',
      type: 'POST',
      data: ({game: 2, record: recordNumber}),
      dataType: 'html'
    })
      }
      theGame.style.display = "none"
      gameOver.style.display = "block"
}

start()
restart.onclick = start
reloadButton.onclick = start
