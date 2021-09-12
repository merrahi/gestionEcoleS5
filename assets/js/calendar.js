

const $ = require('jquery');
$(document).ready(function() {
    var now_date = new Date();
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    var today_date = new Date(y,m,d);

    var cd = today_date.getDate();
    var cm = today_date.getMonth();
    var cy = today_date.getFullYear();
    var view = 'agendaMonth';
    var cours; // les cours
    var datesDefault={
        firstDay: 0,
        monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Décembre'],
        monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun','Juil','Aou','Sep','Oct','Nov','Déc'],
        dayNames: ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'],
        dayNamesShort: ['Lun','Mar','Mer','Jeu','Ven','Sam','Dim'],
    };
    //initialisation  fc-header-title
    $('span.fc-header-title h2').html(datesDefault.monthNames[m]+' '+ y);
    showView('agendaMonth');
    createDateMonth();

    // change date
    $('.fc-button-agendaDay , .fc-button-agendaWeek ,.fc-button-month  ').click(function () {
        if(!$(this).hasClass('fc-state-active')){
            //removeclass fc-state-active
            $('span.fc-button').removeClass('fc-state-active');
            //addclass fc-state-active
            $(this).addClass('fc-state-active');
            // show view
            var _val = $(this).html();
            var _view = 'agenda'+_val.charAt(0).toUpperCase() + _val.slice(1);
            view=_view;
            showView(_view);
            if(_view=='agendaMonth') createDateMonth();
            if(_view=='agendaWeek') createDateWeek();
            if(_view=='agendaDay') createDateDay();
            // load data to show
            loadData();
        }
    });

    // fc-button-next
    $('.fc-button-next').click(function () {
        if(view=='agendaMonth') {
            date=new Date(y,m+1,1);
            m=date.getMonth();
            y=date.getFullYear();
            $('span.fc-header-title h2').html(datesDefault.monthNames[m]+' '+ y);
            destroyDateMonth();
            createDateMonth();
        }
        if(view=='agendaWeek') {
            date=new Date(y,m,d+7);
            d = date.getDate();
            m = date.getMonth();
            y = date.getFullYear();
            $('span.fc-header-title h2').html(datesDefault.monthNames[m]+' '+ date.getFullYear());
            //destroyDateMonth();
            createDateWeek();
        }
        if(view=='agendaDay') {
            date=new Date(y,m,d+1);
            d = date.getDate();
            m = date.getMonth();
            y = date.getFullYear();
            $('span.fc-header-title h2').html(datesDefault.monthNames[m]+' '+ date.getFullYear());
            //destroyDateMonth();
            createDateDay();
        }

    });





    // fc-button-prev
    $('.fc-button-prev').click(function () {
        if(view=='agendaMonth' ) {
            date=new Date(y,m-1,1);
            m = date.getMonth();
            y = date.getFullYear();
            $('span.fc-header-title h2').html(datesDefault.monthNames[m]+' '+ y);
            destroyDateMonth();
            createDateMonth();
        }
        if(view=='agendaWeek') {
            date=new Date(y,m,d-7);
            d = date.getDate();
            m = date.getMonth();
            y = date.getFullYear();
            $('span.fc-header-title h2').html(datesDefault.monthNames[date.getMonth()]+' '+ date.getFullYear());
            //destroyDateMonth();
            createDateWeek();
        }
        if(view=='agendaDay') {
            date=new Date(y,m,d-1);
            d = date.getDate();
            m = date.getMonth();
            y = date.getFullYear();
            $('span.fc-header-title h2').html(datesDefault.monthNames[date.getMonth()]+' '+ date.getFullYear());
            //destroyDateMonth();
            createDateDay();
        }

    });

    // fc-fc-button-today
    $('.fc-button-today').click(function () {
        date=today_date;
        d=date.getDate();
        m=date.getMonth();
        y=date.getFullYear();
        $('span.fc-header-title h2').html(datesDefault.monthNames[m]+' '+ y);
        if(view=='agendaMonth') {
            destroyDateMonth();
            createDateMonth();
        }
        if(view=='agendaWeek') {
            createDateWeek();
        }
        if(view=='agendaDay') {
            createDateDay();
        }

    });
    // show view
    function showView(fcView) {
        $(".fc-view").hide();
        $(".fc-view.fc-view-"+fcView).show();
    }

    function createDateMonth(){
        //curent month
        var firstDate = new Date(y, m, 1);
        var lastDate = new Date(y, m + 1, 0);

        var weekDay=firstDate.getDay()!= 0 ? firstDate.getDay()-1 : 6 ;
        var lastDay=lastDate.getDate() ;

        //last month
        var prevDate = new Date(y, m, 0);
        var prevLastDay=prevDate.getDate();
        var _lastDay=prevLastDay-weekDay+1 ;
        // next month

        var daysCell= $(".fc-day");
        // past month
        for(var i=0;i<weekDay;i++){
            var _date=new Date(y,m-1,_lastDay+i);
            if(_date.valueOf()==today_date.valueOf()) {
                $(daysCell[i]).addClass('fc-today fc-state-highlight ');
            }
            $(daysCell[i]).addClass('fc-other-month');
            $(daysCell[i]).attr('data-date',_date);
            $(daysCell[i]).find('.fc-day-number').html(_date.getDate());

        }
        // current month
        for(var i=0;i<lastDay;i++){

            var _date=new Date(y,m,i+1);
            if(_date.valueOf()<today_date.valueOf()) $(daysCell[i+weekDay]).addClass('fc-past');
            else {
                if(_date.valueOf()>today_date.valueOf()) $(daysCell[i]).addClass('fc-future');
                if(_date.valueOf()==today_date.valueOf()) {
                    $(daysCell[i+weekDay]).addClass('fc-today fc-state-highlight ');
                }
            }
            $(daysCell[i+weekDay]).attr('data-date',_date);
            $(daysCell[i+weekDay]).find('.fc-day-number').html(_date.getDate());
        }
        // next month
        for(var i=lastDay+weekDay;i<=41;i++){

            var _date=new Date(y,m+1,i-lastDay-weekDay+1);
            $(daysCell[i]).addClass('fc-other-month');
            $(daysCell[i]).attr('data-date',_date);
            $(daysCell[i]).find('.fc-day-number').html(_date.getDate());
            $(daysCell[i]).addClass('fc-future');
        }
    }

    function destroyDateMonth(){
        $(".fc-day").each(function( index , fcday) {
            $(fcday).removeClass('fc-other-month');
            $(fcday).removeClass('fc-past');
            $(fcday).removeClass('fc-future');
            $(fcday).removeClass('fc-state-highlight');
            $(fcday).removeClass('fc-today');
        });
    }

    function createDateWeek(){
        var weekDay=date.getDay()!= 0 ? date.getDay()-1 : 6 ;
        //curent month
        var firstDate = new Date(y, m, d-weekDay);
        var lastDate = new Date(y,m, d+6-weekDay);
        $('span.fc-header-title h2').html(datesDefault.monthNames[m]+' '+ y);
        $(".fc-week-day").each(function( index , fcday) {
            var _date=new Date(y,firstDate.getMonth(),firstDate.getDate()+index);
            $(fcday).html(datesDefault.dayNamesShort[index]+' '+_date.getDate());
        });



    }

    function createDateDay(){
        var weekDay=date.getDay()!= 0 ? date.getDay()-1 : 6 ;
        //curent month
        /*var firstDate = new Date(y, m, d-weekDay);
        var lastDate = new Date(y,m, d+6-weekDay);*/
        $('span.fc-header-title h2').html(datesDefault.monthNames[m]+' '+ y);
        $(".fc-day-show").html(datesDefault.dayNames[weekDay]+' '+date.getDate());



    }

    function destroyDateWeek(){
    }

    function dayDiff(d1, d2) { // d1 - d2
        return Math.round((cloneDate(d1, true) - cloneDate(d2, true)) / DAY_MS);
    }

});
