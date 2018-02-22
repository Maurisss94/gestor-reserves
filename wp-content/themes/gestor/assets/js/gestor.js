(function ($) {

    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);

    $( "#datepicker-ini" ).datepicker({
        minDate: '+2D',
    });
    $( "#datepicker-fi" ).datepicker({
        minDate: '+2D',
        defaultDate: +7
    });
    var someDate = new Date();
    var dd = someDate.getDate()+2;
    var dd2 = someDate.getDate()+7;
    var mm = someDate.getMonth() + 1;
    var y = someDate.getFullYear();

    var someFormattedDate = dd + '/'+ mm + '/'+ y;
    var someFormattedDateFi = dd2 + '/'+ mm + '/'+ y;

    $("#datepicker-ini").attr("value", someFormattedDate);
    $("#datepicker-fi").attr("value", someFormattedDateFi);



})(jQuery);