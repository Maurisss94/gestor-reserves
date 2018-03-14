(function ($) {

    $(document).ready(function(){
        initStepBar();
        initCalendar();
        bookingProcess();
    });
    
    function bookingProcess() {
        var checkAnimals = $('.animals');
        var numOcupants, animals;
        $('#ocupants, input[type=radio][name=opcio-animals]').on('change', function (e) {

            var currentElement = $(e.target)[0].id;
            if(currentElement === 'ocupants')
                numOcupants = this.value;
            else
                animals = this.value;

            if(checkAnimals.hasClass('hide')){
                checkAnimals.removeClass('hide');
            }

            if(numOcupants && animals){
                console.log('peticio');
                //fer peticio ajax
            }

        });



    }


    function initCalendar() {

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

        $("#datepicker-ini").datepicker({
            minDate: '+2D',
        });
        $("#datepicker-fi").datepicker({
            minDate: '+2D',
            defaultDate: +7

        });
        /**
         * TODO: Canviar manera d'indicar el valor al datepicker
         */
        var someDate = new Date();
        var dd = someDate.getDate() + 2;
        var dd2 = someDate.getDate() + 7;
        var mm = someDate.getMonth() + 1;
        var y = someDate.getFullYear();

        var someFormattedDate = dd + '/' + mm + '/' + y;
        var someFormattedDateFi = dd2 + '/' + mm + '/' + y;

        $("#datepicker-ini").attr("value", someFormattedDate);
        $("#datepicker-fi").attr("value", someFormattedDateFi);
    }




    function initStepBar() {
        $('.next').click(function(){

            var nextId = $(this).parents('.tab-pane').next().attr("id");
            $('[href=#'+nextId+']').tab('show');
            return false;

        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

            //update progress
            var step = $(e.target).data('step');
            var percent = (parseInt(step) / 5) * 100;

            $('.progress-bar').css({width: percent + '%'});
            $('.progress-bar').text("Step " + step + " of 5");

            //e.relatedTarget // previous tab

        });

    }

})(jQuery);