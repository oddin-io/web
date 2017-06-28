const router = require('express').Router()

router.get('/lectures/:id', function index(req, res) {
  res.render('home')
})

module.exports = router
