const request = require('request')
const constants = require('../../config/constants')

function index(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function show(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function create(req, res) {
	const session = req.cookies.session

	request({
		uri: `${constants.uri}/instructions`,
		method: 'POST',
		headers: {
			'x-session-token': session.token
		},
		json: {
			'event_id': req.body.event,
			'lecture_id': req.body.lecture,
			'class_number': req.body.class_number,
			'start_date': req.body.start_date,
			'end_date': req.body.end_date
		}
	}).pipe(res)
}

function update() {}

function destroy(req, res) {
	const session = req.cookies.session

	request({
		uri: `${constants.uri}/instructions/${req.params.id}`,
		method: 'DELETE',
		headers: {
			'x-session-token': session.token
		}
	}).pipe(res);
}

function showPresentations(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/presentations`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function createPresentation(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/presentations`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    },
    json: {
      subject: req.body.subject,
    },
  }).pipe(res)
}

function createMaterial(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/materials`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    }
  }).pipe(res)
}

function createNotice(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/notices`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    },
    json: {
      'subject': req.body.subject,
      'text': req.body.text
    }
  }).pipe(res)
}

function createDate(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/instructions/${req.params.id}/dates`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    },
    json: {
      'subject': req.body.subject,
      'text': req.body.text,
      'date': req.body.date
    }
  }).pipe(res)
}

function createWork(req, res) {
  const session = req.cookies.session
  console.log('create work');
  request({
    uri: `${constants.uri}/instructions/${req.params.id}/works`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    },
    json: {
      'subject': req.body.subject,
      'description': req.body.description,
      'deadline': req.body.deadline
    }
  }).pipe(res)
}

function showMaterials(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/materials`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function showParticipants(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/participants`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function showNotices(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/notices`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function showSurveys(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/surveys`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function showDates(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/instructions/${req.params.id}/dates`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function showWorks(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/instructions/${req.params.id}/works`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function showProfile(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/profile`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function deleteDate(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/dates/${req.params.id}`,
    method: 'DELETE',
    headers: {
      'x-session-token': session.token
    }
  }).pipe(res)
}

module.exports = {
  index,
  show,
  create,
  update,
  destroy,
  showPresentations,
  createPresentation,
  createMaterial,
  createNotice,
  createDate,
  createWork,
  showMaterials,
  showParticipants,
  showNotices,
	showSurveys,
  showDates,
  showWorks,
  showProfile,
  deleteDate
}
