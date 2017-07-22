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
                $this->moveFile($file, $this->mkDir($options['move']));
            } else {
                $this->erros['size'] = "O arquivo excedeu o tamanho máximo permitido. Tamanho máximo permitido é " . $options['size'] / (1000 * 1000) . "MB";
            }
        } else {
            $this->erros['type'] = "O formato do arquivo não é suportado. Os formatos permitidos são: " . implode(', ', $options['type']);
        }
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * Movendo arquivo para diretório criado na aplicação
     * -------------------------------------------------------------------------
     *  
     * @param type $file
     * @param type $path
     * @return boolean
     */
    
    
    private function moveFile($file, $path){
        if(move_uploaded_file($file['tmp_name'], $path . $file['name'])){
            return $file['name'];
        } else {
            return FALSE;
        }
    }


    /**
     * -------------------------------------------------------------------------
     * Cria um diretório dentro da pasta definida no __contruct
     * -------------------------------------------------------------------------
     * 
     * @param type $move
     */
    
    
    private function mkDir($move) {
        if(!file_exists($this->path . $move)){
            mkdir($this->path . $move, 0777);
        }
        
        if(!file_exists($this->path . $move . date('Y-m-d'))){
            mkdir($this->path . $move . date('Y-m-d'), 0777);
        }
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * Cria um novo nome para o arquivo que será upado.
     * -------------------------------------------------------------------------
     * 
     * @param type $extension
     * @return type
     */
    
    
    private function fileEncrypted($extension) {
        return md5(time()) . $extension;
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

