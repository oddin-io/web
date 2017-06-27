const ws = require('../../services/webService')

function destroy(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/faqs/${req.params.id}`,
    method: 'DELETE',
  }, session.token).pipe(res)
}

function update(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/faqs/${req.params.id}`,
    method: 'PUT',
    json: {
      question: req.body.question,
      answer: req.body.answer,
    },
  }, session.token).pipe(res)
}

module.exports = {
  destroy,
  update,
}
