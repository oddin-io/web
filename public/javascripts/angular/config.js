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
		controller: 'InstructionsController'
	})
	.state('aulas', {
		url: '/disciplinas/:disciplinaID/aulas',
		templateProvider: function ($cookies, $templateFactory) {
			if($cookies.get('profile') == 0)
			return $templateFactory.fromUrl("/partials/aulas-a");
			if($cookies.get('profile') == 1)
			return $templateFactory.fromUrl("/partials/aulas-p");
		},
		controller: 'PresentationsController'
	})
	.state('avisos', {
		url: '/disciplinas/:disciplinaID/avisos',
		templateProvider: function ($cookies, $templateFactory) {
			if($cookies.get('profile') == 0)
			return $templateFactory.fromUrl("/partials/avisos-a");
			if($cookies.get('profile') == 1)
			return $templateFactory.fromUrl("/partials/avisos-p");
		},
		controller: 'NoticesController'
	})
	.state('datas', {
		url: '/disciplinas/:disciplinaID/datas',
		templateProvider: function ($cookies, $templateFactory) {
			if($cookies.get('profile') == 0)
			return $templateFactory.fromUrl("/partials/datas-a");
			if($cookies.get('profile') == 1)
			return $templateFactory.fromUrl("/partials/datas-p");
		},
		controller: 'DatesController'
	})
	.state('tarefas', {
		url: '/disciplinas/:disciplinaID/tarefas',
		templateProvider: function ($cookies, $templateFactory) {
			if($cookies.get('profile') == 0)
			return $templateFactory.fromUrl("/partials/tarefas-a");
			if($cookies.get('profile') == 1)
			return $templateFactory.fromUrl("/partials/tarefas-p");
		},
		controller: 'WorksController'
	})
	.state('materiais', {
		url: '/disciplinas/:disciplinaID/materiais',
		templateProvider: function ($cookies, $templateFactory) {
			if($cookies.get('profile') == 0)
			return $templateFactory.fromUrl("/partials/materiais-a");
			if($cookies.get('profile') == 1)
			return $templateFactory.fromUrl("/partials/materiais-p");
		},
		controller: 'MaterialsController'
	})
	.state('participantes', {
		url: '/disciplinas/:disciplinaID/participantes',
		templateUrl: '/partials/participantes',
		controller: 'ParticipantsController'
	})
	.state('duvidas', {
		url: '/aulas/:aulaID',
		templateProvider: function ($cookies, $templateFactory) {
			if($cookies.get('profile') == 0)
			return $templateFactory.fromUrl("/partials/duvidas-a");
			if($cookies.get('profile') == 1)
			return $templateFactory.fromUrl("/partials/duvidas-p");
		},
		controller: 'PresentationShowController'
	})
	.state('material-aula', {
		url: '/aulas/:aulaID/material',
		templateProvider: function ($cookies, $templateFactory) {
			if($cookies.get('profile') == 0)
			return $templateFactory.fromUrl("/partials/material-aula-a");
			if($cookies.get('profile') == 1)
			return $templateFactory.fromUrl("/partials/material-aula-p");
		},
		controller: 'PresentationMaterialController'
	})
	.state('tarefa-status',  {
		url: '/tarefas/:tarefaID',
		templateProvider: function ($cookies, $templateFactory) {
			if($cookies.get('profile') == 0)
			return $templateFactory.fromUrl("/partials/tarefa-status-a");
			if($cookies.get('profile') == 1)
			return $templateFactory.fromUrl("/partials/tarefa-status-p");
		},
		controller: 'WorkShowController'
	})
	.state('cursos-admin', {
		url: '/cursos-admin',
		templateUrl: '/partials/admin-cursos',
		controller: 'AdminEventsController'
	})
	.state('curso-status', {
		url: '/curso/:cursoID',
		templateUrl: '/partials/curso-status',
		controller: 'AdminEventShowController'
	})
	.state('instruction-show', {
		url: '/curso-disciplinas/:disciplinaID',
		templateUrl: '/partials/admin-instruction-show',
		controller: 'AdminInstructionShowController'
	})
	.state('disciplinas-admin', {
		url: '/disciplinas-admin',
		templateUrl: '/partials/admin-disciplinas',
		controller: 'AdminLecturesController'
	})
	.state('usuarios-admin', {
		url: '/usuarios-admin',
		templateUrl: '/partials/admin-usuarios',
		controller: 'AdminUsersController'
	})
	.state('add-participants', {
		url: '/add-participants/:disciplinaID',
		templateUrl: '/partials/admin-add-participants',
		controller: 'AdminInstructionShowController'
	})
}).run(function ($window, $location, $state, $cookies) {
	if ($window.location.pathname == '/home') {
		if($cookies.get('admin')) {
			$state.go('cursos-admin');
		} else {
			$state.go('disciplinas')
		}
	}
	if ($window.location.pathname == '/') {
		if(!$cookies.get('session'))
		$state.go('login');
		else
		$window.location.href = '/home';
	}
})
