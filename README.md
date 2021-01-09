# MediaWiki-Extension-GoogleAdSense
Allows to add Google AdSense to the sidebar

## Configuration options

Enable GoogleAdSense. Default is false.

* $wgGoogleAdSense = true;

Show the AdSense box only for anonymous users: true or false. Default is false.
* $wgGoogleAdSenseAnonOnly = true;

Replace this with your own publisher ID (google_ad_client / data-ad-client)
* $wgGoogleAdSenseClient = 'none'; // Client ID for your AdSense script (example: ca-pub-1234546403419693)

Replace this with your AdSense ad unit ID (google_ad_slot / data-ad-slot)
* $wgGoogleAdSenseSlot   = 'none'; // Slot ID for your AdSense script (example: 1234580893)

Width of the AdSense unit, specified in your AdSense account (google_ad_width / data-ad-width)
* $wgGoogleAdSenseWidth = 120;

Height of the AdSense unit, specified in your AdSense account (google_ad_height / data-ad-height)
* $wgGoogleAdSenseHeight = 240;

Source URL of the AdSense script. No need to change - it can't deviate from the defaults.
* $wgGoogleAdSenseSrc = "//pagead2.googlesyndication.com/pagead/show_ads.js";

This can be anything you like. Default is 'none'.
* $wgGoogleAdSenseID = "none";

Text coding. Default is 'utf8'.
* $wgGoogleAdSenseEncoding = "utf8";

Advertising language. Default is $wgLanguageCode.
* $wgGoogleAdSenseLang = "en";

