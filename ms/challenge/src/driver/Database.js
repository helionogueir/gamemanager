const knex = require('knex');

module.exports = class Database {

    constructor() {
        this._dbal = null;
        return this;
    }

    connect() {
        if (!(this._dbal instanceof Function)) {
            this._dbal = new knex({
                client: 'mysql',
                acquireConnectionTimeout: 5000,
                connection: {
                    host: process.env.DSN_HOST_READ,
                    user: process.env.DSN_USERNAME,
                    password: process.env.DSN_PASSWORD,
                    database: process.env.DSN_DBNAME,
                    charset: process.env.DSN_CHARSET,
                    port: process.env.DSN_PORT
                }
            });
        }
        return this._dbal;
    }

    close() {
        try {
            if (this._dbal instanceof Function) {
                this._dbal.destroy();
            }
            this._dbal = null;
        } catch (err) {
            // Put #analytics here!
        }
    }

};