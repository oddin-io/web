oddin.config(function ($stateProvider, $urlRouterProvider) {
  var profile
  $stateProvider
        .state('disciplinas', {
          url: '/disciplinas',
          views: {
            'viewContent': { templateUrl: '/partials/disciplinas', controller: 'DisciplinasController' },
          },
        })
        .state('disciplina', {
          url: '/disciplina/:disciplinaID',
          controllerProvider: function (Profile, $stateParams, $state) {
            if (profile !== undefined)
              $state.go('aulas', { disciplinaID: $stateParams.disciplinaID })
            if (profile === undefined) {
              Profile.get({ id: $stateParams.disciplinaID },
                        function (data) {
                          profile = data.profile
                          $state.go('aulas', { disciplinaID: $stateParams.disciplinaID })
                        },
                        function (erro) {
                          console.log('Erro ao encontrar perfil')
                        }
                    )
            }
          },
        })
        .state('aulas', {
          url: '/disciplina/:disciplinaID/aulas',
          controllerProvider: function ($state, $stateParams) {
            if (profile == 0) {
              $state.go('aulas-aluno', { disciplinaID: $stateParams.disciplinaID })
            } else if (profile == 1) {
              $state.go('aulas-professor', { disciplinaID: $stateParams.disciplinaID })
            }
          },
        })
        .state('aulas-aluno', {
          url: '/disciplina/:disciplinaID/aulas-a',
          views: {
            'viewContent': { templateUrl: 'partials/aulas', controller: 'DisciplinaController' },
          },
        })
        .state('aulas-professor', {
          url: '/disciplina/:disciplinaID/aulas-p',
          views: {
            'viewContent': { templateUrl: 'partials/aulas-p', controller: 'DisciplinaController' },
          },
        })
        .state('materiais', {
          url: '/disciplina/:disciplinaID/materiais',
          controllerProvider: function ($state, $stateParams) {
            if (profile == 0) {
              $state.go('materiais-aluno', { disciplinaID: $stateParams.disciplinaID })
            } else if (profile == 1) {
              $state.go('materiais-professor', { disciplinaID: $stateParams.disciplinaID })
            }
          },
        })
        .state('materiais-aluno', {
          url: '/disciplina/:disciplinaID/materiais-a',
          views: {
            'viewContent': { templateUrl: 'partials/materiais', controller: 'DisciplinaController' },
          },
        })
        .state('materiais-professor', {
          url: '/disciplina/:disciplinaID/materiais-p',
          views: {
            'viewContent': { templateUrl: 'partials/materiais-p', controller: 'DisciplinaController' },
          },
        })
        .state('participantes', {
          url: '/disciplina/:disciplinaID/participantes',
          views: {
            'viewContent': { templateUrl: 'partials/participantes', controller: 'DisciplinaController' },
          },
        })
        .state('duvidas', {
          url: '/disciplina/:disciplinaID/aula/:aulaID',
          controllerProvider: function ($state, $stateParams) {
            if (profile == 0) {
              $state.go('duvidas-aluno', { disciplinaID: $stateParams.disciplinaID, aulaID: $stateParams.aulaID })
            } else if (profile == 1) {
              $state.go('duvidas-professor', { disciplinaID: $stateParams.disciplinaID, aulaID: $stateParams.aulaID })
            }
          },
        })
        .state('duvidas-aluno', {
          url: '/disciplina/:disciplinaID/aula-a/:aulaID',
          views: {
            'viewContent': { templateUrl: 'partials/duvidas', controller: 'AulaController' },
          },
        })
        .state('duvidas-professor', {
          url: '/disciplina/:disciplinaID/aula-p/:aulaID',
          views: {
            'viewContent': { templateUrl: 'partials/duvidas-p', controller: 'AulaController' },
          },
        })
        .state('material-aula', {
          url: '/aulas/:aulaID/material',
          controllerProvider: function ($state, $stateParams) {
            if (profile == 0) {
              $state.go('material-aula-a', { aulaID: $stateParams.aulaID })
            } else if (profile == 1) {
              $state.go('material-aula-p', { aulaID: $stateParams.aulaID })
            }
          },
        })
        .state('material-aula-a', {
          url: '/aulas/:aulaID/material-a',
          views: {
            'viewContent': { templateUrl: 'partials/material-aula', controller: 'AulaController' },
          },
        })
        .state('material-aula-p', {
          url: '/aulas/:aulaID/material-p',
          views: {
            'viewContent': { templateUrl: 'partials/material-aula-p', controller: 'AulaController' },
          },
        })
}).run(function ($window, $location, $state) {
  if ($window.location.pathname == '/home')
    $state.go('disciplinas')
})
