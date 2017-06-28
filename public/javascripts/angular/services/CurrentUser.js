import oddin from '../app'

oddin.factory('CurrentUser', ['$cookies', function ($cookies) {
  const currentUser = $cookies.getObject('session')

  return {
    id: currentUser.person.id,
    name: currentUser.person.name,
    email: currentUser.person.email,
  }
}])
