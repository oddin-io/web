const router = require('express').Router()

router.get('/presentations/:id', function index(req, res) {
  res.render('home')
})

module.exports = router
