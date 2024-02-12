I know YouTube API can be used and setup for a proper long term solution.

This is meant to be a quick drop in solution to assist our apps get basic info from YouTube.

I only need video title for this particular app I am working on.

Usage: 
http://localhost/watchlist/get/?id=<VIDEO_ID>

returns a JSON with vid_id and title


Want to see how I coded it from beginning?
Here it is: https://chat.openai.com/share/25b2a20f-374d-436c-b3d2-5450fe726a22


```
PHP code that will find Youtube title from a video_id

first get the $_GET['id'] as vid_id
if vid_id is empty, just print '.'
the url_video = "https://www.youtube.com/v/<VIDEO_ID>?feature=youtube_gdata_player"
where <VIDEO_ID> is the vid_id
curl the page
```

```
using regex,  extract the matched group

href="https://m.youtube.com/v/<VIDEO_ID>"><title>(.*)</title>
$ret = array of vid_id and title
print a json_encoded ( $ret)
```

```
handle curl errors,
put timeout of 7seconds, connect to 10 seconds
```

```
create variable regex
use a *.? and strip_tags() the result
```

I had to step in, to fix things up, steer it in right direction.
```
should be like this

// Define regex pattern using a variable
        $regex_pattern = '/href="https:\/\/m.youtube.com\/v\/' . $vid_id  . '"><title>(.*?)<\/title>/';

// Create an associative array with vid_id and title
        $ret = array(
            'vid_id' => $vid_id,
            'title' => strip_tags($matches[1] ?? ''), // Strip HTML tags from the title
        );

also handle in case matches are empty
```

```
php header json type
also dont just echo stuff, all results must be JSON objects
```

```
save the data into $title

then regex clean the title
( - YouTube)$
```
