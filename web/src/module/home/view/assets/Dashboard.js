var Dashboard = new function () {
    this.page = function (uri, next) {
        if ((undefined !== uri) && next instanceof Function) {
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
        }
    };
};