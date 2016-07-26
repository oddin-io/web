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
            })
            .state('materiais', {
                url: "/disciplina/:disciplinaID/materiais",
                views: {
                    "viewContent": {templateUrl: "partials/materiais.html", controller: "MateriaisController"}
                }
            })
            .state('participantes', {
                url: "/disciplina/:disciplinaID/participantes",
                views: {
                    "viewContent": {templateUrl: "partials/participantes.html", controller: "ParticipantesController"}
                }
            });
    });
