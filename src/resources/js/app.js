require('./bootstrap');
window.$ = window.jQuery = require('jquery');

$(document).ready(function () {
    $('#shot-link').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: '/shortening',
            data: $('#shot-link').serialize(),
            success: function (data) {
                if (data.error) {
                    switch (data.error) {
                        case 'link_exist':
                            alert('Псевдоним ссылки уже существует');
                            break;
                        case 'unknown_error':
                            alert('Непредвиденная ошибка');
                            break;
                    }
                } else {
                    $('#link-output').val(data.text);
                    $('#link-statistics').val(data.text + '/stat');
                }
            },
            error: function () {
                alert('Непредвиденная ошибка');
            }
        });
    });
    $('.copy').on('click', function (e) {
        navigator.clipboard.writeText(e.currentTarget.previousElementSibling.value);
    })
});
