

const $ = require('jquery');
$(document).ready(function() {
    // windowHalfHeight ;
    windowHalfHeight=($( window ).height()/2);
    var now_date = new Date();
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    var today_date = new Date(y,m,d,0,0,0);

    var cd = today_date.getDate();
    var cm = today_date.getMonth();
    var cy = today_date.getFullYear();
    var view = 'agendaMonth';
    //startdate
    //enddate
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
            date = new Date();
            d = date.getDate();
            m = date.getMonth();
            y = date.getFullYear();
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
            $(daysCell[i]).attr('data-date',_date.toLocaleDateString());
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
            $(daysCell[i+weekDay]).attr('data-date',_date.toLocaleDateString());
            $(daysCell[i+weekDay]).find('.fc-day-number').html(_date.getDate());
        }
        // next month
        for(var i=lastDay+weekDay;i<=41;i++){
            var _date=new Date(y,m+1,i-lastDay-weekDay+1);
            $(daysCell[i]).addClass('fc-other-month');
            $(daysCell[i]).attr('data-date',_date.toLocaleDateString());
            $(daysCell[i]).find('.fc-day-number').html(_date.getDate());
            $(daysCell[i]).addClass('fc-future');
        }

        startdate=new Date(y,m,1-weekDay);
        enddate=_date;
        // load data to show
        loadData().then(function(data) {
            // Run this when your request was successful
            cours=data;
            if(view=="agendaMonth"){
                $('.fc-event').remove();
                $.each( cours, function( key, cour ) {
                    var heuredebut=new Date(cour.start_at).toLocaleTimeString().substring(0,5);
                    var heurefin=new Date(cour.end_at).toLocaleTimeString().substring(0,5);
                    var mydiv ='<div class="fc-event fc-event-hori fc-event-draggable fc-event-start fc-event-end important"\n' +
                        '                 >\n' +
                        '                <div class="fc-event-inner"><span class="fc-event-time"><i class="fa fa-clock" aria-hidden="true"></i> '+ heuredebut+' -- '+heurefin+'</span></div>\n' +
                        '                <div class="fc-event-inner"><span class="fc-event-professeur">'+cour.professeur.first_name+' '+ cour.professeur.last_name+'</span></div>\n' +
                        '                <div class="fc-event-inner"><span class="fc-event-module">'+cour.module.libelle+'</span></div>\n' +
                        '                <div class="fc-event-inner"><span class="fc-event-groupe">'+cour.groupe.libelle+'</span></div>\n' +
                        '                <div class="fc-event-inner"><span class="fc-event-salle"><i class="fa fa-map-marker" aria-hidden="true"></i> '+cour.salle.libelle+'</span></div>\n' +
                        '                <div class="ui-resizable-handle ui-resizable-e">&nbsp;&nbsp;&nbsp;</div>\n' +
                        '            </div>';

                    // var date = new Date().toISOString().substr(0, 10);
                    //                //myStr.substring(4, 20);
                    var faitle=new Date(cour.fait_le).toLocaleDateString();
                    $('td[data-date="'+faitle+'"]').find('div.fc-day-content').append(mydiv);

                });
            }




        }).catch(function(err) {
            // Run this when promise was rejected via reject()
            console.log(err)
        })
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
        var lastDate = new Date(y,m, d+7-weekDay);
        $('span.fc-header-title h2').html(datesDefault.monthNames[m]+' '+ y);
        $(".fc-week-day").each(function( index , fcday) {
            var _date=new Date(y,firstDate.getMonth(),firstDate.getDate()+index);
            $(fcday).html(datesDefault.dayNamesShort[index]+' '+_date.getDate());
        });


        startdate=new Date(y,m,d-weekDay);
        enddate=lastDate;
        loadData().then(function(data) {
            // Run this when your request was successful
            cours=data;
            if(view=="agendaWeek"){
                $('.fc-event').remove();
                $.each( cours, function( key, cour ) {
                    var heuredebut = new Date(cour.start_at).toLocaleTimeString().substring(0, 5);
                    var heurefin = new Date(cour.end_at).toLocaleTimeString().substring(0, 5);
                    var faitle=new Date(cour.fait_le).toLocaleDateString();
                    //alert(faitle+' '+new Date(cour.fait_le).getDay());
                    var rowH=new Date(cour.start_at).getHours();
                    var colD=new Date(cour.start_at).getDay()!=0 ? new Date(cour.start_at).getDay()+1 : 7 ;
                    var tailleH=25*4;
                    var tailleW=118;
                    var mydiv ='<div class="fc-event fc-event-hori fc-event-draggable fc-event-start fc-event-end info"\n' +
                        '    style="position: absolute;  width: 118px; height: '+tailleH+'px; "             >\n' +
                        '                <div class="fc-event-inner"><span class="fc-event-time"><i class="fa fa-clock" aria-hidden="true"></i>'+heuredebut+'</span></div>\n' +
                        '                <div class="fc-event-inner"><span class="fc-event-date">'+new Date(cour.fait_le).toLocaleString().substring(0,10)+'</span></div>\n' +
                        '                <div class="fc-event-inner"><span class="fc-event-module">'+cour.module.libelle+'</span></div>\n' +
                        '                <div class="fc-event-inner"><span class="fc-event-groupe"><i class="fa fa-group" aria-hidden="true"></i>'+cour.groupe.libelle+'</span></div>\n' +
                        '                <div class="fc-event-inner"><span class="fc-event-salle"><i class="fa fa-map-marker" aria-hidden="true"></i> '+cour.salle.libelle+'</span></div>\n' +
                        '                <div class="ui-resizable-handle ui-resizable-e">&nbsp;&nbsp;&nbsp;</div>\n' +
                        '            </div>';
                    $('tr.fc-slot'+rowH+' td:nth-child('+colD+') ').append(mydiv);

                });


            }

        }).catch(function(err) {
            // Run this when promise was rejected via reject()
            console.log(err)
        })



    }

    function createDateDay(){
        var weekDay=date.getDay()!= 0 ? date.getDay()-1 : 6 ;
        //curent month
        /*var firstDate = new Date(y, m, d-weekDay);
        var lastDate = new Date(y,m, d+6-weekDay);*/
        $('span.fc-header-title h2').html(datesDefault.monthNames[m]+' '+ y);
        $(".fc-day-show").html(datesDefault.dayNames[weekDay]+' '+date.getDate());

        startdate=new Date(y,m,d);
        enddate=new Date(y,m,d+1);
        loadData().then(function(data) {
            // Run this when your request was successful
            cours=data;
            if(view=="agendaDay"){
                $('.fc-event').remove();
                $.each( cours, function( key, cour ) {
                    var heuredebut = new Date(cour.start_at).toLocaleTimeString().substring(0, 5);
                    var heurefin = new Date(cour.end_at).toLocaleTimeString().substring(0, 5);
                    var faitle=new Date(cour.fait_le).toLocaleDateString();
                    //alert(faitle+' '+new Date(cour.fait_le).getDay());
                    var rowH=new Date(cour.start_at).getHours();
                    var tailleH=25*8;
                    var tailleW=118;
                    var mydiv ='<div class="fc-event fc-event-hori fc-event-draggable fc-event-start fc-event-end info"\n' +
                        '    style="position: absolute;  width: 100%; height: '+tailleH+'px; "             >\n' +
                        '                <div class="fc-event-inner"><span class="fc-event-time"><i class="fa fa-clock" aria-hidden="true"></i>'+heuredebut+'</span></div>\n' +
                        '                <div class="fc-event-inner"><span class="fc-event-time">'+new Date(cour.fait_le)+'</span></div>\n' +
                        '                <div class="fc-event-inner"><span class="fc-event-salle"><i class="fa fa-map-marker" aria-hidden="true"></i> '+cour.salle.libelle+'</span></div>\n' +
                        '                <div class="fc-event-inner"><span class="fc-event-time">groupe</span></div>\n' +
                        '                <div class="ui-resizable-handle ui-resizable-e">&nbsp;&nbsp;&nbsp;</div>\n' +
                        '            </div>';
                    $('div.fc-view-agendaDay table tr.fc-slot08 td').append(mydiv);
                });
            }


        }).catch(function(err) {
            // Run this when promise was rejected via reject()
            alert(err);
        })




    }

    function destroyDateWeek(){
    }

    function dayDiff(d1, d2) { // d1 - d2
        return Math.round((cloneDate(d1, true) - cloneDate(d2, true)) / DAY_MS);
    }

    //load data
    function loadData() {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/emplois',
                type: "GET",
                dataType: "json",
                data: {
                        'startdate':startdate.toUTCString(),
                        'enddate' : enddate.toUTCString(),
                },
                beforeSend: function(){
                    // Show image container
                    $("div.container").css("opacity", 0.2);
                    $("div.navbar").css("opacity", 0.2);
                    $("div.loading-spinner").css("top", ($(window).scrollTop()+windowHalfHeight)+"px");
                    $("div.loading-spinner").addClass("d-flex");
                    $("div.loading-spinner").show();
                },
                success: function(data) {
                    resolve(data) // Resolve promise and go to then()
                },
                error: function(err) {
                    reject(err) // Reject the promise and go to catch()
                },
                complete: function () {
                    $("div.container").css("opacity", 1);
                    $("div.navbar").css("opacity", 1);
                    $("div.loading-spinner").hide();
                    $("div.loading-spinner").removeClass("d-flex");
                }
            });
        });

    }

});
