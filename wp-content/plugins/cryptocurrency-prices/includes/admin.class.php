<?php
class CPAdmin {
  const NONCE = 'cp-admin-settings';
  
  private static $initiated = false;
	
  public static function init() {
    if ( ! self::$initiated ) {
			self::init_hooks();
		}
  }
  
	public static function init_hooks() {
    self::$initiated = true;
    
    //add admin menu
    add_action('admin_menu', array( 'CPAdmin', 'register_menu_page' ));
	}
  
  public static function register_menu_page() {
    add_menu_page(
      __( 'Cyptocurrency All-in-One', 'cryptocurrency' ),
      __( 'Cyptocurrency', 'cryptocurrency' ),
      'manage_options',
      'cryptocurrency-prices',
      array('CPAdmin', 'cryptocurrency_prices_admin'),
      CP_URL.'images/admin-icon.png',
      81
    );
    
    add_submenu_page( 
      'cryptocurrency-prices', 
      __( 'Help', 'cryptocurrency' ), 
      __( 'Help', 'cryptocurrency' ), 
      'manage_options', 
      'cryptocurrency-prices', 
      array('CPAdmin', 'cryptocurrency_prices_admin_help')
    );
    
    add_submenu_page( 
      'cryptocurrency-prices', 
      __( 'Crypto Resources', 'cryptocurrency' ), 
      __( 'Crypto Resources', 'cryptocurrency' ), 
      'manage_options', 
      'resources', 
      array('CPAdmin', 'cryptocurrency_prices_admin_resources')
    );
    
    add_submenu_page( 
      'cryptocurrency-prices', 
      __( 'Settings', 'cryptocurrency' ), 
      __( 'Settings', 'cryptocurrency' ), 
      'manage_options', 
      'settings', 
      array('CPAdmin', 'cryptocurrency_prices_admin_settings')
    );
    
    add_submenu_page( 
      'cryptocurrency-prices', 
      __( 'Premium and Updates', 'cryptocurrency' ), 
      __( 'Premium and Updates', 'cryptocurrency' ), 
      'manage_options', 
      'premium',
      array('CPAdmin', 'cryptocurrency_prices_admin_premium') 
    );
  }
  
  public static function cryptocurrency_prices_admin(){
    //self::cryptocurrency_prices_admin_help();
  }
  
  public static function cryptocurrency_prices_admin_resources(){
    //check if user has admin capability
    if (current_user_can( 'manage_options' )){ 
      echo '
      <div class="wrap cryptocurrency-admin">
        '.$admin_message_html.'
        <h1>Cyptocurrency Resources:</h1>
        
        <p>You will find a list of resources, specially selected for the users of Cyptocurrency All-in-One.</p>

        <h2>Buy Bitcoin and other cryptocurrency</h2>
        <a href="https://cex.io/r/1/byankov/1">Buy Bitcoin and excnahge it to other cryptocurrency at CEX.IO</a><br />

        <h2>Create Bitcoin and altcoin wallets</h2>
        <a href="https://www.ledgerwallet.com/products/ledger-nano-s">Hardware wallet Ledger Nano S. Very secure but costs money.  Works for receiving donations and payments.</a><br />
        <a href="https://trezor.io/">Hardware wallet TREZOR. Very secure but costs money.  Works for receiving donations and payments.</a><br />
        <a href="https://bitcoin.org/en/download ">Official bitcoin software wallet (hot wallet). Relatively secure. Works for receiving donations and payments.</a><br />
        <a href="https://cex.io/r/0/byankov/0">Exchange site CEX.IO - allows one bitcoin wallet and one wallet for every altcoin. Very easy to use. Works for receiving donations.</a><br />
        <a href="https://yobit.io/?bonus=srtAb">Exchange site YoBit.net - allows one bitcoin wallet and one wallet for every altcoin. Very easy to use. Works for receiving donations.</a><br />

        <h2>Trade and exchange cryptocurrency</h2>
        <a href="https://yobit.io/?bonus=srtAb">Exchange with many coins and low fees for trading - YObit.net</a><br />
        <a href="https://cex.io/r/0/byankov/0">Trusted exchange site - CEX.IO</a><br />
        <a href="https://creditstocks.com/cryptocurrency-prices/list-of-all-cryptocurrencies/">List of all cryptocurrencies</a><br />
        More trading tools - coming soon<br />

        <h2>Publish cryptocurrency article</h2>
        <a href="https://creditstocks.com/submit-article-creditstocks-com/">Publish cryptocurrency or finance article at CreditStocks.com - free</a><br />
        <a href="http://satoshijournal.com/submit-an-article/">Publish cryptocurrency or finance article at SatochiJournal.com - free</a><br />

        <h2>Cryptocurrency mining</h2>
        <a href="http://www.whattomine.com/">Mining calculator - What to mine</a><br />
        <a href="https://www.cryptocompare.com/mining/calculator/btc">Mining calculator - Bitcoin</a><br />
        <a href="https://www.cryptocompare.com/mining/calculator/eth">Mining calculator - Ethereum</a><br />

        <h2>Development resources</h2>
        <a href="https://theethereum.wiki/w/index.php/ERC20_Token_Standard">ERC20 - Ethereum token standard</a><br />
        <a href="https://infura.io/">Infura - Open and free to use Ethereum node</a><br />
        <a href="https://coinmarketcap.com/api/">Free data API about cryptocurrencies - CoinMarketCap</a><br />
        <a href="https://www.cryptocompare.com/api/">Free data API about cryptocurrencies - CryptoCompare</a><br />

        <h2>Crypto community</h2>
        <a href="https://web.facebook.com/groups/469221573283979/">Knights of Satoshi - Facebook group</a><br />
        <a href="https://bitcointalk.org/">BitcoinTalk.org - the largest Bitcoin and cryptocurrency forum</a>
        
        <p><small>* The list is not a recommendation ot the listed services. This is just a list of what we use - you may decide to use them or not at your own risk. Some links may be links to external services, affiliate links, or links that do not work anymore.</small></p>
        
      </div>
      ';
    
    }
      
  }      
  
