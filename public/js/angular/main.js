angular.module('oddin', ['ui.router', 'ngResource', 'ui.materialize'])
    .config(function($stateProvider, $urlRouterProvider) {
        $urlRouterProvider.otherwise("/disciplinas");
        $stateProvider
            .state('disciplinas', {
                url: "/disciplinas",
                views: {
                    "viewTitle": {templateUrl: "partials/title.html"},
                    "viewNavHeader": {templateUrl: "partials/nav_header.html"},
                    "viewSideMenuItens": {templateUrl: "partials/disciplinas_side_menu_itens.html"},
                    "viewContent": {templateUrl: "partials/disciplinas_content.html", controller: "DisciplinasController"}
                    //resolver o problema de carregar o controle multiplas vezes(1 para cada view) angular-ui-router?
                }
            });
    });
