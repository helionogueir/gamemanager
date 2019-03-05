module.exports = class Person {

    constructor(db) {
        this._db = db;
        Object.freeze(this);
    }

    findRowBySignIn(username, password, next) {
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
            FROM person.user u
            INNER JOIN person.person p
                ON p.id = u.personid
                AND p.state = 1
            WHERE u.username = :username
            AND u.password = :password
            AND u.state = 1
            GROUP BY u.id, p.id
            `;
        this._db.raw(sql, new Object({
            username: username,
            password: password
        })).asCallback(function (err, result) {
            if (err) throw err;
            let data = null;
            if ((undefined != result[0]) && (result[0] instanceof Array) && result[0].length) {
                for (let i in result[0]) {
                    data = result[0][i];
                    break;
                }
            }
            if (next instanceof Function) {
                next(data);
            }
        });
    }

}