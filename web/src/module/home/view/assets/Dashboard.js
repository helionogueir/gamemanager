var Dashboard = new function () {
    this.container = function (uri) {
        if ((undefined !== uri)) {
            jQuery.ajax({
                async: true,
                type: "get",
                datatype: 'html',
                url: uri,
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error(errorThrown);
                },
                success: function (htmlText) {
                    $('.dashboard-container', document).html(htmlText).find('.challenge-group').each(function () {
                        Challenge.group.info(this);
                    });
                }
            });
        }
    };
    this.detail = function (uri) {
        if ((undefined !== uri)) {
            jQuery.ajax({
                async: true,
                type: "get",
                datatype: 'html',
                url: uri,
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error(errorThrown);
                },
                success: function (htmlText) {
                    $('.dashboard-detail', document).html(htmlText);
                }
            });
        }
    };
};