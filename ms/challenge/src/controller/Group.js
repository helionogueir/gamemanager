const path = require('path');
const Database = require(path.resolve('./src/driver/Database'));
const ChallengeGroup = require(path.resolve('./src/entity/ChallengeGroup'));

module.exports = class Group {

  seek(next) {
    try {
      const database = new Database();
      (new ChallengeGroup(database.connect())).seekAll((groups) => {
        database.close();
        next(groups);
      });
    } catch (err) {
      database.close();
      throw err;
    }
  }

}