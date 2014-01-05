var vsTolerance     = 15;
var iframeMouseOver = false;
var $hoveredEl      = {};

$(function(){

    //Hangout create form init and processing
    initAddForm();

    //Hangout edit form init and processing
    initEditForm();

    //When a teacher clicks on the Add Hangout button a modal form is shown
    $(".addVideoSession-button").click( onHangoutAddClicked );

    //When a teacher clicks on the Edit Hangout button a modal form is shown
    $(".editVideoSession-button").click( onHangoutEditClicked );

    //When a teacher clicks on the Finish Hangout button a modal form is shown
    $(".finishVideoSession-trigger").click( onHangoutFinishTriggered );

    //When a teacher confirms to finish a video session
    $(".finishVideoSession-button").click( onHangoutFinishClicked );

    //Detects when a Start Hangot button is pressed (Hack to detect iframe clicks)
    $(window).blur( onWindowBlured );
    $(".catchHangoutUrl").parent().hover(
        function(){ iframeMouseOver = true; $hoveredEl = $(this); },
        function(){ iframeMouseOver = false; $hoveredEl = {}; }
    );

    $(".video_session_status").tooltip();

    if($(".video_session-nav li.active").length==0){
        $(".video_session-nav li:first").addClass("active");
    }

    if($(".video_session-tab_container.active").length==0){
        $(".video_session-tab_container:first").addClass("active");
    }

    $("[name='video_session[course_id]']").bind("change", onCourseChange).trigger("change");


});

/**
 * Add Hangout form init and processing
 * @returns void
 */
function initAddForm(){

    var $container  = $("#modal-create-video_session-form-container");
    var $form       = $("form",$container);
    var options     = {
        success: function(data) {

            $container
                .html(data.template)
                .show();

            if (data.status === "success") {
                location.href = "/video_session";
            } else {
                $form.ajaxForm(options);
            }
        },
        dataType: 'json'
    };

    $form.ajaxForm(options);
}

/**
 * Instanciates an ajax form for the hangout url submission
 * @returns void
 */
function initEditForm(){
    $("form","#modal-update-video_session-url").ajaxForm({
        success : onHangoutFormSuccess,
        dataType: 'json'
    });
}

/**
 * Callback to the form submit success
 *
 * @param string data
 * @returns {void}
 */
function onHangoutFormSuccess(data){
    var $hangoutUrlModal = $("#modal-update-video_session-url");

    $hangoutUrlModal
        .html(data.template)
        .show();

    if (data.status === "success") {
        location.href = "/video_session";
    }
}

/**
 * Callback to the Add Video session button
 *
 * @param Event e
 * @returns {void}
 */
function onHangoutAddClicked(e){

    if(googleID === ""){
        triggerModalSuccess({
            id:     "modal-google_login",
            title:  "Asociar cuenta de Google",
            effect: "md-effect-17"
        });
        return true;
    }

    triggerModalSuccess({
        id:     "modal-create-video_session-form",
        title:  "Crear Sesión de Video",
        effect: "md-effect-17"
    });
}

/**
 *
 * @param {type} $tr
 * @returns {void}
 */
function onHangoutEditClicked(e){
    var $this   = $(this);
    var $cont   = $("#modal-edit-video_session-form-container");
    var href    = $this.attr("href");

    e.preventDefault();

    $cont.text("Cargando...");

    triggerModalSuccess({
        id      : "modal-edit-video_session-form",
        title   : "Editar sesión de video",
        effect  : "md-effect-17"
    });

    $.get(href,function(data){
        $cont.html(data.template);
        $("[name='video_session[course_id]']",$cont).bind("change", onCourseChange).trigger("change");
        $("form",$cont).ajaxForm({
            success : onHangoutFormSuccess,
            dataType: 'json'
        });
    },"json");
}

/**
 *
 * @param {type} $tr
 * @returns {void}
 */
