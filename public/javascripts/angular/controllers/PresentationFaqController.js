import oddin from '../app'

oddin.controller('PresentationFaqController',
  ['$scope', '$stateParams', 'CurrentUser', 'PresentationAPI', 'QuestionAPI',
    function ($scope, $stateParams, CurrentUser, PresentationAPI, QuestionAPI) {
      $scope.user = CurrentUser;
      (function getInfo() {
        $scope.load = false
        PresentationAPI.show($stateParams.presentationID)
          .then(function (response) {
            $scope.presentation = response.data
          })
          .catch(function () {
            Materialize.toast('Erro ao carregar informações da aula', 3000)
          })
          .finally(function () {
            $scope.load = true
          })
      }());

      $(document).ready(function () {
        $('.tooltipped').tooltip();
        $scope.findCluster($scope.presentationID)
        $scope.findFaq($scope.presentationID)
      });

      $scope.createFaq = function () {
        $scope.load = false
        $(".faqs").each(function () {
          var isfaq = {
            isfaq: false
          };
          var id_question = $(this).val();
          if ($(this).is(':checked')) {
            isfaq.isfaq = {
              isfaq: true
            }
          }
          PresentationAPI.createFaq(id_question, isfaq);
        });
        Materialize.toast("Faq gerada com sucesso!");
        $scope.load = true
      }

      $scope.findCluster = function () {
        $scope.load = false
        PresentationAPI.getClusters($stateParams.presentationID)
          .then(function (response) {
            $scope.clusters = response.data
            $scope.cluster = [];
            $scope.clusters.map(clu => {
              var aux = 0;
              if ($scope.cluster.length == 0) {
                var c = {
                  cluster_id: clu.cluster.id,
                  question: [clu]
                };
                $scope.cluster.push(c);
              } else {
                $scope.cluster.map(cl => {
                  if (cl.cluster_id == clu.cluster.id) {
                    cl.question.push(clu);
                    aux = 1;
                  }
                })
                if (aux == 0) {
                  c = {
                    cluster_id: clu.cluster.id,
                    question: [clu]
                  };
                  $scope.cluster.push(c);
                }
              }
            })
            console.log($scope.clusters);
          })
          .catch(function (err) {
            //console.log(err)
            //Materialize.toast('Erro ao carregar as solicitações de atendimentos', 3000)
          })
          .finally(function () {
            $scope.load = true
          })
      }
      $scope.findFaq = function () {
        $scope.load = false
        PresentationAPI.getFaq($stateParams.presentationID)
          .then(function (response) {
            $scope.questions = response.data
            $scope.question = []
            $scope.questions.map(c => {
              if (c.isfaq) {
                $scope.question.push(c);
              }
            })
          })
          .catch(function () {
            Materialize.toast('Erro ao carregar resposta', 3000)
          })
          .finally(function () {
            $scope.load = true
          })
      }
      $scope.findAnswers = function (question) {
        $scope.load = false
        QuestionAPI.getAnswers(question.id)
          .then(function (response) {
            question.answers = response.data
          })
          .catch(function () {
            Materialize.toast('Erro ao carregar resposta', 3000)
          })
          .finally(function () {
            $scope.load = true
          })
      }

      $scope.findMaterials = function (question) {
        $scope.load = false
        QuestionAPI.getMaterials(question.id)
          .then(function (response) {
            question.material = response.data
          })
          .catch(function () {
            Materialize.toast('Erro ao carregar material', 3000)
          })
          .finally(function () {
            $scope.load = true
          })
      }

      $scope.closeAnswers = function (question) {
        question.answers = undefined
      }

      $scope.createQuestionToCluster = function (newQuestion) {
        $scope.load = false
        if (newQuestion.anonymous == undefined) newQuestion.anonymous = false
        newQuestion.cluster_id = $scope.selectedCluster.cluster_id
        newQuestion.isfaq = true
        PresentationAPI.createQuestionToFaq($stateParams.presentationID, newQuestion)
                .then(function (response) {
                  Materialize.toast('Dúvida postada', 3000)
                })
                .catch(function () {
                  Materialize.toast('Não foi possível postar a dúvida', 3000)
                })
                .finally(function () {
                  delete $scope.newQuestion
                  $scope.load = true
                })
      }
      $scope.createAnswer = function (newAnswer) {
        $scope.load = false
        QuestionAPI.createAnswer($scope.selectedQuestion.id, newAnswer)
          .then(function () {
            $scope.selectedQuestion.has_answer = true
            $scope.findAnswers($scope.selectedQuestion)
            Materialize.toast('Resposta postada', 3000)
          })
          .catch(function () {
            Materialize.toast('Não foi possível postar a resposta', 3000)
          })
          .finally(function () {
            delete $scope.newAnswer
            $scope.load = true
          })
      }

      $scope.acceptAnswer = function (answer) {
        $scope.load = false
        AnswerAPI.accept(answer.id)
                .then(function () {
                  answer.accepted = true
                  for (var i = 0; i < $scope.questions.length; i++) {
                    if ($scope.questions[i].id == answer.question.id) {
                      $scope.questions[i].answered = true
                      break
                    }
                  }
                })
                .catch(function () {
                  Materialize.toast('Erro ao aceitar resposta', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.rejectAnswer = function (answer) {
        $scope.load = false
        AnswerAPI.reject(answer.id)
                .then(function () {
                  answer.accepted = false
                  for (var i = 0; i < $scope.questions.length; i++) {
                    if ($scope.questions[i].id == answer.question.id) {
                      $scope.questions[i].answered = false
                      break
                    }
                  }
                })
                .catch(function () {
                  Materialize.toast('Erro ao recusar resposta', 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.downloadMaterial = function (material) {
        $scope.load = false
        MaterialAPI.show(material.id)
                .then(function (response) {
                  var hiddenLink = document.getElementById('hidden-link')
                  var link = document.createElement('a')
   
                  link.setAttribute('href', response.data.url)
                  link.setAttribute('download', true)
                  hiddenLink = document.getElementById('hidden-link')
                  hiddenLink.appendChild(link)
                  link.click()
                  hiddenLink.removeChild(link)
                  Materialize.toast('Fazendo download de ' + material.name, 3000)
                })
                .catch(function (err) {
                  console.log('Erro: ',err)
                  Materialize.toast("Erro ao baixar '" + material.name, 3000)
                })
                .finally(function () {
                  $scope.load = true
                })
      }

      $scope.createAnswerWithMedia = function (newAnswer, material) {
        $scope.load = false
        let newMaterial = null
        let file = null
        var answerID = null

        if(!newAnswer){
          newAnswer = { text: ' ' }
        }

        QuestionAPI.createAnswer($scope.selectedQuestion.id, newAnswer)
                .then((response) => {
                  const answer = response.data
                  answerID = response.data.id
                  return AnswerAPI.createMaterial(answer.id)
                })
                .then((response) => {
                  $scope.materials = []
                  newMaterial = response.data
                  file = blob
                  var fd = new FormData()
                  file.name = material.name + '.webm'

                  for (var key in newMaterial.fields) {
                    fd.append(key, newMaterial.fields[key])
                  }

                  fd.append('file', file, file.name)
                  return $http.post(newMaterial.url, fd, {
                    headers: {
                      'Content-Type': undefined,
                    },
                  })
                })
                .then(function () {
                  return MaterialAPI.update(newMaterial.id, {
                    name: file.name,
                    mime: file.type,
                  })
                })
                .then(function (response) {
                  $scope.materials.push(response.data.material)
                  $scope.findAnswers($scope.selectedQuestion)           
                  Materialize.toast('O arquivo ' + file.name + ' foi postado', 3000)
                })
                .catch(function (err) {
                  console.log('Erro: ', err);
                  AnswerAPI.destroy(answerID)
                  if(file.name == undefined){
                    Materialize.toast('Erro - O nome do arquivo não foi definido', 3000)
                  } else {
                    Materialize.toast('Erro ao fazer upload de material de mídia', 3000)
                  }
                })
                .finally(function () {
                  document.getElementById('new-material-file').value = ''
                  document.getElementById('new-material-description').value = ''
                  $scope.load = true
                  $scope.stopStream()
                })
      }

      $scope.createAnswerWithMaterial = function (newAnswer) {
        $scope.load = false
        let newMaterial = null;
        const file = document.forms.uploadArchive.file.files[0]
        var answerID = null

        if(!newAnswer){
          newAnswer = { text: ' ' }
        }

        QuestionAPI.createAnswer($scope.selectedQuestion.id, newAnswer)
                .then((response) => {
                  const answer = response.data
                  answerID = response.data.id
                  return AnswerAPI.createMaterial(answer.id)
                })
                .then((response) => {
                  $scope.materials = []
                  newMaterial = response.data
                  var fd = new FormData()

                  for (var key in newMaterial.fields) {
                    fd.append(key, newMaterial.fields[key])
                  }

                  fd.append('file', file)
                  return $http.post(newMaterial.url, fd, {
                    headers: {
                      'Content-Type': undefined,
                    },
                  })
                })
                .then(function () {
                  return MaterialAPI.update(newMaterial.id, {
                    name: file.name,
                    mime: file.type,
                  })
                })
                .then(function (response) {
                  $scope.materials.push(response.data.material)
                  $scope.findAnswers($scope.selectedQuestion)
                  Materialize.toast('O arquivo ' + file.name + ' foi postado', 3000)
                })
                .catch(function (err) {
                  console.log('Erro: ', err)
                  AnswerAPI.destroy(answerID)
                  Materialize.toast('Erro ao fazer upload de material', 3000)
                })
                .finally(function () {
                  document.getElementById('new-material-file').value = ''
                  document.getElementById('new-material-description').value = ''
                  $scope.load = true
                })
      }

      $scope.stopStream = function () {
        $scope.stream.getTracks().forEach(track => track.stop())
        delete $scope.stream
      }

      $scope.modalCreateAnswer = function (question) {
        $scope.selectedQuestion = question
        $('#modal-create-answer').openModal()
      }
      $scope.modalCreateFaq = function (cluster) {
        $scope.selectedCluster = cluster
        $('#modal-create-question-faq').openModal()
      }
      $scope.modalCreateVideo = function () {
        $('#modal-create-video').openModal({
          complete: function(){
            $scope.stopStream()
          }
        })
        $('#modal-create-answer').closeModal()
        webRtcVideo()
          .then((stream) => {
            $scope.stream = stream
          })
          .catch((err) => {
            alert('Desculpe, mas não é possível detectar sua câmera!')
            $('#modal-create-video').closeModal()
          })
      }

      $scope.modalCreateAudio = function () {
        $('#modal-create-audio').openModal({
          complete: function(){
            $scope.stopStream()
          }
        })
        $('#modal-create-answer').closeModal()
        webRtcAudio()
          .then((stream) => {
            $scope.stream = stream
          })
          .catch((err) => {
            $('#modal-create-audio').closeModal()
            alert('Desculpe, mas não é possível detectar seu microfone!')
          })
      }

      $scope.modalCreateMaterial = function () {
        $('#modal-create-material').openModal()
        $('#modal-create-answer').closeModal()
      }
      
    },
  ])