<!DOCTYPE html>
<?php
include 'helper.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="css/style.css" rel="stylesheet">
        <script src="javascript/jquery-1.11.2.js"></script>
        <title>Slack Demo</title>
    </head>
    <body>
        <div id="container">
            <div id="wrapper">
            <div id="content">
                <h1>Input URL</h1>
                <p>
                        <form method="post" action="index.php">
                        Input URL: <input type="text" size="25" maxlength="255" name="in_url">
                        <input type="submit" value="Submit" name="submit">
                        </form>
                </p>
                <?php
                if(isset($_POST["submit"])) {
                    if (filter_var($_POST["in_url"], FILTER_VALIDATE_URL) === FALSE) {
                        die('<font color="red">Not a valid URL</font>');
                    }
                    ?>
                <h1 id="resultsOC">Retrieved HTML: <?php echo $_POST["in_url"]; ?></h1>
                <p id="results">
                    <?php
                    $http_status=0;
                    $html=get_url_contents($_POST["in_url"], $http_status);
                    if($http_status!=200) {
                        die("Error retrieving URL. HTTP code: ".$http_status);
                    }
                    $stats=array();
                    echo html_highlight($html, $stats);
                    ?>
                </p>
                <h1>Stats</h1>
                <p>
                <ul>
                    <?php
                    $totalCtr=0;
                    foreach($stats as $tag=>$tagCount) {
                        echo "<li><span class=\"accessor\" title=\"$tag\">".$tag."</span>:<strong>".$tagCount."</strong></li>";
                        $totalCtr+=$tagCount;
                    }
                    ?>
                </ul>
                <?php
                echo "Total:<strong>".$totalCtr."</strong>";
                ?>
                </p>
                <?php
                }
                ?>
            </div>
            </div>
            <div id="footer">
                <span id="design-by">Design by <a href="http://smallpark.org">Smallpark Studios<!-- Thank you for keeping this on --></a></span> 
                      Slack Demo by Sarfaraz Soomro
            </div>
        </div>
        <script>
            $(".accessor").click( function() {
                    $(".tgOpen, .tgClose").removeClass("highlight");
                    $(".tgOpen.hl_"+$(this).attr("title")).addClass("highlight");
                    $(".tgClose.hl_"+$(this).attr("title")).addClass("highlight");
                }
            );
            $(".tgOpen,.tgClose").click( function(event) {
                    //event.stopPropagation();
                    $(".tgOpen, .tgClose").removeClass("highlight");
                    $(".hl_"+$(this).attr("title")).addClass("highlight");
                }
            );
            $("#resultsOC").click(
                function() {
                    $("#results").toggle();
                }
            );
        </script>        
    </body>
</html>
