var vsTolerance     = 15;
var iframeMouseOver = false;
var $hoveredEl      = {};

$(function(){

    //Avoids disabled buttons to work
    $(".disabled").click(function(e){ e.preventDefault(); });

    //Hangout create form init and processing
    initAddVideoSessionForm()

    //When a teacher clicks on the Add Hangout button a modal form is shown
    $(".addVideoSession-button").click( onVideoSessionAddClicked );

    //When a teacher clicks on the Edit Hangout button a modal form is shown
    $(".editVideoSession-button").click( onVideoSessionEditClicked );

    //When a teacher clicks on the Finish Hangout button a modal form is shown
    $(".finishVideoSession-trigger").click( onVideoSessionFinishTriggered );

    //When a teacher confirms to finish a video session
    $(".finishVideoSession-button").click( onVideoSessionFinishClicked );

    $("[data-toggle=tooltip]").tooltip();

    if(!$(".video_session-nav li.active").length){
        $(".video_session-nav li:first").addClass("active");
    }

    if(!$(".video_session-tab_container.active").length){
        $(".video_session-tab_container:first").addClass("active");
    }
    
    $(".btn-participants").click( showParticipants );
    
    $("#modal-participants .md-close").click( function(){
        $("#modal-participants table").thfloat('destroy');
    } );
    
    $(window).scroll( function(){ $("#modal-participants table").thfloat('refresh'); } );
    
    //auto refresh sessions to see if there are newly availables
    setTimeout(refreshVideoSessions,5000);
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
                $("[name='video_session[course_id]']",$container).unbind().bind("change", onCourseChange).trigger("change");
                $("[name='video_session[visibility]']",$container).unbind().bind("change", onVisibilityChange).trigger("change");
                $("form",$container).ajaxForm(options);
            }
        },
        dataType: 'json',
        beforeSerialize: mapParticipants
    };

    $("form",$container).ajaxForm(options);
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
    var $modal = $("#modal-create-video_session-form");

    //If the professor doesn't have a google id, is asked to be registered
    if(googleID === "" && platform === "hangouts"){
        triggerModalSuccess({
            id:     "modal-google_login",
            title:  "Asociar cuenta de Google",
            effect: "md-effect-17"
        });
        return true;
    }

    //Else:
    $("#video_session_type").val("class");
    $("#video_session_platform").val(platform);

    triggerModalSuccess({
        id:     $modal.attr("id"),
        title:  "Crear sesión de video",
        effect: "md-effect-17"
    });

    $("[name='video_session[course_id]']",$modal).unbind().bind("change", onCourseChange).trigger("change");
    $("[name='video_session[visibility]']",$modal).unbind().bind("change", onVisibilityChange).trigger("change");
    
    if(platform === "external") {
        //show url
        $("[for='video_session_url']",$modal).show();
        $("[name='video_session[url]']",$modal).show();
    } else {
        //hide url
        $("[for='video_session_url']",$modal).hide();
        $("[name='video_session\[url]']",$modal).hide();
    }
}

/**
 *
 * @param {type} $tr
 * @returns {void}
 */
