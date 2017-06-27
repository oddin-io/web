const ws = require('../../services/webService')

function destroy(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/tests/${req.params.id}`,
    method: 'DELETE',
  }, session.token).pipe(res)
}

function update(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/tests/${req.params.id}`,
    method: 'PUT',
    json: {
      title: req.body.title,
      question: req.body.question,
      alternatives: req.body.alternatives,
    },
  }, session.token).pipe(res)
}

function close(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/tests/${req.params.id}/close`,
    method: 'POST',
  }, session.token).pipe(res)
}

module.exports = {
  destroy,
  update,
  close,
}
