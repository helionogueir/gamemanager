var Challenge = new function () {
    this.group = new function () {
        this.info = function (groupObject) {
            var groupid = $(groupObject).attr('data-id');
            if (undefined !== groupid) {
                jQuery.ajax({
                    async: true,
                    type: "get",
                    datatype: 'html',
                    url: '/challenge/group/' + groupid + '/match/info',
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error(errorThrown);
                    },
                    success: function (htmlText) {
                        $('.challenge-group-info', groupObject).html(htmlText);
                    }
                });
            }
        };
    };
};