oddin.config(['$stateProvider', function ($stateProvider) {
  $stateProvider
    .state('login', {
      url: '/login',
      templateUrl: '/partials/login',
      controller: 'LoginController',
      authenticate: false,
    })
    .state('recuperar_senha', {
      url: '/recuperar_senha',
      templateUrl: '/partials/recover-password',
      controller: 'LoginController',
      authenticate: false,
    })
    .state('redefinir_senha', {
      url: '/redefinir_senha',
      templateUrl: '/partials/redefine-password',
      controller: 'LoginController',
      authenticate: false,
    })
    .state('instructions', {
      url: '/disciplinas',
      templateUrl: '/partials/instructions',
      controller: 'InstructionsController',
      authenticate: true,
    })
    .state('presentations', {
      url: '/disciplinas/:instructionID/aulas',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/presentations/index-student')
        }

        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/presentations/index-instructor')
        }
      },
      controller: 'PresentationsController',
      authenticate: true,
    })
    .state('presentation-show', {
      url: '/aulas/:presentationID',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/presentations/show-student')
        }

        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/presentations/show-instructor')
        }
      },
      controller: 'PresentationShowController',
      authenticate: true,
    })
    .state('presentation-materials', {
      url: '/aulas/:presentationID/material',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/presentations/material-student')
        }
        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/presentations/material-instructor')
        }
      },
      controller: 'PresentationMaterialController',
      authenticate: true,
    })
    .state('notices', {
      url: '/disciplinas/:instructionID/avisos',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/notices/index-student')
        }
        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/notices/index-instructor')
        }
      },
      controller: 'NoticesController',
      authenticate: true,
    })
    .state('dates', {
      url: '/disciplinas/:instructionID/datas',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/dates/index-student')
        }
        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/dates/index-instructor')
        }
      },
      controller: 'DatesController',
      authenticate: true,
    })
    .state('works', {
      url: '/disciplinas/:instructionID/tarefas',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/works/index-student')
        }
        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/works/index-instructor')
        }
      },
      controller: 'WorksController',
      authenticate: true,
    })
    .state('work-show', {
      url: '/tarefas/:workID',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/works/show-student')
        }
        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/works/show-instructor')
        }
      },
      controller: 'WorkShowController',
      authenticate: true,
    })
    .state('materials', {
      url: '/disciplinas/:instructionID/materiais',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/materials/index-student')
        }
        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/materials/index-instructor')
        }
      },
      controller: 'MaterialsController',
      authenticate: true,
    })
    .state('participants', {
      url: '/disciplinas/:instructionID/participantes',
      templateUrl: '/partials/participants',
      controller: 'ParticipantsController',
      authenticate: true,
    })
    .state('faqs', {
      url: '/disciplinas/:instructionID/faqs',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/faqs/index-student')
        }
        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/faqs/index-instructor')
        }
      },
      controller: 'FAQsController',
      authenticate: true,
    })
    .state('surveys', {
      url: '/disciplinas/:instructionID/enquetes',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/surveys/index-student')
        }
        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/surveys/index-instructor')
        }
      },
      controller: 'SurveysController',
      authenticate: true,
    })
    .state('tests', {
      url: '/disciplinas/:instructionID/testes',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/tests/index-student')
        }

        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/tests/index-instructor')
        }
      },
      controller: 'TestsController',
      authenticate: true,
    })
    .state('admin-events', {
      url: '/admin-cursos',
      templateUrl: '/partials/admin/events',
      controller: 'AdminEventsController',
      authenticate: true,
    })
    .state('admin-lectures', {
      url: '/admin-disciplinas',
      templateUrl: '/partials/admin/lectures',
      controller: 'AdminLecturesController',
      authenticate: true,
    })
    .state('admin-users', {
      url: '/admin-usuarios',
      templateUrl: '/partials/admin/users',
      controller: 'AdminUsersController',
      authenticate: true,
    })
    .state('admin-event-show', {
      url: '/admin-cursos/:eventID',
      templateUrl: '/partials/admin/event-show',
      controller: 'AdminEventShowController',
      authenticate: true,
    })
    .state('admin-instruction-show', {
      url: '/admin-disciplinas-cadastradas/:instructionID',
      templateUrl: '/partials/admin/instruction-show',
      controller: 'AdminInstructionShowController',
      authenticate: true,
    })
    .state('admin-add-participants', {
      url: '/add-participants/:instructionID',
      templateUrl: '/partials/admin/add-participants',
      controller: 'AdminInstructionShowController',
      authenticate: true,
    })
    .state('admin-add-instructions', {
      url: '/add-instructions/:eventID',
      templateUrl: '/partials/admin/add-instructions',
      controller: 'AdminEventShowController',
      authenticate: true,
    })
}])
.run([
  '$window', '$location', '$state', '$cookies',
  function ($window, $location, $state, $cookies) {
    if ($window.location.pathname == '/home') {
      if ($cookies.get('admin')) {
        $state.go('admin-events')
      } else {
        $state.go('instructions')
      }
    }
    if ($window.location.pathname == '/') {
      if (!$cookies.get('session')) {
        $state.go('login')
      } else {
        $window.location.href = '/home'
      }
    }
  },
])

oddin.run([
  '$window', '$rootScope', '$state', '$cookies',
  function authenticationChecker($window, $rootScope, $state, $cookies) {
    var isAuthenticated = !!$cookies.get('session')

    $rootScope.$on('$stateChangeStart', function (event, toState) {
      if (toState.authenticate && !isAuthenticated) {
        // User isn’t authenticated
        event.preventDefault()
        $window.location.href = '/'
      }
    })
  },
])
