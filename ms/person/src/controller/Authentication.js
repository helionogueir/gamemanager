const path = require('path');
const Person = require(path.resolve('./src/entity/Person'));
const Database = require(path.resolve('./src/driver/Database'));
const EncryptPassword = require(path.resolve('./src/usecase/EncryptPassword'));

module.exports = class Authentication {

  make(username, password, next) {
    if ((undefined !== username) && (undefined !== password)) {
      (new EncryptPassword()).encrypt(password, (passwordEncrypt) => {
        try {
          const database = new Database();
          (new Person(database.connect())).findRowBySignIn(username, passwordEncrypt, (person) => {
            database.close();
            next(person);
          });
        } catch (err) {
          database.close();
          throw err;
        }
      });
    } else {
      next(null);
    }
  }

}