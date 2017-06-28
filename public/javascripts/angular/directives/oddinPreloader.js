import oddin from '../app'

oddin.directive('oddinPreloader', function () {
  return {
    replace: true,
    restrict: 'AE',
    scope: {
      sideBar: '@',
      loadVar: '=',
    },
    templateUrl: '/components/preloader.html',
  }
})
