oddin.directive('oddinFab', function () {
  return {
    replace: true,
    restrict: 'AE',
    scope: {
      trigger: '@',
      modalTrigger: '@',
      icon: '@',
    },
    templateUrl: '/components/fab',
  }
})
