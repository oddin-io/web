function ver_resposta(id_resposta) {
  var obj=document.getElementById(id_resposta);
  var status=obj.style.display;
  if(status=="none"){
    obj.style.display="block"
  } else {
    obj.style.display="none";
  }
}
