<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Global Twitter</title>

    <script src="js/jquery.min.js"></script>
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    <link  rel="stylesheet" href="css/style.css">
</head>

<body>
    <div id="tweet" tweetID="515490786800963584"></div>

    <?php
    if (!isset($_GET['id'])) {
        exit;
    } else {
        $hashtagId = $_GET['id'];
    }

    require 'bd/connection.php';

    $sql = "SELECT t1.id_busquedatweets, t1.id_tweet,t2.text,t2.followers_count,t2.tiene_foto,t3.screen_name as screen_name, t3.profile_image_url as profile_image_url, t3.name as user_name
    FROM `twitter_busquedastweets_tweets` AS t1 
    INNER JOIN `twitter_tweets` AS t2 ON t1.id_tweet = t2.id_tweet
    INNER JOIN `twitter_usuarios` AS t3 ON t2.id_user_twitter = t3.id_user_twitter
    WHERE t1.id_busquedatweets = ? and t1.estado = '1' ORDER BY t2.created_at DESC limit 10";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $hashtagId);
    $stmt->execute();
    $result = $stmt->get_result();

    $tweets = array();

    while ($row = $result->fetch_assoc()) {
        $id_tweet = $row['id_tweet'];
        array_push($tweets, $id_tweet);
    }
    ?>

    <script>
        let tweets = <?php echo json_encode($tweets); ?>;
        let $tweetTemplate = $('.twitter-tweet');
        let $containter = $('.container');

        for (let i = 0; i < tweets.length; i++) {
            setTimeout(function () {
                var tweet = document.getElementById("tweet");
                var id = tweet.getAttribute(tweets[i]);

                twttr.widgets.createTweet(id, tweet,
                    {
                        conversation : 'none',    // or all
                        cards        : 'hidden',  // or visible
                        linkColor    : '#cc0000', // default is blue
                        theme        : 'light'    // or dark
                    })
                    .then (function (el) {

                    });
            }, 1000);
        }

    </script>
</body>
</html>