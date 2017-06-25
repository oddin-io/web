oddin.factory('AlternativeAPI', ['$http', function ($http) {
  var _choose = function (id) {
    return $http.post('/api/alternatives/' + id + '/choose')
  }

  return {
    choose: _choose,
  }
}])
