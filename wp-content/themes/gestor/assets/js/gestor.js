(function ($) {

    $(document).ready(function(){
        initStepBar();
        initCalendar();
        bookingProcess();
    });
    
    function bookingProcess() {
        var checkAnimals = $('.animals');
        var listVans = $('.furgos');
        var calendarIni = $('.calendar-ini');
        var numOcupants, animals;
        $('#ocupants, input[type=radio][name=opcio-animals]').on('change', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var currentElement = $(e.target)[0].id;
            if(currentElement === 'ocupants')
                numOcupants = this.value;
            else
                animals = this.value;

            removeHideClass(checkAnimals);
            if(numOcupants && animals){
                console.log('peticio');
                //fer peticio ajax
                getVans(numOcupants, animals).then(function (response) {
                    if(response.length > 0){
                        var selectFurgos = $('.select-furgos');
                        items = response;
                        selectFurgos.find('option').remove().end();
                        selectFurgos.append('<option value="" selected disabled hidden>Tria la teva furgo</option>');
                        //TODO: Afegir imatges a les options del select.
                        $.each(items, function (i, item) {
                            selectFurgos.append($('<option> ', {
                                value: item.title,
                                text : item.title,
                                class: 'option-furgo'
                            }));
                        });
                        removeHideClass(listVans);
                        //TODO: Repassar perquè fa més d'una petició
                        selectFurgos.on('change', function (e) {
                            e.preventDefault();
                            e.stopPropagation();
                            initCalendar();
                            var nomFurgo = $(this).val();
                            var idFurgo = checkSelectedFurgo(nomFurgo, items);
                            if(idFurgo !== -1){
                                getPriceVanSeason(idFurgo).then(function (response) {
                                    console.log(response);
                                });
                            }


                            removeHideClass(calendarIni);
                        });
                    }else{
                        addHideClass(listVans);
                        addHideClass(calendarIni);
                    }

                });
            }

        });



    }

    function getVans(ocupants, animals) {
        var boolAnimals = animals ==='Yes' ? 1 : 0;

        var data = {
            'action': 'vans_available',
            'ocupants': ocupants,
            'animals': boolAnimals,
            'lang': ajax_object.lang
        };
        return jQuery.getJSON(ajax_object.ajax_url, data);
    }
    
    function getPriceVanSeason(id) {

        var data = {
            'action': 'vans_prices',
            'id': id,
            'lang': object_van.lang
        };
        return jQuery.getJSON(object_van.ajax_url, data);
    }

    function checkSelectedFurgo(nomFurgo, items) {
        var element = $.grep(items, function(e){ return e.title === nomFurgo; });
        if(element.length > 0)
            return element[0].id;
        else
            return -1;
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
            minDate: '+1D',
        });
        $("#datepicker-fi").datepicker({
            minDate: '+3D',
            defaultDate: +7

        });
        /**
         * TODO: Canviar manera d'indicar el valor al datepicker
         */
        var someDate = new Date();
        var dd = someDate.getDate() + 1;
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

    function removeHideClass(element){
        if(element.hasClass('hide')){
            element.removeClass('hide');
        }
    }
    function addHideClass(element) {
        if(!element.hasClass('hide')){
            element.addClass('hide');
        }
    }
    function parseDataDropdown(items) {
        var res = [];
        $.each(items, function (i, item) {
            var tmp = {
                'text': item.title,
                'value': item.title,
                'selected': false,
                'description': '',
                'imageSrc': item.thumbnail
            };
            res.push(tmp);
        });
        return res;
    }

})(jQuery);