const ws = require('../../services/webService')

function create(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: '/enrolls',
    method: 'POST',
    json: {
      person_id: req.body.person_id,
      instruction_id: req.body.instruction_id,
      profile: req.body.profile,
    },
  }, session.token).pipe(res)
}

function destroy(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/enrolls/${req.params.id}`,
    method: 'DELETE',
  }, session.token).pipe(res)
}

module.exports = {
  create,
  destroy,
}
