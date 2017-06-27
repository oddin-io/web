const ws = require('../../services/webService')

function show(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/works/${req.params.id}`,
    method: 'GET',
  }, session.token).pipe(res)
}

function destroy(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/works/${req.params.id}`,
    method: 'DELETE',
  }, session.token).pipe(res)
}

function update(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/works/${req.params.id}`,
    method: 'PUT',
    json: {
      subject: req.body.subject,
      description: req.body.description,
      deadline: req.body.deadline,
    },
  }, session.token).pipe(res)
}

function createMaterial(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/works/${req.params.id}/materials`,
    method: 'POST',
  }, session.token).pipe(res)
}

function showMaterials(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/works/${req.params.id}/materials`,
    method: 'GET',
  }, session.token).pipe(res)
}

function updateMaterials(req, res) {
  const session = req.cookies.session
  console.log('update materials' + req.body)
  ws.authenticated({
    uri: `/works/${req.params.id}/materials`,
    method: 'PUT',
  }, session.token).pipe(res)
}

function showSubmissions(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/works/${req.params.id}/submissions`,
    method: 'GET',
  }, session.token).pipe(res)
}

function createSubmission(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/works/${req.params.id}/submissions`,
    method: 'POST',
    json: {
      text: req.body.text,
    },
  }, session.token).pipe(res)
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
