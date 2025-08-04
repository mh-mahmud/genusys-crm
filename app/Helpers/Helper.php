<?php


namespace App\Helpers;
use App\Models\Logs;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
class Helper
{
    public static function generateTableId() 
    {
        $microtime = explode(' ', microtime());
        $genaratedId = (int)round($microtime[0] * 1000000) + $microtime[1];
        return $genaratedId.rand(1000, 9999);
    }
    public static function slugify($value)
    {

        return strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $value));

    }

    public static function storeLog($log_text, $module_name, $sub_module_name, $lead_id=null, $user_id = null)
    {
        $log                    = new Logs();
        $log->user_id           = $user_id ?? Auth::id();
        $log->lead_id           = $lead_id;
        $log->module            = $module_name;
        $log->sub_module        = $sub_module_name;
        // $log->log_message       = $log_text." => ".$module_name." => ".$action;
        $log->log_message       = $log_text;
        $log->status            = 1;
        $log->save();
    }

    public static function getEnumValues($table, $column)
    {
        $query = "SHOW COLUMNS FROM `{$table}` WHERE Field = '{$column}'";
        $result = DB::select($query);
        if (!empty($result)) {
            $type = $result[0]->Type;
            // Use regex to extract the enum values
            preg_match('/^enum\((.*)\)$/', $type, $matches);
            if (isset($matches[1])) {
                $enum = array_map(function ($value) {
                    return trim($value, "'");
                }, explode(',', $matches[1]));
                return $enum;
            }
        }
        return [];
    }

    public static function getLeads() 
    {
        // if (Auth::user()->user_type === 'admin') {
            return DB::table('leads')
                    ->select('id', 'first_name', 'last_name', 'email', 'phone')
                    ->where('lead_status', 1)
                    ->get();
        // } else {
        //     return DB::table('leads')
        //             ->select('id', 'first_name', 'last_name', 'email', 'phone')
        //             ->where('lead_status', 1)
        //             ->where('created_by', Auth::user()->id)
        //             ->get();
        // }

    }

    /**
     * If date is valid then return ture otherwise false
     * @return Bool
     */
    public static function isDateValid($date, $format)
    {
        $validator = Validator::make(['date' => $date], ['date' => "date|date_format:{$format}"]);
        return !$validator->fails();
    }

    public static function isDateRangeValid($startDate, $endDate):bool{
        if(strtotime($startDate) > strtotime($endDate)){// Start date is after end date
            return false;
        }
        $startDate  = Carbon::parse($startDate);
        $endDate    = Carbon::parse($endDate);
        return config('constants.MAX_REPORT_DAYS') >= $startDate->diffInDays($endDate);
    }

    public static function convertNumberToWords_backup_03032025($number) {
        if ($number == 0) {
            return 'zero taka';
        }
    
        // Define arrays for words
        $ones = array(
            "", "one", "two", "three", "four", "five",
            "six", "seven", "eight", "nine", "ten",
            "eleven", "twelve", "thirteen", "fourteen",
            "fifteen", "sixteen", "seventeen", "eighteen", "nineteen"
        );
        $tens = array(
            "", "", "twenty", "thirty", "forty", "fifty",
            "sixty", "seventy", "eighty", "ninety"
        );
        $thousands = array(
            "", "thousand", "million", "billion", "trillion"
        );
    
        // Helper function to convert three-digit numbers
        function convertThreeDigits($num, $ones, $tens) {
            $result = "";
    
            if ($num >= 100) {
                $result .= $ones[intval($num / 100)] . " hundred ";
                $num %= 100;
            }
            if ($num >= 20) {
                $result .= $tens[intval($num / 10)] . " ";
                $num %= 10;
            }
            if ($num > 0) {
                $result .= $ones[$num] . " ";
            }
    
            return trim($result);
        }
    
        // Split number into integer and decimal parts
        $integerPart = intval($number);
        $decimalPart = round($number - $integerPart, 2) * 100; // Extract 2 decimal places
    
        $words = "";
        $place = 0;
    
        // Convert the integer part
        while ($integerPart > 0) {
            $chunk = $integerPart % 1000; // Get the last three digits
            if ($chunk > 0) {
                $words = convertThreeDigits($chunk, $ones, $tens) . " " . $thousands[$place] . " " . $words;
            }
            $integerPart = intval($integerPart / 1000); // Remove the last three digits
            $place++;
        }
    
        $words = trim($words) . " taka";
    
        // Add decimal part if exists
        if ($decimalPart > 0) {
            $words .= " and " . convertThreeDigits($decimalPart, $ones, $tens) . " paisa";
        }
    
        return $words;
    }




     // convert number to words
     public static function convertNumberToWords($number) {
        if ($number == 0) {
            return 'zero taka';
        }

        //define arrays for words
        $ones = array(
            "", "one", "two", "three", "four", "five",
            "six", "seven", "eight", "nine", "ten",
            "eleven", "twelve", "thirteen", "fourteen",
            "fifteen", "sixteen", "seventeen", "eighteen", "nineteen"
        );
        $tens = array(
            "", "", "twenty", "thirty", "forty", "fifty",
            "sixty", "seventy", "eighty", "ninety"
        );
        $thousands = array(
            "", "thousand", "million", "billion", "trillion"
        );

        // split number into integer and decimal parts
        $integerPart = intval($number);
        $decimalPart = round($number - $integerPart, 2) * 100; // Extract 2 decimal places

        $words = "";
        $place = 0;

        //convert the integer part
        while ($integerPart > 0) {
            $chunk = $integerPart % 1000; // get the last three digits
            if ($chunk > 0) {
                $words = self::convertThreeDigits($chunk, $ones, $tens) . " " . $thousands[$place] . " " . $words;
            }
            $integerPart = intval($integerPart / 1000); // remove the last three digits
            $place++;
        }

        $words = trim($words) . " taka";

        // add decimal part if exists
        if ($decimalPart > 0) {
            $words .= " and " . self::convertThreeDigits($decimalPart, $ones, $tens) . " paisa";
        }

        return $words;
    }

    // helper function to convert three digits
    public static function convertThreeDigits($num, $ones, $tens) {
        $result = "";

        if ($num >= 100) {
            $result .= $ones[intval($num / 100)] . " hundred ";
            $num %= 100;
        }
        if ($num >= 20) {
            $result .= $tens[intval($num / 10)] . " ";
            $num %= 10;
        }
        if ($num > 0) {
            $result .= $ones[$num] . " ";
        }

        return trim($result);
    }

    public static function settings() {
        return Settings::first();
    }

    public static function send_sms($phone, $custom_message) {
        // new api code
        $url = "https://sms.novocom-bd.com/api/v2/SendSMS";
        $myObj = new \stdClass();
        $myObj->senderId = "8809638011080";
        $myObj->is_Unicode = false;
        $myObj->is_Flash = false;
        $myObj->dataCoding = 0;
        $myObj->schedTime = "";
        $myObj->groupId = "";
        $myObj->Message = $custom_message;
        $myObj->mobileNumbers = "88".$phone;
        $myObj->serviceId = "";
        $myObj->coRelator = "";
        $myObj->linkId = "";
        $myObj->principleEntityId = "";
        $myObj->templateId = "";
        $myObj->clientId = "66b4a410-c559-4bcd-98d3-ead4e6bf033b";
        $myObj->apiKey = "j21qvq/8AJZmHVNnyyO+2CRwjobe4lqXgYLc3JJoZUQ=";

        $data_string = json_encode($myObj);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $myObj->apiKey
        ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Improved error handling
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return 'CURL Error: ' . curl_error($ch);
        } else {
            return 'API Response: ' . $result;
        }
        curl_close($ch);
    }

     public static function storeNotification($data)
     {
            Notification::create([
                'lead_id' => !empty($data['lead_id']) ? $data['lead_id'] : null,
                'user_id' =>  auth()->id(),
                'notify_by' => $data["notify_by"],
                'notify_msg' => $data["notify_msg"],
                'notify_datetime' => !empty($data["notify_datetime"]) ? $data["notify_datetime"] : Carbon::now(),
                'send_email' => !empty($data["send_email"]) ? 1 : 0,
                'send_sms' => !empty($data["send_sms"]) ? 1 : 0,
                'notify_seen' => 0,
            ]);
     }
    
}