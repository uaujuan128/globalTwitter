<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Global Twitter</title>

    <script src="js/jquery.min.js"></script>
    <link  rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    require 'bd/connection.php';

    $sql = "SELECT t1.id_busquedatweets, t1.id_tweet,t2.text,t2.followers_count,t2.tiene_foto,t3.screen_name as screen_name, t3.profile_image_url as profile_image_url, t3.name as user_name
    FROM `twitter_busquedastweets_tweets` AS t1 
    INNER JOIN `twitter_tweets` AS t2 ON t1.id_tweet = t2.id_tweet
    INNER JOIN `twitter_usuarios` AS t3 ON t2.id_user_twitter = t3.id_user_twitter
    WHERE t1.id_busquedatweets = '1148' and t1.estado = '1' ORDER BY t2.created_at DESC";

    $queryTweets = $conn->query($sql);

    while ($row = $queryTweets->fetch_assoc()) {

        $text = $row['text'];
        $text = preg_replace('/(^|\s)@([a-z0-9_]+)/i', '$1<a href="http://www.twitter.com/$2">@$2</a>', $text);
        $text = preg_replace('/(^|\s)#([a-z0-9_]+)/i','$1<a href="https://twitter.com/hashtag/$2">#$2</a>', $text);
        $id_busquedatweets = $row['id_busquedatweets'];
        $imagenprevia = $row['profile_image_url'];
        $imagen = explode("_normal", $imagenprevia);
        $id_tweet = $row['id_tweet'];
        $screen_name = $row['screen_name'];
        $user_name = $row['user_name'];
        $profile_image = $imagen[0].$imagen[1];
        $tiene_foto = $row['tiene_foto'];
    }

    $conn->close();
    ?>
</body>
</html>