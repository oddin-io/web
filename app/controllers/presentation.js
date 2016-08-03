function index(req, res, next) {
  res.render('home')
}

module.exports = function () {
  return {
    index: index
  };
};
