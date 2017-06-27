const ws = require('../../services/webService')

function index(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: '/lectures',
    method: 'GET',
  }, session.token).pipe(res)
}

function create(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: '/lectures',
    method: 'POST',
    json: {
      code: req.body.code,
      name: req.body.name,
      workload: req.body.workload,
    },
  }, session.token).pipe(res)
}

function update(req, res) {
  const session = req.cookies.session
  console.log(req.params)
  ws.authenticated({
    uri: `/lectures/${req.params.id}`,
    method: 'PUT',
    json: {
      code: req.body.code,
      name: req.body.name,
      workload: req.body.workload,
    },
  }, session.token).pipe(res)
}

function destroy(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/lectures/${req.params.id}`,
    method: 'DELETE',
  }, session.token).pipe(res)
}

module.exports = {
  index,
  destroy,
  create,
  update,
}
