import angular from 'angular'
import uiRouter from 'angular-ui-router'
import uiMask from 'angular-ui-mask'
import ngMaterialize from 'angular-materialize'
import ngCookies from 'angular-cookies'

const oddin = angular.module('oddin', [uiRouter, ngMaterialize, ngCookies, uiMask])
oddin.constant('env', window.env)

export default oddin
