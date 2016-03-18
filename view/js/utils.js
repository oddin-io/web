(function (root) {
  root.exibeMsg = function showMsg(message){
    if(document.getElementById(message).style.display == 'none'){
      document.getElementById(message).style.display = 'block';
    }
    else{
      document.getElementById(message).style.display = 'none';
    }
  };

  function Util() {}

  Util.setEnvironment = function (obj) {
    window.environment = obj;
  };

  Util.getEnvironment = function () {
    return window.environment;
  };

  Util.getPaths = function () {
    var parts = location.pathname.split("/");
    parts.splice(0, 1);
    return parts;
  };

  root.getCookie = function (name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
  }

  root.Util = Util;
})(window);
