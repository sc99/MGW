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
    <title>.:Home:.</title>
    <link rel="icon" href="../imgs/logoIcon.png" />
    <link rel="stylesheet" href="../css/master.css">
    <link rel="stylesheet" href="../css/home.css">
    <script type="text/javascript">
        function showSignaturesPreview(){
          alert("TODO Show signatures preview");
        }
    </script>
  </head>
  <body>
    <header>
        <a href="#"><img class="header_logo" src="../imgs/headerLogo.png" alt="Logo"></a>
        <ul class="header_menu">
          <li class="header_menuItem"><a href="login.html">Salir</a></li>
          <li class="header_menuItem" onclick="showSignaturesPreview();" style="cursor:pointer;">Signatures</li>
        </ul>
    </header>
    <section class="home_container">
        <center><h1>Agregar guitarra</h1>
        <hr style="width:10%"></center>
        <br><br>
        <div class="home_form">
          <div class="home_form_field">
            <label  for="body">Cuerpo</label>
            <select id="body" name="body"><option value=0>Selecciona un cuerpo</option></select>
          </div>
          <div class="home_form_field">
            <label for="effect">Efecto</label>
            <select id="effect" name="effect"><option value=0>Selecciona un efecto</option></select>
          </div>

          <div class="home_form_field">
            <label  for="freetboard">Mástil</label>
            <select id="freetboard" name="freetboard"><option value=0>Selecciona un mástil</option></select>
          </div>
          <div class="home_form_field">
            <label for="kaoss">Kaoss Pad</label>
            <select id="kaoss" name="kaoss"><option value=0>Selecciona un Kaoss Pad</option></select>
          </div>

          <div class="home_form_field">
            <label  for="bridge">Puente</label>
            <select id="bridge" name="bridge"><option value=0>Selecciona un puente</option></select>
          </div>
          <div class="home_form_field">
            <label for="sustainer">Sustainer</label>
            <select id="sustainer" name="sustainer"><option value=0>Selecciona un sustainer</option></select>
          </div>


          <div class="home_form_field">
            <label for="pickups">Pastillas</label>
            <select id="pickups" name="pickups"><option value=0>Selecciona una combinación</option></select>
          </div>
          <div class="home_form_field">
            <label  for="wood">Madera</label>
            <select id="wood" name="wood"><option value=0>Selecciona un tipo de madera</option></select>
          </div>


          <div class="home_form_field">
            <label  for="strings">Cuerdas</label>
            <select id="strings" name="strings"><option value=0>Selecciona las cuerdas</option></select>
          </div>
          <div class="home_form_field">
            <label for="model">Nombre</label>
            <input type="text" id="model" name="model" placeholder="Escribe el nombre de la guitarra">
          </div>

          <div class="home_form_field" style="width:70%;height:17%;">
            <label  for="image">Imagen</label>
            <input type="file" id="image" name="image" style="width:100%;">
          </div>
          <button class="home_form_button" type="button">Agregar</button>
        </div>
    </section>
  </body>
</html>
