const ws = require('../../services/webService')

function index() {}

function show(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/materials/${req.params.id}`,
    method: 'GET',
  }, session.token).pipe(res)
}

function create() {}

function update(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/materials/${req.params.id}`,
    method: 'PUT',
    json: {
      name: req.body.name,
      mime: req.body.mime,
    },
  }, session.token).pipe(res)
}

function destroy(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/materials/${req.params.id}`,
    method: 'DELETE',
  }, session.token).pipe(res)
}

module.exports = {
  index,
  show,
  create,
  update,
  destroy,
}
