const crypto = require('crypto');

module.exports = class EncryptPassword {

    encrypt(password, next) {
        let encrypt = crypto.createHash('sha256').update(password).digest("hex");
        if (next instanceof Function) next(encrypt);
        return encrypt;
    }

}