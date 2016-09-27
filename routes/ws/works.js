const router = require('express').Router()
const controller = require('../../controllers/ws/works')

router.post('/works/:id/materials', controller.createMaterial)
router.get('/works/:id/materials', controller.showMaterials)
router.post('/works/:id/submissions', controller.createSubmission)
router.get('/works/:id/submissions', controller.showSubmissions)
router.get('/works/:id', controller.show)

module.exports = router
