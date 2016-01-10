$(function () {
    initDatepicker();
});

function initDatepicker() {
    $('.datepicker').datepicker({
        format: "dd-mm-yyyy"
    });
}

function initAjaxForm() {
    $('body').on('submit', '.ajaxForm', function (e) {

        e.preventDefault();

        $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize()
            })
            .done(function (data) {
                $('#form_body').html(data);
                initDatepicker();
            });
    });
}
