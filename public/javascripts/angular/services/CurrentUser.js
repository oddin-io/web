oddin.factory('CurrentUser', ['$cookies', function ($cookies) {
  return {
    id: JSON.parse($cookies.get('session').substring(2)).person.id,
    name: JSON.parse($cookies.get('session').substring(2)).person.name,
    email: JSON.parse($cookies.get('session').substring(2)).person.email,
  }
}])
