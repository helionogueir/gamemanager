module.exports = class ChallengeMatch {

    constructor(db) {
        this._db = db;
        Object.freeze(this);
    }

    seekInfoByGroupId(groupid, next) {
        let sql = `
        SELECT
            ct.id AS teamid,
            ct.name AS teamname,
            SUM(ct.id = IF((cm.avictory > cm.bvictory), cm.ateamid, cm.bteamid)) AS victories,
            SUM(ABS(cm.avictory - cm.bvictory)) AS rounds
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