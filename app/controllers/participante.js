var participantes = [
  {
    "id": 1,
    "name": "Célia",
    "online": 0
  },
  {
    "id": 2,
    "name": "Rafael",
    "online": 1
  },
  {
    "id": 3,
    "name": "Bruno",
    "online": 1
  }
];

function listaParticipantes(req, res) {
  res.json(participantes);
}

module.exports = function() {
  return {
    listaParticipantes: listaParticipantes
  };
};
