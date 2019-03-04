const path = require('path');
const Database = require(path.resolve('./src/driver/Database'));
const SeekGroupsAndMatches = require(path.resolve('./src/usecase/SeekGroupsAndMatches'));

module.exports = class GroupByEventAndPerson {

  seekAllMatches(eventid, personid, next) {
    try {
      if ((undefined !== eventid) && (undefined !== personid)) {
        const database = new Database();
        (new SeekGroupsAndMatches(database.connect())).seek(eventid, personid, (events) => {
          database.close();
          next(events);
        });
      } else {
        next(null);
      }
    } catch (err) {
      throw err;
    }
  }

}