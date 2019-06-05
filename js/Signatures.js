var modalSignature = document.getElementById("modalSignature");
var modalOrder = document.getElementById("orderContainer");


function setSignatureData(signatureContainer){
  var signatureJSON = JSON.parse(signatureContainer.firstChild.value);
  var targetTable = document.getElementById("signature_table");
  var html = "";
  html +="<tr><td>Modelo</td><td>"+signatureJSON.model+"</td></tr>";
  html +="<tr><td>Precio</td><td>"+signatureJSON.price+"</td></tr>";
  html +="<tr><td>Kaoss Pad</td><td>"+signatureJSON.kaoss+"</td></tr>";
  html +="<tr><td>Sustainer</td><td>"+signatureJSON.sustainer+"</td></tr>";
  html +="<tr><td>Cuerpo</td><td>"+signatureJSON.body+"</td></tr>";
  html +="<tr><td>Mástil</td><td>"+signatureJSON.freetboard+"</td></tr>";
  html +="<tr><td>Puente</td><td>"+signatureJSON.bridge+"</td></tr>";
  html +="<tr><td>Pastillas</td><td>"+signatureJSON.pickups+"</td></tr>";
  html +="<tr><td>Cuerdas</td><td>"+signatureJSON.strings+"</td></tr>";
  html +="<tr><td>Efecto embebido</td><td>"+signatureJSON.effect+"</td></tr>";
  html +="<tr><td>Madera</td><td>"+signatureJSON.wood+"</td></tr>";
  targetTable.innerHTML = html;
  document.getElementById("orderData").value = signatureJSON.id;

}

function showSignatureModal(btnSignature){
  setSignatureData(btnSignature.parentNode.parentNode.parentNode);
  modalSignature.style.display = modalSignature.display ==  'block' ? 'hidden' : 'block';
}

function showOrderModal(){
 modalOrder.style.display = modalOrder.style.display == 'block' ? 'none' : 'block';
}

window.onclick = function(event) {
  if (event.target == modalSignature) {
    modalSignature.style.display = "none";
  }
  if(event.target == modalOrder){
    modalOrder.style.display = 'none';
  }
}



        function validateDataOrder(personName,personSurname,personLastname,personCard,personCCV){
            var onlyLettersExp = new RegExp("[^(A-Za-z)]");
            var onlyNumbersExp = new RegExp("[^(0-9)]");
            var isValidData = false;
            if(personName == '' || personName == ' ' || onlyLettersExp.exec(personName) != null)
              alert("Nombre no válido");
            else if( personSurname == '' || personSurname == ' ' || onlyLettersExp.exec(personSurname) != null)
              alert("Apellido Paterno no válido");
            else if(personLastname =='' || personLastname == ' ' || onlyLettersExp.exec(personLastname) != null)
              alert("Apellido materno no válido");
            else if(personCard == '' || personCard == ' ' || onlyNumbersExp.exec(personCard) != null || personCard.length != 16)
              alert("Número de tarjeta no válido. Cuida que sean sólo 20 dígitos numéricos");
            else if(personCCV == '' || personCCV == ' ' || onlyNumbersExp.exec(personCCV) != null || personCCV.length != 3)
              alert("CCV no válido. 3 dígitos solamente");
            else{
              isValidData = true;
            }
            return isValidData;
        }

        function submitOrder(){
          var personName = document.getElementById("applicant").value;
          var personSurname = document.getElementById("applicant_surname").value;
          var personLastname = document.getElementById("applicant_lastname").value;
          var personCard = document.getElementById("applicant_card").value;
          var personCCV = document.getElementById("applicant_cvv").value;

          if(validateDataOrder(personName,personSurname,personLastname,personCard,personCCV)){
            var objectPerson = {
              "name":personName,
              "surname":personSurname,
              "lastname":personLastname,
              "card":personCard,
              "ccv":personCCV,
              "signature":document.getElementById("orderData").value
            };
            var ajax = new XMLHttpRequest();
            var params = "action="+ACTIONS.ORDERSIGNATURE+"&order="+JSON.stringify(objectPerson);
            var response = null;

            ajax.open("POST","/CG/api/services/Signatures.php",true);
            ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            ajax.onreadystatechange = function(){
              if(this.readyState == 4 && this.status == 200){
                console.log(ajax.responseText);
                response = JSON.parse(ajax.responseText);
                alert(response.message);
                if(response.result == 0){
                  showOrderModal();
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
            html += '<br><button type="button" class="signature_button" onClick="showSignatureModal(this)" >Ver a detalle</button>';
            html += '</center></div></div>';
          }
          document.getElementsByClassName('signatures_section')[0].innerHTML = html;

        }

        function getSignatures(){
          var ajax = new XMLHttpRequest();
          var params = "action="+ACTIONS.GETSIGNATURES;
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
