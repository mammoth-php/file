<?php

namespace Mammoth\Upload;


class File {
    
    private $image = ['png', 'jpeg', 'jpg', 'gif', 'ico', 'bmp', 'tif', 'tiff', 'pcx', 'tga', 'raw'];
    
    private $video = ['avi', 'mp4', 'vob', 'mpeg', 'mkv' ,'rmvb', '3gp', 'wmv', 'mpg', 'mov', 'flv', 'swf'];
    
    private $music = ['mp3', 'wma', 'ape', 'flac', 'acc', 'ac3', 'dts', 'mmf', 'amr', 'm4a', 'm4r', 'ogg', 'wav', 'wavpack', 'mp2'];
    
    private $dir   = NULL;
    
    private $erros = FALSE;
    
    public function __construct($dir){
        $this->dir = $dir;
    }
    
    public function upload($file, array $options){
        $path_info = pathinfo($file['name']);
        if(in_array(strtolower($path_info['extension']), $options['type'])):
            if($file['size'] <= $options['size']):
                $this->dirVerif();
            else:
            $this->erros[] = "O arquivo excedeu o tamanho maximo requerido.";
            endif;
        else:
            $this->erros[] = "O formato do arquivo n é suportado";
        endif;
    }
    
    private function dirVerif() {
        if(!file_exists($this->dir.'/upload/')):
            mkdir($this->dir.'/upload/');
        endif;
        if(!file_exists($this->dir.'/upload/'. date('Y-m-d'))):
            mkdir($this->dir.'/upload/'. date('Y-m-d'));
        endif;
    }


    public function getErros() {
        return $this->erros;
    }
    
}

