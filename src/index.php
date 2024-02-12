<?php
// Get video_id from $_GET['id']
$vid_id = isset($_GET['id']) ? $_GET['id'] : '';

// Initialize response array
$response = array();

// If vid_id is empty, set response and return
if (empty($vid_id)) {
    $response['result'] = '.';
} else {
    // Construct YouTube video URL
    $url_video = "https://www.youtube.com/v/{$vid_id}?feature=youtube_gdata_player";

    // Define regex pattern using a variable
    $regex_pattern = '/href="https:\/\/m.youtube.com\/v\/' . $vid_id . '"><title>(.*?)<\/title>/';

    // Initialize cURL
    $ch = curl_init($url_video);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 7); // Timeout in seconds for the entire request
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // Timeout for connecting to the server

    // Execute cURL and handle errors
    $page_content = curl_exec($ch);
    if (curl_errno($ch)) {
        // Handle cURL error
        $response['error'] = 'Curl error: ' . curl_error($ch);
    } else {
        // Use regex to extract video_id and title
        preg_match($regex_pattern, $page_content, $matches);

        // Set response with vid_id and title as JSON object
        $response['result'] = array(
            'vid_id' => $vid_id,
            'title' => !empty($matches[1]) ? strip_tags($matches[1]) : '', // Strip HTML tags from the title if matches[1] is not empty
        );
    }

    // Close cURL resource
    curl_close($ch);
}

// Set JSON content type header
header('Content-Type: application/json');

// Print JSON-encoded response
echo json_encode($response);
?>
