jQuery(document).ready(function($) {

    // datepicker
    $('.datepicker').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'dd.mm.yyyy',
        showOtherMonths: true,
        selectOtherMonths: true
    });
});
