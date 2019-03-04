/* global Function */
var Auth = function () {
    this.login = function (username, password, next) {
        if (next instanceof Function) {
            if ((undefined !== username) && (undefined !== password)) {
                jQuery.ajax({
                    async: true,
                    type: "post",
                    datatype: 'json',
                    url: '/auth/login',
                    data: {
                        username: username,
                        password: password
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error(errorThrown);
                        next(null);
                    },
                    success: function (response) {
                        next(response);
                    }
                });
            } else {
                next(null);
            }
        }
    };
};