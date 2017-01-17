oddin.controller('LoginController', function ($scope, $window, $http, $cookies, $location, $state) {

	$scope.login = function (_user) {
		var user = angular.copy(_user);
		delete $scope.user;

		$http.post('/login', user)
			.then(function (data) {
				data = data.data;
				if(user.persist) {
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
		$http.post('/logout')
			.success(function (data) {
				$cookies.remove('session');
				$cookies.remove('profile');
				$cookies.remove('admin');
				$window.location.href = '/';
		});
	};

	$scope.recoverPassword = function (_user) {
		var user = angular.copy(_user);
		delete $scope.user;

		$http.post('/recover-password', user)
		.success(function (data) {
			Materialize.toast('Um Email com o link para recuperação de senha será enviado para ' + user.email, 5000)
			$state.go('login');
		})
		.error(function (data) {
			console.log('erro')
			Materialize.toast('Não foi possível enviar o email de recuperação de senha', 5000)
			$state.go('login');
		})
	}

	$scope.redefinePassword = function (_user) {
		var user = angular.copy(_user);
		delete $scope.user;

		if (user.password !== user.passwordConfirmation) {
			Materialize.toast('As senhas estão diferentes', 5000);
			return;
		}

		var requestBody = {
			password: password,
			token: $location.search().token,
		};

		$http.post('/redefine-password', requestBody)
			.success(function (data) {
				Materialize.toast('Senha redefinida com sucesso', 3000);
				$state.go('login');
			})
			.error(function (data) {
				Materialize.toast('Erro', 3000);
			});
	};
});
