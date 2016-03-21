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

  Util.getPaths = function () {
    var pathname = location.pathname;

    if (pathname.startsWith("/")) pathname = pathname.slice(1);
    if (pathname.endsWith("/")) pathname = pathname.slice(0, -1);

    return pathname.split("/");
  };

  Util.setEnvironment = function (obj) {
    window.environment = obj;
  };

  Util.getEnvironment = function () {
    return window.environment;
  };

  Util.getCookie = function (name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
  };

  root.setEnvironment = Util.setEnvironment;
  root.Util = Util;
})(window);
