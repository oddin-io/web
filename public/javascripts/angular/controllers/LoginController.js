oddin.controller('LoginController', function ($scope, $window, LoginAPI, $cookies, $location, $state) {
	$scope.dataLoaded = true;
	$scope.login = function (user) {
		$scope.dataLoaded = false;
		LoginAPI.login(user)
		.then(function (response) {
			data = response.data;
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
		.catch(function (error) {
			$scope.dataLoaded = true;
			delete $scope.user;
			if (error.status == 401)
				Materialize.toast('Usuário ou senha inválida', 3000);
			if (error.status >= 500)
				Materialize.toast('Erro no servidor', 3000);
		});
	};

	$scope.logout = function () {
		$scope.dataLoaded = false;
		LoginAPI.logout()
		.then(function () {
			$cookies.remove('session');
			$cookies.remove('profile');
			$cookies.remove('admin');
			$window.location.href = '/';
		});
	};

	$scope.recoverPassword = function (user) {
		$scope.dataLoaded = false;
		LoginAPI.recoverPassword(user)
		.then(function () {
			Materialize.toast('Um Email com o link para recuperação de senha será enviado para ' + user.email, 3000)
			$state.go('login');
		})
		.catch(function () {
			$scope.dataLoaded = true;
			delete $scope.user;
			Materialize.toast('Não foi possível enviar o email de recuperação de senha', 3000)
		})
	}

	$scope.redefinePassword = function (user) {
		$scope.dataLoaded = false;
		if (_user.password !== _user.passwordConfirmation) {
			$scope.dataLoaded = true;
			delete $scope.user;
			Materialize.toast('As senhas estão diferentes', 3000);
			return;
		}
		_user.token = $location.search().token;
		LoginAPI.redefinePassword(_user)
		.then(function () {
			Materialize.toast('Senha redefinida com sucesso', 3000);
			$state.go('login');
		})
		.catch(function () {
			$scope.dataLoaded = true;
			delete $scope.user;
			Materialize.toast('Erro ao redefinir senha', 3000);
		});
	};
});
