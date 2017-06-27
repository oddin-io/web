const ws = require('../../services/webService')

function show(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/works/${req.params.id}`,
    method: 'GET',
  }, token).pipe(res)
}

function destroy(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/works/${req.params.id}`,
    method: 'DELETE',
  }, token).pipe(res)
}

function update(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/works/${req.params.id}`,
    method: 'PUT',
    json: {
      subject: req.body.subject,
      description: req.body.description,
      deadline: req.body.deadline,
    },
  }, token).pipe(res)
}

function createMaterial(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/works/${req.params.id}/materials`,
    method: 'POST',
  }, token).pipe(res)
}

function showMaterials(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/works/${req.params.id}/materials`,
    method: 'GET',
  }, token).pipe(res)
}

function updateMaterials(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/works/${req.params.id}/materials`,
    method: 'PUT',
  }, token).pipe(res)
}

function showSubmissions(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/works/${req.params.id}/submissions`,
    method: 'GET',
  }, token).pipe(res)
}

function createSubmission(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/works/${req.params.id}/submissions`,
    method: 'POST',
    json: {
      text: req.body.text,
    },
  }, token).pipe(res)
}

module.exports = {
  show,
  destroy,
  update,
  createMaterial,
  showMaterials,
  updateMaterials,
  createSubmission,
  showSubmissions,
}
