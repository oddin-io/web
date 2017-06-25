oddin.factory('SubmissionAPI', ['$http', function ($http) {
  var _show = function (id) {
    return $http.get('/api/submissions/' + id)
  }
  var _update = function (id, submission) {
    return $http.put('/api/submissions/' + id, submission)
  }
  var _destroy = function (id) {
    return $http.delete('/api/submissions/' + id)
  }
  var _createMaterial = function (id) {
    return $http.post('/api/submissions/' + id + '/materials')
  }

  return {
    show: _show,
    update: _update,
    destroy: _destroy,
    createMaterial: _createMaterial,
  }
}])
