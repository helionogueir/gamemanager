const path = require('path');
const Database = require(path.resolve('./src/driver/Database'));
const SeekEvent = require(path.resolve('./src/usecase/SeekEvent'));
const SeekAllEvents = require(path.resolve('./src/usecase/SeekAllEvents'));

module.exports = class EventByPerson {

  seekAllByPersonId(personid, next) {
    try {
      if ((undefined !== personid)) {
        const database = new Database();
        (new SeekAllEvents(database.connect())).seek(personid, (events) => {
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

  seekRowByPersonId(eventid, personid, next) {
    try {
      if ((undefined !== eventid) && (undefined !== personid)) {
        const database = new Database();
        (new SeekEvent(database.connect())).seek(eventid, personid, (event) => {
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