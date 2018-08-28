<?php defined( 'VCW_INDEX' ) or die( '' );

if(!class_exists('VCW_Admin')) {

    class VCW_Admin {

        static public function init()
        {
            if(!is_admin()) return;

            $class = get_class();
            add_action( 'admin_menu', array($class, 'addToMenu') );
            add_action( 'admin_enqueue_scripts', array($class, 'enqueueAssets') );
            add_action( 'wp_ajax_vcw_render', array($class, 'widgetRender') );
        }

        static public function addToMenu()
        {
            add_menu_page( 'Virtual Coin Widgets',
                'Coin Widgets',
                'manage_options',
                'vcw',
                array(get_class(), 'adminPage'),
                'dashicons-layout'
            );
        }

        static public function enqueueAssets()
        {
            VCW_Shortcodes::enqueueAssets();

            // CSS Files
            wp_enqueue_style('vcw-admin-css', VCW_URL.'assets/css/admin.css', array(), VCW_VERSION);

            // JS Files
            wp_enqueue_script('vcw-admin-js', VCW_URL.'assets/js/admin.js', array('jquery','vcw-script'), VCW_VERSION, true);

        }

        static protected function cleanParams()
        {
            $clean_params = array();
            $params = array(
                'shortcode',
                'symbol',
                'color',
                'currency',
                'currency1',
                'currency2',
                'currency3',
                'symbol',
                'symbol1',
                'symbol2',
                'symbols',
                'url',
                'target',
                'fullwidth',
                'initial',
                'count'
            );

            foreach ($params as $param) {
                $clean_params[$param] = isset($_POST[$param]) ? $_POST[$param] : null;
            }

            return $clean_params;
        }

        static public function widgetRender()
        {
            $widget = null;
            $code = null;
            $params = self::cleanParams();

            extract($params);

            if($shortcode === 'price-label') {
                $widget = new VCW_PriceLabelWidget();
                $widget->setSymbol($symbol);
                $widget->setColor($color);
                $widget->setCurrency($currency);
                $widget->setLinkTarget($target);
                $widget->setLinkURL($url);
                $widget->setFullWidth($fullwidth === 'yes');

                $code = "[vcw-price-label symbol=\"$symbol\" color=\"$color\" currency=\"$currency\" url=\"$url\" target=\"$target\" fullwidth=\"$fullwidth\"]";
            }
            else if($shortcode === 'change-label') {
                $widget = new VCW_ChangeLabelWidget();
                $widget->setSymbol($symbol);
                $widget->setColor($color);
                $widget->setLinkTarget($target);
                $widget->setLinkURL($url);
                $widget->setFullWidth($fullwidth === 'yes');

                $code = "[vcw-change-label symbol=\"$symbol\" color=\"$color\" url=\"$url\" target=\"$target\" fullwidth=\"$fullwidth\"]";
            }
            else if($shortcode === 'price-big-label') {
                $widget = new VCW_PriceBigLabelWidget();
                $widget->setSymbol($symbol);
                $widget->setColor($color);
                $widget->setLinkTarget($target);
                $widget->setLinkURL($url);
                $widget->setFullWidth($fullwidth === 'yes');
                $widget->setCurrencies($currency1, $currency2, $currency3);

                $code = "[vcw-price-big-label symbol=\"$symbol\" color=\"$color\" currency1=\"$currency1\" currency2=\"$currency2\" currency3=\"$currency3\" url=\"$url\" target=\"$target\" fullwidth=\"$fullwidth\"]";
            }
            else if($shortcode === 'change-big-label') {
                $widget = new VCW_ChangeBigLabelWidget();
                $widget->setSymbol($symbol);
                $widget->setColor($color);
                $widget->setLinkTarget($target);
                $widget->setLinkURL($url);
                $widget->setFullWidth($fullwidth === 'yes');

                $code = "[vcw-change-big-label symbol=\"$symbol\" color=\"$color\" url=\"$url\" target=\"$target\" fullwidth=\"$fullwidth\"]";
            }
            else if($shortcode === 'price-card') {
                $widget = new VCW_PriceCardWidget();
                $widget->setSymbol($symbol);
                $widget->setColor($color);
                $widget->setLinkTarget($target);
                $widget->setLinkURL($url);
                $widget->setFullWidth($fullwidth === 'yes');
                $widget->setCurrencies($currency1, $currency2, $currency3);

                $code = "[vcw-price-card symbol=\"$symbol\" color=\"$color\" currency1=\"$currency1\" currency2=\"$currency2\" currency3=\"$currency3\" url=\"$url\" target=\"$target\" fullwidth=\"$fullwidth\"]";
            }
            else if($shortcode === 'change-card') {
                $widget = new VCW_ChangeCardWidget();
                $widget->setSymbol($symbol);
                $widget->setColor($color);
                $widget->setLinkTarget($target);
                $widget->setLinkURL($url);
                $widget->setFullWidth($fullwidth === 'yes');

                $code = "[vcw-change-card symbol=\"$symbol\" color=\"$color\" url=\"$url\" target=\"$target\" fullwidth=\"$fullwidth\"]";
            }
            else if($shortcode === 'full-card') {
                $widget = new VCW_FullCardWidget();
                $widget->setSymbol($symbol);
                $widget->setColor($color);
                $widget->setLinkTarget($target);
                $widget->setLinkURL($url);
                $widget->setFullWidth($fullwidth === 'yes');
                $widget->setCurrencies($currency1, $currency2, $currency3);

                $code = "[vcw-full-card symbol=\"$symbol\" color=\"$color\" currency1=\"$currency1\" currency2=\"$currency2\" currency3=\"$currency3\" url=\"$url\" target=\"$target\" fullwidth=\"$fullwidth\"]";
            }
            else if($shortcode === 'converter') {
                $widget = new VCW_ConverterWidget();
                $widget->setSymbols($symbol1, $symbol2);
                $widget->setColor($color);
                $widget->setFullWidth($fullwidth === 'yes');
                $widget->setInitial($initial);

                $code = "[vcw-converter symbol1=\"$symbol1\" symbol2=\"$symbol2\" color=\"$color\" initial=\"$initial\" fullwidth=\"$fullwidth\"]";
            }
            else if($shortcode === 'table') {
                if(!$symbols) {
                    $symbols_array = VCW_Helpers::defaultTableWidgetItems($count);
                }
                else {
                    $symbols_array = explode(',', $symbols);
                }

                $widget = new VCW_TableWidget();
                $widget->setSymbols($symbols_array);
                $widget->setColor($color);
                $widget->setCurrency($currency);
                $widget->setFullWidth($fullwidth === 'yes');

                $code = "[vcw-table symbols=\"$symbols\" color=\"$color\" currency=\"$currency\" count=\"$count\" fullwidth=\"$fullwidth\"]";
            }
            else if($shortcode === 'small-table') {
                if(!$symbols) {
                    $symbols_array = VCW_Helpers::defaultTableWidgetItems($count);
                }
                else {
                    $symbols_array = explode(',', $symbols);
                }

                $widget = new VCW_SmallTableWidget();
                $widget->setSymbols($symbols_array);
                $widget->setColor($color);
                $widget->setCurrency($currency);
                $widget->setFullWidth($fullwidth === 'yes');

                $code = "[vcw-small-table symbols=\"$symbols\" color=\"$color\" currency=\"$currency\" count=\"$count\" fullwidth=\"$fullwidth\"]";
            }


            wp_send_json(array(
                'html' => $widget ? $widget->build() : null,
                'code' => $code
            ));
        }

        static public function adminPage()
        {

            $cc = VCW_Data::cryptoCurrencies(array());
            $rates = VCW_Data::rates(array());

            ?>
            <div id="vcw-admin-page" class="wrap">

                <h1>Virtual Coin Widgets</h1>
                <h3>By <a target="_blank" href="http://runcoders.com">RunCoders</a></h3>

                <div class="card">
                    <h2>Builder:</h2>

                    <form id="vcw-admin-builder" novalidate="novalidate">
                        <table class="form-table">
                            <tbody>

                            <tr class="shortcode-row">
                                <th scope="row"><label for="shortcode">Shortcode</label></th>
                                <td>
                                    <select name="shortcode">
                                        <option selected value="price-label">Price Label</option>
                                        <option value="change-label">Change Label</option>
                                        <option value="price-big-label">Price Big Label</option>
                                        <option value="change-big-label">Change Big Label</option>
                                        <option value="price-card">Price Card</option>
                                        <option value="change-card">Change Card</option>
                                        <option value="full-card">Full Card</option>
                                        <option value="converter">Converter</option>
                                        <option value="table">Table</option>
                                        <option value="small-table">Small Table</option>
                                    </select>
                                    <p class="description">Widget type</p>
                                </td>
                            </tr>

                            <tr class="color-row">
                                <th scope="row"><label for="color">Color</label></th>
                                <td>
                                    <select name="color">
                                        <?php foreach (VCW_Contants::$color_schemas as $slang => $name) : ?>
                                            <option <?php if($slang === 'white') echo 'selected'; ?> value="<?php echo $slang; ?>"><?php echo $name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="description">Widget color schema</p>
                                </td>
                            </tr>

                            <tr class="symbol-row" style="display: none">
                                <th scope="row"><label for="symbol">Symbol</label></th>
                                <td>
                                    <select name="symbol">
                                        <?php foreach ($cc as $code => $info) : ?>
                                            <option value="<?php echo $code; ?>"><?php echo $info['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="description">Cryptocurrency for the widget</p>
                                </td>
                            </tr>

                            <tr class="symbol1-row" style="display: none">
                                <th scope="row"><label for="symbol1">Symbol #1</label></th>
                                <td>
                                    <select name="symbol1">
                                        <?php foreach ($rates as $code => $info) : ?>
                                            <option <?php if($code === 'BTC') echo 'selected'; ?> value="<?php echo $code; ?>"><?php echo $info['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="description">Select the top currency</p>
                                </td>
                            </tr>

                            <tr class="symbol2-row" style="display: none">
                                <th scope="row"><label for="symbol2">Symbol #2</label></th>
                                <td>
                                    <select name="symbol2">
                                        <?php foreach ($rates as $code => $info) : ?>
                                            <option <?php if($code === 'USD') echo 'selected'; ?> value="<?php echo $code; ?>"><?php echo $info['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="description">Select the bottom currency</p>
                                </td>
                            </tr>

                            <tr class="symbols-row" style="display: none">
                                <th scope="row"><label for="symbols">Symbols List</label></th>
                                <td>
                                    <input class="regular-text code" name="symbols" type="text" value="BTC,ETH,XRP,LTC,BCH">
                                    <p class="description">Enter cryptocurrency codes separated by comma (e.g. BTC,ETH,XRP)</p>
                                </td>
                            </tr>

                            <tr class="currency-row" style="display: none">
                                <th scope="row"><label for="currency">Price Currency</label></th>
                                <td>
                                    <select name="currency">
                                        <?php foreach ($rates as $code => $info) : ?>
                                            <option <?php if($code === 'USD') echo 'selected'; ?> value="<?php echo $code; ?>"><?php echo $info['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="description">Currency used for price quote</p>
                                </td>
                            </tr>

                            <tr class="currency1-row" style="display: none">
                                <th scope="row"><label for="currency1">Price Currency #1</label></th>
                                <td>
                                    <select name="currency1">
                                        <?php foreach ($rates as $code => $info) : ?>
                                            <option <?php if($code === 'USD') echo 'selected'; ?> value="<?php echo $code; ?>"><?php echo $info['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="description">Currency used for #1 price quote</p>
                                </td>
                            </tr>

                            <tr class="currency2-row" style="display: none">
                                <th scope="row"><label for="currency2">Price Currency #2</label></th>
                                <td>
                                    <select name="currency2">
                                        <?php foreach ($rates as $code => $info) : ?>
                                            <option <?php if($code === 'EUR') echo 'selected'; ?> value="<?php echo $code; ?>"><?php echo $info['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="description">Currency used for #2 price quote</p>
                                </td>
                            </tr>

                            <tr class="currency3-row" style="display: none">
                                <th scope="row"><label for="currency3">Price Currency #3</label></th>
                                <td>
                                    <select name="currency3">
                                        <?php foreach ($rates as $code => $info) : ?>
                                            <option <?php if($code === 'GBP') echo 'selected'; ?> value="<?php echo $code; ?>"><?php echo $info['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="description">Currency used for #3 price quote</p>
                                </td>
                            </tr>

                            <tr class="url-row" style="display: none">
                                <th scope="row"><label for="url">URL</label></th>
                                <td>
                                    <input class="regular-text code" name="url" type="text">
                                    <p class="description">URL address for click action</p>
                                </td>
                            </tr>

                            <tr class="target-row" style="display: none">
                                <th scope="row"><label for="target">Target</label></th>
                                <td>
                                    <select name="target">
                                        <option value="_blank">New Tab</option>
                                        <option value="_self">Same Tab</option>
                                    </select>
                                    <p class="description">Select the redirection behaviour click action</p>
                                </td>
                            </tr>

                            <tr class="initial-row" style="display: none">
                                <th scope="row"><label for="initial">Initial</label></th>
                                <td>
                                    <input class="regular-text code" name="initial" type="text" value="1">
                                    <p class="description">Default value for symbol #1</p>
                                </td>
                            </tr>

                            <tr class="count-row" style="display: none">
                                <th scope="row"><label for="count">Count</label></th>
                                <td>
                                    <input class="regular-text code" name="count" type="text" value="10">
                                    <p class="description">Top market cap cryptocurrencies count (if symbols are empty)</p>
                                </td>
                            </tr>

                            <tr class="fullwidth-row">
                                <th scope="row"><label for="fullwidth">Fullwidth</label></th>
                                <td>
                                    <select name="fullwidth">
                                        <option value="no">No</option>
                                        <option value="yes">Yes</option>
                                    </select>
                                    <p class="description">Sets widget width to fill all parent element</p>
                                </td>
                            </tr>

                            <tr class="submit-row">
                                <td>
                                    <input type="button" class="render-submit button button-primary" value="Generate">
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="card">
                    <h2>Preview:</h2>
                    <div id="vcw-admin-preview"></div>
                </div>
                <div class="card">
                    <h2>Shortcode:</h2>

                    <form id="vcw-admin-code">
                        <textarea class="large-text code" rows="3" readonly></textarea>
                    </form>
                </div>


            </div>

            <?php
        }

    }

    VCW_Admin::init();

}