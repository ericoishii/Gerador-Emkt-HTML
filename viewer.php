<?php

    $subject = $_GET['subject'];
	$link = $_GET['link'];
    $bg = $_GET['bg'];
    $file = $_GET['file'];
    $textcolor = $_GET['textcolor'];
    $caso = urldecode($serverPath.'viewer.php?subject='.$subject.'&bg='.$bg.'&textcolor='.$textcolor.'&link='.$link.'&file='.$file);

    if (! empty($link)) $lineImage = "<td><a href='".$link."' target='_blank'><img src='".$file."'></a></td>";
    else $lineImage = "<td><img src='".$file."'></td>";

    if (! empty($bg)) $lineBody = "<body bgcolor='#".$bg."'>";
    else $lineBody = "<body>";

    $html = "<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <title>".$subject."</title>
    </head>
    ".$lineBody."
    <p align='center' style='font-family:Arial; text-align:center; font-size:14px; color:#".$textcolor."'>Caso não consiga visualizar o e-mail corretamente, acesse este <a href='".$caso."' target='_blank' style='color:".$textcolor."'>link</a>.</p>
    <br />
    <table border='0' cellpadding='0' cellspacing='0' align='center'>
    <tr>
    ".$lineImage."
    </tr>
    </table>
    </body>
    </html>";

    echo $html;

?>