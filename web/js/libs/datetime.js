function timeSince(date) {

    var seconds = Math.floor((new Date() - date) / 1000);

    var interval = Math.floor(seconds / 31536000);

    var ret = "Hace ";

    if (interval > 1) {
        return ret + interval    + " años";
    }
    interval = Math.floor(seconds / 2592000);
    if (interval > 1) {
        return ret + interval + " meses";
    }
    interval = Math.floor(seconds / 86400);
    if (interval > 1) {
        return ret + interval + " dias";
    }
    interval = Math.floor(seconds / 3600);
    if (interval > 1) {
        return ret + interval + " horas";
    }
    interval = Math.floor(seconds / 60);
    if (interval > 1) {
        return ret + interval + " minutos";
    }
    if(seconds > 10){
        return ret + Math.floor(seconds) + " segundos";
    }

    //is very recent
    var ndate = new Date(date);

    return "A las " + ndate.getHours() + ":" + ndate.getMinutes() + "hs";

}

Date.createFromMysql = function(mysql_string)
{ 
   if(typeof mysql_string === 'string')
   {
      var t = mysql_string.split(/[- :]/);

      //when t[3], t[4] and t[5] are missing they defaults to zero
      return new Date(t[0], t[1] - 1, t[2], t[3] || 0, t[4] || 0, t[5] || 0);
   }

   return null;   
}