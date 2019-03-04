module.exports = class SeekAllEvents {

    constructor(db) {
        this._db = db;
        Object.freeze(this);
    }

    seek(personid, next) {
        try {
            let sql = `
            SELECT
                eeg.eventid,
                ee.name,
                ee.description
            FROM db_event.event_guest eeg
            INNER JOIN db_team.team tt
                ON tt.id = eeg.teamid
                AND tt.state = 1
            INNER JOIN db_event.event ee
                ON ee.id = eeg.eventid
                AND ee.state = 1
            WHERE tt.ownerid = :personid
            GROUP BY eeg.eventid
            `;
            this._db.raw(sql, new Object({
                personid: personid
            })).asCallback(function (err, result) {
                if (err) throw err;
                let data = new Array();
                if ((undefined != result[0]) && (result[0] instanceof Array) && result[0].length) {
                    for (let i = 0, row; row = result[0][i++];) {
                        data.push(row);
                    }
                }
                next(data);
            });
        } catch (err) {
            throw err;
        }
    }

}