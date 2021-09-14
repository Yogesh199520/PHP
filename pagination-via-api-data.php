<?php

// Insert your Pipedrive API token
const API_TOKEN = '659c9fddb16335e48cc67114694b52074e812e03';
// Insert your Pipedrive company domain
const COMPANY_DOMAIN = 'https://companydomain.pipedrive.com/api/';
// Insert number of Deals per page you want to retrieve (cannot exceed 500 due to the pagination limit)
const DEALS_PER_PAGE = 10;
function getDeals($limit = DEALS_PER_PAGE, $start = 0) {
    echo "Getting Deals, limit: $limit, start: $start"  . PHP_EOL;
    $url = 'https://' . COMPANY_DOMAIN . '.pipedrive.com/api/v1/deals?api_token='
        . API_TOKEN . '&start=' . $start . '&limit=' . $limit;
    echo $url;
    die();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      
    echo 'Sending request...' . PHP_EOL;
      
    $output = curl_exec($ch);
    curl_close($ch);
 
    $result = json_decode($output, true);
    $deals = [];
 
    // If the result is not empty, then add each Deal into the Deals array
    if (!empty($result['data'])) {
        foreach ($result['data'] as $deal) {
            $deals[] = $deal;
        }
    } else {
        // If you have no Deals in your company, then print out the whole response
        print_r($result);
    }
 
   
    if (!empty($result['additional_data']['pagination']['more_items_in_collection'] 
        && $result['additional_data']['pagination']['more_items_in_collection'] === true)
    ) {
        
        $deals = array_merge($deals, getDeals($limit, $result['additional_data']['pagination']['next_start']));
    }
    return $deals;
}
 
$deals = getDeals();
echo 'Found '.count($deals).' deals' . PHP_EOL;
 
foreach ($deals as $key => $deal) {
    echo '#' . ($key + 1) . ' ' .  $deal['title'] . ' ' . '(Deal ID:'. $deal['id'] . ')' . PHP_EOL;  
}
?>
$api_token = '659c9fddb16335e48cc67114694b52074e812e03';
// Pipedrive company domain
$company_domain = 'efficient-company';
// URL for creating an empty remote file and associate it with an item
$url = 'https://' . $company_domain . '.pipedrive.com/api/v1/files/remote?api_token=' . $api_token;

https://pipedrive.readme.io/docs/using-pagination-to-retrieve-all-deal-titles