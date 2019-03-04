try {
  const path = require('path');
  const express = require('express');
  const bodyParser = require('body-parser');
  const Route = require(path.resolve('./src/driver/Route'));
  const server = new express();

  server.use(bodyParser.json());
  server.use(bodyParser.urlencoded({
    extended: false
  }));
  server.use((req, res, next) => {
    res.header("Content-Type", "application/json");
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Headers", "Content-Type,Authorization");
    next();
  });
  (new Route()).list((resources) => {
    for (let [key, value] of Object.entries(resources)) {
      server.use(`/${key}`, require(value));
      console.info(key, value);
    }
    server.listen(3000, () => {
      console.info("\n", Date() + " | Server Started");
    });
  });
  module.exports = server;
} catch (err) {
  console.error(err);
}