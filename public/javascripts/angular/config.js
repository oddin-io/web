oddin.config(function ($stateProvider, $urlRouterProvider) {
    $stateProvider
        .state('login', {
            url: '/login',
            templateUrl: '/partials/login',
            controller: 'LoginController',
        })
        .state('recuperar_senha', {
            url: '/recuperar_senha',
            templateUrl: '/partials/recover-password',
            controller: 'LoginController'
        })
        .state('redefinir_senha', {
            url: '/redefinir_senha',
            templateUrl: '/partials/redefine-password',
            controller: 'LoginController'
        })
        .state('disciplinas', {
            url: '/disciplinas',
            templateUrl: '/partials/disciplinas',
            controller: 'DisciplinasController'
        })
        .state('aulas', {
            url: '/disciplinas/:disciplinaID/aulas',
            templateUrl: '/partials/aulas'
        })
        .state('aulas.aluno', {
            url: '/aluno',
            templateUrl: '/partials/aulas-a',
            controller: 'DisciplinaController'
        })
        .state('aulas.professor', {
            url: '/professor',
            templateUrl: '/partials/aulas-p',
            controller: 'DisciplinaController'
        })
        .state('avisos', {
            url: '/disciplinas/:disciplinaID/avisos',
            templateUrl: '/partials/avisos',
            controller: function ($cookies, $state) {
                if($cookies.get('profile') == 0) {
                    $state.go('avisos.aluno')
                } else {
                    $state.go('avisos.professor')
                }
            }
        })
        .state('avisos.aluno', {
            url: '/aluno',
            templateUrl: '/partials/avisos-a',
            controller: 'DisciplinaController'
        })
        .state('avisos.professor', {
            url: '/professor',
            templateUrl: '/partials/avisos-p',
            controller: 'DisciplinaController'
        })
        .state('informativos', {
            url: '/disciplinas/:disciplinaID/informativos',
            templateUrl: '/partials/informativos',
            controller: function ($cookies, $state) {
                if($cookies.get('profile') == 0) {
                    $state.go('informativos.aluno')
                } else {
                    $state.go('informativos.professor')
                }
            }
        })
        .state('informativos.aluno', {
            url: '/aluno',
            templateUrl: '/partials/informativos-a',
            controller: 'DisciplinaController'
        })
        .state('informativos.professor', {
            url: '/professor',
            templateUrl: '/partials/informativos-p',
            controller: 'DisciplinaController'
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
            }
        })
        .state('materiais.aluno', {
            url: '/aluno',
            templateUrl: '/partials/materiais-a',
            controller: 'DisciplinaController'
        })
        .state('materiais.professor', {
            url: '/professor',
            templateUrl: '/partials/materiais-p',
            controller: 'DisciplinaController'
        })
        .state('participantes', {
            url: '/disciplinas/:disciplinaID/participantes',
            templateUrl: '/partials/participantes',
            controller: 'DisciplinaController'
        })
        .state('duvidas', {
            url: '/aulas/:aulaID',
            templateUrl: '/partials/duvidas'
        })
        .state('duvidas.aluno', {
            url: '/aluno',
            templateUrl: '/partials/duvidas-a',
            controller: 'AulaController'
        })
        .state('duvidas.professor', {
            url: '/professor',
            templateUrl: '/partials/duvidas-p',
            controller: 'AulaController'
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
            }
        })
        .state('material-aula.aluno', {
            url: '/aluno',
            templateUrl: '/partials/material-aula-a',
            controller: 'AulaController'
        })
        .state('material-aula.professor', {
            url: '/professor',
            templateUrl: '/partials/material-aula-p',
            controller: 'AulaController'
        })

}).run(function ($window, $location, $state, $cookies) {
    if ($window.location.pathname == '/home')
        $state.go('disciplinas')
    if($window.location.pathname == '/')
        if(!$cookies.get('session'))
            $state.go('login');
        else
            $window.location.href = '/home';
})
