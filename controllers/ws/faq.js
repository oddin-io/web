const ws = require('../../services/webService')

function destroy(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/faqs/${req.params.id}`,
    method: 'DELETE',
  }, token).pipe(res)
}

function update(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/faqs/${req.params.id}`,
    method: 'PUT',
    json: {
      question: req.body.question,
      answer: req.body.answer,
    },
  }, token).pipe(res)
}

module.exports = {
  destroy,
  update,
}
