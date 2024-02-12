<?php
// Get video_id from $_GET['id']
$vid_id = isset($_GET['id']) ? $_GET['id'] : '';

// If vid_id is empty, print '.'
if (empty($vid_id)) {
    echo '.';
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
        echo 'Curl error: ' . curl_error($ch);
    } else {
        // Use regex to extract video_id and title
        preg_match($regex_pattern, $page_content, $matches);

        // Create an associative array with vid_id and title
        $ret = array(
            'vid_id' => $vid_id,
            'title' => !empty($matches[1]) ? strip_tags($matches[1]) : '', // Strip HTML tags from the title if matches[1] is not empty
        );

        // Print JSON-encoded result
        echo json_encode($ret);
    }

    // Close cURL resource
    curl_close($ch);
}
?>
