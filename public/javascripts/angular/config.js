oddin.config(function ($stateProvider) {
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
		templateUrl: '/partials/instructions-index',
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
	.state('faqs', {
		url: '/disciplinas/:disciplinaID/faqs',
		templateProvider: function ($cookies, $templateFactory) {
			if($cookies.get('profile') == 0)
			return $templateFactory.fromUrl("/partials/faqs-a");
			if($cookies.get('profile') == 1)
			return $templateFactory.fromUrl("/partials/faqs-p");
		},
		controller: 'FAQsController'
	})
	.state('enquetes', {
		url: '/disciplinas/:disciplinaID/enquetes',
		templateProvider: function ($cookies, $templateFactory) {
			if($cookies.get('profile') == 0)
			return $templateFactory.fromUrl("/partials/enquetes-a");
			if($cookies.get('profile') == 1)
			return $templateFactory.fromUrl("/partials/enquetes-p");
		},
		controller: 'SurveysController'
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
	.state('admin-events', {
		url: '/admin-cursos',
		templateUrl: '/partials/admin-events',
		controller: 'AdminEventsController'
	})
	.state('admin-lectures', {
		url: '/admin-disciplinas',
		templateUrl: '/partials/admin-lectures',
		controller: 'AdminLecturesController'
	})
	.state('admin-users', {
		url: '/admin-usuarios',
		templateUrl: '/partials/admin-users',
		controller: 'AdminUsersController'
	})
	.state('admin-event-show', {
		url: '/admin-cursos/:eventID',
		templateUrl: '/partials/admin-event-show',
		controller: 'AdminEventShowController'
	})
	.state('instruction-show', {
		url: '/curso-disciplinas/:disciplinaID',
		templateUrl: '/partials/admin-instruction-show',
		controller: 'AdminInstructionShowController'
	})
	.state('add-participants', {
		url: '/add-participants/:disciplinaID',
		templateUrl: '/partials/admin-add-participants',
		controller: 'AdminInstructionShowController'
	})
	.state('admin-add-instructions', {
		url: '/add-instructions/:eventID',
		templateUrl: '/partials/admin-add-instructions',
		controller: 'AdminEventShowController'
	})
}).run(function ($window, $location, $state, $cookies) {
	if ($window.location.pathname == '/home') {
		if($cookies.get('admin')) {
			$state.go('admin-events');
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
