const router = require('express').Router()

router.get('/partials/:filename', function renderPartial(req, res) {
  const filename = req.params.filename
  res.render(`partials/${filename}`)
})

router.get('/partials/admin/:filename', function renderPartial(req, res) {
	const filename = req.params.filename
	res.render(`partials/admin/${filename}`)
})

router.get('/partials/presentations/:filename', function renderPartial(req, res) {
	const filename = req.params.filename
	res.render(`partials/presentations/${filename}`)
})

router.get('/partials/notices/:filename', function renderPartial(req, res) {
	const filename = req.params.filename
	res.render(`partials/notices/${filename}`)
})

router.get('/partials/dates/:filename', function renderPartial(req, res) {
	const filename = req.params.filename
	res.render(`partials/dates/${filename}`)
})

router.get('/partials/works/:filename', function renderPartial(req, res) {
	const filename = req.params.filename
	res.render(`partials/works/${filename}`)
})

router.get('/partials/materials/:filename', function renderPartial(req, res) {
	const filename = req.params.filename
	res.render(`partials/materials/${filename}`)
})

router.get('/partials/faqs/:filename', function renderPartial(req, res) {
	const filename = req.params.filename
	res.render(`partials/faqs/${filename}`)
})

router.get('/partials/surveys/:filename', function renderPartial(req, res) {
	const filename = req.params.filename
	res.render(`partials/surveys/${filename}`)
})

module.exports = router
