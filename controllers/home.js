const constants = require('../config/constants')

function index(req, res) {
  if (`${constants.envMode}` == 'production')  	{ res.render('home-prod') } else {
    res.render('home')
  }
}

module.exports = {
  index,
}
