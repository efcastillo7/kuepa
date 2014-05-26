var calendario = function()
{
    var thisClass = this;
    this.MySqlFormat = 'yyyy-MM-dd hh:mm:ss';
    
    this.idSelector = function() { return $(this).attr("data-filter"); };
    this.loadSidebar = function(){
       return $.ajax({
           url: '/kuepa_api.php/calendar/getSidebarData',
           type: 'GET',
           dataType: 'json',
           success: function(data){
              $("#sidebarElementsContainer").remove();
              $(".sidebarContainer").append(new EJS({url: "/js/templates/calendar/sidebar.ejs"}).render({sideBar: data}));
              $(".cont-subjects input[type=checkbox], .cont-tutorias input[type=checkbox]").click(function(){
                   
                   var container = $(this).parent().parent().parent();

                   if(container.hasClass("cont-subjects")){
                       $.cookie('subjects', $(".cont-subjects input[type=checkbox]:checked").map(thisClass.idSelector).get());
                   }
                   
                   if(container.hasClass("cont-tutorias")){
                       $.cookie('tutorias', $(".cont-tutorias input[type=checkbox]:checked").map(thisClass.idSelector).get());
                   }
                   
                   $('#calendar').fullCalendar( 'refetchEvents' );
                   
              });
              $('#calendar').fullCalendar( 'refetchEvents' );
           },
           error: function(){}
       });
    };
    
    this.init = function()
    {
        //Seteo las fechas en español
        $.datepicker.setDefaults($.datepicker.regional['es']);
        
       
        $.when( thisClass.loadSidebar() ).then(function( data, textStatus, jqXHR ) {
            $('#calendar').fullCalendar({
             header: {
                  left: 'prev,today,next',
                  center: 'title',
                  right: 'month,agendaWeek,agendaDay'
             },
             axisFormat:'HH:mm',
             timeFormat:'HH:mm',
             eventSources: [
                {
                    url: '/kuepa_api.php/calendar/getUserEventsByMonth',
                    type: 'GET',
                    data:function() {
                        return {
                           filterCourse: $(".cont-subjects input[type=checkbox]:checked").map(thisClass.idSelector).get(),
                           filterTutorias: $(".cont-tutorias input[type=checkbox]:checked").map(thisClass.idSelector).get()                            
                        };
                    },
                    error: function(e) {}
                }
             ],
             editable: true,
             eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
                $.ajax({
                    url: '/kuepa_api.php/calendar/editEvent',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: event.id,
                        start: event.start,
                        end: event.end
                    },
                    error: revertFunc
                });
             },
             eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {
                $.ajax({
                    url: '/kuepa_api.php/calendar/editEvent',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: event.id,
                        start: event.start,
                        end: event.end
                    },
                    error: revertFunc
                });
             },
             eventDragStart: function (){
                $(".ui-cluetip").hide();
             },
             eventRender:function( event, element, view ) { 
                element.append(new EJS({url: "/js/templates/calendar/eventDetailsPopUp.ejs"}).render({event: event}));
                element.attr('ref', '#popup_' + event.id);
                element.cluetip({
                    local: true,
                    attribute: 'ref',
                    activation: 'click',
                    sticky: true,
                    closeText:'<div class="close-cluetip"></div>',
                    onActivate: function(e) {
                      $(".ui-cluetip").hide();
                      $(".add-event").hide();
                      element.find("#btn-remove-event #texto").text("Quitar evento");
                      element.find("#btn-remove-event").click(function(ev){
                        var texto = $(this).find("#texto");
                        texto.text("Seguro?");
                        texto.append(' ');
                        var achorSi = $('<a id="si" class="cursor">Si</a>');
                        achorSi.click(function(){
                            $.ajax({
                                  url: '/kuepa_api.php/calendar/delete',
                                  type: 'POST',
                                  dataType: 'json',
                                  data: {
                                      id: event.id
                                  },
                                  success: function(data){
                                      if(data.status == "success"){
                                        $("#calendar").fullCalendar( 'removeEvents' , event.id );
                                        $('.close-cluetip').click();
                                        thisClass.loadSidebar();
                                      }
                                 }
                            });
                        });

                        texto.append(achorSi);
                        texto.append(' ');
                        var achorNo = $('<a id="no" class="cursor">No</a>');
                        achorNo.click(function(){
                            $('.close-cluetip').click();
                        });
                        texto.append(achorNo);
                      });
                    }
                });
             },
             selectable: true,
             selectHelper: true,
            select: function(start, end,allDay,event){ 

                $(".close-cluetip").click(); 

                event = event || window.event //For IE
                var x = event.pageX - 200;
                var y = event.pageY - 225;

                if(y < 50){y = 80;}
                $(".add-event").show().css({"top":y,"left":x}); //abre el popup y lo posiciona en las coordenadas donde se hizo click

                // Se agrega la fecha al titulo del popup
                $(".add-event h3").text( start.getTime() === end.getTime() ? $.datepicker.formatDate("DD d 'de' MM 'de' yy", start) : $.datepicker.formatDate("DD d 'de' MM 'de' yy", start) +  " - " + $.datepicker.formatDate("DD d 'de' MM 'de' yy", end) );

                $("#btn-edit-event").unbind('click').click(function(){

                    var parameters = {
                        title: $("#title").val(),
                        subject: $("#component_id").val(),
                        public: $("#public").is(":checked"),
                        start: $.datepicker.formatDate("dd/mm/yy", start),
                        end: $.datepicker.formatDate("dd/mm/yy", end)
                    };
                    
                    $(this).attr("href", $(this).attr("href") +'?'+ $.param(parameters));
                });

                $("#btn-add-event").unbind('click').click(function(){
                  var title = $("#title").val();
                  var subject = $("#component_id").val();
                  if( title == "" ){
                    $("#title").addClass('input-alert');
                    return false;
                  }else{
                    $("#title").removeClass('input-alert');
                    $.ajax({
                        url: '/kuepa_api.php/calendar/createEvent',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            start: $.fullCalendar.formatDate( start, thisClass.MySqlFormat ), 
                            end: $.fullCalendar.formatDate( end, thisClass.MySqlFormat ),
                            title: title,
                            subject: subject,
                            publico: $("#public").is(':checked')
                        },
                        success:function(data){
                            $('#calendar').fullCalendar('unselect');
                            $(".add-event").hide();
                            $("#title").val("");
                            $("#materia").val("");                            
                            $.cookie('subjects', $.cookie('subjects') + ',' + data.subject_id );                            
                            thisClass.loadSidebar();
                        },
                        error: function(){
                            return false;
                        }
                    });
                  }

                });
            }

         });

        });
 
         $("#chk-label").click(function(){
             $("#" + $(this).attr("for")).checked(true);
         });
         
          $("#close-add-event").click(function(){
            $(".add-event").hide();
          });

        // ------------------------------------------------------------------- Fullcalendar

          $(function() {
            $( "#mini-calendar" ).datepicker({
                onSelect: function(dateText) { 
                    $('#calendar').fullCalendar( 'gotoDate', $.datepicker.parseDate( 'dd/mm/yy', dateText.substr(0,10) ) );
                    $('#calendar').fullCalendar( 'changeView', 'agendaDay' );
                }
    
            });
          });
           
          

          $(".toggle").click(function(){
            var rel = $(this).attr("rel");
            $(".cont-"+rel).slideToggle();

            var arrow = $(this).find(".ico-arrow-list");

            if( $(arrow).hasClass("active") ){
              $(arrow).removeClass("active");
            }else{
              $(arrow).addClass("active");
            }
          });


          $("#title").keypress(function(){
            $(this).removeClass('input-alert');
          });

          add_scroll();

          $("#calendar").mousemove(function(){
            add_scroll();
          });

          function add_scroll(){
            $(".fc-agenda-divider").siblings().css("overflow-y","hidden").perfectScrollbar({wheelSpeed:30,wheelPropagation:true,suppressScrollX:true});
          }
    }; 
    this.init();
    
};

$(document).ready( function() { new calendario(); } );