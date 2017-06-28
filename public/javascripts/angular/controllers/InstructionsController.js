import oddin from '../app'

oddin.controller('InstructionsController',
  ['$scope', '$cookies', '$state', 'CurrentUser', 'InstructionAPI', '$filter',
    function ($scope, $cookies, $state, CurrentUser, InstructionAPI, $filter) {
      $scope.user = CurrentUser

      function setSeasons(instructions) {
        var seasonAux = {}
        $scope.seasons = instructions.map(function (instruction) {
          var _semester = $filter('date')(instruction.start_date, 'MM') < 7 ? 1 : 2
          var _year = $filter('date')(instruction.start_date, 'yyyy')
          var _season = _year + '/' + _semester

          if (seasonAux.hasOwnProperty(_season)) {
            return undefined
          }

          seasonAux[_season] = true
          return {
            label: _season,
            instructions: [],
          }
        }).filter(function (season) {
          return typeof season !== 'undefined'
        })
        $scope.seasons.forEach(function (season) {
          instructions.forEach(function (instruction) {
            var _instructionSeason = $filter('date')(instruction.start_date, 'yyyy')
            _instructionSeason += '/' + ($filter('date')(instruction.start_date, 'MM') < 7 ? 1 : 2)
            if (season.label == _instructionSeason) {
              season.instructions.push(instruction)
            }
          })
        })
      }

      (function findInstructions() {
        $scope.load = false
        InstructionAPI.index()
                .then(function (response) {
                  setSeasons(response.data)
                })
                .catch(function () {
                  Materialize.toast('Erro ao carregar disciplinas', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }())

      $scope.enterInstruction = function (instruction) {
        if (!$cookies.get('profile')) {
          InstructionAPI.getProfile(instruction.id)
                    .then(function (response) {
                      $cookies.put('profile', response.data.profile)
                      $state.go('presentations', {
                        instructionID: instruction.id,
                      })
                    })
                    .catch(function () {
                      Materialize.toast(
                        'Erro ao tentar entrar em ' + instruction.lecture.name, 3000
                      )
                    })
        } else {
          $state.go('presentations', {
            instructionID: instruction.id,
          })
        }
      }
    },
  ])
