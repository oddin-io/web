angular.module('oddin', ['ui.router', 'ngResource', 'ui.materialize'])
.config(function($stateProvider, $urlRouterProvider) {
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
      "viewContent": {templateUrl: "partials/aulas.html", controller: "DisciplinaController"}
    }
  })
  .state('materiais', {
    url: "/disciplina/:disciplinaID/materiais",
    views: {
      "viewContent": {templateUrl: "partials/materiais.html", controller: "DisciplinaController"}
    }
  })
  .state('participantes', {
    url: "/disciplina/:disciplinaID/participantes",
    views: {
      "viewContent": {templateUrl: "partials/participantes.html", controller: "DisciplinaController"}
    }
  })
  .state('duvidas', {
    url: "/disciplina/:disciplinaID/aula/:aulaID",
    views: {
      "viewContent": {templateUrl: "partials/duvidas.html", controller: "AulaController"}
    }
  })
}).run(function($window, $location, $state) {
  if($window.location.pathname == '/index')
  $state.go('disciplinas');
});
