<?php

#CONFIG: set manually
$sourceFile = __DIR__ . '/data/vanguard.json';


$pathinfo = pathinfo($sourceFile);
$sourceDir = $pathinfo['dirname'];
$fileStem = $pathinfo['filename'];

$outFile = __DIR__ . '/data/vanguard-waypoints.gpx';

$outFile = "$sourceDir/$fileStem-waypoints.gpx";

$data = json_decode(file_get_contents($sourceFile));

$items = $data->response->list->listItems->items;
$title = $data->response->list->name;

$time = date('Y-m-d\TH:i:s.000\Z');

$startTag = '<gpx xmlns="http://www.topografix.com/GPX/1/1" xmlns:gpxx="http://www.garmin.com/xmlschemas/GpxExtensions/v3" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" version="1.1" creator="4SL2GPX" xsi:schemaLocation="http://www.topografix.com/GPX/1/1 http://www.topografix.com/GPX/1/1/gpx.xsd http://www.garmin.com/xmlschemas/GpxExtensions/v3 http://www.garmin.com/xmlschemas/GpxExtensionsv3.xsd">';
$meta = "<metadata><name>$title</name><time>$time</time></metadata>";

$typeMap =
    [
        'Train Station' => ['Trackback', 'ff0000'],
        'Pub' => ['House', '00ffff'],
        'Gastropub' => ['House', '00ffff'],
        'Bar' => ['House', '00ffff'],
        'Restaurant' => ['House', '00ffff'],
        'Hotel' => ['House', '00ffff'],
    ];

$waypoints = [];

foreach ($items as $item) {
    $name = $item->venue->name;
    $lat = $item->venue->location->lat;
    $lng = $item->venue->location->lng;
    $type = $item->venue->categories ? $item->venue->categories[0]->name : '?';

    print("$name ($type) : $lat/$lng\n");

    $sym = 'Pin';
    $color = '00ff00';
    if (array_key_exists($type, $typeMap)) {
        $sym = $typeMap[$type][0];
        $color = $typeMap[$type][1];
    }

    $waypoints[] = "<wpt lon=\"$lng\" lat=\"$lat\"><name>$name</name><type>$type</type><sym>$sym</sym><color>$color</color></wpt>";
}

$closeTag = "</gpx>";

$contents = "$startTag\n$meta\n" . implode("\n", $waypoints) . $closeTag;

file_put_contents($outFile, $contents);

fputs(STDERR, "\nOutput to $outFile\n\n");
