const ws = require('../services/webService')

function login(req, res) {
  ws({
    uri: '/session',
    method: 'POST',
    json: {
      email: req.body.email,
      password: req.body.password,
    },
  }).pipe(res)
}

function logout(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: '/session',
    method: 'DELETE',
  }, session.token, function responseHandler(error, response) {
    if (response.statusCode >= 200 && response.statusCode < 300) {
      res.clearCookie('session')
      res.clearCookie('token')
    }

    res.status(response.statusCode)
    res.end()
  })
}

function recoverPassword(req, res) {
  ws({
    uri: '/recover-password',
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
    uri: '/redefine-password',
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
