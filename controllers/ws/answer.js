const ws = require('../../services/webService')

function index(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/questions/${req.params.id}/answers`,
    method: 'GET',
  }, session.token).pipe(res)
}

function show(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/answers/${req.params.id}`,
    method: 'GET',
  }, session.token).pipe(res)
}

function create(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/questions/${req.params.id}/answers`,
    method: 'POST',
    json: {
      text: req.body.text,
    },
  }, session.token).pipe(res)
}

function update() {}

function destroy() {}

function upvote(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/answers/${req.params.id}/upvote`,
    method: 'POST',
  }, session.token).pipe(res)
}

function downvote(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/answers/${req.params.id}/downvote`,
    method: 'POST',
  }, session.token).pipe(res)
}

function cancelvote(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/answers/${req.params.id}/vote`,
    method: 'DELETE',
  }, session.token).pipe(res)
}

function accept(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/answers/${req.params.id}/accept`,
    method: 'POST',
  }, session.token).pipe(res)
}

function unaccept(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/answers/${req.params.id}/accept`,
    method: 'DELETE',
  }, session.token).pipe(res)
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
