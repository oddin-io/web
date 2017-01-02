oddin.controller('PresentationMaterialController',
    function ($scope, $stateParams, Aula, Duvida, Resposta, $http, $state, $cookies) {
      $scope.filter = false
      $scope.duvida = new Duvida()
      $scope.last_doubt = {}
      $scope.data_loaded = true

      function buscaInfo() {
        Aula.get({ id: $stateParams.aulaID },
                function (aula) {
                  $scope.aula = aula
                },
                function (erro) {
                  $scope.mensagem = { texto: 'Não foi possível obter o resultado.' }
                }
            )
      }

      function feedbackReloadMaterial(msg) {
        $http.get('/api/presentation/' + $stateParams.aulaID + '/materials')
                .success(function (data) {
                  $scope.materiais = data
                  $scope.data_loaded = true
                  Materialize.toast(msg, 4000)
                })
      }

      $scope.buscaMateriais = function () {
        $http.get('/api/presentation/' + $stateParams.aulaID + '/materials')
                .success(function (data) {
                  $scope.materiais = data
                })
      }

      $scope.uploadMaterial = function () {
        $scope.data_loaded = false
        var file = document.forms.uploadArchive.file.files[0]
        var fd = new FormData()
        $http.post('api/presentation/' + $stateParams.aulaID + '/materials')
                .success(function (data) {
                  for (var key in data.fields) {
                    fd.append(key, data.fields[key])
                  }
                  fd.append('file', file)
                  $http.post(data.url, fd, { headers: { 'Content-Type': undefined } })
                        .success(function () {
                          $http.put('api/materials/' + data.id, { name: file.name, mime: file.type })
                                .success(function () {
                                  console.log('Upload Realizado')
                                  feedbackReloadMaterial('O arquivo ' + file.name + ' foi postado')
                                })
                        })
                })
      }

      $scope.openModalDeleteMaterial = function (material) {
        $scope.modalContent = material
        $('#modal-deleta-material').openModal()
      }

      $scope.downloadMaterial = function (material) {
        $scope.data_loaded = false
        $http.get('api/materials/' + material.id)
                .success(function (data) {
                  var link = document.createElement('a')
                  link.setAttribute('href', data.url)
                  link.setAttribute('download', true)
                  link.click()
                  $scope.data_loaded = true
                  Materialize.toast('Fazendo download de ' + material.name, 4000)
                })
      }

      $scope.deleteMaterial = function (material) {
        $scope.data_loaded = false
        $http.delete('api/materials/' + material.id)
                .success(function (data) {
                  feedbackReloadMaterial('Arquivo deletado')
                })
      }

      $scope.usuario = {
        id: JSON.parse($cookies.get('session').substring(2)).person.id,
        nome: JSON.parse($cookies.get('session').substring(2)).person.name,
        email: JSON.parse($cookies.get('session').substring(2)).person.email,
      }
      buscaInfo()
    }
)
