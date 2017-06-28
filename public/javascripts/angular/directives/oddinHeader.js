import oddin from '../app'

oddin.directive('oddinHeader', function () {
  return {
    templateUrl: '/components/header.html',
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
