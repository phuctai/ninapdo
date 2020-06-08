<?php
    class statistic
    {
        private $d;

        public function __construct($d)
        {
            $this->d = $d;
        }

        public function getCounter()
        {
            $locktime = 15 * 60;
            $initialvalue = 1;
            $records = 100000;
            $day = date('d');
            $month = date('n');
            $year = date('Y');

            /* Day start */
            $daystart = mktime(0,0,0,$month,$day,$year);

            /* Month start */
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
            
            $t = $this->d->rawQueryOne("SELECT MAX(id) AS total FROM table_counter");
            $all_visitors = $t['total'];
            
            if($all_visitors !== NULL) $all_visitors += $initialvalue;
            else $all_visitors = $initialvalue;
            
            /* Delete old records */
            $temp = $all_visitors - $records;

            if($temp>0) $this->d->rawQuery("DELETE FROM table_counter WHERE id < '$temp'");
            
            $vip = $this->d->rawQueryOne("SELECT COUNT(*) AS visitip FROM table_counter WHERE ip='$ip' AND (tm+'$locktime')>'$now'");
            $items = $vip['visitip'];
            
            if(empty($items)) $this->d->rawQuery("INSERT INTO table_counter (tm, ip) VALUES ('$now', '$ip')");
            
            $n = $all_visitors;
            $div = 100000;
            while ($n > $div) $div *= 10;

            $todayrec = $this->d->rawQueryOne("SELECT COUNT(*) AS todayrecord FROM table_counter WHERE tm>'$daystart'");
            $yesrec = $this->d->rawQueryOne("SELECT COUNT(*) AS yesterdayrec FROM table_counter WHERE tm>'$yesterdaystart' and tm<'$daystart'");
            $weekrec = $this->d->rawQueryOne("SELECT COUNT(*) AS weekrec FROM table_counter WHERE tm>='$weekstart'");
            $monthrec = $this->d->rawQueryOne("SELECT COUNT(*) AS monthrec FROM table_counter WHERE tm>='$monthstart'");
            $totalrec = $this->d->rawQueryOne("SELECT MAX(id) AS totalrec FROM table_counter");

            $result['today'] = $todayrec['todayrecord'];
            $result['yesterday'] = $yesrec['yesterdayrec'];
            $result['week'] = $weekrec['weekrec'];
            $result['month'] = $monthrec['monthrec'];
            $result['total'] = $totalrec['totalrec'];

            return $result;
        }

        public function getOnline()
        {
            $session = session_id();
            $time = time();
            $time_check = $time - 600;
            $ip = $_SERVER['REMOTE_ADDR'];

            $result = $this->d->rawQuery("SELECT * FROM table_user_online WHERE session = ?",array($session));
            
            if(count($result) == 0)
            {
                $this->d->rawQuery("INSERT INTO table_user_online(session,time,ip) VALUES(?,?,?)",array($session,$time,$ip));
            }
            else
            {
                $this->d->rawQuery("UPDATE table_user_online SET time = ? WHERE session = ?",array($time,$session));
            }

            $this->d->rawQuery("DELETE FROM table_user_online WHERE time < $time_check");

            $user_online = $this->d->rawQuery("SELECT * FROM table_user_online");
            $user_online = count($user_online);

            return $user_online;
        }
    }
?>