<?php
session_start();
if(isset($_SESSION['name'])){
    $text = $_POST['text'];
    
     
    $cb = fopen("index.html", 'a');
    fwrite($cb,  "<div class='msgln'> (".date("(H:i:s)" ). " ) <b>".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
    fclose($cb);
}
?>