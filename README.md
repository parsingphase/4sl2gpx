4SL2GPX
=======

Foursquare lists to GPX convertor

Setup
-----

Get an application key from your Foursquare account:

1. Visit https://foursquare.com/developers/apps 
1. Create an app on the free tier
1. Get your Client ID and Client Secret

Usage
-----

1. Find your list, eg https://foursquare.com/parsingphase/list/vanguard-way
1. Dump the list to your hard drive via an API call:

        FSCLIENT=YOURCLIENTIDHERE
        FSSECRET=YOURCLIENTSECRETHERE
        FSOUTPUT=list.json # example
        FSLISTID=parsingphase/london-craft-beer # example
        curl -X GET -G  https://api.foursquare.com/v2/lists/$FSLISTID -d client_id=$FSCLIENT -d client_secret=$FSSECRET -d v=20180323 -o $FSOUTPUT          

1. Modify the `$sourceFile` line at the top of `convert-list-to-waypoints.php` to point to this file
1. Run the script: `php convert-list-to-waypoints.php`
1. Waypoints will be described & output:

        ...
        Rose Cottage Inn (Pub) : 50.831954127606/0.13859023650566
        Golden Cross Inn (Pub) : 50.891285614054/0.18496513366699
        Yew Tree Inn (Pub) : 50.845951876264/0.19209795220683
        Plough and Harrow (Bar) : 50.794833701457/0.15950750861373
        The Carpenters Arms (Pub) : 51.248175414391/0.040117454737234
        Bishopstone Railway Station (BIP) (Train Station) : 50.780051293812/0.082674669514551
        
        Output to /Users/wechsler/repos/4sl2gpx/data/vanguard-waypoints.gpx



Useful links
------------
- https://developer.foursquare.com/docs/api/lists/details
- https://developer.foursquare.com/docs/explore#req=lists/parsingphase/vanguard-way
- https://api.foursquare.com/v2/lists/parsingphase/vanguard-way?oauth_token=TOKEN&v=20170823
- http://www.topografix.com/gpx_manual.asp#wpt
- http://www.topografix.com/gpx.asp