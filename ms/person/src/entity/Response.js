module.exports = class Response {

    format(statusCode, data, next) {
        let response = new Object({
            statusCode: 500,
            data: null
        });
        try {
            if ((undefined !== statusCode) && (undefined !== data) && statusCode) {
                response.statusCode = statusCode;
                response.data = data;
            }
        } catch (err) {
            response.data = `${err}`;
        }
        if (next instanceof Function) {
            next(response);
        }
    }

}