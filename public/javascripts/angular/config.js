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
            templateProvider: function ($cookies, $templateFactory) {
                if($cookies.get('profile') == 0)
                    return $templateFactory.fromUrl("/partials/aulas-a");
                if($cookies.get('profile') == 1)
                    return $templateFactory.fromUrl("/partials/aulas-p");
            },
            controller: 'DisciplinaController'
        })
        .state('avisos', {
            url: '/disciplinas/:disciplinaID/avisos',
            templateProvider: function ($cookies, $templateFactory) {
                if($cookies.get('profile') == 0)
                    return $templateFactory.fromUrl("/partials/avisos-a");
                if($cookies.get('profile') == 1)
                    return $templateFactory.fromUrl("/partials/avisos-p");
            },
            controller: 'DisciplinaController'
        })
        .state('informativos', {
            url: '/disciplinas/:disciplinaID/informativos',
            templateProvider: function ($cookies, $templateFactory) {
                if($cookies.get('profile') == 0)
                    return $templateFactory.fromUrl("/partials/informativos-a");
                if($cookies.get('profile') == 1)
                    return $templateFactory.fromUrl("/partials/informativos-p");
            },
            controller: 'DisciplinaController'
        })
        .state('materiais', {
            url: '/disciplinas/:disciplinaID/materiais',
            templateProvider: function ($cookies, $templateFactory) {
                if($cookies.get('profile') == 0)
                    return $templateFactory.fromUrl("/partials/materiais-a");
                if($cookies.get('profile') == 1)
                    return $templateFactory.fromUrl("/partials/materiais-p");
            },
            controller: 'DisciplinaController'
        })
        .state('participantes', {
            url: '/disciplinas/:disciplinaID/participantes',
            templateUrl: '/partials/participantes',
            controller: 'DisciplinaController'
        })
        .state('duvidas', {
            url: '/aulas/:aulaID',
            templateProvider: function ($cookies, $templateFactory) {
                if($cookies.get('profile') == 0)
                    return $templateFactory.fromUrl("/partials/duvidas-a");
                if($cookies.get('profile') == 1)
                    return $templateFactory.fromUrl("/partials/duvidas-p");
            },
            controller: 'AulaController'
        })
        .state('material-aula', {
            url: '/aulas/:aulaID/material',
            templateProvider: function ($cookies, $templateFactory) {
                if($cookies.get('profile') == 0)
                    return $templateFactory.fromUrl("/partials/material-aula-a");
                if($cookies.get('profile') == 1)
                    return $templateFactory.fromUrl("/partials/material-aula-p");
            },
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
