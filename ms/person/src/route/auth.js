const path = require('path');
const express = require('express');
const router = express.Router();
const HttpResponse = require(path.resolve('./src/usecase/HttpResponse'));
const Authentication = require(path.resolve('./src/controller/Authentication'));

router.options('/', function (req, res) {
  const options = new Array('GET', 'OPTIONS');
  res.header("Access-Control-Allow-Methods", options.join(','));
  res.header("Access-Control-Allow-Headers", "Content-Type");
  (new HttpResponse()).prepare(200, options, res);
});

router.get('/:username', function (req, res) {
  try {
    if ((undefined !== req.params.username) && (undefined !== req.body.password)) {
      (new Authentication()).make(req.params.username, req.body.password, (result) => {
        let code = (result instanceof Object) ? 200 : 401;
        (new HttpResponse()).prepare(code, result, res);
      });
    } else {
      (new HttpResponse()).prepare(400, null, res);
    }
  } catch (err) {
    (new HttpResponse()).prepare(500, {
      message: `${err.stack}`
    }, res);
  }
});

module.exports = router;