/* global Function */
var Dashboard = new function () {
    this.open = function (uri) {
        this.content(uri, function (htmlText) {
            $('.dashboard-container', document).html(htmlText);
        });
    };
    this.content = function (uri, next) {
        if (next instanceof Function) {
            if (undefined !== uri) {
                jQuery.ajax({
                    async: true,
                    type: "get",
                    datatype: 'html',
                    url: uri,
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error(errorThrown);
                        next(null);
                    },
                    success: function (htmlText) {
                        next(htmlText);
                    }
                });
            } else {
                next(null);
            }
        }
    };
};