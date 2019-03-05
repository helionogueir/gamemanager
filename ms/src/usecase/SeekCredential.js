module.exports = class SeekCredential {

    constructor(db) {
        this._db = db;
        Object.freeze(this);
    }

    seek(personid, next) {
        try {
            let sql = `
            SELECT
                u.accesskey,
                u.secretkey
            FROM user u
            WHERE u.personid = :personid
            AND u.state = 1
            `;
            this._db.raw(sql, new Object({
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