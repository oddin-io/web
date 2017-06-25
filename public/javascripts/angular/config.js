oddin.config(['$stateProvider', function ($stateProvider) {
  $stateProvider
        .state('login', {
          url: '/login',
          templateUrl: '/partials/login',
          controller: 'LoginController',
        })
        .state('recuperar_senha', {
          url: '/recuperar_senha',
          templateUrl: '/partials/recover-password',
          controller: 'LoginController',
        })
        .state('redefinir_senha', {
          url: '/redefinir_senha',
          templateUrl: '/partials/redefine-password',
          controller: 'LoginController',
        })
        .state('instructions', {
          url: '/disciplinas',
          templateUrl: '/partials/instructions',
          controller: 'InstructionsController',
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
        })
        .state('participants', {
          url: '/disciplinas/:instructionID/participantes',
          templateUrl: '/partials/participants',
          controller: 'ParticipantsController',
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
        })
        .state('admin-events', {
          url: '/admin-cursos',
          templateUrl: '/partials/admin/events',
          controller: 'AdminEventsController',
        })
        .state('admin-lectures', {
          url: '/admin-disciplinas',
          templateUrl: '/partials/admin/lectures',
          controller: 'AdminLecturesController',
        })
        .state('admin-users', {
          url: '/admin-usuarios',
          templateUrl: '/partials/admin/users',
          controller: 'AdminUsersController',
        })
        .state('admin-event-show', {
          url: '/admin-cursos/:eventID',
          templateUrl: '/partials/admin/event-show',
          controller: 'AdminEventShowController',
        })
        .state('admin-instruction-show', {
          url: '/admin-disciplinas-cadastradas/:instructionID',
          templateUrl: '/partials/admin/instruction-show',
          controller: 'AdminInstructionShowController',
        })
        .state('admin-add-participants', {
          url: '/add-participants/:instructionID',
          templateUrl: '/partials/admin/add-participants',
          controller: 'AdminInstructionShowController',
        })
        .state('admin-add-instructions', {
          url: '/add-instructions/:eventID',
          templateUrl: '/partials/admin/add-instructions',
          controller: 'AdminEventShowController',
        })
}])
.run(
  [
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
    }])
