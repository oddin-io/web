const request = require('request')
const constants = require('../config/constants')

function login(req, res) {
  request(
    {
      uri: `${constants.uri}/session`,
      method: 'POST',
      json: {
        email: req.body.email,
        password: req.body.password,
      },
    }, function responseHandler(error, response, body) {
    if (response.statusCode === 401) {
      res.status(401)
      res.end()
    } else if (response.statusCode === 404) {
      res.status(404)
      res.end()
    } else {
      res.cookie('session', body)
      res.end()
    }
  })
}

function logout(req, res) {
  var session = req.cookies.session

  request(
    {
      uri: `${constants.uri}/session`,
      method: 'DELETE',
      headers: {
        'x-session-token': session.token,
      },
    }, function responseHandler(error, response) {
    if (response.statusCode === 401) {
      res.status(401)
      res.end()
    } else {
      res.status(204)
      res.end()
    }
  })
}

module.exports = {
  login,
  logout,
}
