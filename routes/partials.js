const router = require('express').Router()

router.get('/partials/*', function renderPartial(req, res) {
  const filename = req.path.substring(1)

  res.render(filename)
})

module.exports = router
