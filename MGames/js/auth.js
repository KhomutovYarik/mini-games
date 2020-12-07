var modal = document.getElementById('modal-auth')

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = 'none'
  }
}

var login = document.getElementById('login')
var password = document.getElementById('password')
var signin = document.getElementById('signin-button')

signin.onclick = function(){
  if (login.value.length >= 4 && login.value.length <= 12 && password.value.length >= 8 && password.value.length <= 16) {
    $.ajax({
      url: '../php/auth.php',
      type: 'POST',
      data: ({login: login.value, password: password.value}),
      dataType: 'html',
      success: function(data)
      {
        if (data == 1)
        {
          location.reload()
        }
        else
        {
          $('#dialog').dialog(
            { title: 'Неверные данные',
              width: 350,
               height: 130,
              modal: true}
          )
          $('.dialog-text').text('Пользователя с такой парой логин-пароль\nне существует в системе')
          $('#dialog').dialog('open')
        }
      }
    })
  }
  else {
    $('#dialog').dialog(
                    { title: 'Заполните форму',
                      width: 430,
                       height: 140,
                      modal: true}
                  )
              $('.dialog-text').text('Длина логина должна составлять от 4 до 16 символов\nДлина пароля должна составлять от 8 до 16 символов')
              $('#dialog').dialog('open')
  }
}

