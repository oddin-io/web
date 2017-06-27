const ws = require('../../services/webService')

function index(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: '/lectures',
    method: 'GET',
  }, token).pipe(res)
}

function create(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: '/lectures',
    method: 'POST',
    json: {
      code: req.body.code,
      name: req.body.name,
      workload: req.body.workload,
    },
  }, token).pipe(res)
}

function update(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/lectures/${req.params.id}`,
    method: 'PUT',
    json: {
      code: req.body.code,
      name: req.body.name,
      workload: req.body.workload,
    },
  }, token).pipe(res)
}

function destroy(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/lectures/${req.params.id}`,
    method: 'DELETE',
  }, token).pipe(res)
}

module.exports = {
  index,
  destroy,
  create,
  update,
}
