const request = require('request')
const constants = require('../../config/constants')

function index() {}

function show(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/presentations/${req.params.id}`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function create() {}

function update() {}

function destroy() {}

function closePresentation(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/presentations/${req.params.id}/close`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function showQuestions(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/presentations/${req.params.id}/questions`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function showMaterials(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/presentations/${req.params.id}/materials`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function createMaterial(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/presentations/${req.params.id}/materials/new`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function postQuestion(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/presentations/${req.params.id}/questions`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    },
    json: {
      text: req.body.text,
      anonymous: req.body.anonymous,
    },
  }).pipe(res)
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
