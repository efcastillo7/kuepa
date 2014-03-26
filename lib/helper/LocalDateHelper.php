<?php
function utcToLocalDate($originedatetime, $format = 'g')
{
    if (class_exists('sfContext', false) && sfContext::hasInstance() && sfConfig::get('sf_i18n'))
    {
        $timezone = sfContext::getInstance()->getUser()->getTimezone();
        if (!empty($timezone) && ($newtimezone = new DateTimeZone($timezone)))
        {
            $datetime = new DateTime($originedatetime);
            $datetime->setTimezone($newtimezone);
            $originedatetime = $datetime->format("Y-m-d H:i:s");
        }
    }
    if (function_exists('format_date'))
    {
        return format_date($originedatetime, $format);
    }
    return $originedatetime;
}