<?php
function search_qualifications($data)
{
  ob_start();
  // Define the SOAP client
  $client = new SoapClient('https://quba.quartz-system.com/QuartzWSExtra/OCNNWR/WSQUBA_UB_V3.asmx?WSDL');
  // Set the SOAP action
  $soapAction = 'http://tempuri.org/QUBA_QualificationSearch';

  // Create the SOAP request
  $request = array(
    'qualificationID'     => 0,
    'qualificationTitle'  => $data['s'],
    'qualificationLevel'  => $data['level'],
    'qualificationNumber' => $data['code'],
    'provisionType'       => $data['type'],
    'unitID'              => '',
    'qcaSector'           => '',
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
        $metaInputArray[] = $child->getName();
      }
      $resultArray[] = $qualificationArray;
    }
    echo '<div class="row row-results g-5">';
    foreach ($resultArray as $result) {
      echo qual_grid($result);
    }
    echo '</div>';

    // Output as JSON
    //echo '<pre>';
    //echo json_encode($resultArray, JSON_PRETTY_PRINT);
    //echo '</pre>';

  }
  catch (Exception $e) {
    var_dump($e);
    // Handle errors (e.g., invalid XML, data extraction issues)
  }
  return ob_get_clean();
}

add_action('wp_ajax_nopriv_archive_ajax_qualifications', 'archive_ajax_qualifications'); // for not logged in users
add_action('wp_ajax_archive_ajax_qualifications', 'archive_ajax_qualifications');
function archive_ajax_qualifications()
{
  $type = $_POST['type'];
  $level = $_POST['level'];
  $code = $_POST['code'];
  $s = $_POST['s'];
  $data = array(
    'type'  => $type,
    'level' => $level,
    'code'  => $code,
    's'     => $s,
  );
  echo search_qualifications($data);
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

function qual_grid($result)
{
  ob_start();
  $check_qual = get_post_id_by_meta_field('_id', $result['ID']);
  if ($check_qual) {
    $post_id = $check_qual;
  }
  else {
    // Insert the post into the database
    $post_data['post_type'] = 'qualifications';
    $post_data['post_title'] = $result['Title'];
    $post_data['post_status'] = 'publish';
    $post_data['meta_input'] = array(
      '_id' => $result['ID']
    );

    $post_id = wp_insert_post($post_data);

  }
  if ($result['Level'] == 'E1' || $result['Level'] == 'E2' || $result['Level'] == 'E3') {
    $level_val = str_replace('E', 'Entry Level ', $result['Level']);
  }
  else {
    $level_val = str_replace('L', 'Level ', subject: $result['Level']);
  }
  ?>
  <div class="col-lg-4 post-item">
    <div class="post-box h-100">
      <div class="image-box image-box-placeholder">
        <img src="https://openawards.theprogressteam.com/wp-content/uploads/2023/10/logo-new.svg">
        <span class="level <?= $result['Level'] ?>">
          &#10004; <?= $level_val ?>
        </span>
      </div>
      <div class="content-box content-box-v1">
        <div class="heading-excerpt-box">
          <div class="heading-box">
            <h4><?= $result['Title'] ?></h4>
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
  $level = carbon_get_the_post_meta('_level');
  $data = array(
    'level' => $level
  );
  return search_qualifications($data);
}

add_shortcode('related_qualifications', 'related_qualifications');