  public static function cryptocurrency_prices_admin_settings(){
    //check if user has admin capability
    if (current_user_can( 'manage_options' )){ 
      $admin_message_html = '';

      if (isset($_POST['cryptocurrency-prices-default-css']) and $_POST['cryptocurrency-prices-default-css']!=''){
        //check nonce
        check_admin_referer( self::NONCE );
              
        $sanitized_cryptocurrency_prices_default_css = sanitize_text_field($_POST['cryptocurrency-prices-default-css']);
        update_option('cryptocurrency-prices-default-css', $sanitized_cryptocurrency_prices_default_css);
        $admin_message_html = '<div class="notice notice-success"><p>Plugin settings have been updated!</p></div>';
      }
      
      if (isset($_POST['ethereum-api'])){
        //check nonce
        check_admin_referer( self::NONCE );
        
        $sanitized_ethereum_api = sanitize_text_field($_POST['ethereum-api']);
        update_option('ethereum-api', $sanitized_ethereum_api);
        $admin_message_html = '<div class="notice notice-success"><p>Plugin settings have been updated!</p></div>';
      }
      
      if (isset($_POST['cryptocurrency-prices-css'])){
        //check nonce
        check_admin_referer( self::NONCE );
        
        $sanitized_cryptocurrency_prices_css = sanitize_text_field($_POST['cryptocurrency-prices-css']);
        update_option('cryptocurrency-prices-css', $sanitized_cryptocurrency_prices_css);
        $admin_message_html = '<div class="notice notice-success"><p>Plugin settings have been updated!</p></div>';
      }
      
      //delete_option( 'cryptocurrency-prices-default-css' ); //remove setting
      $default_css_selected_light = '';
      $default_css_selected_dark = '';
      if (get_option('cryptocurrency-prices-default-css') == 'light'){
        $default_css_selected_light = 'selected="selected"';
      } elseif (get_option('cryptocurrency-prices-default-css') == 'dark'){
        $default_css_selected_dark = 'selected="selected"';
      }
      
      echo '
      <div class="wrap cryptocurrency-admin">
        '.$admin_message_html.'
        <h1>Cyptocurrency All-in-One Settings:</h1>
          
        <form action="" method="post">
          <h2>Design:</h2>
          <label>Use default design (insludes default CSS): </label>
          <select name="cryptocurrency-prices-default-css">
            <option value="0">no</option>
            <option value="light" '.$default_css_selected_light.'>light</option>
            <option value="dark" '.$default_css_selected_dark.'>dark</option>
          </select>

          <p>Write your custom CSS code here to style the plugin. Check the <a href="https://wordpress.org/support/plugin/cryptocurrency-prices/" target="_blank">support forum</a> for examples.</p>
          <textarea name="cryptocurrency-prices-css" rows="5" cols="50">'.get_option('cryptocurrency-prices-css').'</textarea>

          <h2>Ethereum blockchain node API URL:</h2>
          <p>You need to set it up, if you will use the ethereum blockchain features. Example URLs http://localhost:8545 for your own node or register for a public node https://mainnet.infura.io/[your key].</p>
          <input type="text" name="ethereum-api" value="'.get_option('ethereum-api').'" />
          
          <br /><br />
          '.wp_nonce_field( self::NONCE ).'        
          <input type="submit" value="Save options" />
        </form>
      </div>
      ';
    
    }
  }
  
