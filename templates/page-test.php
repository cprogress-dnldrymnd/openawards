<?php

/*
Template name: Page Template : Test
*/

$client = new SoapClient("https://quba.quartz-system.com/QuartzWSExtra/OCNNWR_ST/WSQUBA_UB_V3.asmx?wsdl", array('trace' => 1));

$ns = 'ChartsWeb'; //Namespace of the WS. 

//Body of the Soap Header. 
$headerbody = array(
    'Username' => 'test',
    'Password' => 'test',
    'LoggingRequest' => True
);

//Create Soap Header.        
$header = new SOAPHeader($ns, '2dfb523c-711b-42bc-a82f-476e4eb06fa5', $headerbody);

// //set the Headers of Soap Client. 
$client->__setSoapHeaders($header);

$fcs = $client->__getFunctions();

$res_FetchPropertyInfo = $client->QUBA_GetQualificationGuide(1);

echo '<pre>';
var_dump($fcs);

echo '</pre>';


var_dump($res_FetchPropertyInfo);
