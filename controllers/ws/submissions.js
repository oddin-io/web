const ws = require('../../services/webService')

function showMaterials(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/submissions/${req.params.id}/materials`,
    method: 'GET',
  }, token).pipe(res)
}

function createMaterial(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/submissions/${req.params.id}/materials`,
    method: 'POST',
  }, token).pipe(res)
}

function show(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/submissions/${req.params.id}`,
    method: 'GET',
  }, token).pipe(res)
}

function destroy(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/submissions/${req.params.id}`,
    method: 'DELETE',
  }, token).pipe(res)
}

function update(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/submissions/${req.params.id}`,
    method: 'PUT',
    json: {
      text: req.body.text,
    },
  }, token).pipe(res)
}

module.exports = {
  showMaterials,
  createMaterial,
  show,
  destroy,
  update,
}
