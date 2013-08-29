
<div id="" class="container">
    <div id="leccion" class="row">
        <div class="span9">
            <div id='calendar'></div>
        </div>
    </div>
</div><!-- /container -->

executeGetCoursesEvents
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