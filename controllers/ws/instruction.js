const request = require('request')
const constants = require('../../config/constants')

function index(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function show(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function create() {}

function update() {}

function destroy() {}

function showPresentations(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/presentations`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function createPresentation(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/presentations`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    },
    json: {
      subject: req.body.subject,
    },
  }).pipe(res)
}

function createMaterial(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/materials`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    }
  }).pipe(res)
}

function createNotice(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/notices`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    },
    json: {
      'subject': req.body.subject,
      'text': req.body.text
    }
  }).pipe(res)
}

function createDate(req, res) {

}

function showMaterials(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/materials`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function showParticipants(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/participants`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function showNotices(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/notices`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function showDates(req, res) {
  const session = req.cookies.session
  console.log('datas');

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/dates`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function showProfile(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/profile`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

module.exports = {
  index,
  show,
  create,
  update,
  destroy,
  showPresentations,
  createPresentation,
  createMaterial,
  createNotice,
  createDate,
  showMaterials,
  showParticipants,
  showNotices,
  showDates,
  showProfile,
}
