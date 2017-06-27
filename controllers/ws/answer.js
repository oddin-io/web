const ws = require('../../services/webService')

function index(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/questions/${req.params.id}/answers`,
    method: 'GET',
  }, token).pipe(res)
}

function show(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/answers/${req.params.id}`,
    method: 'GET',
  }, token).pipe(res)
}

function create(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/questions/${req.params.id}/answers`,
    method: 'POST',
    json: {
      text: req.body.text,
    },
  }, token).pipe(res)
}

function update() {}

function destroy() {}

function upvote(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/answers/${req.params.id}/upvote`,
    method: 'POST',
  }, token).pipe(res)
}

function downvote(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/answers/${req.params.id}/downvote`,
    method: 'POST',
  }, token).pipe(res)
}

function cancelvote(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/answers/${req.params.id}/vote`,
    method: 'DELETE',
  }, token).pipe(res)
}

function accept(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/answers/${req.params.id}/accept`,
    method: 'POST',
  }, token).pipe(res)
}

function unaccept(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/answers/${req.params.id}/accept`,
    method: 'DELETE',
  }, token).pipe(res)
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
