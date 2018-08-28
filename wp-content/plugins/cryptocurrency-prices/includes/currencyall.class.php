<?php
class CPCurrencyAll{

  public static function cp_all_currencies_shortcode($atts){
    $html = '';
    
    if (isset($atts['basecurrency']) and $atts['basecurrency']!=''){
      $base_currency = trim(mb_strtoupper($atts['basecurrency']));
    } else {
      $base_currency = 'USD';
    }
    
    if (isset($atts['limit']) and $atts['limit']!=''){
      $limit = (int)$atts['limit'];
    } else {
      $limit = 500;
    }
    
    if (isset($atts['perpage']) and $atts['perpage']!=''){
      $perpage = (int)$atts['perpage'];
    } else {
      $perpage = 100;
    }
    
    
    if (isset($atts['locale']) and $atts['locale']!=''){
      $locale = 'locale="'.$atts['locale'].'"';
    } else {
      $locale = '';
    }

    //load libraries
    CPCommon::cp_load_scripts('datatable');
    CPCommon::cp_load_scripts('lazy');
    
    $html .= '
    <table class="cp-table cp-cryptocurrencies-table"></table>
    <script type="text/javascript">
    //get list of currencies
    var toCurrency = \''.$base_currency.'\';
    var apiUrl = \'https://api.coinmarketcap.com/v1/ticker/?convert=\'+\''.$base_currency.'\'+\'&limit='.$limit.'\';
    console.log(apiUrl);
    jQuery.get( apiUrl, function( data ) {

      //prepare dataset for datatable
      var dataSet = [];
      for (var currentCurrency in data){
        //console.log(data[currentCurrency]);
        var name = data[currentCurrency].name;
        var rank = data[currentCurrency].rank;
        var price_number = data[currentCurrency][\'price_'.mb_strtolower($base_currency).'\'];
        var price = price_number.toLocaleString('.$locale.')+\' \'+toCurrency;
        var supply = parseInt(data[currentCurrency].available_supply).toLocaleString('.$locale.');
        var volume = parseInt(data[currentCurrency][\'24h_volume_'.mb_strtolower($base_currency).'\']+\' \').toLocaleString('.$locale.');
        if (data[currentCurrency].percent_change_24h > 0){
          var changeClass = "change-inc";
        } else {
          var changeClass = "change-dec";
        }
        var change = "<span class=\""+changeClass+"\">"+data[currentCurrency].percent_change_24h+\'%\'+"</span>";
        var marketCap = parseInt(data[currentCurrency][\'market_cap_'.mb_strtolower($base_currency).'\']).toLocaleString('.$locale.');
        var image = "<img class=\"lazy\" data-src=\"'.CP_URL.'images/coins32x32/"+data[currentCurrency].symbol.toLowerCase()+".png\" style=\"max-width:20px;\" />";
        
        dataSet.push([rank, image+\' \'+name, marketCap, price, volume, supply, change]);
      }
      
      //show datatable
      jQuery(".cp-cryptocurrencies-table").DataTable({
        data: dataSet,
        columns: [{ title: "#" },{ title: "Coin" }, { title: "Market Cap, '.$base_currency.'" }, { title: "Price" }, { title: "Volume (24h), '.$base_currency.'" }, { title: "Circulating supply" }, { title: "Change (24h)" }, ],
        "order": [ [0, \'asc\'] ],
        "pageLength": '.$perpage.',
        "lengthMenu": [ [10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, "All"] ],
        drawCallback: function() {
          var lazy = jQuery(".cp-cryptocurrencies-table img").Lazy({
            chainable: false,
            defaultImage: \'data:image/png;base64,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\'                            
          });
          lazy.update(); 
        },
      });
    } );
    </script>
    ';

    return $html;
  }
}