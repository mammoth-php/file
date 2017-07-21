<?php

namespace Mammoth\Upload;


class File {
    
    
    /**
     * @var type | $path 
     */
    
    
    private $path  = NULL;
    
    
    /**
     * @var type | image extensions
     */
    
    
    private $image = ['png', 'jpeg', 'jpg', 'gif', 'ico', 'bmp', 'tif', 'tiff', 'pcx', 'tga', 'raw'];
    
    
    /**
     * @var type | video extensions
     */
    
    
    private $video = ['avi', 'mp4', 'vob', 'mpeg', 'mkv' ,'rmvb', '3gp', 'wmv', 'mpg', 'mov', 'flv', 'swf'];
    
    
    /**
     * @var type | music extensions
     */
    
    
    private $music = ['mp3', 'wma', 'ape', 'flac', 'acc', 'ac3', 'dts', 'mmf', 'amr', 'm4a', 'm4r', 'ogg', 'wav', 'wavpack', 'mp2'];
    
    
    /**
     * @var type | erros 
     */
    
    
    private $erros = FALSE;
    
    
    /**
     * -------------------------------------------------------------------------
     * Diretório onde ficará os arquivos de upload.
     * -------------------------------------------------------------------------
     *  
     * @param type $path
     */
    
    
    public function __construct($path){
        $this->path = $path;
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * Realiza o Upload de(os) arquivo(s).
     * -------------------------------------------------------------------------
     * 
     * @param type $file
     * @param array $options
     */
    
    
    public function upload($file, array $options){
        $path_info = pathinfo($file['name']);
        
        if(in_array(strtolower($path_info['extension']), $options['type'])){
            if($file['size'] <= $options['size']){
                $this->mkDir($options['move']);
            } else {
                $this->erros[] = "O arquivo excedeu o tamanho máximo permitido. Tamanho máximo permitido é " . $options['size'];
            }
        } else {
            $this->erros[] = "O formato do arquivo não é suportado.";
        }
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * Cria um diretório dentro da pasta definida no @__contruct
     * -------------------------------------------------------------------------
     * 
     * @param type $move
     */
    
    
    private function mkDir($move) {
        if(!file_exists($this->dir . $move)){
            mkdir($this->dir . $move);
        }
        
        if(!file_exists($this->dir . $move . date('Y-m-d'))){
            mkdir($this->dir . $move . date('Y-m-d'));
        }
    }


    /**
     * -------------------------------------------------------------------------
     * Retorna todos os erros possíveis.
     * -------------------------------------------------------------------------
     * 
     * @return type
     */
    
    
    public function getErros() {
        return $this->erros;
    }
    
}

