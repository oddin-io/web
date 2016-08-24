const request = require('request')
const constants = require('../config/constants')

function login(req, res) {
  request({
    uri: `${constants.uri}/session`,
    method: 'POST',
    json: {
      email: req.body.email,
      password: req.body.password,
    },
  }, function responseHandler(error, response, body) {
    if (response.statusCode >= 200 && response.statusCode < 300) {
      res.cookie('session', body)
    }

    res.status(response.statusCode)
    res.end()
  })
}

function logout(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/session`,
    method: 'DELETE',
    headers: {
      'x-session-token': session.token,
    },
  }, function responseHandler(error, response) {
    if (response.statusCode >= 200 && response.statusCode < 300) {
      res.clearCookie('session')
    }

    res.status(response.statusCode)
    res.end()
  })
}

module.exports = {
  login,
  logout,
}
