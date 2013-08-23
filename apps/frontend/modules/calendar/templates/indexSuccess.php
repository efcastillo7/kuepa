
<div id="" class="container">
    <div id="leccion" class="row">
        <div class="span9">
            <div id='calendar'></div>
        </div>
    </div>
</div><!-- /container -->


<script type="text/javascript">

$(document).ready(function() {

    // page is now ready, initialize the calendar...

    $('#calendar').fullCalendar({
        eventSources: ['/calendar']
    })

});

</script>