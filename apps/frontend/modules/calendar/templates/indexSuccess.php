
<div id="" class="container">
    <div id="leccion" class="row">
        <div class="span9">
            <div id='calendar'></div>
        </div>
    </div>
</div><!-- /container -->

<?php CalendarService::getUserEventsByDateRange(3, 7, '2013-05-17 00:01:00', '2013-10-17 00:03:00'); ?>
<script type="text/javascript">

$(document).ready(function() {

    // page is now ready, initialize the calendar...

    $('#calendar').fullCalendar({

    	eventSources: [
	        // your event source
	        {
	            url: '/calendar/getEvents',
	            type: 'POST',
	            error: function() {
	                alert('there was an error while fetching events!');
	            }
	        },
	        {
	            url: '/calendar/getCoursesEvents',
	            type: 'POST',
	            error: function() {
	                alert('there was an error while fetching events!');
	            }
	        }

	    ]

    })



});

</script>