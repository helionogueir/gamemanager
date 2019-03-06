const jsonwebtoken = require("jsonwebtoken");

module.exports = class Authorization {

    verify(credential, token, next) {
        let authorized = false;
        try {
            let payload = jsonwebtoken.verify(token, credential.secretkey, {
                "algorithm": "HS256",
                "clockTolerance": 300
            });
            authorized = ((undefined !== payload.exp) && (payload.accesskey == credential.accesskey));
            if (next instanceof Function) {
                next(authorized);
            }
            return authorized;
        } catch (err) {
            // Put #analytics here!
            next(authorized);
        }
    }

};