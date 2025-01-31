<?php

/** Quba Functions */
function QUBA_GetQCASectors()
{
  $client = new SoapClient('https://quba.quartz-system.com/QuartzWSExtra/OCNNWR/WSQUBA_UB_V3.asmx?WSDL');
  // Set the SOAP action


  // Call the SOAP method
  $response = $client->QUBA_GetQCASectors();

  // Assuming $response is the object returned from the SOAP call:
  $xmlString = $response->QUBA_GetQCASectorsResult->any; // Assuming XML is in the "any" field

  $responseString = '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <QUBA_GetQCASectorsResponse xmlns="http://tempuri.org/">
      <QUBA_GetQCASectorsResult namespace="" tableTypeName="">
        ' . $xmlString . '
      </QUBA_GetQCASectorsResult>
    </QUBA_GetQCASectorsResponse>
  </soap:Body>
</soap:Envelope>';


  try {
    $xml = new SimpleXMLElement($responseString);
    $QubaGetSSAReferenceData = $xml->xpath('//QubaGetSSAReferenceData');
    return $QubaGetSSAReferenceData;
  } catch (Exception $e) {
    var_dump($e);
    // Handle errors (e.g., invalid XML, data extraction issues)
  }
}
function QUBA_QualificationSearch($data)
{
  ob_start();
  // Define the SOAP client
  $client = new SoapClient('https://quba.quartz-system.com/QuartzWSExtra/OCNNWR/WSQUBA_UB_V3.asmx?WSDL');
  // Set the SOAP action

  // Create the SOAP request
  $request = array(
    'qualificationID'     => 0,
    'qualificationTitle'  => $data['qualificationTitle'],
    'qualificationLevel'  => $data['qualificationLevel'],
    'qualificationNumber' => $data['qualificationNumber'],
    'qcaSector'           => $data['qcaSector'],
    'provisionType'       => '',
    'unitID'              => '',
    'includeHub'          => false,
    'centreID'            => ''
  );
  // Call the SOAP method
  $response = $client->QUBA_QualificationSearch($request);

  // Assuming $response is the object returned from the SOAP call:
  $xmlString = $response->QUBA_QualificationSearchResult->any; // Assuming XML is in the "any" field

  $responseString = '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
      <soap:Body>
        <QUBA_QualificationSearchResponse xmlns="http://tempuri.org/">
          <QUBA_QualificationSearchResult namespace="" tableTypeName="">
          ' . $xmlString . '
          </QUBA_QualificationSearchResult>
        </QUBA_QualificationSearchResponse>
      </soap:Body>
    </soap:Envelope>';

  try {
    $xml = new SimpleXMLElement($responseString);
    $qualifications = $xml->xpath('//QubaQualification'); // Extract qualification nodes


    foreach ($qualifications as $qualification) {
      // Extract and process data from each qualification element
      $qualificationArray = [];
      foreach ($qualification->children() as $child) {
        $qualificationArray[$child->getName()] = htmlentities($child);
      }
      $resultArray[] = $qualificationArray;
    }

    if ($data['qualificationType'] != '') {
      $qualificationType = $data['qualificationType'];
      $resultArray_final = array_filter($resultArray, function ($result) use ($qualificationType) {
        return $result['Type'] == $qualificationType;
      });
    } else {
      $resultArray_final = $resultArray;
    }

    if (count($resultArray_final) != 0) {
      echo '<div class="row row-results g-5">';
      foreach ($resultArray_final as $data) {
        echo qual_grid($data);
      }
      echo '</div>';
    } else {
      echo 'No results found';
    }

    // Output as JSON
    //echo '<pre>';
    //echo json_encode($resultArray, JSON_PRETTY_PRINT);
    //echo '</pre>';

  } catch (Exception $e) {
    var_dump($e);
    // Handle errors (e.g., invalid XML, data extraction issues)
  }
  return ob_get_clean();
}

function QUBA_QualificationSearchPost()
{
  ob_start();
  $posts = get_posts(array(
    'post_type' => 'qualifications',
    'numberposts' => 15,
    'orderby' => 'rand',
  ));

  echo "<div class='row row-results g-5'>";
  foreach ($posts as $post) {
    $level = carbon_get_post_meta($post->ID, 'level');
    $data = array(
      'Level'   => $level,
      'Title'   => $post->post_title,
      'post_id' => $post->ID,
    );
    echo qual_grid($data, 'qualifications', true);
  }
  echo "</div>";
  return ob_get_clean();
}

