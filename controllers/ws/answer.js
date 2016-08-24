const request = require('request')
const constants = require('../../config/constants')

function index(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/questions/${req.params.id}/answers`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function show(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/answers/${req.params.id}`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function create(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/questions/${req.params.id}/answers`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    },
    json: {
      text: req.body.text,
    },
  }).pipe(res)
}

function update() {}

function destroy() {}

function upvote(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/answers/${req.params.id}/upvote`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function downvote(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/answers/${req.params.id}/downvote`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function cancelvote(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/answers/${req.params.id}/vote`,
    method: 'DELETE',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function accept(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/answers/${req.params.id}/accept`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function unaccept(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/answers/${req.params.id}/accept`,
    method: 'DELETE',
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
  upvote,
  downvote,
  cancelvote,
  accept,
  unaccept,
}
