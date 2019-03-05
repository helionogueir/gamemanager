const path = require('path');
const Database = require(path.resolve('./src/driver/Database'));
const SeekPersonByUsernameAndPassword = require(path.resolve('./src/usecase/SeekPersonByUsernameAndPassword'));

module.exports = class Person {

  auth(username, password, next) {
    try {
      if ((undefined !== username) && (undefined !== password)) {
        const database = new Database();
        (new SeekPersonByUsernameAndPassword(database.connect())).seek(username, password, (person) => {
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