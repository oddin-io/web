const ws = require('../../services/webService')

function index() {}

function show() {}

function create() {}

function update() {}

function destroy() {}

function upvote(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/questions/${req.params.id}/upvote`,
    method: 'POST',
  }, token).pipe(res)
}

function cancelvote(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/questions/${req.params.id}/vote`,
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
  cancelvote,
}
