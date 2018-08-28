<?php defined( 'VCW_INDEX' ) or die( '' );

if(!class_exists('VCW_Data'))
{
    class VCW_Data
    {
        static protected $data;

        static public function init()
        {
            $data = null;
            $last_update = null;
            $time_now = time();

            VCW_Storage::fetch($data, $last_update);

            if (!is_array($data)
                || !isset($data['cryptocurrencies'])
                || !isset($data['rates'])
                || $last_update === 0
                || $time_now > $last_update + VCW_Contants::$update_interval) {

                try {
                    $cmc_data =     self::requestCoinMarketCap();
                    $bitpay_data =  self::requestBitPay();

                    $data = self::parseData($cmc_data, $bitpay_data);

                    if (is_array($data)) {
                        VCW_Storage::save($data);
                    }
                }
                catch (Exception $e) {
                    $data = null;
                }
            }

            self::$data = $data;
        }

        static protected function request($url)
        {
            $ch = curl_init();
            $headers = array(
                'Accept: application/json',
                'Content-Type: application/json',
            );
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $response = curl_exec($ch);
            curl_close($ch);

            return $response;
        }

        static protected function requestCoinMarketCap()
        {
            $cmd_json = self::request('https://api.coinmarketcap.com/v1/ticker/?limit=0');
            $cmc_data = json_decode($cmd_json, true);

            return is_array($cmc_data) ? $cmc_data : null;
        }

        static protected function requestBitPay()
        {
            $bitpay_json = self::request('https://bitpay.com/api/rates');
            $bitpay_data = json_decode($bitpay_json, true);

            return is_array($bitpay_data) ? $bitpay_data : null;
        }

        static protected function parseData(&$cmc_data, &$bitpay_data)
        {

            if (!is_array($cmc_data) || !is_array($bitpay_data))
                return null;

            $rates = array('BTC' => array(
                'code' => 'BTC',
                'name' => 'Bitcoin',
                'rate' => 1
            ));

            $cryptocurrencies = array();
            $usd_to_btc = null;

            foreach ($bitpay_data as $currency) {
                $code = $currency['code'];
                $rate = $currency['rate'];

                if ($code !== 'BTC') {
                    $rates[$code] = array(
                        'code' => $code,
                        'name' => $currency['name'],
                        'rate' => $rate !== null ? floatval($rate) : null
                    );
                }

                if ($code === 'USD') {
                    $usd_to_btc = $rates[$code]['rate'];
                }
            }

            if (!$usd_to_btc) return null;


            foreach ($cmc_data as $info) {
                $code = $info['symbol'];
                $name = $info['name'];
                $price_btc = $info['price_btc'] !== null ? floatval($info['price_btc']) : null;
                $rate = $price_btc !== null ? 1 / $price_btc : null;

                if ($code !== 'BTC') {
                    $rates[$code] = array(
                        'code' => $code,
                        'name' => $name,
                        'rate' => $rate
                    );
                }

                $cryptocurrencies[$code] = array(
                    'code'              => $code,
                    'name'              => $name,
                    'rank'              => $info['rank'],
                    'price_btc'         => $price_btc,
                    'market_cap_btc'    => $info['market_cap_usd'] !== null ? floatval($info['market_cap_usd']) / $usd_to_btc : null,
                    'volume_24h_btc'    => $info['24h_volume_usd'] !== null ? floatval($info['24h_volume_usd']) / $usd_to_btc : null,
                    'change_1h'         => $info['percent_change_1h'] !== null ? floatval($info['percent_change_1h']) : null,
                    'change_24h'        => $info['percent_change_24h'] !== null ? floatval($info['percent_change_24h']) : null,
                    'change_7d'         => $info['percent_change_7d'] !== null ? floatval($info['percent_change_7d']) : null,
                    'available_units'   => $info['available_supply'],
                    'max_units'         => $info['max_supply']
                );

            }

            return array(
                'rates' => $rates,
                'cryptocurrencies' => $cryptocurrencies
            );
        }

        static public function cryptoCurrency($code, $default = null)
        {
            return is_array(self::$data) && isset(self::$data['cryptocurrencies']) && isset(self::$data['cryptocurrencies'][$code]) ?
                self::$data['cryptocurrencies'][$code] : $default;
        }

        static public function cryptoCurrencies($default = null)
        {
            return is_array(self::$data) && isset(self::$data['cryptocurrencies']) ?
                self::$data['cryptocurrencies'] : $default;
        }

        static public function cryptoCurrenciesTop($n = 10)
        {
            $all = self::cryptoCurrencies();

            if(is_array($all)) {
                return array_slice($all, 0, $n);
            }

            return null;
        }

        static public function rate($code, $default = null)
        {
            return is_array(self::$data) && isset(self::$data['rates']) && isset(self::$data['rates'][$code]) ?
                self::$data['rates'][$code] : $default;
        }

        static public function rates($default = null)
        {
            return is_array(self::$data) && isset(self::$data['rates']) ?
                self::$data['rates'] : $default;
        }

    }

    VCW_Data::init();
}


