<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Global Twitter</title>

    <script src="js/jquery.min.js"></script>
    <script async src="js/widgets.js" charset="utf-8"></script>
    <link  rel="stylesheet" href="css/style.css">
</head>

<body>
    <div id="tweet"></div>

    <script>
        let tweets = <?php include 'controller/getTweets.php' ?>;
        let $tweetTemplate = $('.twitter-tweet');
        let $containter = $('.container');
        let i = 0;

        function setTweet() {
            if (i < tweets.length) {
                var tweet = $('#tweet')[0];
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