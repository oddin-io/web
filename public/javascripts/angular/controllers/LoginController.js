oddin.controller('LoginController',
function ($scope, $window, $http, $cookies, $location, Login, $state) {
  $scope.recover = {}
  $scope.user = new Login()
  $scope.login = function () {
    $scope.user.$save()
    .then(function (data) {
      $window.location.href = '/home'
    })
    .catch(function (erro) {
      if (erro.status == 401)
      Materialize.toast('Usuário ou senha inválida', 5000)
      if (erro.status >= 500)
      Materialize.toast('Erro no servidor', 5000)
      $scope.user.email = ''
      $scope.user.password = ''
    })
  }
  $scope.logout = function () {
    $http.post('/logout')
    .success(function (data) {
      $cookies.remove('session')
      $cookies.remove('profile')
      $window.location.href = '/'
    })
  }
  $scope.recoverPassword = function () {
    $http.post('/recover-password', $scope.recover)
    .success(function (data) {
      Materialize.toast('Um Email com o link para recuperação de senha será enviado para ' + $scope.recover.email, 5000)
      $state.go('login');
    })
    .error(function (data) {
      console.log('erro')
      Materialize.toast('Não foi possível enviar o email de recuperação de senha', 5000)
      $state.go('login');
      $scope.recover.email = ''
    })
  }

  $scope.redefinePassword = function (password, passwordConfirmation) {
    if (password !== passwordConfirmation) {
      Materialize.toast('As senhas estão diferentes', 5000)
      return
    }

    var body = {
      password: password,
      token: $location.search().token,
    }

    $http.post('/redefine-password', body)
    .success(function (data) {
      Materialize.toast('Senha redefinida com sucesso', 3000)
      $state.go('login');
    })
    .error(function (data) {
      console.log('erro')
      Materialize.toast('Senha inválida', 3000)
      password = "";
      passwordConfirmation = "";
    })
  }
}
)
