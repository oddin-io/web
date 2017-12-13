import oddin from './app'

oddin.config(['$stateProvider', function ($stateProvider) {
  $stateProvider
    .state('login', {
      url: '/login',
      templateUrl: '/partials/login.html',
      controller: 'LoginController',
      authenticate: false,
    })
    .state('recuperar_senha', {
      url: '/recuperar_senha',
      templateUrl: '/partials/recover-password.html',
      controller: 'LoginController',
      authenticate: false,
    })
    .state('redefinir_senha', {
      url: '/redefinir_senha',
      templateUrl: '/partials/redefine-password.html',
      controller: 'LoginController',
      authenticate: false,
    })
    .state('instructions', {
      url: '/disciplinas',
      templateUrl: '/partials/instructions.html',
      controller: 'InstructionsController',
      authenticate: true,
    })
    .state('presentations', {
      url: '/disciplinas/:instructionID/aulas',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/presentations/index-student.html')
        }

        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/presentations/index-instructor.html')
        }
      },
      controller: 'PresentationsController',
      authenticate: true,
    })
    .state('presentation-show', {
      url: '/aulas/:presentationID',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/presentations/show-student.html')
        }

        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/presentations/show-instructor.html')
        }
      },
      controller: 'PresentationShowController',
      authenticate: true,
    })
    .state('presentation-materials', {
      url: '/aulas/:presentationID/material',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/presentations/material-student.html')
        }
        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/presentations/material-instructor.html')
        }
      },
      controller: 'PresentationMaterialController',
      authenticate: true,
    })
    .state('presentation-request', {
      url: '/aulas/:presentationID/atendimento',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/presentations/request-student.html')
        }

        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/presentations/request-instructor.html')
        }
      },
      controller: 'PresentationRequestController',
      authenticate: true,
    })
    .state('notices', {
      url: '/disciplinas/:instructionID/avisos',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/notices/index-student.html')
        }
        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/notices/index-instructor.html')
        }
      },
      controller: 'NoticesController',
      authenticate: true,
    })
    .state('dates', {
      url: '/disciplinas/:instructionID/datas',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/dates/index-student.html')
        }
        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/dates/index-instructor.html')
        }
      },
      controller: 'DatesController',
      authenticate: true,
    })
    .state('works', {
      url: '/disciplinas/:instructionID/tarefas',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/works/index-student.html')
        }
        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/works/index-instructor.html')
        }
      },
      controller: 'WorksController',
      authenticate: true,
    })
    .state('work-show', {
      url: '/tarefas/:workID',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/works/show-student.html')
        }
        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/works/show-instructor.html')
        }
      },
      controller: 'WorkShowController',
      authenticate: true,
    })
    .state('materials', {
      url: '/disciplinas/:instructionID/materiais',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/materials/index-student.html')
        }
        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/materials/index-instructor.html')
        }
      },
      controller: 'MaterialsController',
      authenticate: true,
    })
    .state('participants', {
      url: '/disciplinas/:instructionID/participantes',
      templateUrl: '/partials/participants.html',
      controller: 'ParticipantsController',
      authenticate: true,
    })
    .state('faqs', {
      url: '/disciplinas/:instructionID/faqs',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/faqs/index-student.html')
        }
        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/faqs/index-instructor.html')
        }
      },
      controller: 'FAQsController',
      authenticate: true,
    })
    .state('surveys', {
      url: '/disciplinas/:instructionID/enquetes',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/surveys/index-student.html')
        }
        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/surveys/index-instructor.html')
        }
      },
      controller: 'SurveysController',
      authenticate: true,
    })
    .state('tests', {
      url: '/disciplinas/:instructionID/testes',
      templateProvider: function ($cookies, $templateFactory) {
        if ($cookies.get('profile') == 0) {
          return $templateFactory.fromUrl('/partials/tests/index-student.html')
        }

        if ($cookies.get('profile') == 1) {
          return $templateFactory.fromUrl('/partials/tests/index-instructor.html')
        }
      },
      controller: 'TestsController',
      authenticate: true,
    })
    .state('test-student', {
      url: '/disciplinas/:instructionID/testes/:testID/realizar-teste',
      templateUrl: '/partials/tests/index-test-student.html',
      controller: 'StudentTestsController',
      authenticate: true,
    })
    .state('admin-events', {
      url: '/admin-cursos',
      templateUrl: '/partials/admin/events.html',
      controller: 'AdminEventsController',
      authenticate: true,
    })
    .state('admin-lectures', {
      url: '/admin-disciplinas',
      templateUrl: '/partials/admin/lectures.html',
      controller: 'AdminLecturesController',
      authenticate: true,
    })
    .state('admin-users', {
      url: '/admin-usuarios',
      templateUrl: '/partials/admin/users.html',
      controller: 'AdminUsersController',
      authenticate: true,
    })
    .state('admin-event-show', {
      url: '/admin-cursos/:eventID',
      templateUrl: '/partials/admin/event-show.html',
      controller: 'AdminEventShowController',
      authenticate: true,
    })
    .state('admin-instruction-show', {
      url: '/admin-disciplinas-cadastradas/:instructionID',
      templateUrl: '/partials/admin/instruction-show.html',
      controller: 'AdminInstructionShowController',
      authenticate: true,
    })
    .state('admin-add-participants', {
      url: '/add-participants/:instructionID',
      templateUrl: '/partials/admin/add-participants.html',
      controller: 'AdminInstructionShowController',
      authenticate: true,
    })
    .state('admin-add-instructions', {
      url: '/add-instructions/:eventID',
      templateUrl: '/partials/admin/add-instructions.html',
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

oddin.factory('AuthorizationInterceptor', ['$cookies', function ($cookies) {
  return {
    request: function (config) {
      var authToken = $cookies.get('token')
      var isAmazon = config.url.indexOf('amazonaws.com') != -1;

      if (authToken && !isAmazon) {
        Object.assign(config.headers, {
          Authorization: authToken,
        })

        return config
      }

      return config
    },
  }
}])

oddin.config(['$httpProvider', function ($httpProvider) {
  $httpProvider.interceptors.push('AuthorizationInterceptor')
}])
