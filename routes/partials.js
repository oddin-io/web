const router = require('express').Router()

router.get('/partials/:filename', function renderPartial(req, res) {
  const filename = req.params.filename

  res.render(`partials/${filename}`)
})

module.exports = router
