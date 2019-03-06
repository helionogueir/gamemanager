const path = require('path');
const express = require('express');
const router = express.Router();
const Group = require(path.resolve('./src/controller/Group'));
const Match = require(path.resolve('./src/controller/Match'));
const HttpResponse = require(path.resolve('./src/usecase/HttpResponse'));
const Authentication = require(path.resolve('./src/controller/Authentication'));

router.options('/', function (req, res) {
  const options = new Array('GET', 'OPTIONS');
  res.header("Access-Control-Allow-Methods", options.join(','));
  res.header("Access-Control-Allow-Headers", "Content-Type,X-Total-Count,Authorization");
  (new HttpResponse()).prepare(200, options, res);
});

router.get('/:stage', function (req, res) {
  try {
    if ((undefined !== req.params.stage) &&
      (undefined !== req.body.personid) &&
      (undefined !== req.headers['authorization'])) {
      (new Authentication()).authorized(req.body.personid, req.headers['authorization'], (authorized) => {
        if (!authorized)(new HttpResponse()).prepare(401, null, res);
        else {
          (new Group()).seekByStage(req.params.stage, (result) => {
            let code = (result instanceof Object) ? 200 : 404;
            (new HttpResponse()).prepare(code, result, res);
          });
        }
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

router.get('/:groupid/match/info', function (req, res) {
  try {
    if ((undefined !== req.body.personid) &&
      (undefined !== req.params.groupid) &&
      (undefined !== req.headers['authorization'])) {
      (new Authentication()).authorized(req.body.personid, req.headers['authorization'], (authorized) => {
        if (!authorized)(new HttpResponse()).prepare(401, null, res);
        else {
          (new Match()).infoByGroupId(req.params.groupid, (result) => {
            let code = (result instanceof Object) ? 200 : 404;
            (new HttpResponse()).prepare(code, result, res);
          });
        }
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