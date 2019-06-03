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
    <title>.:Gallery:.</title>
    <link rel="icon" href="../imgs/logoIcon.png" />
    <link rel="stylesheet" href="../css/master.css">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/signatures.css">
    <script type="text/javascript" src="../js/Actions.js"></script>
    <script type="text/javascript">

    function deleteSignature(signatureId){
      if(confirm("¿Estás seguro de que deseas eliminar esta guitarra?")){
        var ajax = new XMLHttpRequest();
        var params = "action="+ACTIONS.DELETESIGNATURE+"&signature="+signatureId;
        var response = null;

        ajax.open("POST","/CG/api/services/Signatures.php",true);
        ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        ajax.onreadystatechange = function(){
          if(this.readyState == 4 && this.status == 200){
            console.log(ajax.responseText);
            response = JSON.parse(ajax.responseText);
            if(response.result == 0){// No errors
              alert(response.message);
              location.reload();
            }

          }
        }
        ajax.send(params);
      }
    }


    function renderSignatures(signatures){
      var html = document.getElementsByClassName('signatures_section')[0].innerHTML;
      var length = Object.keys(signatures).length;
      var signature = null;
      for(var i = 0; i < length; i++){
        signature = signatures[i];
        console.log(signature);
        html +='<div class="signature_container">';
        html += "<input type='hidden' value='"+JSON.stringify(signature)+"'>"
        html += '<div class="signature_image">';
        html += '<img src="'+signature.image+'" alt="Guitar Signature Model"></div>';
        html += '<div class="signature_info">';
        html += '<center><h2>'+signature.model+'</h2><hr style="width:20%;">';
        html += '<div class="signature_description">Guitarra tipo:'+signature.body+'.$'+signature.price+'</div>';
        html += '<br><button type="button" class="signature_button " onClick="deleteSignature('+signature.id+')" >Eliminar</button>';
        html += '</center></div></div>';
      }
      document.getElementsByClassName('signatures_section')[0].innerHTML = html;

    }

    function getSignatures(){
      var ajax = new XMLHttpRequest();
      var params = "action="+ACTIONS.GETGALLERY;
      var response = null;

      ajax.open("POST","/CG/api/services/Signatures.php",true);
      ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      ajax.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
          console.log(ajax.responseText);
          response = JSON.parse(ajax.responseText);
          switch(response.result){
            case 1:
              renderSignatures(response.guitars);
            break;
            case 0:
              alert(response.message);
            break;
            case -1:
              document.getElementById("signatureMessage").innerHTML = response.message;
              document.getElementById("signatureMessage").classList.remove("signature_message--hidden");
            break;
          }
        }
      }
      ajax.send(params);
    }

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
    </script>
  </head>
  <body onload="getSignatures();">
    <header>
        <a href="#"><img class="header_logo" src="../imgs/headerLogo.png" alt="Logo"></a>
        <ul class="header_menu">
          <li class="header_menuItem" onclick="logOut()">Salir</li>
          <li class="header_menuItem" style="cursor:pointer;"><a href="home.php">Home</a></li>
        </ul>
    </header>
    <section class="signatures_section">
      <input type="hidden" id="orderData" value="">
  <span id="signatureMessage" class="signature_message signature_message--hidden"></span>
      <!--<div class="signature_container">
        <div class="signature_image">
          <img src="imgs/mockupGuitar.jpg" alt="Guitar Signature Model">
        </div>
        <div class="signature_info">
            <center>
              <h2>Signature name</h2>
              <hr style="width:20%;">
              <div class="signature_description">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
              <br>
              <button type="button" class="signature_button" onClick="showSignatureModal(this)" >Ver a detalle</button>
          </center>
        </div>
      </div> -->

    </section>
  </body>
</html>
