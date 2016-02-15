window.onload = function() {
  var checkbox = document.getElementById("status_resposta");
  var checkbox_label = document.getElementById("status_resposta_label");
  checkbox.onclick = function() {
    if(checkbox.checked == true) {
      checkbox_label.innerHTML = "Responder Parcialmente";
    } else {
      checkbox_label.innerHTML = "Responder";
    }
  }
}
