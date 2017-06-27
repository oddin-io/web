const constants = require('../config/constants')

function index(req, res) {
  if (`${constants.envMode}` === 'production') res.render('index-prod')
  else res.render('index')
}

function recoverPassword() {
  console.log('recover-password')
}

module.exports = {
  index,
  recoverPassword,
}
