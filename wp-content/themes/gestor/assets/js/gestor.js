(function ($) {

    var preus, diesReserves;

    $(document).ready(function(){
        initStepBar();
        initCalendar();
        bookingProcess();
    });
    
    function bookingProcess() {
        var checkAnimals = $('.animals');
        var listVans = $('.furgos');
        var calendarIni = $('.calendar-ini');
        var calendarFi = $('.calendar-fi');
        var llocs = $('.llocs-recollida-retorn');
        var buttonReserva = $('.button-reserva');
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
                                value: item.id,
                                text : item.title,
                                class: 'option-furgo'
                            }));
                        });
                        removeHideClass(listVans);
                        //TODO: Repassar perquè fa més d'una petició
                        selectFurgos.on('change', function (e) {
                            e.preventDefault();
                            e.stopPropagation();
                            var idF = $(this).val();
                            var idFurgo = checkSelectedFurgo(idF, items);
                            addHideClass(calendarFi);
                            addHideClass(llocs);
                            addHideClass(buttonReserva);
                            setDateValues();
                            if(idFurgo !== -1){
                                getPriceVanSeason(idFurgo).then(function (response) {
                                    preus = response;

                                    getBookingsOfVan(idFurgo).then(function (response) {
                                        diesReserves = response;

                                    if(preus.preu_t1 !== null){
                                        removeHideClass(calendarIni);
                                        $("#datepicker-ini").datepicker("destroy");
                                        $("#datepicker-ini").datepicker({
                                            prevText: "<",
                                            nextText: ">",
                                            minDate: '+1D',
                                            beforeShowDay: getPricesandAvailability,
                                            onSelect: function (date, obj) {
                                                var formatDate = new Date(parseInt(obj.currentMonth+1) + '/' + obj.selectedDay + '/' + obj.currentYear);
                                                removeHideClass(calendarFi);
                                                $("#datepicker-fi").datepicker("destroy");
                                                $("#datepicker-fi").datepicker({
                                                    minDate: addDays(formatDate, 3),
                                                    beforeShowDay:getPricesandAvailability,
                                                    onSelect: function () {
                                                        removeHideClass(llocs);
                                                        removeHideClass(buttonReserva);
                                                    }
                                                });
                                            }
                                        });
                                        setDateValues();
                                    }else{
                                        addHideClass(calendarIni);
                                        addHideClass(calendarFi);
                                    }
                                });
                                });
                            }

                        });
                    }else{
                        addHideClass(listVans);
                        addHideClass(calendarIni);
                        addHideClass(calendarFi);
                    }

                });
            }

        });

    }

    function getPricesandAvailability(date) {
        var selectable = true,
            style = '',
            popup = '';

        var day = date.getDate();
        day = (day < 10) ? '0'+day : day;
        var month = parseInt(date.getMonth())+1;
        month = (month < 10) ? '0'+month : month;
        var formatDate = month + "/" + day + "/" + date.getFullYear();
        //comprovem temporades
        for(var i = 0;i<temporades.length;i++){
            for(var j = 0;j<temporades[i].length;j++){
                var newDate = new Date(formatDate);
                var dIni = new Date(temporades[i][j].data_inici);
                var dFi = new Date(temporades[i][j].data_fi);
                if(newDate >=  dIni && newDate <= dFi){
                    switch(i) {
                        case 0:
                            popup = preus.preu_t1 + ' €';
                            break;
                        case 1:
                            popup = preus.preu_t2 + ' €';
                            break;
                        case 2:
                            popup = preus.preu_t3 + ' €';
                            break;
                        case 3:
                            popup = preus.preu_t4 + ' €';
                            break;
                        default:
                            popup = 0;
                    }
                }
            }

        }
        for(var i = 0;i<diesReserves.length;i++){
            var newDate = new Date(formatDate);
            var dIni = new Date(diesReserves[i].dIni);
            var dFi = new Date(diesReserves[i].dFi);
            if(newDate >=  dIni && newDate <= dFi){
                selectable = false;
            }
        }
        return [selectable, style, popup];
    }

    function getBookingsOfVan(idFurgo){

        var data = {
            'action': 'gestor_get_reserved_vans',
            'id_furgo': idFurgo,
            'lang': ajax_object.lang
        };

        return jQuery.getJSON(object_booking.ajax_url, data);
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

    function checkSelectedFurgo(idF, items) {
        var element = $.grep(items, function(e){ return e.id === parseInt(idF); });
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

    }

    function setDateValues() {
        $("#datepicker-ini")[0].value = "Dia de sortida";
        $("#datepicker-fi")[0].value = "Dia de tornada";
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
    function addDays(date, days) {
        var dat = date;
        dat.setDate(dat.getDate() + days);
        return dat;
    }


})(jQuery);