const ws = require('../../services/webService')

function destroy(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/dates/${req.params.id}`,
    method: 'DELETE',
  }, token).pipe(res)
}

function update(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/dates/${req.params.id}`,
    method: 'PUT',
    json: {
      subject: req.body.subject,
      text: req.body.text,
      date: req.body.date,
    },
  }, token).pipe(res)
}

module.exports = {
  destroy,
  update,
}
