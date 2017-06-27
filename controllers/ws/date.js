const ws = require('../../services/webService')

function destroy(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/dates/${req.params.id}`,
    method: 'DELETE',
  }, session.token).pipe(res)
}

function update(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/dates/${req.params.id}`,
    method: 'PUT',
    json: {
      subject: req.body.subject,
      text: req.body.text,
      date: req.body.date,
    },
  }, session.token).pipe(res)
}

module.exports = {
  destroy,
  update,
}
