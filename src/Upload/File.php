<?php

namespace Mammoth\Upload;


class File {
    
    
    /**
     * @var type | $path 
     */
    
    
    private $path  = NULL;
    
    
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
        $pathInfo  = pathinfo($file['name']);
        
        if(in_array(strtolower($pathInfo['extension']), $options['type'])){
            if($file['size'] <= $options['size']){
                
                $this->mkDir($options['move']); // Cria um diretório 
                
                $fileRename = $this->fileRename($pathInfo['extension']); // Gerando um nome criptografado para o arquivo
                $pathFile   = $this->path . $options['move'] . date('d-m-Y'); // Definindo o caminho criado anteriormente
                
                $this->moveFile($file,  $pathFile . '/' . $fileRename); // Copiando arquivo para o destino
            } else {
                $this->erros['size'] = "O arquivo excedeu o tamanho máximo permitido. (Tamanho: " . round($options['size'] / (1000 * 1000), 2) . "MB)";
            }
        } else {
            $this->erros['type'] = "O formato do arquivo não é suportado. (Formatos suportados: " . implode(', ', $options['type']) . ")";
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
    
    
    private function moveFile($file, $destination){
        if(move_uploaded_file($file['tmp_name'], $destination)){
            return $destination;
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
            mkdir($this->path . $dir, 0777);
        }
        
        if(!file_exists($this->path . $dir . date('d-m-Y'))){
            mkdir($this->path . $dir . date('d-m-Y'), 0777);
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
        return  '@' . date('H%i%s') . '@' . md5(time()) . '.' . $extension;
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

