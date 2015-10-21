<?php
    $serverPath = 'http://dale.ag/tools/gerador-html/';
    //$serverPath = 'http://localhost/gerador-html/';

    if (isset($_POST['generate']))
    {
        if (! isset($_FILES['imagem']) || ! is_uploaded_file($_FILES['imagem']['tmp_name']))
            exit('Imagem não selecionada. <a href="./">Volte e tente novamente</a>');

        if ($_FILES['imagem']['error'] !== UPLOAD_ERR_OK)
            exit('Upload falhou. Código de erro: '.$_FILES['image']['error'].'<br/> <a href="./">Volte e tente novamente com outra imagem</a>');

        if (!validMimeType($_FILES['imagem']))
            exit('Imagem com formato inválido, imagens devem ser: JPG, GIF ou PNG. <a href="./">Volte e tente novamente</a>');


        //////////// FILE UPLOAD
        $path_parts = pathinfo($_FILES["imagem"]["name"]);
        $extension = $path_parts['extension'];
        $file = 'upload/' . $filename = base64_encode(date("D M j G:i:s T Y")) . '.' . $extension;
        move_uploaded_file($_FILES["imagem"]["tmp_name"], $file);


        //////////// HTML
        $filename = 'emkt.html';
        $subject = $_POST['subject'];
        $link = $_POST['link'];
        $bg = $_POST['bg'];
        $textcolor = $_POST['textcolor'];

        if (! empty($link)) $lineImage = "<td><a href='".$link."' target='_blank'><img src='".$serverPath . $file."'></a></td>";
        else
        {
            $lineImage = "<td><img src='".$serverPath . $file."'></td>";
            $link = '';
        }

        if (! empty($bg)) $lineBody = "<body bgcolor='".$bg."'>";
        else
        {
            $lineBody = "<body>";
            $bg = '';
        }

        $caso = urldecode($serverPath.'viewer.php?subject='.$subject.'&bg='.substr($bg, 1).'&textcolor='.substr($textcolor, 1).'&link='.$link.'&file='.$file);

        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/octet-stream; "); 
        header("Content-Transfer-Encoding: binary");

        $html = "<html>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
            <title>".$subject."</title>
        </head>

        ".$lineBody."
        <p align='center' style='font-family:Arial; text-align:center; font-size:14px; color:".$textcolor."'>Caso não consiga visualizar o e-mail corretamente, acesse este <a href='".$caso."' target='_blank' style='color:".$textcolor."'>link</a>.</p>
        <br />
        <table border='0' cellpadding='0' cellspacing='0' align='center'>
        <tr>
        ".$lineImage."
        </tr>
        </table>
        </body>
        </html>";

        echo $html;
        exit;
    }





    //////////// FUNCTIONS
    function validMimeType($file)
    {
        $type = $file['type'];
        $validTypes = array('image/jpeg', 'image/png', 'image/gif');

        if (!in_array($type, $validTypes))
            return false;
        else
            return true;
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!--[if lte IE 7]> <html class="ie7" xmlns="http://www.w3.org/1999/xhtml"> <![endif]-->  
<!--[if IE 8]>     <html class="ie8" xmlns="http://www.w3.org/1999/xhtml"> <![endif]-->  
<!--[if IE 9]>     <html class="ie9" xmlns="http://www.w3.org/1999/xhtml"> <![endif]-->  
<!--[if !IE]><!--> <html xmlns="http://www.w3.org/1999/xhtml">             <!--<![endif]-->  

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <title>Gerador de HTML</title>
    
    <link href="css/reset.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/colpick.css" rel="stylesheet" type="text/css"/>

    <script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="js/colpick.js" type="text/javascript"></script>
    <script src="js/application.js" type="text/javascript"></script>

    <link rel="shortcut icon" href="favicon.ico">

    
    <!--[if IE]>
    	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>

<body>




<div id="wrapper">

    <form enctype="multipart/form-data"  action="index.php" method="post">

        <h1>GERADOR DE HTML</h1>

        <div id="form">
            <label for="subject">Assunto:</label>
            <input type="text" id="subject" name="subject" />

            <label for="link">URL (opcional):</label>
            <input type="text" id="link" name="link" placeholder="ex: http://www.url.com.br" />

            <label for="bg">Background (opcional):</label>
            <input type="text" id="bg" name="bg" placeholder="padrão: #FFFFFF (branco)" autocomplete="off" />

            <label for="text-color">Cor do texto (opcional):</label>
            <input type="text" id="textcolor" name="textcolor" placeholder="padrão: #000000 (preto)" autocomplete="off" />

            <label for="imagem">JPG, PNG ou GIF (72dpi):</label>
            <input type="file" id="imagem" name="imagem" />

            <input type="hidden" name="generate" value="true" />
        </div>

        <input type="submit" value="GERAR HTML" />

    </form>

</div>





</body>
</html>
