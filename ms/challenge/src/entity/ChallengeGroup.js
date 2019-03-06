module.exports = class ChallengeGroup {

    constructor(db) {
        this._db = db;
        Object.freeze(this);
    }

    seekByStage(stage, next) {
        let sql = `
            SELECT cg.id, cg.name
            FROM challenge.group cg
            WHERE cg.stage = :stage
            AND cg.state = :state
            `;
        this._db.raw(sql, new Object({
            stage: stage,
            state: 1
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