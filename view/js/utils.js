(function (root) {
  var getPaths = function () {
    var parts = location.pathname.split("/");
    parts.splice(0, 1);
    return parts;
  };

  root.exibeMsg = function showMsg(message){
    if(document.getElementById(message).style.display == 'none'){
      document.getElementById(message).style.display = 'block';
    }
    else{
      document.getElementById(message).style.display = 'none';
    }
  };

  root.getPaths = getPaths;
})(window);
