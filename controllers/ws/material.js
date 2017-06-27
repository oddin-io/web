const ws = require('../../services/webService')

function index() {}

function show(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/materials/${req.params.id}`,
    method: 'GET',
  }, token).pipe(res)
}

function create() {}

function update(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/materials/${req.params.id}`,
    method: 'PUT',
    json: {
      name: req.body.name,
      mime: req.body.mime,
    },
  }, token).pipe(res)
}

function destroy(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/materials/${req.params.id}`,
    method: 'DELETE',
  }, token).pipe(res)
}

module.exports = {
  index,
  show,
  create,
  update,
  destroy,
}
