const router = require('express').Router()
const controller = require('../../controllers/ws/presentation')

router.get('/presentations', controller.index)
router.get('/presentations/:id', controller.show)
router.post('/presentations', controller.create)
router.post('/presentations/:id/close', controller.closePresentation)
router.put('/presentations/:id', controller.update)
router.delete('/presentations/:id', controller.destroy)
router.get('/presentations/:id/questions', controller.showQuestions)
router.post('/presentations/:id/questions', controller.postQuestion)
router.get('/presentation/:id/materials', controller.showMaterials)
router.get('/presentation/:id/materials/new', controller.createMaterial)

module.exports = router
