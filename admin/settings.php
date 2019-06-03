<?php
  session_start();
  if(!isset($_SESSION['isLogged']) || !$_SESSION['isLogged'] ){
    header("Location:login.html");
    die();
  }
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>.:Configuración:.</title>
    <link rel="icon" href="../imgs/logoIcon.png" />
    <link rel="stylesheet" href="../css/master.css">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/signatures.css">
    <link rel="stylesheet" href="../css/settings.css">
    <script type="text/javascript" src="../js/Actions.js"></script>
    <script type="text/javascript">

    function logOut(){
      var ajax = new XMLHttpRequest();
      var params = "action="+ACTIONS.LOGOUT;
      var response = null;

      ajax.open("POST","/CG/api/services/Logging.php",true);
      ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      ajax.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
          console.log(ajax.responseText);
          response = JSON.parse(ajax.responseText);
          if(response.result > 0){//successful login
            window.location = "login.html";
          }
        }
      }
      ajax.send(params);
    }
      function updatePassword(){
        var pswd = null;
        var newPswd = document.getElementById("password").value;
        var params = null;
        var response = null;
        if(newPswd.length == 0 || newPswd == '' || newPswd == ' ')
          alert("Introduce una nueva contraseña");
        else{
              pswd = prompt("Confirma tu actual contraseña para continuar.","");
            if(pswd == null || pswd =='' || pswd == ' ')
              alert("Confirmación errónea, debes confirmar tu contraseña antes de continuar");
            else{
            params = "action="+ACTIONS.UPDATEPSWD+"&oldpassword="+pswd+"&newpassword="+newPswd;
                        submitPassword(params);
            }
          }

      }
      function submitPassword(params){
        var ajax = new XMLHttpRequest();
        ajax.open("POST","/CG/api/services/Logging.php",true);
        ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        ajax.onreadystatechange = function(){
          if(this.readyState == 4 && this.status == 200){
            console.log(ajax.responseText);
            response = JSON.parse(ajax.responseText);
            alert(response.message);
            if(response.result == 1){//successful update
              document.getElementById("password").value = "";
            }
          }
        }
        ajax.send(params);
      }
    </script>
  </head>
  <body>
    <header>
        <a href="#"><img class="header_logo" src="../imgs/headerLogo.png" alt="Logo"></a>
        <ul class="header_menu">
          <li class="header_menuItem" onclick="logOut()">Salir</li>
          <li class="header_menuItem" style="cursor:pointer;"><a href="gallery.php">Signatures</a></li>
        </ul>
    </header>
    <section class="settings_container">
      <div class="update_form">
        <label for="password">Nueva Password</label>
        <input type="text" name="password" id="password" placeholder="*************">
        <br><br><br><br>
        <button type="button" onClick="updatePassword();">Actualizar</button>
      </div>
    </section>
  </body>
</html>
