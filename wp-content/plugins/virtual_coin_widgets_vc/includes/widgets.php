<?php defined( 'VCW_INDEX' ) or die( '' );

if(!class_exists('VCW_Widget')) {

    abstract class VCW_Widget {

        protected $color         = 'white';
        protected $link_url      = null;
        protected $link_target   = '_self';
        protected $full_width    = false;
        protected $symbol        = 'BTC';
        protected $currency      = 'USD';
        protected $currencies    = array();

        protected $main_class    = '';

        public function setColor($color)
        {
            if(array_key_exists($color, VCW_Contants::$color_schemas)){
                $this->color = $color;
            }
        }

        public function getColor()
        {
            return $this->color;
        }

        public function setLinkURL($url)
        {
            if(is_string($url)){
                $this->link_url = $url;
            }
        }

        public function getLinkURL()
        {
            return $this->link_url;
        }

        public function setLinkTarget($target)
        {
            if($target === '_self' || $target === '_blank'){
                $this->link_target = $target;
            }
        }

        public function getLinkTarget()
        {
            return $this->link_target;
        }

        public function setFullWidth($enable)
        {
            $this->full_width = $enable === true;
        }

        public function getFullWidth()
        {
            return $this->full_width;
        }

        public function setSymbol($symbol)
        {
            if(is_string($symbol)) {
                $this->symbol = $symbol;
            }
        }

        public function getSymbol()
        {
            return $this->symbol;
        }

        public function setCurrency($currency)
        {
            if(is_string($currency)) {
                $this->currency = $currency;
            }
        }

        public function getCurrency()
        {
            return $this->currency;
        }

        public function setCurrencies($currency1, $currency2, $currency3)
        {
            if(is_string($currency1)) {
                $this->currencies[0] = $currency1;
            }

            if(is_string($currency2)) {
                $this->currencies[1] = $currency2;
            }

            if(is_string($currency3)) {
                $this->currencies[2] = $currency3;
            }
        }

        public function getCurrencies()
        {
            return $this->currencies;
        }

        public function classes()
        {
            $classes = "vcw vcw-$this->main_class vcw-$this->color";

            if($this->full_width){
                $classes .= ' vcw-full-width';
            }

            if($this->link_url) {
                $classes .= ' vcw-cursor';
            }

            return $classes;
        }

        protected function buildLink(&$elem)
        {
            if($this->link_url) {
                $elem->data_target   = $this->link_target;
                $elem->data_url      = $this->link_url;
            }
        }

        protected function changeIcon($change)
        {
            $w_or_b = $this->color === 'white' || $this->color === 'black';

            if(is_null($change)){
                $classes = $w_or_b ? 'fa-question vcw-warn-color' : 'fa-question vcw-text';
            }
            else if($change > 0) {
                $classes = $w_or_b ? 'fa-caret-up vcw-up-color' : 'fa-caret-up vcw-text';
            }
            else if($change < 0) {
                $classes = $w_or_b ? 'fa-caret-down vcw-down-color' : 'fa-caret-down vcw-text';
            }
            else {
                $classes = $w_or_b ? 'fa-circle-o vcw-around-color' : 'fa-circle-o vcw-text';
            }

            return VCW_HTML::i("vcw fa $classes");
        }

        protected function pricesBlock($price_btc)
        {
            $prices = array();

            foreach ($this->currencies as $currency) {

                $rate = VCW_Data::rate($currency);
                $quote = VCW_Helpers::quotation($rate, $price_btc, false);

                $prices[] = VCW_HTML::div('vcw-price', array(
                    VCW_HTML::div('vcw-currency vcw-header', $currency),
                    VCW_HTML::div('vcw-value vcw-text', $quote),
                ));
            }

            return VCW_HTML::div('vcw-prices', $prices);
        }

        protected function changesBlock($change_1h, $change_24h, $change_7d)
        {
            return VCW_HTML::div('vcw-changes', array(
                VCW_HTML::div('vcw-change', array(
                    VCW_HTML::div('vcw-title vcw-header', VCW_Contants::$widgets_change_headers['change_1h']),
                    VCW_HTML::div('vcw-value', array(
                        $this->changeIcon($change_1h),
                        VCW_HTML::div('vcw-number vcw-text', VCW_Helpers::changeString($change_1h, false))
                    ))
                )),
                VCW_HTML::div('vcw-change', array(
                    VCW_HTML::div('vcw-title vcw-header', VCW_Contants::$widgets_change_headers['change_24h']),
                    VCW_HTML::div('vcw-value', array(
                        $this->changeIcon($change_24h),
                        VCW_HTML::div('vcw-number vcw-text', VCW_Helpers::changeString($change_24h, false))
                    ))
                )),
                VCW_HTML::div('vcw-change', array(
                    VCW_HTML::div('vcw-title vcw-header', VCW_Contants::$widgets_change_headers['change_7d']),
                    VCW_HTML::div('vcw-value', array(
                        $this->changeIcon($change_7d),
                        VCW_HTML::div('vcw-number vcw-text', VCW_Helpers::changeString($change_7d, false))
                    ))
                )),
            ));
        }

        abstract public function build();

    }

    class VCW_PriceLabelWidget extends VCW_Widget {

        protected $main_class = 'price-label';

        public function build()
        {
            $info = array_merge(array(
                'name'      => '?',
                'price_btc' => null
            ), VCW_Data::cryptoCurrency($this->symbol, array()));

            $elem = VCW_HTML::div($this->classes());

            $this->buildLink($elem);

            $rate = VCW_Data::rate($this->currency);

            $elem->addChildren(array(
                VCW_HTML::div('vcw-name vcw-header', $info['name']),
                VCW_HTML::div('vcw-number vcw-text', VCW_Helpers::quotation($rate, $info['price_btc'])),
            ));

            return (string) $elem;
        }

    }

    class VCW_ChangeLabelWidget extends VCW_Widget {

        protected $main_class = 'change-label';

        public function build()
        {
            $info = array_merge(array(
                'name'          => '?',
                'change_24h'    => null
            ), VCW_Data::cryptoCurrency($this->symbol, array()));

            $elem = VCW_HTML::div($this->classes());

            $this->buildLink($elem);

            $change = $info['change_24h'];

            $change_str = VCW_Helpers::changeString($change);

            $elem->addChildren(array(
                VCW_HTML::div('vcw-name vcw-header', $info['name']),
                $this->changeIcon($change),
                VCW_HTML::div('vcw-change vcw-text', $change_str)
            ));

            return (string) $elem;
        }

    }

    class VCW_PriceBigLabelWidget extends VCW_Widget {

        protected $main_class = 'price-big-label';

        public function build()
        {
            $info = array_merge(array(
                'code'      => '?',
                'price_btc' => null
            ), VCW_Data::cryptoCurrency($this->symbol, array()));

            $elem = VCW_HTML::div($this->classes());

            $this->buildLink($elem);

            $elem->addChildren(array(
                VCW_HTML::div('vcw-symbol vcw-text', $info['code']),
                $this->pricesBlock($info['price_btc'])
            ));

            return (string) $elem;
        }

    }

    class VCW_ChangeBigLabelWidget extends VCW_Widget {

        protected $main_class = 'change-big-label';

        public function build()
        {
            $info = array_merge(array(
                'code'          => '?',
                'change_1h'     => null,
                'change_24h'    => null,
                'change_7d'     => null
            ), VCW_Data::cryptoCurrency($this->symbol, array()));

            $elem = VCW_HTML::div($this->classes());

            $this->buildLink($elem);

            $elem->addChildren(array(
                VCW_HTML::div('vcw-symbol vcw-text', $info['code']),
                $this->changesBlock($info['change_1h'], $info['change_24h'], $info['change_7d'])
            ));

            return (string) $elem;
        }

    }

    class VCW_PriceCardWidget extends VCW_Widget {

        protected $main_class = 'price-card';

        public function build()
        {
            $info = array_merge(array(
                'code'      => '?',
                'name'      => '?',
                'price_btc' => null
            ), VCW_Data::cryptoCurrency($this->symbol, array()));

            $elem = VCW_HTML::div($this->classes());

            $this->buildLink($elem);

            $elem->addChildren(array(
                VCW_HTML::div('vcw-symbol vcw-text', $info['code']),
                VCW_HTML::div('vcw-name vcw-header', $info['name']),
                $this->pricesBlock($info['price_btc'])
            ));

            return (string) $elem;
        }

    }

    class VCW_ChangeCardWidget extends VCW_Widget {

        protected $main_class = 'change-card';

        public function build()
        {
            $info = array_merge(array(
                'code'          => '?',
                'name'          => '?',
                'change_1h'     => null,
                'change_24h'    => null,
                'change_7d'     => null
            ), VCW_Data::cryptoCurrency($this->symbol, array()));

            $elem = VCW_HTML::div($this->classes());

            $this->buildLink($elem);

            $elem->addChildren(array(
                VCW_HTML::div('vcw-symbol vcw-text', $info['code']),
                VCW_HTML::div('vcw-name vcw-header', $info['name']),
                $this->changesBlock($info['change_1h'], $info['change_24h'], $info['change_7d'])
            ));

            return (string) $elem;
        }

    }

    class VCW_FullCardWidget extends VCW_Widget {

        protected $main_class = 'full-card';

        public function build()
        {
            $info = array_merge(array(
                'code'          => '?',
                'name'          => '?',
                'price_btc'     => null,
                'change_1h'     => null,
                'change_24h'    => null,
                'change_7d'     => null
            ), VCW_Data::cryptoCurrency($this->symbol, array()));

            $elem = VCW_HTML::div($this->classes());

            $this->buildLink($elem);

            $elem->addChildren(array(
                VCW_HTML::div('vcw-symbol vcw-text', $info['code']),
                VCW_HTML::div('vcw-name vcw-header', $info['name']),
                $this->changesBlock($info['change_1h'], $info['change_24h'], $info['change_7d']),
                VCW_HTML::div('vcw-divider'),
                $this->pricesBlock($info['price_btc'])
            ));

            return (string) $elem;
        }

    }

    class VCW_ConverterWidget extends VCW_Widget {

        protected $main_class = 'converter';

        protected $symbols    = array();
        protected $initial    = 1;

        public function __construct()
        {
            $this->symbols[0] = 'BTC';
            $this->symbols[1] = 'USD';
        }

        public function setSymbols($symbol1, $symbol2)
        {
            $this->symbols[0] = $symbol1;
            $this->symbols[1] = $symbol2;
        }

        public function getSymbols()
        {
            return $this->symbols;
        }

        public function setInitial($initial)
        {
            $this->initial = floatval($initial);
        }

        public function getInitial()
        {
            return $this->initial;
        }

        protected function rateOptions($selected = null)
        {
            $priority   = VCW_Contants::$converter_widget_priority;
            $rates      = VCW_Data::rates(array());
            $options_1  = VCW_HTML::optgroup();

            foreach ($priority as $code) {
                if(!array_key_exists($code, $rates)) continue;

                $rate = $rates[$code];
                $attrs = array('value' => $code);

                if($selected === $code) {
                    $attrs['selected'] = '';
                }

                $options_1->addChildren(VCW_HTML::option($attrs, $rate['name']));
            }

            $options_2  = VCW_HTML::optgroup();

            foreach ($rates as $code => $rate) {
                if(in_array($code, $priority)) continue;

                $attrs = array('value' => $code);

                if($selected === $code) {
                    $attrs['selected'] = '';
                }

                $options_2->addChildren(VCW_HTML::option($attrs, $rate['name']));
            }

            return array($options_1, $options_2);
        }

        public function build()
        {
            $elem = VCW_HTML::div($this->classes());

            $elem->addChildren(array(
                VCW_HTML::div('vcw-input', array(
                    VCW_HTML::div('vcw-input-child', VCW_HTML::select('vcw-currency-1', $this->rateOptions($this->symbols[0]))),
                    VCW_HTML::div('vcw-input-child', VCW_HTML::input(array('class' => 'vcw-value-1', 'value' => $this->initial)))
                )),
                VCW_HTML::div('vcw-input', array(
                    VCW_HTML::div('vcw-input-child', VCW_HTML::select('vcw-currency-2', $this->rateOptions($this->symbols[1]))),
                    VCW_HTML::div('vcw-input-child', VCW_HTML::input('vcw-value-2'))
                ))
            ));

            return (string) $elem;
        }

    }

    class VCW_TableWidget extends VCW_Widget {

        protected $main_class = 'table';

        protected $symbols    = array();

        public function setSymbols($symbols)
        {
            if(is_array($symbols)){
                $this->symbols = $symbols;
            }
        }

        public function getSymbols()
        {
            return $this->symbols;
        }

        public function build()
        {
            $elem = VCW_HTML::table($this->classes());
            $rate = VCW_Data::rate($this->currency);
            $rows = array();

            foreach ($this->symbols as $symbol) {

                $info = array_merge(array(
                    'name'          => '?',
                    'price_btc'     => null,
                    'change_1h'     => null,
                    'change_24h'    => null,
                    'change_7d'     => null
                ), VCW_Data::cryptoCurrency($symbol, array()));

                $change_1h  = $info['change_1h'];
                $change_24h = $info['change_24h'];
                $change_7d  = $info['change_7d'];

                $rows[] = VCW_HTML::tr(null, array(
                    VCW_HTML::td('vcw-name vcw-text',    $info['name']),
                    VCW_HTML::td('vcw-rate vcw-text',    VCW_Helpers::quotation($rate, $info['price_btc'], false)),
                    VCW_HTML::td('vcw-change vcw-text',  array($this->changeIcon($change_1h), ' ', VCW_Helpers::changeString($change_1h))),
                    VCW_HTML::td('vcw-change vcw-text',  array($this->changeIcon($change_24h), ' ', VCW_Helpers::changeString($change_24h))),
                    VCW_HTML::td('vcw-change vcw-text',  array($this->changeIcon($change_7d), ' ', VCW_Helpers::changeString($change_7d)))
                ));
            }

            $elem->addChildren(array(
                VCW_HTML::thead(null, VCW_HTML::tr(null, array(
                    VCW_HTML::th('vcw-name vcw-header',    VCW_Contants::$table_widget_cols['name']),
                    VCW_HTML::th('vcw-rate vcw-header',    $this->currency),
                    VCW_HTML::th('vcw-change vcw-header',  VCW_Contants::$table_widget_cols['change_1h']),
                    VCW_HTML::th('vcw-change vcw-header',  VCW_Contants::$table_widget_cols['change_24h']),
                    VCW_HTML::th('vcw-change vcw-header',  VCW_Contants::$table_widget_cols['change_7d'])
                ))),
                VCW_HTML::tbody(null, $rows)
            ));

            return (string) $elem;
        }

    }

    class VCW_SmallTableWidget extends VCW_Widget {

        protected $main_class = 'small-table';

        protected $symbols    = array();

        public function setSymbols($symbols)
        {
            if(is_array($symbols)){
                $this->symbols = $symbols;
            }
        }

        public function getSymbols()
        {
            return $this->symbols;
        }

        public function build()
        {
            $elem = VCW_HTML::table($this->classes());
            $rate = VCW_Data::rate($this->currency);
            $rows = array();

            foreach ($this->symbols as $symbol) {

                $info = array_merge(array(
                    'code'          => '?',
                    'price_btc'     => null,
                    'change_1h'     => null,
                    'change_24h'    => null,
                    'change_7d'     => null
                ), VCW_Data::cryptoCurrency($symbol, array()));

                $change_1h  = $info['change_1h'];
                $change_24h = $info['change_24h'];
                $change_7d  = $info['change_7d'];

                $rows[] = VCW_HTML::tr(null, array(
                    VCW_HTML::td('vcw-symbol vcw-text',  $info['code']),
                    VCW_HTML::td('vcw-rate vcw-text',    VCW_Helpers::quotation($rate, $info['price_btc'], false)),
                    VCW_HTML::td('vcw-change vcw-text',  array($this->changeIcon($change_1h), ' ', VCW_Helpers::changeString($change_1h, false))),
                    VCW_HTML::td('vcw-change vcw-text',  array($this->changeIcon($change_24h), ' ', VCW_Helpers::changeString($change_24h, false))),
                    VCW_HTML::td('vcw-change vcw-text',  array($this->changeIcon($change_7d), ' ', VCW_Helpers::changeString($change_7d, false)))
                ));
            }

            $elem->addChildren(array(
                VCW_HTML::thead(null, VCW_HTML::tr(null, array(
                    VCW_HTML::th('vcw-symbol vcw-header',  VCW_Contants::$small_table_widget_cols['symbol']),
                    VCW_HTML::th('vcw-rate vcw-header',    $this->currency),
                    VCW_HTML::th('vcw-change vcw-header',  VCW_Contants::$small_table_widget_cols['change_1h']),
                    VCW_HTML::th('vcw-change vcw-header',  VCW_Contants::$small_table_widget_cols['change_24h']),
                    VCW_HTML::th('vcw-change vcw-header',  VCW_Contants::$small_table_widget_cols['change_7d'])
                ))),
                VCW_HTML::tbody(null, $rows)
            ));

            return (string) $elem;
        }

    }

}