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
    <div id="tweet"></div>

    <script>
        let tweets;
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
                getTweets();
                i = 0;
            }
        }

        function getTweets() {
            $.ajax({
                context: this,
                async: false,
                url: 'controller/getTweets.php',
                type: 'GET',
                dataType: 'JSON',
                data: {id: <?php echo $_GET["id"] ?>}
            })
                .done(function(data) {
                    tweets = data;
                })
                .fail(function() {
                    alert('Ha habido un error');
                })
            ;
        }

        $(document).ready(function () {
            getTweets();
            setTweet();
            setInterval(setTweet, 15000);
        });
    </script>
</body>
</html>