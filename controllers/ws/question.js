const ws = require('../../services/webService')

function index() {}

function show() {}

function create() {}

function update() {}

function destroy() {}

function upvote(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/questions/${req.params.id}/upvote`,
    method: 'POST',
  }, session.token).pipe(res)
}

function cancelvote(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/questions/${req.params.id}/vote`,
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
  cancelvote,
}
