const router = require('express').Router()
const controller = require('../../controllers/ws/lecture')

router.get('/lectures', controller.index)
router.post('/lectures', controller.create)
router.put('/lectures/:id', controller.update)
router.delete('/lectures/:id', controller.destroy)

module.exports = router
