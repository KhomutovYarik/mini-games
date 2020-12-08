var square = document.getElementsByClassName("square")[0]
var lvl = document.getElementById("lvl")
var restart = document.getElementById("restart")
var allsquares = document.getElementsByClassName('square-cell')
var timeblock = document.getElementsByClassName('Time')[0]
var timer = document.getElementById('timer')
var levelnumber = 1
var numberofsquares = 4
var levelcount = 50
var timeleft = 5
let timerId = setInterval(() => {timer.textContent = timeleft + " секунд"; timeleft--; if (timer.textContent == "0 секунд"){ clearInterval(timerId);
autofind(false)}}, 1000)
clearInterval(timerId)

var k = 1;

window.onload = function()
{
  var the_game = document.getElementsByClassName("main-game")[0]
  NewLevel()
  restart.onclick = function()
  {
      location.reload()
  }
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
  var randsquare = Rand(1, numberofsquares)
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
          clearInterval(timerId)
          lvl.textContent = "Вы проиграли\nВаш счёт: " + (levelnumber-1)
          restart.style.display = "block"
          timeblock.style.display = "none"
          allsquares[randsquare - 1].onclick = function(){}
        }
      else
        allsquares[i].onclick = function()
        {
          if (levelnumber < levelcount)
          {
            Next()
            NewLevel()
            clearInterval(timerId)
            levelnumber++
            timeleft = 4
            lvl.textContent = "Уровень: " + levelnumber
            timer.textContent = "5 секунд"
            timerId = setInterval(() => {timer.textContent = timeleft + " секунд"; timeleft--; if (timer.textContent == "0 секунд"){ clearInterval(timerId);
            autofind(false)}}, 1000)
          }
          else
          {
            clearInterval(timerId)
            lvl.textContent = "Игра пройдена\nВаш счёт: " + levelnumber
            restart.style.display = "block"
            timeblock.style.display = "none"
            for(j = 0; j < allsquares.length; j++)
              allsquares[j].onclick = function(){}
          }
        }
    }
}

var Next = function()
{
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

var autofind = function(boolchik)
{
      var elnum = 0
      if (allsquares[0].style.backgroundColor == allsquares[1].style.backgroundColor)
      {
        var curcolor = allsquares[0].style.backgroundColor
        elnum = 0
      }
      else
      {
        if (allsquares[0].style.backgroundColor == allsquares[2].style.backgroundColor)
        {
          var curcolor = allsquares[0].style.backgroundColor
          elnum = 0
        }
        else
        {
          var curcolor = allsquares[1].style.backgroundColor
          elnum = 1
        }
      }
      if (boolchik == true)
      {
        for(i = 0; i < allsquares.length; i++)
        {
          if (allsquares[i].style.backgroundColor != curcolor)
          {
            allsquares[i].onclick()
            return
          }
        }
      }
      else
        allsquares[elnum].onclick()
}
