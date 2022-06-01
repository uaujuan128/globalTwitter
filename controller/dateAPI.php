<?php
    if (!isset($_GET['id'])) {
        exit;
    } else {
        $hashtagId = $_GET['id'];
    }
    require "bd/connection.php";

    $sql = "SELECT MAX(created_at) fecha FROM twitter_tweets t1 
            JOIN twitter_busquedastweets_tweets t2 
            ON t1.id_tweet = t2.id_tweet 
            WHERE t2.estado = 1 AND t2.id_busquedatweets = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $hashtagId);
    $stmt->execute();
    $result = $stmt->get_result();


    while ($row = $result->fetch_assoc()) {
        $fecha = $row['fecha'];
    }

    $minutes = 20;
    $seconds = $minutes * 60;
    $diffTime = strtotime(date("h:i:sa")) - strtotime($fecha);

    if ($seconds < $diffTime) {
        echo "Se ha superado el tiempo";
    }

?>