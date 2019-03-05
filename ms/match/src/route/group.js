const path = require('path');
const express = require('express');
const router = express.Router();
const Response = require(path.resolve('./src/entity/Response'));
const Authorize = require(path.resolve('./src/controller/Authorize'));
const GroupMembers = require(path.resolve('./src/controller/GroupMembers'));

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

router.get('/event/:eventid/person/:personid', function (req, res) {
  try {
    if ((undefined !== req.params.eventid) &&
      (undefined !== req.params.personid) &&
      (undefined !== req.headers['authorization'])) {
      (new Authorize()).isAuthorized(req.params.personid, req.headers['authorization'], (isAuthorized) => {
        if (isAuthorized) {
          (new GroupMembers()).seekByEvent(req.params.eventid, (result) => {
            let total = (result instanceof Array) ? result.length : 0;
            let code = (total) ? 200 : 404;
            (new Response()).format(code, result, (response) => {
              res.header("X-Total-Count", total);
              res.statusCode = response.statusCode;
              res.send(response);
            });
          });
        } else {
          (new Response()).format(401, null, (response) => {
            res.statusCode = response.statusCode;
            res.end();
          });
        }
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