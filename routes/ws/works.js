const router = require('express').Router()
const controller = require('../../controllers/ws/works')

router.post('/works/:id/materials', controller.createMaterial)
router.get('/works/:id/materials', controller.showMaterials)
router.put('/works/:id/materials', controller.updateMaterials)
router.post('/works/:id/submissions', controller.createSubmission)
router.get('/works/:id/submissions', controller.showSubmissions)
router.get('/works/:id', controller.show)
router.delete('/works/:id', controller.destroy)
router.put('/works/:id', controller.update)


module.exports = router
