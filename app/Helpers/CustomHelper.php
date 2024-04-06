<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use App\Models\SalaryBreakup;
use App\Models\SalaryCalculations;

class CustomHelper{


    public static function generateRandomString($length = 32) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {

            $randomString .= $characters[rand(0, $charactersLength - 1)];

        }

        return $randomString;

    }

    public static function thousandsCurrencyFormat($num)
    {

        if ($num > 1000)
        {

            $x = round($num);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = array(
                'k',
                'm',
                'b',
                't'
            );
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int)$x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];

            return $x_display;

        }

        return $num;
    }




    public static function formatBytes($bytes, $precision = 2) {
        if ($bytes >= 1073741824)

        {

            $bytes = number_format($bytes / 1073741824, 2) . ' GB';

        }

        elseif ($bytes >= 1048576)

        {

            $bytes = number_format($bytes / 1048576, 2) . ' MB';

        }

        elseif ($bytes >= 1024)

        {

            $bytes = number_format($bytes / 1024, 2) . ' KB';

        }

        elseif ($bytes > 1)

        {

            $bytes = $bytes . ' bytes';

        }

        elseif ($bytes == 1)

        {

            $bytes = $bytes . ' byte';

        }

        else

        {

            $bytes = '0 bytes';

        }



        return $bytes; 

    } 



    public static function getCalculationData($employee_id, $name){

        $sal_cal = SalaryCalculations::where(['employee_id' => $employee_id, 'created_by' => \Auth::user()->creatorId(), 'meta_key' => $name ])->first();

        if($sal_cal){              

            return $sal_cal;

        }else{

            return '';

        }

    }

    public static function getBreakupData($id){

        $sal_breakup = SalaryBreakup::where(['created_by' => \Auth::user()->creatorId(), 'id' => $id ])->first();
        if($sal_breakup){              

            return $sal_breakup;

        }else{

            return '';

        }

    }

    public static function getBaseSalaryData($employee_id){

        $sal_breakup = SalaryBreakup::where(['created_by' => \Auth::user()->creatorId(), 'component_value_type' => 'Base Salary' ])->first();

        $get_salary_value = SalaryCalculations::where(['employee_id' => $employee_id, 'created_by' => \Auth::user()->creatorId(), 'field_id' => $sal_breakup->id ])->first();

        if($get_salary_value){              

            return $get_salary_value->meta_value;

        }else{

            return '0';

        }

    }

    
    public static function currencyFormat($number){

        setlocale(LC_MONETARY,"en_US");

        return number_format($number);

    }



    public static function time_elapsed_string($datetime, $full = false) {

        $time_ago = strtotime($datetime);

        $cur_time   = time();

        $time_elapsed = $cur_time - $time_ago;

        $seconds    = $time_elapsed ;

        $minutes    = round($time_elapsed / 60 );

        $hours      = round($time_elapsed / 3600);

        $days       = round($time_elapsed / 86400 );

        $weeks      = round($time_elapsed / 604800);

        $months     = round($time_elapsed / 2600640 );

        $years      = round($time_elapsed / 31207680 );

        // Seconds

        if($seconds <= 60){

            return "just now";

        }

        //Minutes

        else if($minutes <=60){

            if($minutes==1){

                return "one minute ago";

            }

            else{

                return "$minutes minutes ago";

            }

        }

        //Hours

        else if($hours <=24){

            if($hours==1){

                return "an hour ago";

            }else{

                return "$hours hrs ago";

            }

        }

        //Days

        else if($days <= 7){

            if($days==1){

                return "yesterday";

            }else{

                return "$days days ago";

            }

        }

        //Weeks

        else if($weeks <= 4.3){

            if($weeks==1){

                return "a week ago";

            }else{

                return "$weeks weeks ago";

            }

        }

        //Months

        else if($months <=12){

            if($months==1){

                return "a month ago";

            }else{

                return "$months months ago";

            }

        }

        //Years

        else{

            if($years==1){

                return "one year ago";

            }else{

                return "$years years ago";

            }

        }

    }



    public static function formatTimeString($timeStamp) {

        $str_time = date("Y-m-d H:i:sP", $timeStamp);

        $time = strtotime($str_time);

        $d = new DateTime($str_time);



        $weekDays = ['Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'];

        $months = ['Jan', 'Feb', 'Mar', 'Apr', ' May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];



        if ($time > strtotime('-2 minutes')) {

          return 'Just now';

        } elseif ($time > strtotime('-59 minutes')) {

          $min_diff = floor((strtotime('now') - $time) / 60);

          return $min_diff . ' min' . (($min_diff != 1) ? "s" : "") . ' ago';

        } elseif ($time > strtotime('-23 hours')) {

          $hour_diff = floor((strtotime('now') - $time) / (60 * 60));

          return $hour_diff . ' hour' . (($hour_diff != 1) ? "s" : "") . ' ago';

        } elseif ($time > strtotime('today')) {

          return $d->format('G:i');

        } elseif ($time > strtotime('yesterday')) {

          return 'Yesterday at ' . $d->format('G:i');

        } elseif ($time > strtotime('this week')) {

          return $weekDays[$d->format('N') - 1] . ' at ' . $d->format('G:i');

        } else {

          return $d->format('j') . ' ' . $months[$d->format('n') - 1] .

          (($d->format('Y') != date("Y")) ? $d->format(' Y') : "") .

          ' at ' . $d->format('G:i');

        }



    }

    public static function getNoOfDaysBetweenTwoDates($date1,$date2){

        $dateOne = strtotime($date1);
        $dateTwo = strtotime($date2);
        $diff = $dateTwo - $dateOne;
        $days = floor($diff / (60 * 60 * 24));
        echo $days;

    }

    public static function mssql_escape($unsafe_str) 
    {
        if (get_magic_quotes_gpc())
        {
            $unsafe_str = stripslashes($unsafe_str);
        }
        return $escaped_str = str_replace("'", "''", $unsafe_str);
    }

}