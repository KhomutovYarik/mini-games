$('#regButt').click(function(){
  var login = document.getElementById('inLogin')
var password = document.getElementById('inputPass')
var repeatPass = document.getElementById('inputSecondPass')

  if (login.value.match(/^(\w+){4,}$/) && login.value.length <= 12)
  {
      $.ajax({
        url: '../php/checklog.php',
        type: 'POST',
        data: ({login: login.value}),
        dataType: 'html',
        success: function(data)
        {
            if (data == 0)
            {
              $('#dialog').dialog(
                    { title: 'Внимание',
                      width: 300,
                      modal: true}
                  )
              $('.dialog-text').text('Такой логин уже занят')
              $('#dialog').dialog('open')
            }
            else
            {
              if (password.value.match(/(?=.*\d)(?=.*[A-Z]).{8,}/) && password.value.length <= 16)
        {
          if (password.value == repeatPass.value)
          {
            $.ajax({
      url: '../php/register.php',
      type: 'POST',
      data: ({inputLogin: login.value, inputPassword: password.value, repeatPass:repeatPass.value}),
      dataType: 'html',
      success: function(data)
      {
        if (data == 1)
        {
          window.location.replace("index.php")
        }
        else
        {
          $('#dialog').dialog(
            { title: 'Регистрация не удалась',
              width: 300,
              modal: true}
          )
          $('.dialog-text').text('Не удалось зарегистрироваться')
          $('#dialog').dialog('open')
        }
      }
    })
          }
          else
          {
            $('#dialog').dialog(
              { title: "Пароли не совпадают",
                width: 300}
            );
            $('.dialog-text').text("Введённые Вами пароли не совпадают")
            $('#dialog').dialog("open")
          }
        }
        else
        {
          $('#dialog').dialog(
            { title: "Пароль не соответствует требованиям",
              width: 550}
          );
          $('.dialog-text').text("Пароль должен содержать хотя бы одну букву в верхнем регистре и цифру\nДлина пароля должна составлять от 8 до 16 символов")
          $('#dialog').dialog("open")
          }
          }
        }
      })
  }
  else
  {
    $('#dialog').dialog(
      { title: "Логин не соответствует требованиям",
        width: 430}
    );
    $('.dialog-text').text("Логин должен состоять только из латинских букв и цифр\nДлина логина должна составлять от 4 до 16 символов")
    $('#dialog').dialog("open")
  }
})
