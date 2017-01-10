const router = require('express').Router()
const controller = require('../../controllers/ws/enroll')

router.post('/enrolls', controller.create)
router.delete('/enrolls/:id', controller.destroy)

module.exports = router
