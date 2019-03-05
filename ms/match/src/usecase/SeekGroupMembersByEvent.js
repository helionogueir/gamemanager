module.exports = class SeekGroupMembersByEvent {

    constructor(db) {
        this._db = db;
        Object.freeze(this);
    }

    seek(eventid, next) {
        try {
            let sql = `
            SELECT
                mg.id,
                mg.type,
                mg.name AS groupname,
                tt.name AS teamname 
            FROM db_match.group mg
            INNER JOIN db_match.match mm
                ON mm.groupid = mg.id
            INNER JOIN db_event.guest eg
                ON eg.eventid = mg.eventid
                AND eg.id IN (mm.aguestid, mm.bguestid)
            INNER JOIN db_team.team tt
                ON tt.id = eg.teamid
            WHERE mg.eventid = :eventid
            AND mg.state = 1
            GROUP BY mg.id, eg.id
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