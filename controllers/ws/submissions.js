const ws = require('../../services/webService')

function showMaterials(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/submissions/${req.params.id}/materials`,
    method: 'GET',
  }, session.token).pipe(res)
}

function createMaterial(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/submissions/${req.params.id}/materials`,
    method: 'POST',
  }, session.token).pipe(res)
}

function show(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/submissions/${req.params.id}`,
    method: 'GET',
  }, session.token).pipe(res)
}

function destroy(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/submissions/${req.params.id}`,
    method: 'DELETE',
  }, session.token).pipe(res)
}

function update(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/submissions/${req.params.id}`,
    method: 'PUT',
    json: {
      text: req.body.text,
    },
  }, session.token).pipe(res)
}

module.exports = {
  showMaterials,
  createMaterial,
  show,
  destroy,
  update,
}
