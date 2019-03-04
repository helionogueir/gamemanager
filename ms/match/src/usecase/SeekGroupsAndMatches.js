module.exports = class SeekGroupsAndMatches {

    constructor(db) {
        this._db = db;
        Object.freeze(this);
    }

    seek(eventid, personid, next) {
        try {
            let sql = `
            SELECT
                mg.id,
                mg.type,
                mg.name,
                mg.description
            FROM db_match.group mg
            INNER JOIN db_event.event ee
                ON ee.id = mg.eventid
                AND ee.state = 1
            WHERE mg.eventid = :eventid
            AND mg.state = 1
            GROUP BY mg.id
            `;
            this._db.raw(sql, new Object({
                eventid: eventid
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