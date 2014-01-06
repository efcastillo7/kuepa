<div id="" class="container">
    <p class="title3">Soporte vía Hangouts</p>
    <div class="tabbable">
        <?php
        include_partial(
            'list_container',
            array(
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
?>
<script src="/js/support.js"></script>