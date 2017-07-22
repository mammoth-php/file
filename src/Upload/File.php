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
        if(file_exists($path) && is_dir($path)){
            $this->path = $path;
        } else {
            $this->erros['source'] = "O diretório (raiz) que irá conter cópia(s) do(s) arquivo(s) não existe.";
        }
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
        $path_info  = pathinfo($file['name']);
        
        $fileRename = $this->fileRename($path_info['extension']);
        $moveFile   = $this->mkDir($options['move']);
        
        if(in_array(strtolower($path_info['extension']), $options['type'])){
            if($file['size'] <= $options['size']){
                //$this->moveFile($file, $fileRename, $moveFile);
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
     * @param type $destination
     * @return boolean
     */
    
    
    private function moveFile($file, $rename, $destination){
        if(move_uploaded_file($file['tmp_name'], $destination . $rename)){
            return $rename;
        } else {
            return FALSE;
        }
    }


    /**
     * -------------------------------------------------------------------------
     * Cria um diretório dentro da pasta definida no __contruct
     * -------------------------------------------------------------------------
     * 
     * @param type $dir
     */
    
    
    private function mkDir($dir) {
        if(!file_exists($this->path . $dir)){
            //mkdir($this->path . $dir);
            echo $this->path . $dir;
        }
        
        if(!file_exists($this->path . $dir . date('Y-m-d'))){
            //mkdir($this->path . $dir . date('Y-m-d'));
            echo $this->path . $dir . date('Y-m-d');
        }
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * Renomeia o nome do arquivo que será upado, com uma criptografia.
     * -------------------------------------------------------------------------
     * 
     * @param type $extension
     * @return type
     */
    
    
    private function fileRename($extension) {
        return md5(time()) . '.' . $extension;
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

