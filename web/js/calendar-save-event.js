var calenderSaveEvent = function()
{
    var thisClass = this;
    this.MySqlFormat = 'yy-mm-dd';
    this.init = function()
    {
        
        $(".datepicker").datepicker({
          dateFormat: 'dd/mm/yy',
          changeMonth: true,
          changeYear: true
        });
        
        $('#allDay').change(function(){
            if($(this).is(':checked')){
                $('#start_time').hide();
                $(".hs").hide();
                $('#end_time').hide();
                $('#start_time').val("");
                $('#end_time').val("");
            }else{
                $('#start_time').show();
                $(".hs").show();
                $('#end_time').show();
            }
        });
        $.datepicker.setDefaults( $.datepicker.regional[ "es" ] );

        $("#btn-save-event").click(function(e){
  
           e.stopPropagation();
           e.preventDefault(); 
           var title    = $("#title").val();
           var subject  = $("#component_id").val();
           var start    = $.datepicker.formatDate("yy-mm-dd",$.datepicker.parseDate('dd/mm/yy',$("#start_date").val())) + ($("#allDay").is(":checked") ? " 00:00" : " " + $("#start_time").val());
           var end      = $.datepicker.formatDate("yy-mm-dd",$.datepicker.parseDate('dd/mm/yy',$("#end_date").val())) + ($("#allDay").is(":checked") ? " 23:59" : " "+ $("#end_time").val());
           
            $(".datepicker").blur();
            $(".hour").blur();
            $("#title").blur();
            
           if( !$("#title").hasClass('input-alert') && !$(".datepicker").hasClass('input-alert') && !$(".hour").hasClass('input-alert') ){
              $("#title").removeClass('input-alert');
              var url = '/kuepa_api.php/calendar/' + $("#eventHeader").attr("data-edit");
              $.ajax({
                   url: url,
                   type: 'POST',
                   dataType: 'json',
                   data: {
                       id: $("#eventHeader").attr("data-id"),
                       start:  start, 
                       end: end,
                       title: title,
                       subject: subject,
                       address: $("#address").val(),
                       description: $("#description").val(),
                       publico: $("#public").is(':checked')
                   },
                   success:function(data){
                       if(data.status == "error"){
                            $(".datepicker").blur();
                            $(".hour").blur();
                            $("#title").blur();
                       }else{
                            window.location.replace("http://"+document.domain+"/calendar");
                       }
                   },
                   error: function(){
                       return false;
                   }
               }); 
            }
            
        });
        
        $("#btn-cancel-event").click(function(){
            parent.history.back();
            return false;
        });
        
        
        var d = new Date();
        var date = d.getDate()+"/"+(d.getMonth() + 1)+"/"+d.getFullYear();
        $(".datepicker").attr("placeholder",date);
        
        $(".datepicker").blur(function(){
            try{
                parsedDate = $.datepicker.parseDate('dd/mm/yy',$(this).val());
            }catch(e){
                parsedDate = null;
            }

            if (parsedDate == null) {
                $(this).val('');
                $(this).addClass('input-alert');
            }else {
                $(this).removeClass('input-alert');
            }
        });
        $("#end_date").blur(function(){
             try{
                parsedDate = $.datepicker.parseDate('dd/mm/yy',$(this).val());
                parsedStart = $.datepicker.parseDate('dd/mm/yy',$("#start_date").val());
            }catch(e){
                parsedDate = null;
            }
            if (parsedDate == null || parsedDate < parsedStart) {
                $(this).val('');
                $(this).addClass('input-alert');
            }else {
                $(this).removeClass('input-alert');
            }
        });
        $(".hour").blur(function(){
            var regex = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])/;
            if(!regex.test($(this).val())){
                $(this).val('');
                $(this).addClass('input-alert');
            }else {
                $(this).removeClass('input-alert');
            }
        });
        
        $("#title").blur(function(){
            if($(this).val() == ""){
                $(this).addClass('input-alert');
                $(this).val("");
            }else{
                $(this).removeClass('input-alert');
            }
        });
                
        $(".datepicker").change(function(){$(this).blur();});
        $(".hour").change(function(){$(this).blur();});
        
    }; 
    this.init();
};

$(document).ready( function() { new calenderSaveEvent(); } );