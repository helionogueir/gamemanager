const jsonwebtoken = require("jsonwebtoken");

module.exports = class Jwt {

    verify(token, credential, next) {
        try {
            let payload = jsonwebtoken.verify(token, credential.secretkey, {
                "algorithm": "HS256",
                "clockTolerance": 300
            });
            next((undefined !== payload.exp) && (payload.accesskey == credential.accesskey));
        } catch (err) {
            // Put #analytics here!
            next(false);
        }
    }

};