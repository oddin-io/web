angular.module('oddin', ['ui.router', 'ngResource'])
    .config(function($stateProvider, $urlRouterProvider) {
        $urlRouterProvider.otherwise("/disciplinas");
        $stateProvider
            .state('disciplinas', {
                url: "/disciplinas",
                views: {
                    "viewTitle": {templateUrl: "partials/title.html", controller: "DisciplinasController"},
                    "viewNavHeader": {templateUrl: "partials/nav_header.html", controller: "DisciplinasController"},
                    "viewSideMenuItens": {templateUrl: "partials/disciplinas_side_menu_itens.html"},
                    "viewContent": {templateUrl: "partials/disciplinas_content.html", controller: "DisciplinasController"}
                },
                controller: "DisciplinasController"
            });
    });
