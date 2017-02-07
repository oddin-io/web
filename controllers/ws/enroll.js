const request = require('request')
const constants = require('../../config/constants')

function create(req, res) {
	const session = req.cookies.session
	request({
		uri: `${constants.uri}/enrolls`,
		method: 'POST',
		headers: {
			'x-session-token': session.token
		},
		json: {
			'person_id': req.body.person_id,
			'instruction_id': req.body.instruction_id,
			'profile': req.body.profile
		}
	}).pipe(res)
}

function destroy(req, res) {
	const session = req.cookies.session
	request({
		uri: `${constants.uri}/enrolls/${req.params.id}`,
		method: 'DELETE',
		headers: {
			'x-session-token': session.token
		}
	}).pipe(res);
}

module.exports = {
  create,
  destroy
}
