const router = require('express').Router()
const controller = require('../../controllers/ws/answer')

router.get('/questions/:id/answers', controller.index)
router.get('/answers/:id', controller.show)
router.post('/questions/:id/answers', controller.create)
router.put('/answers/:id', controller.update)
router.delete('/answers/:id', controller.destroy)
router.post('/answers/:id/upvote', controller.upvote)
router.post('/answers/:id/downvote', controller.downvote)
router.delete('/answers/:id/vote', controller.cancelvote)
router.post('/answers/:id/accept', controller.accept)
router.delete('/answers/:id/accept', controller.unaccept)

module.exports = router
