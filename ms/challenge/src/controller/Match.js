const path = require('path');
const Database = require(path.resolve('./src/driver/Database'));
const ChallengeMatch = require(path.resolve('./src/entity/ChallengeMatch'));

module.exports = class Match {

  infoByGroupId(groupid, next) {
    try {
      const database = new Database();
      (new ChallengeMatch(database.connect())).seekInfoByGroupId(groupid, (rowSet) => {
        database.close();
        next(rowSet);
      });
    } catch (err) {
      database.close();
      throw err;
    }
  }

}