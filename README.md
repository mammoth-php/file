# File

O File é uma classe de *upload* de arquivos baseada em PHP que permite upar arquivos de várias extensões.

# Instalação

via composer.

```
$ composer require mammoth-php/file
``` 

# Usando 

``` php 
<?php

    require 'vendor/autoload.php';
    
    // Instanciando e definindo onde irá ficar a pasta de upload dos arquivos
    $file = new Mammoth\Upload\File(__DIR__ . '/public');
    
    $file->upload($_FILES['arquivo'], [
          'move' => '/uploads/',                     // diretório que irá conter os uploads separados por datas.
          'size' => 3000000,                         // tamanho do arquivo em MB. Ex: 3MB
          'type' => ['jpg', 'png', 'gif', 'ico']     // extensões permitidas(validação).
    ]);
    
    if(!$file->getErros()){
        echo 'Upload realizado com sucesso!';
    } else {
        var_dump($file->getErros());
    }
```

# Licença

O file é uma aplicação open-source licenciado sob a [licença MIT](https://opensource.org/licenses/MIT).
