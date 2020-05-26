<?php  
    $locktime = 15;
    $initialvalue = 1;
    $records = 100000;
    $locktime = $locktime * 60;

    /* Month start */
    $day = date('d');
    $month = date('n');
    $year = date('Y');
    $daystart = mktime(0,0,0,$month,$day,$year);
    $monthstart = mktime(0,0,0,$month,1,$year);
    
    /* Week start */
    $weekday = date('w');
    $weekday--;
    if($weekday < 0) $weekday = 7;
    $weekday = $weekday * 24*60*60;
    $weekstart = $daystart - $weekday;

    /* Yesterday start */
    $yesterdaystart = $daystart - (24*60*60);
    $now = time();
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $t = $d->rawQueryOne("SELECT MAX(id) AS total FROM table_counter");
    $all_visitors = $t['total'];
    
    if($all_visitors !== NULL) $all_visitors += $initialvalue;
    else $all_visitors = $initialvalue;
    
    /* Delete old records */
    $temp = $all_visitors - $records;

    if($temp>0) $d->rawQuery("DELETE FROM table_counter WHERE id < '$temp'");
    
    $vip = $d->rawQueryOne("SELECT COUNT(*) AS visitip FROM table_counter WHERE ip='$ip' AND (tm+'$locktime')>'$now'");
    $items = $vip['visitip'];
    
    if(empty($items)) $d->rawQuery("INSERT INTO table_counter (tm, ip) VALUES ('$now', '$ip')");
    
    $n = $all_visitors;
    $div = 100000;
    while ($n > $div) $div *= 10;

    $todayrec = $d->rawQueryOne("SELECT COUNT(*) AS todayrecord FROM table_counter WHERE tm>'$daystart'");
    $today_visitors = $todayrec['todayrecord'];
    
    $yesrec = $d->rawQueryOne("SELECT COUNT(*) AS yesterdayrec FROM table_counter WHERE tm>'$yesterdaystart' and tm<'$daystart'");
    $yesterday_visitors = $yesrec['yesterdayrec'];

    $weekrec = $d->rawQueryOne("SELECT COUNT(*) AS weekrec FROM table_counter WHERE tm>='$weekstart'");
    $week_visitors = $weekrec['weekrec'];

    $monthrec = $d->rawQueryOne("SELECT COUNT(*) AS monthrec FROM table_counter WHERE tm>='$monthstart'");
    $month_visitors = $monthrec['monthrec'];
   
    /* User online */
    $session = session_id();
    $time = time();
    $time_check = $time - 600; // Set thời gian kiểm tra là 10 phút
    $ip = $_SERVER['REMOTE_ADDR'];

    $result = $d->rawQuery("SELECT * FROM table_user_online WHERE session = ?",array($session));
    
    if(count($result) == 0) $d->rawQuery("INSERT INTO table_user_online(session,time,ip) VALUES(?,?,?)",array($session,$time,$ip));
    else $d->rawQuery("UPDATE table_user_online SET time = ? WHERE session = ?",array($time,$session));

    /* Nếu quá 10 phút mà ko thấy session này làm việc thì tiến hành xóa */
    $d->rawQuery("DELETE FROM table_user_online WHERE time < $time_check");

    /* Lấy all users online */
    $user_online = $d->rawQuery("SELECT * FROM table_user_online");
    $user_online = count($user_online);
?>