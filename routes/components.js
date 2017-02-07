const router = require('express').Router()

router.get('/components/:filename', function renderPartial(req, res) {
  const filename = req.params.filename

  res.render(`components/${filename}`)
})

module.exports = router
