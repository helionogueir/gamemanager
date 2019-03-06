module.exports = class ChallengeMatch {

    constructor(db) {
        this._db = db;
        Object.freeze(this);
    }

    seekByGroupId(groupid, next) {
        let sql = `
        SELECT
            cm.id,
            act.name AS ateamname,
            cm.avictory,
            bct.name AS bteamname,
            cm.bvictory
        FROM challenge.match cm
        INNER JOIN challenge.team act
            ON act.id = cm.ateamid
        INNER JOIN challenge.team bct
            ON bct.id = cm.bteamid
        WHERE cm.groupid = :groupid
        GROUP BY cm.id
        `;
        this._db.raw(sql, new Object({
            groupid: groupid
        })).asCallback(function (err, result) {
            if (err) throw err;
            let data = new Array();
            if ((undefined != result[0]) && (result[0] instanceof Array) && result[0].length) {
                data = result[0];
            }
            if (next instanceof Function) {
                next(data);
            }
        });
    }

    seekInfoByGroupId(groupid, next) {
        let sql = `
        SELECT
            ct.id AS teamid,
            ct.name AS teamname,
            SUM(ct.id = IF((cm.avictory > cm.bvictory), cm.ateamid, cm.bteamid)) AS victories
        FROM challenge.team ct
        INNER JOIN challenge.match cm
            ON ct.id IN (cm.ateamid, cm.bteamid)
        INNER JOIN challenge.group cg
            ON cg.id = cm.groupid
            AND cg.state = 1
        WHERE ct.state = 1
        AND cg.id = :groupid
        GROUP BY ct.id
        ORDER BY victories DESC, rounds DESC
        `;
        this._db.raw(sql, new Object({
            groupid: groupid
        })).asCallback(function (err, result) {
            if (err) throw err;
            let data = new Array();
            if ((undefined != result[0]) && (result[0] instanceof Array) && result[0].length) {
                data = result[0];
            }
            if (next instanceof Function) {
                next(data);
            }
        });
    }

}