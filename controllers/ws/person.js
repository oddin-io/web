const request = require('request')
const constants = require('../../config/constants')

//Implementar exibição de todos os usuários no backend
function index(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/people`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function create(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/people`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    },
    json: {
      'name': req.body.name,
      'email': req.body.email,
      'password': req.body.password
    }
  }).pipe(res)
}

function update(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/people/${req.params.id}`,
    method: 'PUT',
    headers: {
      'x-session-token': session.token,
    },
    json: {
      'name': req.body.name,
      'email': req.body.email
    }
  }).pipe(res)
}

function destroy(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/people/${req.params.id}`,
    method: 'DELETE',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

module.exports = {
  index,
  destroy,
  create,
  update
}
