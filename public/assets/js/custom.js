// $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
$(document).ready(function () {
    $('.form-global-handle').submit(function (event) {
        event.preventDefault();
        // var title = global_locale == 'en' ? 'Are you sure?' : 'Apakah anda yakin?';
        // var mes = global_locale == 'en' ? 'Are you sure to continue?' : 'Apakah anda yakin untuk melanjutkan?';
        var title = 'Are you sure ?'
        var mes = 'Are you sure to continue ?'
        Swal.fire({
            title: title,
            text: mes,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes',
        }).then((result) => {
            $('body').css('padding', '0');
            if (result.value) {
                $.blockUI();
                $(this).off('submit').submit();
            }
        });
    });

    $(".btn-global").on('click', function () {
        event.preventDefault();
        // var title = global_locale == 'en' ? 'Are you sure?' : 'Apakah anda yakin?';
        // var mes = global_locale == 'en' ? 'Are you sure to continue?' : 'Apakah anda yakin untuk melanjutkan?';
        var title = 'Are you sure ?'
        var mes = 'Are you sure to continue ?'
        Swal.fire({
            title: title,
            text: mes,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes',
        }).then((result) => {
            $('body').css('padding', '0');
            if (result.value) {
                $.blockUI;
                $(this).off('submit').submit();
            }
        });
    });

});
