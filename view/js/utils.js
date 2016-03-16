(function (root) {
  root.exibeMsg = function showMsg(message){
    if(document.getElementById(message).style.display == 'none'){
      document.getElementById(message).style.display = 'block';
    }
    else{
      document.getElementById(message).style.display = 'none';
    }
  };

  root.getPaths = function () {
    var parts = location.pathname.split("/");
    parts.splice(0, 1);
    return parts;
  };

  root.addVariable = function (obj, propName) {
    window[propName] = window[propName] || obj;
  };

  root.getCookie = function (name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
  }
})(window);
