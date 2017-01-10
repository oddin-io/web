function index(req, res) {
  res.render('index')
}

function recoverPassword() {
  console.log('recover-password')
}

module.exports = {
  index,
  recoverPassword,
}
