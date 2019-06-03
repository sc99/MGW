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

        function getSignatureParts(){
          var ajax = new XMLHttpRequest();
          var params = "action="+ACTIONS.GETPARTS;
          var response = null;

          ajax.open("POST","/CG/api/services/Signatures.php",true);
          ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
          ajax.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
              console.log(ajax.responseText);
              response = JSON.parse(ajax.responseText);
              if(response.result == 1){//successful login
                setSignatureParts(response);
              }
            }
          }
          ajax.send(params);
        }

        function showSignaturesPreview(){
          alert("TODO Show signatures preview");
        }

        function setSignatureParts(jsonParts){
          setBodies(jsonParts.bodies);
          setBridges(jsonParts.bridges);
          setPicks(jsonParts.picks);
          setEffects(jsonParts.effects);
          setStrings(jsonParts.strings);
          setFreets(jsonParts.freet);
          setWoods(jsonParts.woods);

        }

        function setBodies(bodies){
          var length = Object.keys(bodies).length;
          var row = null;
          var html = document.getElementById("body").innerHTML;
          for(var i = 0; i < length ; i++){
            row = bodies[i];
            html += "<option value="+row.body_id+">"+row.body_name+"</option>";
          }
          document.getElementById("body").innerHTML = html;
        }

        function setBridges(bridges){
          var length = Object.keys(bridges).length;
          var row = null;
          var html = document.getElementById("bridge").innerHTML;
          for(var i = 0; i < length ; i++){
            row = bridges[i];
            html +="<option value="+row.bridge_id+" >"+row.bridge_name+" </option>";
          }
          document.getElementById("bridge").innerHTML= html;
        }

        function setPicks(picks){
          var length = Object.keys(picks).length;
          var row = null;
          var html = document.getElementById("pickups").innerHTML;
          for(var i = 0; i < length ; i++){
            row = picks[i];
            html +="<option value="+row.pickup_id+" >"+row.pickup_name+" </option>";
          }
          document.getElementById("pickups").innerHTML= html;
        }

        function setEffects(effects){
          var length = Object.keys(effects).length;
          var row = null;
          var html = document.getElementById("effect").innerHTML;
          for(var i = 0; i < length ; i++){
            row = effects[i];
            html +="<option value="+row.effect_id+" >"+row.effect_name+" </option>";
          }
          document.getElementById("effect").innerHTML= html;
        }

        function setStrings(strings){
          var length = Object.keys(strings).length;
          var row = null;
          var html = document.getElementById("strings").innerHTML;
          for(var i = 0; i < length ; i++){
            row = strings[i];
            html +="<option value="+row.string_id+" >Cuerdas: "+row.string_quantity+",Calibre: "+row.string_gauge+" </option>";
          }
          document.getElementById("strings").innerHTML= html;
        }

        function setFreets(freets){
          var length = Object.keys(freets).length;
          var row = null;
          var html = document.getElementById("freetboard").innerHTML;
          for(var i = 0; i < length ; i++){
            row = freets[i];
            html +="<option value="+row.freetboard_id+" >"+row.freetboard_name+" </option>";
          }
          document.getElementById("freetboard").innerHTML= html;
        }

        function setWoods(woods){
          var length = Object.keys(woods).length;
          var row = null;
          var html = document.getElementById("wood").innerHTML;
          for(var i = 0; i < length ; i++){
            row = woods[i];
            html +="<option value="+row.wood_id+" >"+row.wood_name+" </option>";
          }
          document.getElementById("wood").innerHTML = html;
        }

        function getSignatureObject(){
          var object = {
            "body":document.getElementById("body").value,
            "price":document.getElementById("price").value,
            "effect":document.getElementById("effect").value,
            "freet":document.getElementById("freetboard").value,
            "kaoss":document.getElementById("kaoss").value,
            "bridge":document.getElementById("bridge").value,
            "sustainer":document.getElementById("sustainer").value,
            "picks":document.getElementById("pickups").value,
            "wood":document.getElementById("wood").value,
            "strings":document.getElementById("strings").value,
            "model":document.getElementById("model").value,

          };
          return object;
        }

        function isValidSignatureObject(object){
          if(!object.body >0)
            return "Cuerpo";
          if(!object.effect >0)
            return "Efecto";
          if(!object.freet > 0)
            return "Mástil";
          if(!object.bridge > 0)
            return "Puente";
          if(!object.picks > 0)
            return "Pastillas";
          if(!object.wood >0)
            return "Madera";
          if(!object.strings >0)
            return "Cuerdas";
          if(object.model == '' || object.model == ' ')
            return "Modelo";
          if(object.price == 0)
            return "Precio";
          return null;
        }

        function clearFields(){
          document.getElementById("body").value = 0;
          document.getElementById("effect").value = 0;
          document.getElementById("freetboard").value = 0;
          document.getElementById("kaoss").value = 0;
          document.getElementById("bridge").value = 0;
          document.getElementById("sustainer").value = 0;
          document.getElementById("pickups").value = 0;
          document.getElementById("wood").value = 0;
          document.getElementById("strings").value = 0;
          document.getElementById("model").value = '';
          document.getElementById("price").value = 0;
        }

        function submitSignature(signature){
          var ajax = new XMLHttpRequest();
          var params = "action="+ACTIONS.ADDSIGNATURE+"&signature="+JSON.stringify(signature);
          var response = null;

          ajax.open("POST","/CG/api/services/Signatures.php",true);
          ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
          ajax.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
              console.log(ajax.responseText);
              response = JSON.parse(ajax.responseText);
              if(response.result == 0){//successful register
                alert(response.message);
                clearFields();
              }
            }
          }
          ajax.send(params);
        }

        function addSignature(){
            var signatureObject = getSignatureObject();
            console.log(signatureObject);
            var invalidPart = isValidSignatureObject(signatureObject);
            if(invalidPart == null){ //No invalid part
              submitSignature(signatureObject);
            }else {
              alert("Selección no válida de la parte: "+invalidPart);
            }
        }
    </script>
  </head>
  <body onload="getSignatureParts()">
    <header>
        <a href="#"><img class="header_logo" src="../imgs/headerLogo.png" alt="Logo"></a>
        <ul class="header_menu">
          <li class="header_menuItem" onclick="logOut()">Salir</li>
          <li class="header_menuItem" style="cursor:pointer;"><a href="gallery.php">Signatures</a></li>
        </ul>
    </header>
    <section class="home_container">
        <center><h1>Agregar guitarra</h1>
        <hr style="width:10%"></center>
        <br><br>
        <div class="home_form">
          <div class="home_form_field">
            <label  for="body">Cuerpo</label>
            <select id="body" name="body"><option id="body_options"  value=0>Selecciona un cuerpo</option></select>
          </div>
          <div class="home_form_field">
            <label for="effect">Efecto</label>
            <select id="effect" name="effect"><option id="effect_options" value=0>Selecciona un efecto</option></select>
          </div>

          <div class="home_form_field">
            <label  for="freetboard">Mástil</label>
            <select id="freetboard" name="freetboard"><option id="freetboard_options" value=0>Selecciona un mástil</option></select>
          </div>
          <div class="home_form_field">
            <label for="kaoss">Kaoss Pad</label>
            <select id="kaoss" name="kaoss"><option  id="kaoss_options" value=0>No</option><option value=1>Sí</option></select>
          </div>

          <div class="home_form_field">
            <label  for="bridge">Puente</label>
            <select id="bridge" name="bridge"><option id="bridge_options" value=0>Selecciona un puente</option></select>
          </div>
          <div class="home_form_field">
            <label for="sustainer">Sustainer</label>
            <select id="sustainer" name="sustainer"><option id="sustainer_options" value=0>No</option><option value=1>Sí</option></select>
          </div>


          <div class="home_form_field">
            <label for="pickups">Pastillas</label>
            <select id="pickups" name="pickups"><option id="pickups_options" value=0>Selecciona una combinación</option></select>
          </div>
          <div class="home_form_field">
            <label  for="wood">Madera</label>
            <select id="wood" name="wood"><option id="wood_options" value=0>Selecciona un tipo de madera</option></select>
          </div>


          <div class="home_form_field">
            <label  for="strings">Cuerdas</label>
            <select id="strings" name="strings"><option id="strings_options" value=0>Selecciona las cuerdas</option></select>
          </div>
          <div class="home_form_field">
            <label for="model">Nombre</label>
            <input type="text" id="model" name="model" placeholder="Escribe el nombre de la guitarra">
          </div>

          <div class="home_form_field" style="width:70%;height:17%;">
            <label  for="price">Precio</label>
            <input type="number" id="price" name="price" style="width:100%;" min=0 max=10000000>
          </div>
          <button class="home_form_button" type="button" onclick="addSignature();" >Agregar</button>
        </div>
    </section>
  </body>
</html>
