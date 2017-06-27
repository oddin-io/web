const ws = require('../../services/webService')

function index(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: '/instructions',
    method: 'GET',
  }, token).pipe(res)
}

function show(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/instructions/${req.params.id}`,
    method: 'GET',
  }, token).pipe(res)
}

function create(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: '/instructions',
    method: 'POST',
    json: {
      event_id: req.body.event,
      lecture_id: req.body.lecture,
      class_code: req.body.class_code,
      start_date: req.body.start_date,
      end_date: req.body.end_date,
    },
  }, token).pipe(res)
}

function update() {}

function destroy(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/instructions/${req.params.id}`,
    method: 'DELETE',
  }, token).pipe(res)
}

function showPresentations(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/instructions/${req.params.id}/presentations`,
    method: 'GET',
  }, token).pipe(res)
}

function createPresentation(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/instructions/${req.params.id}/presentations`,
    method: 'POST',
    json: {
      subject: req.body.subject,
    },
  }, token).pipe(res)
}

function createMaterial(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/instructions/${req.params.id}/materials`,
    method: 'POST',
  }, token).pipe(res)
}

function createNotice(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/instructions/${req.params.id}/notices`,
    method: 'POST',
    json: {
      subject: req.body.subject,
      text: req.body.text,
    },
  }, token).pipe(res)
}

function createSurvey(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/instructions/${req.params.id}/surveys`,
    method: 'POST',
    json: {
      title: req.body.title,
      question: req.body.question,
      alternatives: req.body.alternatives,
    },
  }, token).pipe(res)
}

function createFAQ(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/instructions/${req.params.id}/faqs`,
    method: 'POST',
    json: {
      question: req.body.question,
      answer: req.body.answer,
    },
  }, token).pipe(res)
}

function createDate(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/instructions/${req.params.id}/dates`,
    method: 'POST',
    json: {
      subject: req.body.subject,
      text: req.body.text,
      date: req.body.date,
    },
  }, token).pipe(res)
}

function createWork(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/instructions/${req.params.id}/works`,
    method: 'POST',
    json: {
      subject: req.body.subject,
      description: req.body.description,
      deadline: req.body.deadline,
    },
  }, token).pipe(res)
}

function showMaterials(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/instructions/${req.params.id}/materials`,
    method: 'GET',
  }, token).pipe(res)
}

function showParticipants(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/instructions/${req.params.id}/participants`,
    method: 'GET',
  }, token).pipe(res)
}

function showNotices(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/instructions/${req.params.id}/notices`,
    method: 'GET',
  }, token).pipe(res)
}

function showSurveys(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/instructions/${req.params.id}/surveys`,
    method: 'GET',
  }, token).pipe(res)
}

function showFAQs(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/instructions/${req.params.id}/faqs`,
    method: 'GET',
  }, token).pipe(res)
}

function showDates(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/instructions/${req.params.id}/dates`,
    method: 'GET',
  }, token).pipe(res)
}

function showWorks(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/instructions/${req.params.id}/works`,
    method: 'GET',
  }, token).pipe(res)
}

function showProfile(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/instructions/${req.params.id}/profile`,
    method: 'GET',
  }, token).pipe(res)
}

function deleteDate(req, res) {
  const token = req.cookies.token

  ws.authenticated({
    uri: `/dates/${req.params.id}`,
    method: 'DELETE',
  }, token).pipe(res)
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
  createSurvey,
  createFAQ,
  showMaterials,
  showParticipants,
  showNotices,
  showSurveys,
  showFAQs,
  showDates,
  showWorks,
  showProfile,
  deleteDate,
}
