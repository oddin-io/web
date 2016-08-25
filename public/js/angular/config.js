oddin.config(function($stateProvider, $urlRouterProvider) {
    $stateProvider
        .state('disciplinas', {
            url: "/disciplinas",
            templateUrl: "partials/disciplinas.html",
            controller: "DisciplinasController"
        })
        .state('aulas', {
            url: "/disciplinas/:disciplinaID/aulas",
            templateUrl:"partials/aulas.html",
            controller: function($cookies, $state) {
                if ($cookies.get('profile') == 0) {
                    $state.go('aulas.aluno');
                } else {
                    $state.go('aulas.professor');
                }
            }
        })
            .state('aulas.aluno', {
                url: "/aluno",
                templateUrl:'partials/aulas-a.html',
                controller: "DisciplinaController"
            })
            .state('aulas.professor', {
                url: "/professor",
                templateUrl:'partials/aulas-p.html',
                controller: "DisciplinaController"
            })
        .state('materiais', {
            url: "/disciplinas/:disciplinaID/materiais",
            templateUrl:"partials/materiais.html",
            controller: function($cookies, $state) {
                if ($cookies.get('profile') == 0) {
                    $state.go('materiais.aluno');
                } else {
                    $state.go('materiais.professor');
                }
            }
        })
            .state('materiais.aluno', {
                url: "/aluno",
                templateUrl:'partials/materiais-a.html',
                controller: "DisciplinaController"
            })
            .state('materiais.professor', {
                url: "/professor",
                templateUrl:'partials/materiais-p.html',
                controller: "DisciplinaController"
            })
        .state('participantes', {
            url: "/disciplinas/:disciplinaID/participantes",
            templateUrl: "partials/participantes.html",
            controller: 'DisciplinaController'
        })
        .state('duvidas', {
            url: "/aulas/:aulaID",
            templateUrl:"partials/duvidas.html",
            controller: function($cookies, $state) {
                if ($cookies.get('profile') == 0) {
                    $state.go('duvidas.aluno');
                } else {
                    $state.go('duvidas.professor');
                }
            }
        })
            .state('duvidas.aluno', {
                url: "/aluno",
                templateUrl:'partials/duvidas-a.html',
                controller: "AulaController"
            })
            .state('duvidas.professor', {
                url: "/professor",
                templateUrl:'partials/duvidas-p.html',
                controller: "AulaController"
            })
        .state('material-aula',  {
            url: "/aulas/:aulaID/material",
            templateUrl:"partials/material-aula.html",
            controller: function($cookies, $state) {
                if($cookies.get('profile') == 0) {
                    $state.go('material-aula.aluno');
                } else {
                    $state.go('material-aula.professor');
                }
            }
        })
            .state('material-aula.aluno', {
                url: "/aluno",
                templateUrl:'partials/material-aula-a.html',
                controller: 'AulaController'
            })
            .state('material-aula.professor', {
                url: "/professor",
                templateUrl:'partials/material-aula-p.html',
                controller: 'AulaController'
            })
}).run(function($window, $location, $state) {
    if($window.location.pathname == '/home')
        $state.go('disciplinas');
});
