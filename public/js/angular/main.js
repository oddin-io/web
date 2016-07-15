angular.module('oddin', ['ui.router', 'ngResource'])
    .config(function($stateProvider, $urlRouterProvider) {
        $urlRouterProvider.otherwise("/disciplinas");
        $stateProvider
            .state('disciplinas', {
                url: "/disciplinas",
                views: {
                    "viewA": {templateUrl: "partials/disciplinas.html"}
                },
                controller: "DisciplinasController"
            })
            .state('aulas', {
                url: '/aulas',
                views: {
                    "viewA": {templateUrl: "partials/aulas.html"}
                }
            });
    });
