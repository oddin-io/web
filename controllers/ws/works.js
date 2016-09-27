const request = require('request')
const constants = require('../../config/constants')

function show(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/works/${req.params.id}`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    }
  }).pipe(res)
}

function createMaterial(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/works/${req.params.id}/materials`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    }
  }).pipe(res)
}

function showMaterials(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/works/${req.params.id}/materials`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    }
  }).pipe(res)
}

function showSubmissions(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/works/${req.params.id}/submissions`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    }
  }).pipe(res)
}

function createSubmission(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/works/${req.params.id}/submissions`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    },
    json: {
      'text': req.body.text
    }
  }).pipe(res)
}

module.exports = {
  show,
  createMaterial,
  showMaterials,
  createSubmission,
  showSubmissions
}
