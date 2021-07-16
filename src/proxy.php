<?php

    $url = $_SERVER["PATH_INFO"];
    $target_domain = "https://habr.com";

    $row_content = file_get_contents($target_domain . $url);

    $ready_content = str_replace(array("//habrahabr.ru/", "//habr.com/"), "//localhost/", $row_content);

    function replace_text($ready_content){


        return preg_replace_callback(
                "/<body[^>]*>(.*?)<\/body>/is",
            function($matches){
                    if (preg_match("/<[^>]+?>(.*?)<\/+?>/is",$matches[0])){
                        return replace_text($matches[0]);
                    }else{
                        return preg_replace(
                            "/\b(\w{6})\b/ui",
                            "$1™",
                            $matches[0]);
                    }
            },
            $ready_content);


    }
    $ready_content2 = replace_text($ready_content);




?>
<pre>
<?php
    print_r( $ready_content2);
?>
</pre>
<?php
?>
