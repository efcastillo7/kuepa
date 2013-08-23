
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
        events: { // Render the events in the calendar
            url: '/calendar', // Get the URL of the json feed
            type: 'POST', // Send post data
            error: function() {
                alert('There was an error while fetching events.'); // Error alert
            }
        }
    })



});

</script>