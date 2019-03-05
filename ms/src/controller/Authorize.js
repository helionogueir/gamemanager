const path = require('path');
const Database = require(path.resolve('./src/driver/Database'));
const Authorization = require(path.resolve('./src/driver/Authorization'));
const SeekCredential = require(path.resolve('./src/usecase/SeekCredential'));

module.exports = class Authorize {

  isAuthorized(personid, token, next) {
    try {
      if ((undefined !== personid) && (undefined !== token)) {
        const database = new Database();
        (new SeekCredential(database.connect())).seek(personid, (credential) => {
          (new Authorization()).verify(token, credential, (hasAccess) => {
            next(hasAccess);
          });
        });
      } else {
        next(false);
      }
    } catch (err) {
      // Put #analytics here!
      next(false);
    }
  }

}