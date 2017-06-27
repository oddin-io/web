const ws = require('../../services/webService')

function index(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: '/events',
    method: 'GET',
  }, token).pipe(res)
}

function show(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/events/${req.params.id}`,
    method: 'GET',
  }, token).pipe(res)
}

function create(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: '/events',
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
    uri: `/events/${req.params.id}`,
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
    uri: `/events/${req.params.id}`,
    method: 'DELETE',
  }, token).pipe(res)
}

function instructions(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/events/${req.params.id}/instructions`,
    method: 'GET',
  }, token).pipe(res)
}

module.exports = {
  index,
  create,
  destroy,
  update,
  show,
  instructions,
}
