var vsTolerance     = 15;
var iframeMouseOver = false;
var $hoveredEl      = {};

$(function(){

    //Hangout create form init and processing
    initAddVideoSessionForm();

    //Hangout edit form init and processing
    initEditVideoSessionForm();

    //When a teacher clicks on the Add Hangout button a modal form is shown
    $(".addVideoSession-button").click( onVideoSessionAddClicked );

    //When a teacher clicks on the Edit Hangout button a modal form is shown
    $(".editVideoSession-button").click( onVideoSessionEditClicked );

    //When a teacher clicks on the Finish Hangout button a modal form is shown
    $(".finishVideoSession-trigger").click( onVideoSessionFinishTriggered );

    //When a teacher confirms to finish a video session
    $(".finishVideoSession-button").click( onVideoSessionFinishClicked );

    $(".video_session_status").tooltip();

    if(!$(".video_session-nav li.active").length){
        $(".video_session-nav li:first").addClass("active");
    }

    if(!$(".video_session-tab_container.active").length){
        $(".video_session-tab_container:first").addClass("active");
    }

    $("[name='video_session[course_id]']").bind("change", onCourseChange).trigger("change");


});

/**
 * Add Hangout form init and processing
 * @returns void
 */
function initAddVideoSessionForm(){

    var $container  = $("#modal-create-video_session-form-container");
    var options     = {
        success: function(data) {

            $container
                .html(data.template)
                .show();

            if (data.status === "success") {
                location.href = "/video_session";
            } else {
                $("[name='video_session[course_id]']").bind("change", onCourseChange).trigger("change");
                $("form",$container).ajaxForm(options);
            }
        },
        dataType: 'json'
    };

    $("form",$container).ajaxForm(options);
}

/**
 * Instanciates an ajax form for the hangout url submission
 * @returns void
 */
function initEditVideoSessionForm(){
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
function onVideoSessionAddClicked(e){

    var $this = $(this);
    var platform = $this.attr("data-platform");

    if(googleID === "" && platform === "hangouts"){
        triggerModalSuccess({
            id:     "modal-google_login",
            title:  "Asociar cuenta de Google",
            effect: "md-effect-17"
        });
        return true;
    }

    $("#video_session_type").val("class");
    $("#video_session_platform").val(platform);

    triggerModalSuccess({
        id:     "modal-create-video_session-form",
        title:  "Crear sesión de video",
        effect: "md-effect-17"
    });
}

/**
 *
 * @param {type} $tr
 * @returns {void}
 */
function onVideoSessionEditClicked(e){
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
function onVideoSessionFinishTriggered(e){
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
function onVideoSessionFinishClicked(e){
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