<?php
class stdDates{
  /**
   * Calculated the number of weekdays (M-F) between two timestamps (inclusive).
   *
   * @param string $from the timestamp to start measuring from
   * @param string $to the timestamp to stop measuring at
   * @param string $normalise whether the time of day should be ignored (forces times to yyyy-mm-ddT00:00:00+00:00)
   * @return int the number of weekdays between the two timestamps
   * @author Matt Harris
   */
  public static function weekday_diff($from, $to, $normalise=true) {
    $_from = is_int($from) ? $from : strtotime($from);
    $_to   = is_int($to) ? $to : strtotime($to);
 
    // normalising means partial days are counted as a complete day.
    if ($normalise) {
      $_from = strtotime(date('Y-m-d', $_from));
      $_to = strtotime(date('Y-m-d', $_to));
    }
 
    $all_days = @range($_from, $_to, 60*60*24);
 
    if (empty($all_days)) return 0;
 
    $week_days = array_filter(
      $all_days,
      create_function('$t', '$d = date("w", strtotime("+{$t} seconds", 0)); return !in_array($d, array(0,6));')
    );
 
    return count($week_days);
  }
}