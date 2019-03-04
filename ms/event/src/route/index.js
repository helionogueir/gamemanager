const path = require('path');
const express = require('express');
const router = express.Router();
const Response = require(path.resolve('./src/entity/Response'));
const EventByPerson = require(path.resolve('./src/controller/EventByPerson'));
const AuthorizePerson = require(path.resolve('./src/controller/AuthorizePerson'));

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

router.get('/:eventid/person/:personid', function (req, res) {
  try {
    if ((undefined !== req.params.eventid) &&
      (undefined !== req.params.personid) &&
      (undefined !== req.headers['authorization'])) {
      (new AuthorizePerson()).isAuthorized(req.params.personid, req.headers['authorization'], (isAuthorized) => {
        if (isAuthorized) {
          (new EventByPerson()).seekRowByPersonId(req.params.eventid, req.params.personid, (result) => {
            let code = (result) ? 200 : 404;
            (new Response()).format(code, result, (response) => {
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