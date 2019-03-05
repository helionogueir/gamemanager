const path = require('path');
const Database = require(path.resolve('./src/driver/Database'));
const SeekGroupMembersByEvent = require(path.resolve('./src/usecase/SeekGroupMembersByEvent'));

module.exports = class GroupMembers {

  seekByEvent(eventid, next) {
    try {
      if ((undefined !== eventid)) {
        const database = new Database();
        (new SeekGroupMembersByEvent(database.connect())).seek(eventid, (events) => {
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