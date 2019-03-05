module.exports = class SeekEventByEventIdAndPersonId {

    constructor(db) {
        this._db = db;
        Object.freeze(this);
    }

    seek(eventid, personid, next) {
        try {
            let sql = `
            SELECT
                eg.eventid,
                ee.name,
                ee.description
            FROM db_event.guest eg
            INNER JOIN db_team.team tt
                ON tt.id = eg.teamid
                AND tt.state = 1
            INNER JOIN db_event.event ee
                ON ee.id = eg.eventid
                AND ee.state = 1
            WHERE eg.eventid = :eventid
            AND  tt.ownerid = :personid
            GROUP BY eg.eventid
            `;
            this._db.raw(sql, new Object({
                eventid: eventid,
                personid: personid
            })).asCallback(function (err, result) {
                if (err) throw err;
                let data = null;
                if ((undefined != result[0]) && (result[0] instanceof Array) && result[0].length) {
                    for (let i = 0, row; row = result[0][i++];) {
                        data = row;
                        break;
                    }
                }
                next(data);
            });
        } catch (err) {
            throw err;
        }
    }

}