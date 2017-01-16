const router = require('express').Router()
const controller = require('../../controllers/ws/survey')

router.delete('/surveys/:id', controller.destroy)
router.put('/surveys/:id', controller.update)
router.post('/surveys/:id/close', controller.close)

module.exports = router
