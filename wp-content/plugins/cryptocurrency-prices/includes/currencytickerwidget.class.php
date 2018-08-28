<?php
class CP_Ticker_Widget extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'cp_ticker_widget', 'description' => __('Shows cryptocurrency ticker.', 'cryptocurrency'));
		parent::__construct('cp_ticker_widget', __('CP Ticker Widget', 'cryptocurrency'), $widget_ops);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		
		$currency = strtolower(trim($instance['currency']));
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		} ?>
			<div class="textwidget">
        <?php
          echo self::get_badge($currency);
        ?>
      </div>
		<?php
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['currency'] =  $new_instance['currency'];
		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title = strip_tags($instance['title']);
		$currency = esc_textarea($instance['currency']);
    ?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'cryptocurrency'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Cryptocurrency (i.e BTC):', 'cryptocurrency' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('currency'); ?>" name="<?php echo $this->get_field_name('currency'); ?> type="text" value="<?php echo esc_attr($currency); ?>" /></p>
    <?php
	}
  
  function get_badge($currency){
      
    $html = '
      <div class="cp-ticker-widget" id="cp-ticker-widget-'.$currency.'">
        <div class="cp-ticker-widget-name">Loading data...</div>
      </div>
      <script type="text/javascript">
        //get data
        var apiUrl = \'https://api.coinmarketcap.com/v2/ticker/\';
        jQuery.get( apiUrl, function( dataCurrencies ) {
          //console.log(dataCurrencies);
          console.log("Data loaded");
          
          //var data = dataCurrencies.data[1];
          //find currency
          
          for (var currencyId in dataCurrencies.data) {
            
            var data = dataCurrencies.data[currencyId];
            //console.log(data);
            
            if (data.symbol == \''.strtoupper($currency).'\'){
              //currency found
              
              var currencyName = data.name;
              var currencySymbol = data.symbol;
              var currency_price = data.quotes.USD.price;
              var currency_percent_change_24h = data.quotes.USD.percent_change_24h;
              if (currency_percent_change_24h > 0){
                var currency_change_24h_color = \'changes-up\';
                var currency_change_24h_symbol = \'&#8679;\';
              } else {
                var currency_change_24h_color = \'changes-down\';
                var currency_change_24h_symbol = \'&#8681;\';
              }
              
              var tickerHtml = \'\'+ 
              \'<div class="cp-ticker-widget-icon">\'+
                \'<img src="'.CP_URL.'images/coins128x128/\'+currencySymbol.toLowerCase()+\'.png" alt="\'+data.name+\'">\'+
              \'</div>\'+
              \'<div class="cp-ticker-widget-name">\'+currencyName+\'</div>\'+
              \'<div class="cp-ticker-widget-pricing">\'+
                \'<div class="cp-ticker-widget-pricing-price">\'+
                  \'<i class="fa fa-usd" aria-hidden="true"></i>\'+
                  \'<span>\'+currency_price+\'</span>\'+
                \'</div>\'+
                \'<div class="cp-ticker-widget-pricing-change">\'+
                  \'<span class="\'+currency_change_24h_color+\'">\'+
                    \'\'+currency_change_24h_symbol+\' \'+currency_percent_change_24h+\'%\'+
                  \'</span>\'+
                  \' <span class="cp-ticker-widget-period">24H</span>\'+
                \'</div>\'+
              \'</div>\';
                        
              jQuery(\'#cp-ticker-widget-'.$currency.'\').html(tickerHtml);
            }
          }
        });
      </script>
    ';
    
    return $html;
  }
}