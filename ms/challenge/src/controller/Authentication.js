const path = require('path');
const Person = require(path.resolve('./src/entity/Person'));
const Database = require(path.resolve('./src/driver/Database'));
const Authorization = require(path.resolve('./src/driver/Authorization'));

module.exports = class Authentication {

  authorized(personid, token, next) {
    if ((undefined !== personid) && (undefined !== token)) {
      try {
        const database = new Database();
        (new Person(database.connect())).seekCredentialByPersonId(personid, (credential) => {
          (new Authorization()).verify(credential, token, (authorized) => {
            database.close();
            next(authorized);
          });
        });
      } catch (err) {
        database.close();
        throw err;
      }
    } else {
      next(null);
    }
  }

}