function index(req, res, next) {
  res.render('index');
}

function recoverPassword(req, res, next) {
  console.log('recover-password');
}

module.exports = function() {
  return {
    index: index,
    recoverPassword: recoverPassword
  };
};
