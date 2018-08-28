<?php defined( 'VCW_INDEX' ) or die( '' );

if(!class_exists('VCW_Helpers')) {

    class VCW_Helpers
    {
        static public function price_format($number)
        {
            $dec_point      = VCW_Contants::$number_dec_point;
            $thousands_sep  = VCW_Contants::$number_thousands_sep;

            if($number >= 1) {
                $output = number_format($number,2, $dec_point, $thousands_sep);
            }
            else if($number < 1 && $number > 0.1) {
                $output = number_format($number,3, $dec_point, $thousands_sep);
            }
            else if($number <= 0.1 && $number > 0.01) {
                $output = number_format($number,4, $dec_point, $thousands_sep);
            }
            else if($number <= 0.01 && $number > 0.001) {
                $output = number_format($number,5, $dec_point, $thousands_sep);
            }
            else if($number <= 0.001 && $number > 0.0001) {
                $output = number_format($number,6, $dec_point, $thousands_sep);
            }
            else if($number <= 0.0001 && $number > 0.00001) {
                $output = number_format($number,7, $dec_point, $thousands_sep);
            }
            else {
                $output = sprintf('%.2e', $number);
            }

            return $output;
        }

        static public function big_number($number) {
            return number_format($number,0, VCW_Contants::$number_dec_point, VCW_Contants::$number_thousands_sep);
        }

        static public function checkArrayValues(&$array, $keys = null, $test = null)
        {
            if(!is_array($array))
                return false;

            if(is_null($keys)) {
                foreach ($array as $key => $value){
                    if($test) {
                        if(!call_user_func($test, $value))
                            return false;
                    }
                    else if(!isset($array[$key])) {
                        return false;
                    }
                }
            }
            else if(is_array($keys)) {
                foreach ($keys as $key){
                    if($test) {
                        if(!array_key_exists($key, $array) || !call_user_func($test, $array[$key]))
                            return false;
                    }
                    else if(!isset($array[$key])) {
                        return false;
                    }
                }
            }
            else {
                return false;
            }

            return true;
        }

        static public function quotation($rate, $price_btc, $show_code = true) {
            if(!$rate || !$rate['rate'] || !$price_btc) {
                return '---';
            }
            else {
                $price = self::price_format($rate['rate'] * $price_btc);
                return $show_code ? "{$rate['code']} $price" : $price;
            }
        }

        static public function changeString($change, $percent_sign = true)
        {
            $dec_point      = VCW_Contants::$number_dec_point;
            $thousands_sep  = VCW_Contants::$number_thousands_sep;

            if(is_null($change)) {
                return '---';
            }
            else {
                $change_str = number_format(abs($change), 2, $dec_point, $thousands_sep);
                return $percent_sign ? "$change_str %" : $change_str;
            }
        }

        static public function defaultTableWidgetItems($count)
        {
            $f_count = floatval($count);

            $top = VCW_Data::cryptoCurrenciesTop($f_count > 0 ? $f_count : 10);

            if(is_array($top)){
                return array_map(function($c) {
                    return $c['code'];
                }, $top);
            }

            return null;
        }

    }

}