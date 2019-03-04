const path = require('path');
const Database = require(path.resolve('./src/driver/Database'));
const SeekPerson = require(path.resolve('./src/usecase/SeekPerson'));

module.exports = class ValidateLogin {

  validate(username, password, callback) {
    try {
      const database = new Database();
      (new SeekPerson(database.connect())).seek(username, password, (person) => {
        callback(person);
        database.close();
      });
    } catch (err) {
      throw err;
    }
  }

}