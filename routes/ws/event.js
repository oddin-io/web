const router = require('express').Router()
const controller = require('../../controllers/ws/event')

router.get('/events', controller.index)
router.post('/events', controller.create)
router.put('/events/:id', controller.update)
router.delete('/events/:id', controller.destroy)
router.get('/events/:id', controller.show)
router.get('/events/:id/instructions', controller.instructions)

module.exports = router
