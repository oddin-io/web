const router = require('express').Router()

router.get('/', function index(req, res) {
  res.render('index')
})

router.get('/recover-password', function recoverPassword() {
  console.log('recover-password')
})

module.exports = router
