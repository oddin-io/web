oddin.factory("CurrentUser", function ($cookies) {
	return {
		name: JSON.parse($cookies.get('session').substring(2)).person.name,
		email: JSON.parse($cookies.get('session').substring(2)).person.email
	}
});
