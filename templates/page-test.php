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
$header = new SOAPHeader($ns, 'ChannelCredentials', $headerbody);

// //set the Headers of Soap Client. 
$client->__setSoapHeaders($header);

$fcs = $client->__getFunctions();

$res_FetchPropertyInfo = $client->QUBA_AddLearnerPhotoId();

var_dump($client->__getLastRequest());
