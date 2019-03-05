module.exports = class ChallengeMatch {

    constructor(db) {
        this._db = db;
        Object.freeze(this);
    }

    seekInfoByGroupId(groupid, next) {
        let sql = `
        SELECT
            cgm.id,
            ct.name AS 'teamname',
            SUM(cgm.id = IF((cm.avictory > cm.bvictory), cm.amemberid, cm.bmemberid)) AS victories,
            SUM(ABS(cm.avictory - cm.bvictory)) AS rounds
        FROM challenge.group_members cgm
        INNER JOIN challenge.match cm
            ON cgm.id IN (cm.amemberid, cm.bmemberid)
        INNER JOIN challenge.team ct
            ON ct.id = cgm.teamid
        WHERE cgm.groupid = :groupid
        GROUP BY cgm.id
        ORDER BY victories DESC, rounds DESC;
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