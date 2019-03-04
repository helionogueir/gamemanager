const path = require('path');
const Jwt = require(path.resolve('./src/driver/Jwt'));
const Database = require(path.resolve('./src/driver/Database'));
const SeekEvents = require(path.resolve('./src/usecase/SeekEvents'));
const SeekCredential = require(path.resolve('./src/usecase/SeekCredential'));

module.exports = class FindEvents {

  find(personid, authorization, next) {
    try {
      if ((undefined !== personid) && (undefined !== authorization)) {
        const database = new Database();
        (new SeekCredential(database.connect())).seek(personid, (credential) => {
          (new Jwt()).verify(authorization, credential, (result) => {
            (new SeekEvents(database.connect())).seek(personid, (events) => {
              database.close();
              next(events);
            });
          });
        });
      } else {
        next(null);
      }
    } catch (err) {
      throw err;
    }
  }

}