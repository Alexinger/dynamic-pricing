jQuery(document).ready(function ($) {

    $('#form_update_option').click(function (e) {
        e.preventDefault();
        var dataForm = $('#form-fields').serialize();

        var data = {
            'action': 'test',
            'data': dataForm
        };

        $.post(ajaxurl, data, function (response) {
            alert("Все изменения сохранились!");
        });

    });

    $('#form_set_data').click(function (e) {
        e.preventDefault();
        var data = {
            'action': 'fun_save',
            'data': 'save'
        };

        $.post(ajaxurl, data, function (response) {
            alert("Слепок данных сделан!");
        });

    });

    $('#form_load_data').click(function (e) {
        e.preventDefault();
        var data = {
            'action': 'fun_load',
            'data': 'load'
        };

        $.post(ajaxurl, data, function (response) {
            alert("Сохранено из файла!");
        });

    });
});