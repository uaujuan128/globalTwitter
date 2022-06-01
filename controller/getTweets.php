<?php
if (!isset($_GET['id'])) {
    exit;
} else {
    $hashtagId = $_GET['id'];
}

require 'bd/connection.php';

//Obtenemos todos los tuits con este hashtag
$sql = "SELECT t1.id_busquedatweets, t1.id_tweet,t2.text,t2.followers_count,t2.tiene_foto,t3.screen_name as screen_name, t3.profile_image_url as profile_image_url, t3.name as user_name
    FROM `twitter_busquedastweets_tweets` AS t1 
    INNER JOIN `twitter_tweets` AS t2 ON t1.id_tweet = t2.id_tweet
    INNER JOIN `twitter_usuarios` AS t3 ON t2.id_user_twitter = t3.id_user_twitter
    WHERE t1.id_busquedatweets = ? and t1.estado = '1' ORDER BY t2.created_at DESC limit 5";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $hashtagId);
$stmt->execute();
$result = $stmt->get_result();

$tweets = array();

while ($row = $result->fetch_assoc()) {
    $id_tweet = $row['id_tweet'];
    array_push($tweets, $id_tweet);
}

//Obtenemos todos los usuarios que han tuiteado con este hashtag
$sql = "select count(distinct(t2.id_user_twitter)) as twitter_users 
    from twitter_busquedastweets_tweets t1 
    join twitter_tweets t2 on t1.id_tweet = t2.id_tweet 
    where t1.estado = 1 and t1.id_busquedatweets = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $hashtagId);
$stmt->execute();
$result = $stmt->get_result();

$twitterUsers;

while ($row = $result->fetch_assoc()) {
    $twitterUsers = $row['twitter_users'];
}

//Obtenemos el número total de tweets con este hashtag
$sql = "select count(*) as total_tweets 
    from twitter_busquedastweets_tweets 
    where estado = 1 and id_busquedatweets = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $hashtagId);
$stmt->execute();
$result = $stmt->get_result();

$totalTweets;

while ($row = $result->fetch_assoc()) {
    $totalTweets = $row['total_tweets'];
}

//Obtenemos el alcance de ese hastag
$sql = "select sum(distinct(u.followers_count)) as reach from twitter_busquedastweets_tweets t1 
    join twitter_tweets t2 on t1.id_tweet = t2.id_tweet 
    join twitter_usuarios u on t2.id_user_twitter = u.id_user_twitter 
    where  t1.estado = 1 and t1.id_busquedatweets = ?;
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $hashtagId);
$stmt->execute();
$result = $stmt->get_result();

$reach;

while ($row = $result->fetch_assoc()) {
    $reach = $row['reach'];
}

$conn->close();