=== Cryptocurrency All-in-One ===
Contributors: byankov
Donate link: http://creditstocks.com/donate/
Tags: bitcoin, cryptocurrency, bitcoin, ethereum, ripple, exchange, prices, rates, trading, payments, orders, token, btc, eth, etc, ltc, zec, xmr, ppc, dsh, candlestick, usd, eur  
Requires at least: 3.0
Tested up to: 4.9.6
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Cryptocurrency features: displaying prices and exchange rates, candlestick price chart, calculator, accepting orders and payments, accepting donations.

== Description ==

Notice: The plugin has been updated to a new major version - 3.0. Untortunately, some of the old features are not compatible with the WordPress repository. You will still find them in the premium version. [Get premium now](https://creditstocks.com/cryptocurrency-one-wordpress-plugin/) 

= Cryptocurrency All-in-One free version features: = 
* coin market cap - list of all cryptocurrencies with prices and market capitalization,
* cryptocurrency ticker widget - a badge with the logo, price, and 24h change of one cryptocurrency,
* accept donations: Bitcoin (BTC), Ethereum (ETH), Litecon (LTC), Monero (XMR), Bitcoin Cash (BCH), Zcash (ZEC),
* cyptocurrency resources - helpful resources list in your WordPress admin,
* Ethereum node support: address balance, view block,
* custom designs themes: light, dark, and option to write your own CSS.
* plugin translations: German, Italian, .pot file provided. 

= Cryptocurrency All-in-One premium version features: = 
* all free version features plus:
* easily accept orders and payments: Bitcoin (BTC), Ethereum (ETH), Litecon (LTC), Bitcoin Cash (BCH), Zcash (ZEC),
* display prices and exchange rates (all cryptocurrencies),
* cryptocurrency to fiat calculator (all cryptocurrencies),
* display candlestick price charts (all cryptocurrencies), 

[Get premium now](https://creditstocks.com/cryptocurrency-one-wordpress-plugin/)

= Instructions to display a "Coin Market Capitalization" list of all cryptocurrencies on your web site. =

Add a shortcode to the text of the pages or posts where you want to display CoinMarketCap style list of all cryptocurrencies. The list is paginated, sortable, searchable. The shortcode supports selecting the base currency for showing the prices, default is USD. You can set the total number of cryptocurrencies (default 500), the cryptocurrencies per page (default 100), the number format locale. Exapmle shortcodes:

`[allcurrencies]`
`[allcurrencies basecurrency="eur"]`
`[allcurrencies limit="100" perpage="10"]`
`[allcurrencies basecurrency="eur" locale="de-DE"]`

[Live demo](https://creditstocks.com/cryptocurrency-prices/list-of-all-cryptocurrencies/)

= Instructions to accept cryptocurrency orders and payments on your web site. (Premium version only) = 

Supported currencies for payments are: Bitcoin (BTC) (default), Ethereum (ETH), Litecoin (LTC), Bitcoin Cash (BCH), Zcash (ZEC). No middleman - works with any wallet, no exchange or API required and no extra fees. High security - the plugin does not store your wallet's private keys, captcha support. 

Setup: Open the plugin settings and under "Payment settings" fill in your BTC (or other cryptocurrency) wallet addresses to receive payments and an email for receiving payment notifications. The plugin uses one of the addresses from the provided list of addresses for every payment, by rotating all of them and starting over from the first one. The different addresses are used to idenfiry if a specific payment has been made. You must provide enough addresses - more than the number of payments you will receive a day. Add a shortcode to the text of the pages or posts where you want to accept payments (typically these pages would contain a product or service that you are offering). The amount may be in BTC (default), altcoins or in fiat currency (USD, EUR, etc), which will be converted it to the selected cryptocurrency. You can also setup the form for GDPR compliance in the plugin settings.
 
Exapmle shortcodes:

`[cryptopayment item="Advertising services" amount="0.003" currency="BTC"]`
`[cryptopayment item="Publish a PR article" amount="50 USD" currency="BTC"]`
`[cryptopayment item="Publish a PR article" amount="10 EUR" currency="ETH"]`

[Live demo](https://creditstocks.com/payment-demo/)

= Instructions to accept cryptocurrency donations on your web site. = 

Add a shortcode to the text of the pages or posts where you want to accept donations. 

Supported currencies are: Bitcoin (BTC) (default), Ethereum (ETH), Litecoin (LTC), Bitcoin Cash (BCH), Monero (XMR), Zcash (ZEC). Exapmle shortcodes (do not forget to put your wallet address):

`[cryptodonation address="1ABwGVwbna6DnHgPefSiakyzm99VXVwQz9"]`
`[cryptodonation address="0xc85c5bef5a9fd730a429b0e04c69b60d9ef4c64b" currency="eth"]`
`[cryptodonation address="463tWEBn5XZJSxLU6uLQnQ2iY9xuNcDbjLSjkn3XAXHCbLrTTErJrBWYgHJQyrCwkNgYvyV3z8zctJLPCZy24jvb3NiTcTJ" paymentid="a1be1fb24f1e493eaebce2d8c92dc68552c165532ef544b79d9d36d1992cff07" currency="xmr"]`

[Live demo](https://creditstocks.com/donate/)

= Instructions to display cryptocurrency exchange rates in a nicely formatted table. (Premium version only) = 

To show cryptocurrency prices, add a shortcode to the text of the pages or posts where you want the cryptocurrency prices to apperar. Exapmle shortcodes:

`[currencyprice currency1="btc" currency2="usd,eur,ltc,eth,jpy,gbp,chf,aud,cad"]`
`[currencyprice currency1="ltc" currency2="usd,eur,btc"]`

Most cryptocurrencies are supported and the major ones also have icons: Bitcoin BTC, Ethereum ETH, XRP, DASH, LTC, ETC, XMR, XEM, REP, MAID, PIVX, GNT, DCR, ZEC, STRAT, BCCOIN, FCT, STEEM, WAVES, GAME, DOGE, ROUND, DGD, LISK, SNGLS, ICN, BCN, XLM, BTS, ARDR, 1ST, PPC, NAV, NXT, LANA. Fiat currencies conversion supported: AUD, USD, CAD, GBP, EUR, CHF, JPY, CNY.
[Live demo](https://creditstocks.com/cryptocurrency-prices/current-litecoin-price/)

= Instructions to display cryptocurrency calculator. (Premium version only) = 

To show cryptocurrency calculator, add a shortcode to the text of the pages or posts where you want the calculator prices to apperar. Exapmle shortcodes:

`[currencycalculator currency1="btc" currency2="usd,eur,ltc,eth,jpy,gbp,chf,aud,cad"]`
`[currencycalculator currency1="ltc" currency2="usd,eur,btc"]`

Most cryptocurrencies are supported and the major ones also have icons: Bitcoin BTC, Ethereum ETH, XRP, DASH, LTC, ETC, XMR, XEM, REP, MAID, PIVX, GNT, DCR, ZEC, STRAT, BCCOIN, FCT, STEEM, WAVES, GAME, DOGE, ROUND, DGD, LISK, SNGLS, ICN, BCN, XLM, BTS, ARDR, 1ST, PPC, NAV, NXT, LANA. Partial suport for over 1000 cryptocurrencies. Fiat currencies conversion supported: AUD, USD, CAD, GBP, EUR, CHF, JPY, CNY.
[Live demo](https://creditstocks.com/cryptocurrency-prices/current-litecoin-price/)

= Instructions to display cryptocurrency candlestick price chart (Premium version only) = 

To show cryptocurrency candlestick chart graphic, add a shortcode to the text of the pages or posts where you want the chart to apperar. Set the cryptocurrency that you want on the chart as currency1 and the base currency as currency2. Supported periods are 1hour, 24hours, 7days, 30days, 1year. Exapmle shortcodes:

`[currencychart currency1="btc" currency2="usd"]`
`[currencychart currency1="dash" currency2="btc" defaultperiod="1year"]`

[Live demo](https://creditstocks.com/cryptocurrency-prices/current-bitcoin-price/)

= Instructions for Ethereum node integration = 

Currently supported features are: check Ethereum address balance, view ethereum block. Before using the shortcodes you need to fill in your Ethereum node API URL in the plugin settings (http://localhost:8545 or a public node at infura.io). Exapmle shortcodes:

`[cryptoethereum feature="balance"]`
`[cryptoethereum feature="block"]`

Notice: Beware mixed content browser restriction! If your web site uses https, the node must also use https.

[Live demo](https://creditstocks.com/ethereum/)

= Instructions to use the plugin in a widget or from the theme =

To use the plugin in a widget, use the provided "CP Shortcode Widget" and put the shortcode in the "Content" section.
You can also call all plugin features directly from the theme - see the plugin settings page for PHP samples.

This plugin uses data from third party public APIs. By installing this plugin you agree with their terms:
For free and premium versions:[CoinMarketCap Public API](https://coinmarketcap.com/api/) - no API key required
For premium version only: [CryptoCompare Public API](https://www.cryptocompare.com/api/) - no API key required, under [Creative Commons license](https://creativecommons.org/licenses/by-nc/3.0/), 
[Google Charts API](https://developers.google.com/chart/terms). 
Special thanks to: Emil Samsarov, theox89, Wayne M.

== Installation ==

1. Unzip the `cryptocurrency-prices.zip` folder.
2. Upload the `cryptocurrency-prices` folder to your `/wp-content/plugins` directory.
3. In your WordPress dashboard, head over to the *Plugins* section.
4. Activate *Cryptocurrency Prices*.

== Frequently Asked Questions ==

= Can I show the plugin from the theme code or from another plugin? =

Yes. You can use a PHP code, which handles and shows the plugin shortcode - see the plugin settings page for PHP sample. 

= Can I show the plugin in a widget? =

Yes! Use the provided "CP Shortcode Widget" and put the shortcode in the "Content" section, for example: [currencyprice currency1="btc" currency2="usd,eur"].

= The plugin does not work - I just see the shortcode? =

Make sure you have activated the plugin. Try to add the shortcode to a page to see if it works. If you use a widget - add the shortcode in the widget provided by the plugin. If you call the plugin from the theme, make sure the code is integrated correctly. Make sure you paste the shortcode as plain text or in text mode, otherwise you may copy and paste invisible html code together with it.  

= Why yhe design / layout / styles are broken or look bad? =

Make sure you paste the shortcode as plain text or in text mode, otherwise you may copy and paste invisible html code together with it. Try with the default theme, maybe there is an issue with the theme. Try to enable / disable the styles from the plugin admin.

= The plugin does not work - I see no data or an error message? =

Try to activate compatibility mode from the plugin settings. It may be due to data provider server downtime. 

= How to style the plugin? / I don't like the design? =

This plugin is provided with design styles that you can set in the admin. You can also write CSS code for custom styles - use the "Custom design" field in the plugin settings. 

= Can the plugin cache the data? =

The plugin itself does not cache the data. But it is compatible with caching plugins.   

== Screenshots ==

== Changelog ==

= 3.0.8 =
* Added cryptocurrency ticker widget feature that supports bitcoin and almost all altcoins. Improved coin image library.

= 3.0.7 =
* Bugfixes.

= 3.0.6 =
* Bugfixes and minor improvements.

= 3.0.5 =
* Added support of BCH (Bictoin Cash) payments and donations. Added default period parameter support to currencychart shortcode. Improved coin market cap list of cryptocurrencies.

= 3.0.4 =
* Added Cyptocurrency Resources in plugin admin. Improved list of currencies "allcurrencies". 

= 3.0.3 =
* Added GDPR compliance of the payment form. Added more setting to "allcurrencies"" shortcode. Improved help section and readme.

= 3.0.2 =
* Improved CoinMarketCap list of currencies. Added CSS styles to the free version.

= 3.0.1 =
* Added volume to price chart. Added admin help to free version.

= 3.0 =
* Refactored plugin to use CoinMarketCap API. Created free plugin version again. Features that rely on CryptoCompare API moved to premium version.

= 2.7 =
* Refactored "allcurrencies" shortcode - coin market cap view with pagination, sorting, search. Discontinied the free plugin version, offered only as a premium plugin.

= 2.6.4 =
* Added DataTables support for the "allcurrencies" shortcode - pagination, sorting, search.

= 2.6.3 =
* Added captcha support for payments.

= 2.6.2 =
* Bugfixes. Added feature for ZCash (ZEC) payments in the premium version.

= 2.6.1 =
* Bugfixes. Added feature for altcoin payments in the premium version (ETH, LTC).

= 2.6 =
* Many improvements. Free and premium plugin versions. 

= 2.5.5 =
* Added default CSS.

= 2.5.4 =
* Fixed bugs. Improved plugin styling capabilities.

= 2.5.3 =
* Plugin is now translatable. German translation is provided. Minor improvements.

= 2.5.2 =
* Added support of parameters for [allcurrencies] shortcode.

= 2.5.1 =
* Added support for Ethereum block viewer by connecting to an Ethereum blockchain node. Other minor improvements.

= 2.5 =
* Added Ethereum blockchain node support with web3.js. Removed Counterparty support. Bugfixes.

= 2.4.5 =
* Improved cryptocurrency payments: amount can be specified in fiat currency, multiple payment forms supported on single page, orders can be deleted.  Added a feature for accepting donations in Litecon (LTC), Monero (XMR), Zcash (ZEC).

= 2.4.4 =
* Added a feature for accepting donations in Ethereum (ETH). Improved help section.

= 2.4.3 =
* Bugfixes and improvements of the payments module. Some code rewritten in OOP.

= 2.4.2 =
* Minor improvements of the payments module.

= 2.4.1 =
* Minor improvements.

= 2.4 =
* Added a basic feature for accepting payments in BTC.

= 2.3.4 =
* Added support for multiple charts per page. Added Bitcoin Cash (BCC / BCH) cryptocurrency with its icons supported.

= 2.3.3 =
* Added 30 more cryptocurrencies with their icons supported: dgb, iot, btcd, xpy, prc, craig, xbs, ybc, dank, give, kobo, geo, ac, anc, arg, aur, bitb, blk, xmy, moon, sxc, qtl, btm, bnt, cvc, pivx, ubq, lenin, bat, plbt

= 2.3.2 =
* Added feature to support custom CSS. Fixed minor bugs.

= 2.3.1 =
* Added feature to show only calculator or prices table. Added compatibility mode for servers without CURL support. Fixed minor bugs. 

= 2.3 =
* Changed plugin name. Added better widget support. Improved plugin administration. Improved readme. 

= 2.2 =
* Added coins list feature. Improved plugin code architecture. 

= 2.1.1 =
* Improved price formatting and support of currencies with smaller prices. Added Lana coin icon.

= 2.1 =
* Added cryptocurrency charts feature. Added icons for many currencies: GBP, JPY, XRP, DASH, ZEC, etc.

= 2.0 =
* Major release with many new features: more cryptocurrencies, fiat currencies support, cryptocurrency donations support, counterparty assets explorer support. The new version is backward compatible - you need to update!

= 1.1 =
* Bugs fixed - you need to update.

= 1.0 =
* Plugin released.  Everything is new!

== Upgrade Notice ==

### No upgrades yet. ###