function QUBA_UnitSearch($data)
{
  ob_start();
  // Define the SOAP client
  $client = new SoapClient('https://quba.quartz-system.com/QuartzWSExtra/OCNNWR/WSQUBA_UB_V3.asmx?WSDL');
  //$unitTitle_array = array('L5');
  $resultArray = [];
  // Create the SOAP request
  $request = array(
    'unitID' => $data['unitID'],
    'unitIdAlpha' => '',
    'unitTitle' => $data['unitTitle'],
    'allOrPartTitle' => false,
    'unitLevel' => $data['unitLevel'],
    'unitCredits' => 0,
    'qcaSector' => $data['qcaSector'],
    'learnDirectCode' => '',
    'qcaCode' => $data['qcaCode'],
    'unitType' => '',
    'provisionType' => '',
    'includeHub' => false,
    'moduleID' => '',
    'alternativeUnitCode' => '',
  );

  // Call the SOAP method
  $response = $client->QUBA_UnitSearch($request);

  // Assuming $response is the object returned from the SOAP call:
  $xmlString = $response->QUBA_UnitSearchResult->any; // Assuming XML is in the "any" field

  $responseString = '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <QUBA_UnitSearchResponse xmlns="http://tempuri.org/">
      <QUBA_UnitSearchResult namespace="" tableTypeName="">
      ' . $xmlString . '
      </QUBA_UnitSearchResult>
    </QUBA_UnitSearchResponse>
  </soap:Body>
</soap:Envelope>';
  try {
    $xml = new SimpleXMLElement($responseString);
    $units = $xml->xpath('//QubaUnit'); // Extract qualification nodes

    foreach ($units as $unit) {
      // Extract and process data from each qualification element
      $unitArray = [];
      foreach ($unit->children() as $child) {
        $unitArray[$child->getName()] = htmlentities($child);
      }
      $resultArray[] = $unitArray;
    }

    if (count($resultArray) != 0) {
      echo '<div class="row row-results g-5">';
      foreach ($resultArray as $data) {
        echo qual_grid($data, 'units');
      }
      echo '</div>';
    } else {
      echo 'No results found';
    }
  } catch (Exception $e) {
    var_dump($e);
    // Handle errors (e.g., invalid XML, data extraction issues)
  }

  return ob_get_clean();
}


add_action('wp_ajax_nopriv_archive_ajax_qualifications', 'archive_ajax_qualifications'); // for not logged in users
add_action('wp_ajax_archive_ajax_qualifications', 'archive_ajax_qualifications');
function archive_ajax_qualifications()
{
  $source = isset($_POST['source']) && $_POST['source'] != '' ? $_POST['source'] : '';
  $qualificationLevel = isset($_POST['qualificationLevel']) && $_POST['qualificationLevel'] != '' ? $_POST['qualificationLevel'] : '';
  $qualificationNumber = isset($_POST['qualificationNumber']) && $_POST['qualificationNumber'] != '' ? $_POST['qualificationNumber'] : '';
  $qualificationTitle = isset($_POST['qualificationTitle']) && $_POST['qualificationTitle'] != '' ? $_POST['qualificationTitle'] : '';
  $qualificationType = isset($_POST['qualificationType']) && $_POST['qualificationType'] != '' ? $_POST['qualificationType'] : '';
  $qcaSector = isset($_POST['qcaSector']) && $_POST['qcaSector'] != '' ? $_POST['qcaSector'] : '';
  $data = array(
    'qualificationLevel'  => $qualificationLevel,
    'qcaSector'           => $qcaSector,
    'qualificationNumber' => $qualificationNumber,
    'qualificationTitle'  => $qualificationTitle,
    'qualificationType'   => $qualificationType
  );
  if ($source == 'quba') {
    echo QUBA_QualificationSearch($data);
  } else {
    echo QUBA_QualificationSearchPost($data);
  }
  die();
}


add_action('wp_ajax_nopriv_archive_ajax_units', 'archive_ajax_units'); // for not logged in users
add_action('wp_ajax_archive_ajax_units', 'archive_ajax_units');
function archive_ajax_units()
{
  $qcaCode = isset($_POST['qcaCode']) && $_POST['qcaCode'] != '' ? $_POST['qcaCode'] : '';
  $unitLevel = isset($_POST['unitLevel']) && $_POST['unitLevel'] != '' ? $_POST['unitLevel'] : '';
  $unitTitle = isset($_POST['unitTitle']) && $_POST['unitTitle'] != '' ? $_POST['unitTitle'] : '';
  $qcaSector = isset($_POST['qcaSector']) && $_POST['qcaSector'] != '' ? $_POST['qcaSector'] : '';
  $unitID = isset($_POST['unitID']) && $_POST['unitID'] != '' ? $_POST['unitID'] : 0;

  $data = array(
    'qcaCode'  => $qcaCode,
    'qcaSector'           => $qcaSector,
    'unitLevel' => $unitLevel,
    'unitTitle'  => $unitTitle,
    'unitID' => $unitID
  );
  echo QUBA_UnitSearch($data);
  die();
}




