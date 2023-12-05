<?php

ini_set('memory_limit', '-1');


require __DIR__ . '/src/RollingCurl/RollingCurl.php';

require __DIR__ . '/src/RollingCurl/Request.php';


$rollingCurl = new \RollingCurl\RollingCurl();

$i =0;

$content = file('set_base_here.txt');

$plugin = "/index.php?route=module/mega_filter/results&mfp='";

$arr = array();


foreach ($content as $string) {

 $url = trim($string);

 $url = $url.$plugin;

 $arr[] = $url;

}


print "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++". PHP_EOL;

print "                                                          testing module/mega_filter                                                             ". PHP_EOL;

print "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++". PHP_EOL;


$sites = array_reverse($arr);

$options = array(CURLOPT_TIMEOUT => 15);


foreach ($sites as $url) {

    $request = new \RollingCurl\Request($url);

    $request->setOptions($options);

    $rollingCurl->add($request);

}


$rollingCurl

    ->setCallback(function(\RollingCurl\Request $request, \RollingCurl\RollingCurl $rollingCurl) {


    $out = $request->getResponseText();

    $vuln = explode('syntax;',$out);

    $false1 = explode('<html',$out);

    $false = explode('href="',$out);

    $header = $request->getresponseInfo();

    $http_code = $header['http_code'];


 if(($http_code == '200')&!isset($false[1])&!isset($false1[1])){


    if(mb_strlen($request->getResponseText())==0){

    //print PHP_EOL . $request->getUrl(). ':posible blind' . PHP_EOL;

}   


 if(isset($vuln[1])){

    print PHP_EOL . $request->getUrl(). ':vuln' . PHP_EOL;

}




else{

}

}


else{

}


})->execute();


?>
