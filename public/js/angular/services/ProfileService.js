angular.module('oddin').factory('Profile', function($resource) {
    return $resource('/api/instructions/:id/profile')
});

