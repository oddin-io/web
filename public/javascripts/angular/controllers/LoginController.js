oddin.controller('LoginController', function ($scope, $window, LoginAPI, $cookies, $location, $state) {

	$scope.login = function (user) {
		var _user = angular.copy(user);
		delete $scope.user;

		LoginAPI.login(_user)
		.then(function (response) {
			data = response.data;
			if(_user.persist) {
				var expireDate = new Date();
				expireDate.setMonth(expireDate.getMonth() + 1);
				$cookies.put('session', $cookies.get('session'), {'expires': expireDate});
			}
			if(data.person.admin) {
				$cookies.put('admin', true);
			}
			$window.location.href = '/home';
		})
		.catch(function (erro) {
			if (erro.status == 401)
				Materialize.toast('Usuário ou senha inválida', 5000);
			if (erro.status >= 500)
				Materialize.toast('Erro no servidor', 5000);
		});
	};

	$scope.logout = function () {
		LoginAPI.logout()
		.then(function () {
			$cookies.remove('session');
			$cookies.remove('profile');
			$cookies.remove('admin');
			$window.location.href = '/';
		});
	};

	$scope.recoverPassword = function (user) {
		var _user = angular.copy(user);
		delete $scope.user;

		LoginAPI.recoverPassword(_user)
		.then(function () {
			Materialize.toast('Um Email com o link para recuperação de senha será enviado para ' + _user.email, 5000)
			$state.go('login');
		})
		.catch(function () {
			Materialize.toast('Não foi possível enviar o email de recuperação de senha', 5000)
			$state.go('login');
		})
	}

	$scope.redefinePassword = function (user) {
		var _user = angular.copy(user);
		delete $scope.user;

		if (_user.password !== _user.passwordConfirmation) {
			Materialize.toast('As senhas estão diferentes', 5000);
			return;
		}

		_user.token = $location.search().token;

		LoginAPI.redefinePassword(_user)
		.then(function () {
			Materialize.toast('Senha redefinida com sucesso', 3000);
			$state.go('login');
		})
		.catch(function () {
			Materialize.toast('Erro', 3000);
		});
	};
});
