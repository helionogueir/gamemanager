const path = require('path');
const Database = require(path.resolve('./src/driver/Database'));
const SeekPerson = require(path.resolve('./src/usecase/SeekPerson'));

module.exports = class AuthUser {

  auth(username, password, next) {
    try {
      if ((undefined !== username) && (undefined !== password)) {
        const database = new Database();
        (new SeekPerson(database.connect())).seek(username, password, (person) => {
          database.close();
          next(person);
        });
      } else {
        next(null);
      }
    } catch (err) {
      throw err;
    }
  }

}