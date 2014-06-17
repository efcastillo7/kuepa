var kuepa_api_vs_callback = "http://plataforma.kuepa.com/video_session/update";
var kuepa_api_su_callback = "http://plataforma.kuepa.com/support/create";
var kuepa_api_track_callback = "http://plataforma.kuepa.com/video_session/track_time";
// var kuepa_api_vs_callback = "http://pablo.kibind.com/video_session/update";
// var kuepa_api_su_callback = "http://pablo.kibind.com/support/create";
// var kuepa_api_track_callback = "http://pablo.kibind.com/video_session/track_time";
var track_time_seconds = 10;
var track_time_interval;

gadgets.util.registerOnLoadHandler(init);

/**
 *
 * @returns {undefined}
 */
function init() {
    gapi.hangout.onApiReady.add(onApiReady);
    gapi.hangout.onEnabledParticipantsChanged.add(onParticipantsChanged);
    gapi.hangout.layout.setChatPaneVisible(true);
}


/**
 *
 * @returns {undefined}
 */
function onApiReady(){

    var type = getType();

    //First time
    if(isFirstTime()){
        if(type == "class"){
            $(".aviso.primeraVezClase").show(0);
        }else{
            $(".aviso.primeraVezSoporte").show(0);
        }
        initializeKuepa();
        return true;
    }

    track_time_interval = setInterval(trackTime,track_time_seconds*1000);

    //Recurrent
    if(type == "class"){
        $(".aviso.tutor").show(0);
        checkForProfessor();
        return true;
    }

    if(type == "support"){
        $(".aviso.soporte").show(0);
        checkForSupport();
        return true;
    }

    $(".aviso.error").show(0);
    return false;
}

function onParticipantsChanged(){
    var type = getType();

    if(type == "class"){
        checkForProfessor();
        return true;
    }

    if(type == "support"){
        checkForSupport();
        return true;
    }

    $(".aviso.error").show(0);
    return false;
}

/**
 *
 * @param {type} participants
 * @returns {undefined}
 */
function checkForProfessor(){
    var videoFeed   = gapi.hangout.layout.getDefaultVideoFeed();
    var personId    = getHostPersonId();
    var professor   = findParticipantByPersonID(personId);

    if(professor){
        //Hides the main window (White screen)
        gapi.hangout.hideApp();

        //Sets the professor as the displayed participant
        videoFeed.setDisplayedParticipant(professor.id);

        $(".aviso.tutor").fadeOut(500);

    }else{
        $(".aviso.tutor").fadeIn(500);
    }
}

/**
 *
 * @param {type} participants
 * @returns {undefined}
 */
function checkForSupport(){
    var participants    = gapi.hangout.getEnabledParticipants();
    var videoFeed       = gapi.hangout.layout.getDefaultVideoFeed();

    if(participants.length > 1){

        //Hides the main window (White screen)
        gapi.hangout.hideApp();

        //Sets the professor as the displayed participant
        videoFeed.setDisplayedParticipant(participants[1].id);

        $(".aviso.soporte").fadeOut(500);
    }
}

function initializeKuepa(){

    var type = getType();

    if(type == "class"){
        var data = {
            url: gapi.hangout.getHangoutUrl(),
            profile_id: getProfileId(),
            gid: getCallerPersonId(),
            video_session_id: getVideoSessionId()
        };

        $.post(kuepa_api_vs_callback,data,function(data){
            $(".aviso").hide(0);
            $(".listoClase").show(0);
        });

    }else{
        var data = {
            url: gapi.hangout.getHangoutUrl(),
            gid: getCallerPersonId(),
            profile_id: getProfileId()
        };

        $.post(kuepa_api_su_callback,data,function(data){
            $(".aviso").hide(0);
            $(".aviso.soporte").show(0);
        });
    }

}

/**
 *
 * @returns {Array|Object}
 */
function getAppData(){
    var data = gapi.hangout.getStartData();
    if(data != ""){
        return JSON.parse(data);
    }
    return false;
}

function getStartData(){
    var startData = gadgets.views.getParams()['appData'];
    if(startData != ""){
        return JSON.parse(startData);
    }
    return false;
}

function getType(){
    return __getFromData("type");
}

function getVideoSessionId(){
    return __getFromData("video_session_id");
}

function getProfileId(){
    return __getFromData("profile_id");
}

function __getFromData(var_name){
    var stData = getStartData();
    var apData = getAppData();

    if(!!stData){
        return stData[var_name];
    }

    if(!!apData){
        return apData[var_name];
    }

    return false;
}

/**
 * If its the first time the getStartData returns false
 * @returns {Boolean|Array|Object}
 */
function isFirstTime(){
    var data = getStartData();
    return !!!data.host_person_id;
}

/**
 *
 * @param {type} personID
 * @returns {findParticipantByPersonID.participant|findParticipantByPersonID.participants}
 */
function findParticipantByPersonID(personID){
    var participants = gapi.hangout.getEnabledParticipants();
    for(var i in participants){
        var participant = participants[i];
        if(participant.person.id == personID){
            return participant;
        }
    }
    return false;
}

/**
 *
 * @returns {Boolean|getCallerPersonId.participant|getCallerPersonId.participants}
 */
function getCallerPersonId(){
    var participants    = gapi.hangout.getEnabledParticipants();
    var participant     = participants[0];
    return participant.person.id;
}


/**
 *
 * @returns {participant.person.id}
 */
function getHostPersonId(){
    var dataOb = getAppData();

    if(dataOb.host_person_id){
        return dataOb.host_person_id;
    }

    return false;

}

function trackTime(){
    var data = {
        video_session_id: getVideoSessionId(),
        profile_id: getProfileId(),
        interval: track_time_seconds
    };

    $("#registrando").fadeIn(100);

    $.post(kuepa_api_track_callback,data,function(data){
        $("#registrando").fadeOut(500);
    });
}