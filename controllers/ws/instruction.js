const ws = require('../../services/webService')

function index(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: '/instructions',
    method: 'GET',
  }, session.token).pipe(res)
}

function show(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/instructions/${req.params.id}`,
    method: 'GET',
  }, session.token).pipe(res)
}

function create(req, res) {
  const session = req.cookies.session

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
  }, session.token).pipe(res)
}

function update() {}

function destroy(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/instructions/${req.params.id}`,
    method: 'DELETE',
  }, session.token).pipe(res)
}

function showPresentations(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/instructions/${req.params.id}/presentations`,
    method: 'GET',
  }, session.token).pipe(res)
}

function createPresentation(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/instructions/${req.params.id}/presentations`,
    method: 'POST',
    json: {
      subject: req.body.subject,
    },
  }, session.token).pipe(res)
}

function createMaterial(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/instructions/${req.params.id}/materials`,
    method: 'POST',
  }, session.token).pipe(res)
}

function createNotice(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/instructions/${req.params.id}/notices`,
    method: 'POST',
    json: {
      subject: req.body.subject,
      text: req.body.text,
    },
  }, session.token).pipe(res)
}

function createSurvey(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/instructions/${req.params.id}/surveys`,
    method: 'POST',
    json: {
      title: req.body.title,
      question: req.body.question,
      alternatives: req.body.alternatives,
    },
  }, session.token).pipe(res)
}

function createFAQ(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/instructions/${req.params.id}/faqs`,
    method: 'POST',
    json: {
      question: req.body.question,
      answer: req.body.answer,
    },
  }, session.token).pipe(res)
}

function createDate(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/instructions/${req.params.id}/dates`,
    method: 'POST',
    json: {
      subject: req.body.subject,
      text: req.body.text,
      date: req.body.date,
    },
  }, session.token).pipe(res)
}

function createWork(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/instructions/${req.params.id}/works`,
    method: 'POST',
    json: {
      subject: req.body.subject,
      description: req.body.description,
      deadline: req.body.deadline,
    },
  }, session.token).pipe(res)
}

function showMaterials(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/instructions/${req.params.id}/materials`,
    method: 'GET',
  }, session.token).pipe(res)
}

function showParticipants(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/instructions/${req.params.id}/participants`,
    method: 'GET',
  }, session.token).pipe(res)
}

function showNotices(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/instructions/${req.params.id}/notices`,
    method: 'GET',
  }, session.token).pipe(res)
}

function showSurveys(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/instructions/${req.params.id}/surveys`,
    method: 'GET',
  }, session.token).pipe(res)
}

function showFAQs(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/instructions/${req.params.id}/faqs`,
    method: 'GET',
  }, session.token).pipe(res)
}

function showDates(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/instructions/${req.params.id}/dates`,
    method: 'GET',
  }, session.token).pipe(res)
}

function showWorks(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/instructions/${req.params.id}/works`,
    method: 'GET',
  }, session.token).pipe(res)
}

function showProfile(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/instructions/${req.params.id}/profile`,
    method: 'GET',
  }, session.token).pipe(res)
}

function deleteDate(req, res) {
  const session = req.cookies.session

  ws.authenticated({
    uri: `/dates/${req.params.id}`,
    method: 'DELETE',
  }, session.token).pipe(res)
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
