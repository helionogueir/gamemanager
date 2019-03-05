module.exports = class HttpResponse {

    prepare(statusCode, data, res) {
        let response = new Object({
            statusCode: ((undefined !== statusCode) && statusCode) ? statusCode : 500,
            data: (undefined !== data) ? data : null
        });
        if (undefined !== res.statusCode) {
            res.statusCode = response.statusCode;
        }
        if (res.header instanceof Function) {
            if ((data instanceof Array)) {
                res.header("X-Total-Count", data.length);
            }
        }
        if (res.send instanceof Function) {
            res.send(response);
        }
        return response;
    }

}