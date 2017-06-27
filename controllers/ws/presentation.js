const ws = require('../../services/webService')

function index() {}

function show(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/presentations/${req.params.id}`,
    method: 'GET',
  }, session.token).pipe(res)
}

function create() {}

function update() {}

function destroy() {}

function closePresentation(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/presentations/${req.params.id}/close`,
    method: 'POST',
  }, session.token).pipe(res)
}

function showQuestions(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/presentations/${req.params.id}/questions`,
    method: 'GET',
  }, session.token).pipe(res)
}

function showMaterials(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/presentations/${req.params.id}/materials`,
    method: 'GET',
  }, session.token).pipe(res)
}

function createMaterial(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/presentations/${req.params.id}/materials`,
    method: 'POST',
  }, session.token).pipe(res)
}

function postQuestion(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/presentations/${req.params.id}/questions`,
    method: 'POST',
    json: {
      text: req.body.text,
      anonymous: req.body.anonymous,
    },
  }, session.token).pipe(res)
}

module.exports = {
  index,
  show,
  create,
  update,
  destroy,
  closePresentation,
  showQuestions,
  postQuestion,
  showMaterials,
  createMaterial,
}
