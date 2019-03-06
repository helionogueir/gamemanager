const path = require('path');
const Database = require(path.resolve('./src/driver/Database'));
const ChallengeGroup = require(path.resolve('./src/entity/ChallengeGroup'));

module.exports = class Group {

  seekByStage(stage, next) {
    if (undefined !== stage) {
      try {
        const database = new Database();
        (new ChallengeGroup(database.connect())).seekByStage(stage, (groups) => {
          database.close();
          next(groups);
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