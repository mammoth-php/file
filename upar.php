<?php
    
    require 'vendor/autoload.php';
    
    date_default_timezone_set('America/Fortaleza');
    
    // Instanciando e definindo onde irá ficar a pasta de upload dos arquivos
    $file = new Mammoth\Upload\File(__DIR__ . '/public_html');
    
    //var_dump($_FILES);
    
    $file->upload($_FILES['arquivo'], [
        'move' => '/uploaded/',                   // diretório que irá conter os uploads separados por datas.
        'size' => 1000000,                        // tamanho do arquivo em MB.
        'type' => ['jpg', 'png']                  // extensões permitidas(validação).
    ]);
    
    if(!$file->getErros()){
        echo 'Upload realizado com sucesso!';
    } else {
        var_dump($file->getErros());
    }
