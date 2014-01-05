<div class="md-modal" id="modal-update-support-url">
    <div class="md-content">
        <h3 id="title"></h3>
        <div>
            <div id="modal-update-support-url-container">
                <div class="creating">
                    Creando sesión de soporte...
                </div>
                <div class="form">
                    <form action="<?php echo url_for("support/update"); ?>" method="POST" id="update-support-url">
                        <img src="img/hangout-url-capture.png" class="marginbottom20 margintop20" />
                        Ingrese la URL del hangout y presione Guardar, un agente de soporte lo atenderá a la brevedad: <br />
                        <input type="hidden" name="support_id" />
                        <input type="text" class="input-large" name="hangout_url"/>
                        <div class="text-center">
                            <input type="submit" class="btn btn-default" value="Guardar" />
                        </div>
                    </form>
                </div>
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
<script type="text/javascript">
    var defaultUrl  = "https://talkgadget.google.com/hangouts?gid=<?php echo VideoSessionService::APP_ID_INT; ?>";
</script>
