angular.module('oddin', ['ui.router', 'ngResource', 'ui.materialize'])
    .config(function($stateProvider, $urlRouterProvider) {
        $urlRouterProvider.otherwise("/disciplinas");
        $stateProvider
            .state('disciplinas', {
                url: "/disciplinas",
                views: {
                    "viewContent": {templateUrl: "partials/disciplinas.html", controller: "DisciplinasController"}
                }
            })
            .state('aulas', {
                url: "/disciplina/:disciplinaID/aulas",
                views: {
                    "viewContent": {templateUrl: "partials/aulas.html", controller: "AulasController"}
                }
            });
    });
