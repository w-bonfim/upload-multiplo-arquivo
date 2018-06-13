<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload múltiplos arquivos</title>
</head>
<body>

<?php
    $mensagem = array();
    
    if(isset($_POST['formulario'])):
        $extensoes_permitidas = array('jpg', 'jpeg', 'png');
        $arquivos = $_FILES['arquivos'];
        
        for($i = 0; $i < count($arquivos['name']); $i++):

                $info_arquivo = pathinfo($arquivos['name'][$i]);
                $extensao     = $info_arquivo['extension'];
                $tmp_nome     = $info_arquivo['filename'];
                               
                if(in_array($extensao, $extensoes_permitidas)):
                    $pasta = 'arquivos';
                    $filename = uniqid().'.'.$extensao;

                    if(!file_exists($pasta)):
                        mkdir($pasta, 0777, true);
                    endif;

                    if(move_uploaded_file($arquivos['tmp_name'][$i], $pasta.'/'.$filename)):
                        $mensagem[] = "Upload {$tmp_nome} realizado com sucesso ! <br>";
                    else:
                        $mensagem[] = "Não foi possivel realizar o upload de arquivo {$tmp_nome}, tente novamente mais tarde";
                    endif;    
                else:
                    $mensagem[] = "Extensão {$extensao} não é permitida do arquivo {$tmp_nome}";
                endif;

        endfor; 

    endif;    
?>

<h1>Upload múltiplos arquivos</h1>

    <?php if(count($mensagem) > 0) ?>
        <ul>
            <?php foreach($mensagem as $msg): ?>
                <li><?= $msg ?></li>
            <?php endforeach; ?>
        </ul>
    <?php ?>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
    <input type="file" name="arquivos[]" multiple>
    <button type="submit" name="formulario">Enviar</button>
</form>
    
</body>
</html>