function onHangoutFinishTriggered(e){
    var $this       = $(this);
    var id          = $this.closest("tr").attr("data-id");
    var modal_id    = "modal-finish-video_session";

    $("#"+modal_id).attr("data-video_session_id",id);

    triggerModalSuccess({
        id      : modal_id,
        effect  : "md-effect-17"
    });

}

/**
 *
 * @param {type} $tr
 * @returns {void}
 */
function onHangoutFinishClicked(e){
    var $modal  = $("#modal-finish-video_session");
    var $cont   = $("#modal-finish-video_session-container");
    var id      = $modal.attr("data-video_session_id");

    e.preventDefault();

    $(".message",$cont).hide();
    $(".loading",$cont).show();

    $.get("/video_session/finish/id/"+id,function(data){
        $cont.text(data.template);

        if(data.status === "success"){
            location.href="/video_session";
        }

    },"json");
}

/**
 * Callback triggered when a Start Hangout button is pressd
 *
 * @param jQuery $tr
 * @returns {void}
 */
function onHangoutStartClicked($tr){
    var $hangoutUrlModal    = $("#modal-update-video_session-url");
    var $hidden             = $("[name=video_session_id]",$hangoutUrlModal);
    var id                  = $tr.attr("data-id");

    /*
     * TODO: Checkear si se aplicara reestriccion
    if( !canStartVideoSession( $tr ) ){
        e.preventDefault();
        return false;
    }
    */

    $hidden.val(id);

    triggerModalSuccess({
        id      : "modal-update-video_session-url",
        title   : "Guardar URL de Hangout",
        effect  : "md-effect-17"
    });

}

/**
 * Callback to window onBlur
 * @returns {void}
 */
function onWindowBlured(){
    if(iframeMouseOver){
        setTimeout(function(){
            onHangoutStartClicked($hoveredEl);
        },10);
    }
}

/**
 *
 * @param {type} $tr
 * @returns {Boolean} if conditions are passed
 */
function canStartVideoSession( $tr ){
    var curDateTime = new Date();
    var dateparts   = $tr.attr("data-scheduled_for").split(" ");
    var a_hanDate   = dateparts[0].split("-");
    var a_hanTime   = dateparts[1].split(":");
    var hanDateTime = new Date( a_hanDate[0], a_hanDate[1]-1, a_hanDate[2],a_hanTime[0],a_hanTime[1],a_hanTime[2] );
    var datesDiff   = curDateTime - hanDateTime;
    var diffMins    = datesDiff / 1000 / 3600;

    return (diffMins > vsTolerance*-1);

}

/**
 *
 * @returns {undefined}
 */
function onCourseChange(){
    var $this       = $(this);
    var $form       = $this.parents("form");
    var $chapters   = $form.find("[name='video_session[chapter_id]']");
    var chapter_id  = $form.find(".chapter_id").val();

    if(!$this.val()) return false;

    $.getJSON('/video_session/get_course_chapters/id/'+$this.val(),function(data){
        if(data.status === "success"){
            $("option",$chapters).remove();

            for(i in data.template){

                var chapter = data.template[i];

                $chapters.append(
                    $("<option />",{
                        'value' : chapter.id
                    }).text(chapter.name)
                );

                $("option[value="+chapter_id+"]",$chapters).attr("selected","selected");
            }
        }
    });
}

/**
 *
 * @param {type} obj
 * @returns {undefined}
 */
function onGoogleLogin(authResult) {
    if (authResult['status']['signed_in']) {
        gapi.client.load('plus','v1', function(){
            var request = gapi.client.plus.people.get({
                'userId': 'me'
            });
            request.execute(function(resp) {
                $.getJSON('/video_session/update_user_googleid?google_id='+resp.id,function(data){
                    if(data.status === "success"){
                        alert("yaiii");
                        location.href="/video_session";
                    }else{
                        alert(data.template);
                    }
                });
            });
        });
    } else {
        console.log('Sign-in state: ' + authResult['error']);
    }
}