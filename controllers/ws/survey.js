const ws = require('../../services/webService')

function destroy(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/surveys/${req.params.id}`,
    method: 'DELETE',
  }, token).pipe(res)
}

function update(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/surveys/${req.params.id}`,
    method: 'PUT',
    json: {
      title: req.body.title,
      question: req.body.question,
      alternatives: req.body.alternatives,
    },
  }, token).pipe(res)
}

function close(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/surveys/${req.params.id}/close`,
    method: 'POST',
  }, token).pipe(res)
}

module.exports = {
  destroy,
  update,
  close,
}
