<?php

echo $querybusquedatweets = "SELECT t1.id_busquedatweets, t1.id_tweet,t2.text,t2.followers_count,t2.tiene_foto,t3.screen_name as screen_name, t3.profile_image_url as profile_image_url,  t3.name as user_name
FROM `twitter_busquedastweets_tweets` AS t1 
INNER JOIN `twitter_tweets` AS t2 ON t1.id_tweet = t2.id_tweet
INNER JOIN `twitter_usuarios` AS t3 ON t2.id_user_twitter = t3.id_user_twitter
WHERE t1.id_busquedatweets = '1148' and t1.estado = '1' ORDER BY t2.created_at DESC";