const path = require('path');
const express = require('express');
const router = express.Router();
const Response = require(path.resolve('./src/entity/Response'));
const Person = require(path.resolve('./src/controller/Person'));

router.options('/*', function (req, res) {
  try {
    const options = new Array('GET', 'OPTIONS');
    res.header("Access-Control-Allow-Methods", options.join(','));
    (new Response()).format(200, options, (response) => {
      res.statusCode = response.statusCode;
      res.send(response);
    });
  } catch (err) {
    (new Response()).format(500, null, (response) => {
      res.statusCode = response.statusCode;
      res.end();
    });
  }
});

router.get('/:username', function (req, res) {
  try {
    if ((undefined !== req.params.username) && (undefined !== req.body.password)) {
      (new Person()).auth(req.params.username, req.body.password, (result) => {
        let code = (result) ? 200 : 404;
        (new Response()).format(code, result, (response) => {
          res.statusCode = response.statusCode;
          res.send(response);
        });
      });
    } else {
      (new Response()).format(400, null, (response) => {
        res.statusCode = response.statusCode;
        res.end();
      });
    }
  } catch (err) {
    (new Response()).format(500, `${err}`, (response) => {
      res.statusCode = response.statusCode;
      res.end();
    });
  }
});

module.exports = router;