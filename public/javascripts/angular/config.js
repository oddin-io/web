oddin.config(function ($stateProvider, $urlRouterProvider) {
  $stateProvider
        .state('disciplinas', {
          url: '/disciplinas',
          templateUrl: '/partials/disciplinas',
          controller: 'DisciplinasController',
        })
        .state('aulas', {
          url: '/disciplinas/:disciplinaID/aulas',
          templateUrl: '/partials/aulas',
        })
            .state('aulas.aluno', {
              url: '/aluno',
              templateUrl: '/partials/aulas-a',
              controller: 'DisciplinaController',
            })
            .state('aulas.professor', {
              url: '/professor',
              templateUrl: '/partials/aulas-p',
              controller: 'DisciplinaController',
            })
        .state('materiais', {
          url: '/disciplinas/:disciplinaID/materiais',
          templateUrl: '/partials/materiais',
          controller: function ($cookies, $state) {
            if ($cookies.get('profile') == 0) {
              $state.go('materiais.aluno')
            } else {
              $state.go('materiais.professor')
            }
          },
        })
            .state('materiais.aluno', {
              url: '/aluno',
              templateUrl: '/partials/materiais-a',
              controller: 'DisciplinaController',
            })
            .state('materiais.professor', {
              url: '/professor',
              templateUrl: '/partials/materiais-p',
              controller: 'DisciplinaController',
            })
        .state('participantes', {
          url: '/disciplinas/:disciplinaID/participantes',
          templateUrl: '/partials/participantes',
          controller: 'DisciplinaController',
        })
        .state('duvidas', {
          url: '/aulas/:aulaID',
          templateUrl: '/partials/duvidas',
        })
            .state('duvidas.aluno', {
              url: '/aluno',
              templateUrl: '/partials/duvidas-a',
              controller: 'AulaController',
            })
            .state('duvidas.professor', {
              url: '/professor',
              templateUrl: '/partials/duvidas-p',
              controller: 'AulaController',
            })
        .state('material-aula', {
          url: '/aulas/:aulaID/material',
          templateUrl: '/partials/material-aula',
          controller: function ($cookies, $state) {
            if ($cookies.get('profile') == 0) {
              $state.go('material-aula.aluno')
            } else {
              $state.go('material-aula.professor')
            }
          },
        })
            .state('material-aula.aluno', {
              url: '/aluno',
              templateUrl: '/partials/material-aula-a',
              controller: 'AulaController',
            })
            .state('material-aula.professor', {
              url: '/professor',
              templateUrl: '/partials/material-aula-p',
              controller: 'AulaController',
            })
}).run(function ($window, $location, $state) {
  if ($window.location.pathname == '/home')
    $state.go('disciplinas')
})