function get_post_id_by_meta_field($meta_key, $meta_value)
{
  global $wpdb;

  $query = $wpdb->prepare(
    "SELECT pm.post_id FROM $wpdb->postmeta pm
        JOIN $wpdb->posts p ON pm.post_id = p.ID
        WHERE pm.meta_key = %s AND pm.meta_value = %s
        AND p.post_status = 'publish' LIMIT 1", // Limit to one result
    $meta_key,
    $meta_value
  );

  $post_id = $wpdb->get_var($query);

  return $post_id;
}
function santize_html($html)
{
  // Use a regular expression to remove all attributes.
  $html = str_replace('SPANstyle;', 'span style', $html);
  $html = html_entity_decode($html);
  $html = str_replace('&nbsp;', '', $html);
  $html = preg_replace('/<([a-z][a-z0-9]*)([^>]*?)>/i', '<$1>', $html);
  $html = preg_replace("/<[^\/>]*>([\s]?)*<\/[^>]*>/", '', $html);
  return $html;
}

function qual_grid($data, $post_type = 'qualifications', $post = false)
{
  ob_start();
  if ($post == false) {
    $check_qual = get_post_id_by_meta_field('_id', $data['ID']);
    if ($data['QualificationSummary']) {
      $post_content = santize_html($data['QualificationSummary']);
    } else {
      $post_content = '';
    }
    $post_data['post_type'] = $post_type;
    $post_data['post_title'] = $data['Title'];
    $post_data['post_status'] = 'publish';
    $post_data['post_content'] = $post_content;

    $post_data['meta_input'] = array(
      '_id' => $data['ID'],
      '_level' => $data['Level'],
      '_type' => $data['Type'],
      '_regulationstartdate' => $data['RegulationStartDate'],
      '_operationalstartdate' => $data['OperationalStartDate'],
      '_regulationenddate' => $data['RegulationEndDate'],
      '_reviewdate' => $data['ReviewDate'],
      '_totalcreditsrequired' => $data['TotalCreditsRequired'],
      '_minimumcreditsatorabove' => $data['MinimumCreditsAtOrAbove'],
      '_qualificationreferencenumber' => $data['QualificationReferenceNumber'],
      '_contactdetails' => $data['ContactDetails'],
      '_minage' => $data['MinAge'],
      '_tqt' => $data['TQT'],
      '_glh' => $data['GLH'],
      '_alternativequalificationtitle' => $data['AlternativeQualificationTitle'],
      '_classification1' => $data['Classification1'],
    );

    if ($check_qual) {
      $post_id = $check_qual;
      $post_data['ID'] = $post_id;
      wp_update_post($post_data);
    } else {
      // Insert the post into the database
      $post_id = wp_insert_post($post_data);
    }
  } else {
    $post_id = $data['post_id'];
  }
  if ($data['Level'] == 'E1' || $data['Level'] == 'E2' || $data['Level'] == 'E3') {
    $level_val = str_replace('E', 'Entry Level ', $data['Level']);
  } else {
    $level_val = str_replace('L', 'Level ', subject: $data['Level']);
  }
?>
  <div class="col-lg-4 post-item">
    <div class="post-box h-100">
      <div class="image-box image-box-placeholder">
        <img src="https://openawards.theprogressteam.com/wp-content/uploads/2023/10/logo-new.svg">
        <span class="level <?= $data['Level'] ?>">
          &#10004; <?= $level_val ?>
        </span>
      </div>
      <div class="content-box content-box-v1">
        <div class="heading-excerpt-box">
          <div class="heading-box">
            <h4><?= $data['Title'] ?></h4>
          </div>
          <div class="description-box d-none">
            <?php ?>
          </div>
        </div>
      </div>
      <div class="button-group-box row g-0 align-items-center">
        <div class="button-box-v2 button-accent col">
          <a class="w-100 text-center" href="<?= get_the_permalink($post_id) ?>">View Course</a>
        </div>
      </div>
    </div>
  </div>
<?php
  return ob_get_clean();
}


function related_qualifications()
{
  ob_start();
  $level = carbon_get_the_post_meta('level');
  $args['post_type'] = 'qualifications';
  $args['numberposts'] = 3;
  $args['orderby'] = 'rand';
  $args['meta_query']['relation'] = 'AND';

  if ($level) {
    $args['meta_query'][] = array(
      'key'     => '_level',
      'value'   => array($level),
      'compare' => 'IN',
    );
  }
  $posts = get_posts($args);
  echo '<div class="row row-results g-5">';

  foreach ($posts as $post) {
    $data = array(
      'Level'   => $level,
      'Title'   => $post->post_title,
      'post_id' => $post->ID,
    );
    echo qual_grid($data, 'qualifications', true);
  }
  echo '</div>';

  return ob_get_clean();
}

add_shortcode('related_qualifications', 'related_qualifications');
