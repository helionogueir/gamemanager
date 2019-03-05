const path = require('path');
const Database = require(path.resolve('./src/driver/Database'));
const SeekEventByPersonId = require(path.resolve('./src/usecase/SeekEventByPersonId'));
const SeekEventByEventIdAndPersonId = require(path.resolve('./src/usecase/SeekEventByEventIdAndPersonId'));

module.exports = class Event {

  seekAllByPersonId(personid, next) {
    try {
      if ((undefined !== personid)) {
        const database = new Database();
        (new SeekEventByPersonId(database.connect())).seek(personid, (events) => {
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

  seekRowByEventIdAndPersonId(eventid, personid, next) {
    try {
      if ((undefined !== eventid) && (undefined !== personid)) {
        const database = new Database();
        (new SeekEventByEventIdAndPersonId(database.connect())).seek(eventid, personid, (event) => {
          database.close();
          next(event);
        });
      } else {
        next(null);
      }
    } catch (err) {
      throw err;
    }
  }

}