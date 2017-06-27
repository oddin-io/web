const ws = require('../../services/webService')

function index(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: '/events',
    method: 'GET',
  }, session.token).pipe(res)
}

function show(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/events/${req.params.id}`,
    method: 'GET',
  }, session.token).pipe(res)
}

function create(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: '/events',
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

  ws.authenticated({
    uri: `/events/${req.params.id}`,
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
    uri: `/events/${req.params.id}`,
    method: 'DELETE',
  }, session.token).pipe(res)
}

function instructions(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/events/${req.params.id}/instructions`,
    method: 'GET',
  }, session.token).pipe(res)
}

module.exports = {
  index,
  create,
  destroy,
  update,
  show,
  instructions,
}