function onVideoSessionEditClicked(e){
    var $this   = $(this);
    var $cont   = $("#modal-edit-video_session-form-container");
    var $form   = $("#modal-edit-video_session-form");
    var href    = $this.attr("href");

    e.preventDefault();

    $cont.text("Cargando...");

    triggerModalSuccess({
        id      : $form.attr("id"),
        title   : "Editar sesión de video",
        effect  : "md-effect-17"
    });

    $.get(href,function(data){
        $cont.html(data.template);
        $("[name='video_session[course_id]']",$cont).unbind().bind("change", onCourseChange).trigger("change");
        $("[name='video_session[visibility]']",$cont).unbind().bind("change", onVisibilityChange).trigger("change");
        $("form",$cont).ajaxForm({
            success : onHangoutFormSuccess,
            beforeSerialize: mapParticipants,
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
    var $this   = $(this);
    var id      = $this.closest("tr").attr("data-id");
    var $modal  = $("#modal-finish-video_session");

    $modal.attr("data-video_session_id",id);

    triggerModalSuccess({
        id      : $modal.attr("id"),
        effect  : "md-effect-17"
    });

}

/**
 *
 * @param {jQuery} $tr
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
    var $cStudents  = $(".contUsers");
    var chapter_id  = $form.find(".chapter_id").val();

    if(!$this.val()) return false;

    //Gets the current course lessons
    getCourseChapters(chapter_id,$this.val(),$chapters);

    //Gets the current course students if it's private
    if($("[name='video_session[visibility]']",$form).val() == "private"){
        getCourseStudents($this.val(),$cStudents,$form);
    }
}

/**
 *
 * @returns {Boolean}
 */
function onVisibilityChange(){
    var $this           = $(this);
    var $form           = $this.parents("form");
    var $userSelection  = $(".usersSelection");

    if($this.val() == "private"){
        $("[name='video_session[course_id]']",$form).unbind().bind("change", onCourseChange).trigger("change");
        $userSelection.slideDown(500);
        return true;
    }
    $userSelection.slideUp(500);
    return true;
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

/**
 * Selects or deselects a student
 * @returns {Boolean}
 */
function onStudentClicked(){

    $(this).toggleClass("selected");

}

/**
 *
 * @param {Form} $form
 * @param {Object} options
 * @returns {void}
 */
function mapParticipants($form, options) {

    var ids = "";

    $.map( $(".student.selected",$form), function( val, i ) {
        ids+=$(val).attr("data-id")+',';
    });
    $(".students_ids",$form).val(ids.replace(/,(?=[^,]*$)/, ''));
}

/**
 *
 * @param {string} course_id
 * @param {jQuery} $chapters
 * @returns {void}
 */
function getCourseChapters(chapter_id,course_id,$chapters){
    $.getJSON('/video_session/get_course_chapters/id/'+course_id,function(data){
        if(data.status === "success"){

            $("option",$chapters).remove();

            for(i in data.template){

                var chapter = data.template[i];

                $chapters.append(
                    $("<option />",{
                        'value' : chapter.id
                    }).text(chapter.name)
                );
            }

            $("option[value="+chapter_id+"]",$chapters).attr("selected","selected");
        }
    });
}

/**
 *
 * @param {string} course_id
 * @param {jQuery} $cStudents
 * @param {jQuery} $form
 * @returns {void}
 */
function getCourseStudents(course_id,$cStudents,$form){
    $.getJSON('/video_session/get_course_students/id/'+course_id,function(data){

        if(data.status === "success"){
            $cStudents.html("");

            var students_ids = $(".students_ids",$form).val().split(",");

            if(data.template.length > 0){

                for(var i in data.template){

                    var student = data.template[i];
                    var isSelected = students_ids.indexOf(student.id) > -1;

                    $cStudents.append(
                        $("<div class='student"+(isSelected ? " selected" : "")+"' data-id='"+student.id+"' />")
                            //.append($("<div class='avatar'><img src='"+student.avatarPath+student.avatar+"' /></div>"))
                            .append($("<div class='info'>"+student.name+"</div>"))
                            .append($("<div class='clearfix' />"))
                    );

                    if(i>1 && i%2==1){
                        $cStudents.append($("<div class='clearfix' />"));
                    }

                }
                $(".student").bind("click", onStudentClicked);
            }else{
                $cStudents.text("El curso seleccionado no posee alumnos activos");
            }
        }
    });
}

function refreshVideoSessions() {

    var ids = Array();
    
    //get only next courses
    $("#pane-own_video_sessions_next .video-session-tr, #pane-related_video_sessions_next .video-session-tr").each(function(){
       ids.push($(this).attr("data-id")); 
    });


    //post and process json response
    if(ids.length){
        $.ajax('/kuepa_api.php/video_session',{
            dataType: 'json',
            type: 'get',
            data: {id: ids},
            success: function(data){
                for(var i in data){
                    var id = data[i].id;
                    var status = data[i].status;
                    var url = data[i].url;
                    
                    if( status !== "started" || url === null )
                        $(".access-button-"+id).addClass("disabled");
                    else {
                        $(".access-button-"+id).unbind("click");
                        $(".access-button-"+id).removeClass("disabled");
                        $(".access-button-"+id).attr("href", url);
                    }
                }
                        
                setTimeout(refreshVideoSessions,5000);
            }
        });
    }
}


function showParticipants() {

    var videoSessionId = $(this).attr("rel");
    
    //$("#modal-participants table").thfloat( {attachment : "#modal-participants-container"} );
        
    $.ajax('/kuepa_api.php/video_session/' + videoSessionId + '/participants',{
        dataType: 'json',
        type: 'get',
        data: {},
        success: function(participants){
            $("#modal-participants-container").html(new EJS({url: "/js/templates/video_sessions/participants.ejs"}).render({participants: participants}));

            var $modal  = $("#modal-participants");
            
            triggerModalSuccess({
                id      : $modal.attr("id"),
                effect  : "md-effect-17"
            });
                        
            $("#modal-participants-container").scrollTop(0);
            
            $("#modal-participants table").thfloat( {attachment : "#modal-participants-container"} );
            $(".thfloat").css('visibility', 'hidden');
            $(".thfloat tr").css('visibility', 'hidden');
            $(".thfloat th").css('visibility', 'hidden');
            
            setTimeout(
                        function(){
                            $("#modal-participants table").thfloat('refresh');
                            $("#modal-participants table").thfloat( {attachment : "#modal-participants-container"} );
                            $(".thfloat").css('visibility', 'visible');
                            $(".thfloat tr").css('visibility', 'visible');
                            $(".thfloat th").css('visibility', 'visible');
                            },
                        500
            );
            
        } 
    });
    
}