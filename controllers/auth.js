const ws = require('../services/webService')
const constants = require('../config/constants')

function login(req, res) {
  ws({
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

    res.status(response.statusCode).send(body).end()
  })
}

function logout(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: '/session',
    method: 'DELETE',
  }, session.token, function responseHandler(error, response) {
    if (response.statusCode >= 200 && response.statusCode < 300) {
      res.clearCookie('session')
    }

    res.status(response.statusCode)
    res.end()
  })
}

function recoverPassword(req, res) {
  ws({
    uri: `${constants.uri}/recover-password`,
    method: 'POST',
    json: {
      email: req.body.email,
    },
  }, function responseHandler(error, response) {
    if (response.statusCode >= 200 && response.statusCode < 300) {
      res.end()
    }
    res.status(response.statusCode)
    res.end()
  })
}

function redefinePassword(req, res) {
  ws({
    uri: `${constants.uri}/redefine-password`,
    method: 'POST',
    json: {
      password: req.body.password,
      token: req.body.token,
    },
  }, function responseHandler(error, response) {
    if (response.statusCode >= 200 && response.statusCode < 300) {
      res.end()
    }
    res.status(response.statusCode)
    res.end()
  })
}

module.exports = {
  login,
  logout,
  recoverPassword,
  redefinePassword,
}
