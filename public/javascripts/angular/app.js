const oddin = angular.module('oddin', ['ui.router', 'ui.materialize', 'ngCookies', 'ui.mask'])
oddin.constant('env', window.env)

export default oddin