  public static function cryptocurrency_prices_admin_premium(){
    echo '
    <div class="wrap cryptocurrency-admin">
    <h1>Cyptocurrency All-in-One Premium Version and Updates::</h1>
    '; 
    
    echo '
    <h2>Get premium version</h2>
    <p>The premium version has a lot more features than the free version + free support. To get the premium version visit this page <a href="https://creditstocks.com/cryptocurrency-one-wordpress-plugin/">https://creditstocks.com/cryptocurrency-one-wordpress-plugin/</a><p>
    <h2>Premium version updates</h2>
    <p>The premium version of the plugin is constantly updated. Updates include new features, improvements of existing features and security improvements. It is highly recommended that you keep your plugin updated.</p>
    <p>Premium version updates are manual. To check your current version, visit the <a href="plugins.php" target="_blank">Plugins page</a>. To purchase updates, visit the plugin web site: <a href="https://creditstocks.com/cryptocurrency-one-wordpress-plugin/" target="_blank">https://creditstocks.com/cryptocurrency-one-wordpress-plugin/</a></p>
    ';
    
    echo ' 
    </div>
    ';
  }
  
  public static function cryptocurrency_prices_admin_help(){
    //set the active tab
    $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'exchange';
    
    echo '
    <div class="wrap cryptocurrency-admin">
      <h1>Cyptocurrency All-in-One Help:</h1>
    ';

    echo '
      <h2 class="nav-tab-wrapper">
          <a href="?page=cryptocurrency-prices&tab=exchange" class="nav-tab">Exchange rates</a>
          <a href="?page=cryptocurrency-prices&tab=calculator" class="nav-tab">Calculator</a>
          <a href="?page=cryptocurrency-prices&tab=candlestick_chart" class="nav-tab">Price chart</a>
          <a href="?page=cryptocurrency-prices&tab=ticker_widget" class="nav-tab">Ticker widget</a>
          <a href="?page=cryptocurrency-prices&tab=list_cryptocurrencies" class="nav-tab">List all cryptocurrencies</a>
          <a href="?page=cryptocurrency-prices&tab=orders_payments" class="nav-tab">Orders, payments</a>
          <a href="?page=cryptocurrency-prices&tab=donations" class="nav-tab">Donations</a>
          <a href="?page=cryptocurrency-prices&tab=ethereum" class="nav-tab">Ethereum Node</a>
          <a href="?page=cryptocurrency-prices&tab=others" class="nav-tab">Other features</a>
      </h2>
    ';
    
    if ($active_tab == 'exchange'){
      echo '
        <h2>To display cryptocurrency exchange rates (premium version only):</h2>
        <p>To show cryptocurrency prices, add a shortcode to the text of the pages or posts where you want the cryptocurrency prices to apperar. Exapmle shortcodes:</p>
        [currencyprice currency1="btc" currency2="usd,eur,ltc,eth,jpy,gbp,chf,aud,cad"]<br />
        [currencyprice currency1="ltc" currency2="usd,eur,btc"]
        <p>You can also call the prices from the theme like this:</p>
        '.htmlspecialchars('<?php echo do_shortcode(\'[currencyprice currency1="btc" currency2="usd,eur"]\'); ?>').'
        <p>Most cryptocurrencies are supported and the major ones also have icons: Bitcoin BTC, Ethereum ETH, XRP, DASH, LTC, ETC, XMR, XEM, REP, MAID, PIVX, GNT, DCR, ZEC, STRAT, BCCOIN, FCT, STEEM, WAVES, GAME, DOGE, ROUND, DGD, LISK, SNGLS, ICN, BCN, XLM, BTS, ARDR, 1ST, PPC, NAV, XCP, NXT, LANA. Partial suport for over 1000 cryptocurrencies. Fiat currencies conversion supported: AUD, USD, CAD, GBP, EUR, CHF, JPY, CNY.</p>
        <p><a href="https://creditstocks.com/cryptocurrency-prices/current-litecoin-price/" target="_blank">Live demo</a></p>
      ';
    }
    
    if ($active_tab == 'calculator'){
      echo '
        <h2>To display cryptocurrency calculator (premium version only):</h2>
        <p>To show cryptocurrency calculator, add a shortcode to the text of the pages or posts where you want the calculator prices to apperar. Exapmle shortcodes:</p>
        [currencycalculator currency1="btc" currency2="usd,eur,ltc,eth,jpy,gbp,chf,aud,cad"]<br />
        [currencycalculator currency1="ltc" currency2="usd,eur,btc"]
        <p>You can also call the calculator from the theme like this:</p>
        '.htmlspecialchars('<?php echo do_shortcode(\'[currencycalculator currency1="btc" currency2="usd,eur"]\'); ?>').'
        <p>Most cryptocurrencies are supported and the major ones also have icons: Bitcoin BTC, Ethereum ETH, XRP, DASH, LTC, ETC, XMR, XEM, REP, MAID, PIVX, GNT, DCR, ZEC, STRAT, BCCOIN, FCT, STEEM, WAVES, GAME, DOGE, ROUND, DGD, LISK, SNGLS, ICN, BCN, XLM, BTS, ARDR, 1ST, PPC, NAV, XCP, NXT, LANA. Partial suport for over 1000 cryptocurrencies. Fiat currencies conversion supported: AUD, USD, CAD, GBP, EUR, CHF, JPY, CNY.</p>
        <p><a href="https://creditstocks.com/cryptocurrency-prices/current-litecoin-price/" target="_blank">Live demo</a></p>
      ';
    }
    
    if ($active_tab == 'candlestick_chart'){
      echo '
        <h2>To display cryptocurrency candlestick price chart (premium version only):</h2>
        <p>To show cryptocurrency candlestick chart graphic, add a shortcode to the text of the pages or posts where you want the chart to apperar. Set the cryptocurrency that you want on the chart as currency1 and the base currency as currency2. Supported periods are 1hour, 24hours, 7days, 30days, 1year. Exapmle shortcodes:</p>
        [currencychart currency1="btc" currency2="usd"]<br />
        [currencychart currency1="dash" currency2="btc" defaultperiod="1year"]
        <p>You can also call the chart from the theme like this:</p>
        '.htmlspecialchars('<?php echo do_shortcode(\'[currencychart currency1="btc" currency2="usd"]\'); ?>').' 
        <p><a href="https://creditstocks.com/cryptocurrency-prices/current-bitcoin-price/" target="_blank">Live demo</a></p>
      ';
    }
        
    if ($active_tab == 'ticker_widget'){
      echo '
        <h2>Cryptocurrency ticker widget - a badge with the logo, price, and 24h change of one cryptocurrency:</h2>
        <p>To show the cryptocurrency ticker widget go to Appearance / Widgets and add the widget to the widget area where you want it to appear. Set the cryptocurrency you wan to show - for example BTC.</p> 
        <p><a href="https://creditstocks.com/cryptocurrency-prices/current-bitcoin-price/" target="_blank">Live demo</a></p>
      ';
    }
    
    if ($active_tab == 'list_cryptocurrencies'){
      echo '
        <h2>To display a list of all cryptocurrencies</h2>
        <p>Add a shortcode to the text of the pages or posts where you want to display CoinMarketCap style list of all cryptocurrencies. The list is paginated, sortable, searchable. The shortcode supports selecting the base currency for showing the prices, default is USD. You can set the total number of cryptocurrencies (default 500), the cryptocurrencies per page (default 100), the number format locale. Exapmle shortcodes:</p>
        [allcurrencies]<br />
        [allcurrencies basecurrency="eur"]<br />
        [allcurrencies limit="100" perpage="10"]<br />
        [allcurrencies basecurrency="eur" locale="de-DE"]
        <p>You can also call the list from the theme like this:</p>
        '.htmlspecialchars('<?php echo do_shortcode(\'[allcurrencies]\'); ?>').'
        <p><a href="https://creditstocks.com/cryptocurrency-prices/list-of-all-cryptocurrencies/" target="_blank">Live demo</a></p>
      ';
    }
    
    if ($active_tab == 'orders_payments'){
      echo '
        <h2>To accept cryptocurrency orders and payments (premium version only):</h2>
        <p>Supported currencies for payments are:</p> 
        <ul>
          <li>Bitcoin (BTC) (default),</li> 
          <li>Ethereum (ETH),</li> 
          <li>Litecoin (LTC),</li> 
          <li>Bitcoin Cash (BCH),</li> 
          <li>Zcash (ZEC).</li> 
        </ul>
        <p> 
          Open the plugin settings and under "Payment settings" fill in your BTC (or other cryptocurrency) wallet addresses to receive payments and an email for receiving payment notifications.<br />  
          The plugin does not store your wallet\'s private keys. It uses one of the addresses from the provided list for every payment, by rotating all addresses and starting over from the first one. The different addresses are used to idenfiry if a specific payment has been made. You must provide enough addresses - more than the number of payments you will receive a day. <br /> 
          Add a shortcode to the text of the pages or posts where you want to accept payments (typically these pages would contain a product or service that you are offering). The amount may be in BTC (default), Ethereum (ETH), Litecon (LTC) or in fiat currency (USD, EUR, etc), which will be converted it to the selected cryptocurrency.<br /> 
          Exapmle shortcodes:
        </p>
        [cryptopayment item="Advertising services" amount="0.003" currency="BTC"]<br />
        [cryptopayment item="Publish a PR article" amount="50 USD" currency="BTC"]<br />
        [cryptopayment item="Publish a PR article" amount="10 EUR" currency="ETH"]
        <p><a href="https://creditstocks.com/payment-demo/" target="_blank">Live demo</a></p>
      ';
    }
    
    if ($active_tab == 'donations'){
      echo '
        <h2>To accept cryptocurrency donations:</h2>
        <p>Add a shortcode to the text of the pages or posts where you want to accept donations. Supported currencies are:</p>
        <ul>
          <li>Bitcoin (BTC) (default),</li> 
          <li>Ethereum (ETH),</li> 
          <li>Litecoin (LTC),</li> 
          <li>Monero (XMR),</li>
          <li>Bitcoin Cash (BCH),</li> 
          <li>Zcash (ZEC).</li> 
        </ul>
        <p>Exapmle shortcodes (do not forget to put your wallet address):</p>
        [cryptodonation address="1ABwGVwbna6DnHgPefSiakyzm99VXVwQz9"]<br />
        [cryptodonation address="0xc85c5bef5a9fd730a429b0e04c69b60d9ef4c64b" currency="eth"]<br />
        [cryptodonation address="463tWEBn5XZJSxLU6uLQnQ2iY9xuNcDbjLSjkn3XAXHCbLrTTErJrBWYgHJQyrCwkNgYvyV3z8zctJLPCZy24jvb3NiTcTJ" paymentid="a1be1fb24f1e493eaebce2d8c92dc68552c165532ef544b79d9d36d1992cff07" currency="xmr"]
        <p>You can also call the donations from the theme like this:</p>
        '.htmlspecialchars('<?php echo do_shortcode(\'[cryptodonation address="1ABwGVwbna6DnHgPefSiakyzm99VXVwQz9"]\'); ?>').'
        <p><a href="https://creditstocks.com/donate/" target="_blank">Live demo</a></p>
      ';
    }

    if ($active_tab == 'ethereum'){
      echo '
        <h2>Ethereum node integration:</h2>
        <p>Currently supported features are: check Ethereum address balance, view ethereum block. Before using the shortcodes you need to fill in your Ethereum node API URL in the plugin settings (http://localhost:8545 or a public node at infura.io). Exapmle shortcodes:</p>
        [cryptoethereum feature="balance"]<br />
        [cryptoethereum feature="block"]
        <p>Notice: Beware mixed content browser restriction! If your web site uses https, the node must also use https.</p>
        <p><a href="https://creditstocks.com/ethereum/" target="_blank">Live demo</a></p>
      ';
    }
    
    if ($active_tab == 'others'){
      echo '
        <h2>Instructions to use the plugin in a widget:</h2>
        <p>To use the plugin in a widget, use the provided "CP Shortcode Widget" and put the shortcode in the "Content" section, for example:</p>
        [currencyprice currency1="btc" currency2="usd,eur"]
      ';
    }
    
    echo '    
    </div>
    ';
  }
}