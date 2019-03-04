const crypto = require('crypto');

module.exports = class SeekPerson {

    constructor(db) {
        this._db = db;
        Object.freeze(this);
    }

    seek(username, password, next) {
        try {
            let sql = `
            SELECT
                u.personid,
                u.username,
                u.accesskey,
                u.secretkey,
                p.nickname,
                p.fullname,
                p.email,
                p.genre
            FROM user u
            INNER JOIN person p
                ON p.id = u.personid
                AND p.state = 1
            WHERE u.username = :username
            AND u.password = :password
            AND u.state = 1
            GROUP BY u.id, p.id
            `;
            this._db.raw(sql, new Object({
                username: username,
                password: crypto.createHash('sha256').update(password).digest("hex")
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