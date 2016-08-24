const router = require('express').Router()
const controller = require('../../controllers/ws/question')

router.get('/questions', controller.index)
router.get('/questions/:id', controller.show)
router.post('/questions', controller.create)
router.put('/questions/:id', controller.update)
router.delete('/questions/:id', controller.destroy)
router.post('/questions/:id/upvote', controller.upvote)
router.delete('/questions/:id/vote', controller.cancelvote)

module.exports = router
