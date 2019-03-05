module.exports = class Person {

    constructor(db) {
        this._db = db;
        Object.freeze(this);
    }

    seekCredentialByPersonId(personid, next) {
        let sql = `
            SELECT
                u.accesskey,
                u.secretkey
            FROM person.user u
            INNER JOIN person.person p
                ON p.id = u.personid
                AND p.state = 1
            WHERE u.personid = :personid
            AND u.state = 1
            GROUP BY u.id
            `;
        this._db.raw(sql, new Object({
            personid: personid
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