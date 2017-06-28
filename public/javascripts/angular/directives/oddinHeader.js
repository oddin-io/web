import oddin from '../app'

oddin.directive('oddinHeader', function () {
  return {
    templateUrl: '/components/header',
    replace: true,
    restrict: 'AE',
    scope: {
      title: '@',
      btnType: '@',
      sideBar: '@',
      toStateUrl: '@',
      logo: '@',
    },
  }
})
