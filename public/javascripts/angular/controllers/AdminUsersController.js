import oddin from '../app'

oddin.controller('AdminUsersController',
  ['$scope', 'CurrentUser', 'PersonAPI', 'ManageList',
    function ($scope, CurrentUser, PersonAPI, ManageList) {
      $scope.user = CurrentUser;

      (function findUsers() {
        $scope.load = false
        PersonAPI.index()
                .then(function (response) {
                  $scope.users = response.data
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar usuários', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }())

      $scope.createUser = function (newUser) {
        $scope.load = false
        PersonAPI.create(newUser)
                .then(function (response) {
                  $scope.users.push(response.data)
                  Materialize.toast('Usuário cadastrado', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao cadastrar usuário', 3000)
                })
                .finally(function () {
                  delete $scope.newUser
                  $scope.load = true
                })
      }

      $scope.updateUser = function (modalUser) {
        $scope.load = false
        PersonAPI.update(modalUser.id, modalUser)
                .then(function (response) {
                  ManageList.updateItem($scope.users, response.data)
                  Materialize.toast('Usuário atualizado', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao atualizar usuário', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.deleteUser = function (modalUser) {
        $scope.load = false
        PersonAPI.destroy(modalUser.id)
                .then(function () {
                  ManageList.deleteItem($scope.users, modalUser)
                  Materialize.toast('Usuário excluído', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao excluir usuário', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.modalEdit = function (user) {
        $scope.modalUser = angular.copy(user)
        $('#modal-edit').openModal()
      }

      $scope.modalDelete = function (user) {
        $scope.modalUser = angular.copy(user)
        $('#modal-delete').openModal()
      }
    },
  ])
