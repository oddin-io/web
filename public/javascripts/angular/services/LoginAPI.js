oddin.factory("LoginAPI", function ($http) {
	var _login = function (user) {
		return $http.post('/login', user);
	};

	var _logout = function () {
		return $http.post('/logout');
	}

	var _recoverPassword = function (user) {
		return $http.post('/recover-password', user);
	}

	var _redefinePassword = function (user) {
		return $http.post('/redefine-password', user)
	}

	return {
		login: _login,
		logout: _logout,
		recoverPassword: _recoverPassword,
		redefinePassword: _redefinePassword
	}
})
