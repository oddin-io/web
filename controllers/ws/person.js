const ws = require('../../services/webService')

// Implementar exibição de todos os usuários no backend
function index(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: '/people',
    method: 'GET',
  }, token).pipe(res)
}

function create(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: '/people',
    method: 'POST',
    json: {
      name: req.body.name,
      email: req.body.email,
      password: req.body.password,
    },
  }, token).pipe(res)
}

function update(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/people/${req.params.id}`,
    method: 'PUT',
    json: {
      name: req.body.name,
      email: req.body.email,
    },
  }, token).pipe(res)
}

function destroy(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/people/${req.params.id}`,
    method: 'DELETE',
  }, token).pipe(res)
}

module.exports = {
  index,
  destroy,
  create,
  update,
}
