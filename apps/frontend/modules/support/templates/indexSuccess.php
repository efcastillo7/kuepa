<script type="text/javascript" src="https://apis.google.com/js/platform.js"></script>
<script type="text/javascript" src="https://apis.google.com/js/client:plusone.js"></script>

<script type="text/javascript">
    var googleID    = "<?php echo $google_id; ?>";
</script>
<div id="" class="container">
    <p class="title3">Soporte vía Hangouts</p>
    <div class="tabbable">
        <?php
        include_partial(
            'list_container',
            array(
                'pid'       => $profile_id,
                'pending'   => $pending_video_sessions,
                'historic'  => $historic_video_sessions
            )
        );
        ?>
        </div>
    </div>
</div>

<?php
echo include_partial('Modalfinish');