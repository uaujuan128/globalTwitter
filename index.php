<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Global Twitter</title>
    <script src="js/widgets.js" charset="utf-8"></script>
    <script src="js/jquery.min.js"></script>

    <link  rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include 'controller/getTweets.php' ?>

    <?php
        echo $twitterUsers . ' tsuarios que han tuiteado.<br><br>';
        echo $totalTweets . ' tweets totales <br><br>';
        echo $reach . ' alcance total.<br><br>';
    ?>
    <div id="tweet"></div>


    <script>
        let tweets = <?php echo json_encode($tweets) ?>;
        let i = 0;

        function setTweet() {
            if (i < tweets.length) {
                let tweet = document.getElementById("tweet");
                tweet.innerHTML = '';

                twttr.widgets.createTweet(tweets[i], tweet,
                    {
                        conversation : 'none',
                        cards        : 'visible',
                        linkColor    : '#cc0000',
                        theme        : 'light'
                    })

                i++;
            } else {
                location.reload();
            }
        }

        $(document).ready(function () {
            setTweet();
            setInterval(setTweet, 5000);
        });
    </script>
</body>
</html>