var Home = function () {
    this.sigIn = function (formObject) {
        try {
            if ($('form').is(formObject)) {
                var username = $('input#username', formObject).val();
                var password = $('input#password', formObject).val();
                $('.home-login-error', formObject).css('visibility', 'hidden');
                (new Auth()).login(username, password, function (response) {
                    if ((undefined !== response.success) && (undefined !== response.redirect) && response.success) {
                        window.location.replace(response.redirect);
                    } else {
                        $('.home-login-error', formObject).html(response.message).css('visibility', 'visible');
                    }
                });
            }
        } catch (err) {
            console.error(err);
        }
        return false;
    };
};