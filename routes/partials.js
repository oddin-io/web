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

module.exports = router
