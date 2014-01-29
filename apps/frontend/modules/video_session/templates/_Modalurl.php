<div class="md-modal" id="modal-update-video_session-url">
    <div class="md-content">
        <h3 id="title"></h3>
        <div>
            <div id="modal-update-video_session-url-container">
                <form action="<?php echo url_for("video_session/update"); ?>" method="POST" id="update-video_session-url">
                    <img src="img/hangout-url-capture.png" class="marginbottom20 margintop20" />
                    Ingrese la URL del hangout:
                    <input type="hidden" name="video_session_id" />
                    <input type="text" class="input-large" name="hangout_url"/>
                    <div class="text-center">
                        <input type="submit" class="btn btn-default" value="Guardar" />
                    </div>
                </form>
            </div>
            <div id="progressbar" class="ui-progressbar ui-widget ui-widget-content ui-corner-all" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="40">
                <div class="ui-progressbar-value ui-widget-header ui-corner-left" style="width: 40%;"></div>
                <div id="progress">Cargando <span>10%</span></div>
            </div>
            <button class="md-close">Cerrar</button>
        </div>
    </div>
</div>
<div class="md-overlay"></div>