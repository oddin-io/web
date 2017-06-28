import oddin from '../app'

oddin.controller('AdminEventShowController',
  [
    '$scope', '$stateParams', '$filter',
    'CurrentUser', 'InstructionAPI', 'EventAPI', 'LectureAPI', 'ManageList',
    function (
      $scope, $stateParams, $filter,
      CurrentUser, InstructionAPI, EventAPI, LectureAPI, ManageList
    ) {
      $scope.user = CurrentUser

      function setSeason(instruction) {
        var _year = $filter('date')(instruction.start_date, 'yyyy')
        var _semester = $filter('date')(instruction.start_date, 'MM') < 7 ? 1 : 2
        var _season = _year + '/' + _semester
        instruction.season = _season
      }

      (function getInfo() {
        $scope.load = false
        EventAPI.show($stateParams.eventID)
                .then(function (response) {
                  $scope.event = response.data
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar informações do curso', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }());

      (function findInstructions() {
        $scope.load = false
        EventAPI.getInstructions($stateParams.eventID)
                .then(function (response) {
                  $scope.instructions = response.data
                  $scope.instructions.forEach(function (elem) {
                    setSeason(elem)
                  })
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar disciplinas cadastradas', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }())

      $scope.findLectures = function () {
        $scope.load = false
        LectureAPI.index()
                .then(function (response) {
                  $scope.lectures = response.data
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar disciplinas disponíveis', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.createInstruction = function (modalInstruction) {
        $scope.load = false
        modalInstruction.lecture = modalInstruction.lecture.id
        modalInstruction.event = $stateParams.eventID
        modalInstruction.start_date = $filter('toDate')(modalInstruction.start_date)
        modalInstruction.end_date = $filter('toDate')(modalInstruction.end_date)
        InstructionAPI.create(modalInstruction)
                .then(function (response) {
                  setSeason(response.data)
                  $scope.instructions.push(response.data)
                  Materialize.toast('Disciplina Adicionada', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao adicionar disciplina', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.deleteInstruction = function (modalInstruction) {
        $scope.load = false
        InstructionAPI.destroy(modalInstruction.id)
                .then(function () {
                  ManageList.deleteItem($scope.instructions, modalInstruction)
                  Materialize.toast('Disciplina removida', 3000)
                })
                .catch(function () {
                  Materialize.toast('Erro ao remover disciplina', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.modalAdd = function (lecture) {
        $scope.modalInstruction = {}
        $scope.modalInstruction.lecture = angular.copy(lecture)
        $('#modal-add').openModal()
      }

      $scope.modalRemove = function (instruction) {
        $scope.modalInstruction = angular.copy(instruction)
        $('#modal-remove').openModal()
      }
    },
  ])
