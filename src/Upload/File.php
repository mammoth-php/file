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
    
    
    public function upload($file, array $options) {
        
        if(!empty($file['name'])) {
            $file_info  = pathinfo($file['name']);
            
            if(in_array(strtolower($file_info['extension']), $options['type'])){
                if($file['size'] <= $options['size']){
                    $this->create($options['move']); 

                    $new_name  = $this->encrypt($file_info['extension']); 
                    $path_file = $this->path . $options['move'] . date('Y-m-d'); 

                    $this->move($file,  $path_file . '/' . $new_name); 
                } else {
                    $this->erros['size'] = "O arquivo excedeu o tamanho máximo permitido. (Tamanho: " . round($options['size'] / (1000 * 1000), 2) . "MB)";
                }
            } else {
                $this->erros['type'] = "O formato do arquivo não é suportado. (Formatos suportados: " . implode(', ', $options['type']) . ")";
            }
            
        } else {
            $this->erros['file'] = "O campo (arquivo/file) é obrigatório. ";
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
    
    
    private function move($file, $destination){
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
    
    
    private function create($dir) {
        if(!file_exists($this->path . $dir)) {
            mkdir($this->path . $dir);
        }
        
        if(!file_exists($this->path . $dir . date('Y-m-d'))) {
            mkdir($this->path . $dir . date('Y-m-d'));
        }
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * Renomeia o nome do arquivo que será upado com uma criptografia.
     * -------------------------------------------------------------------------
     * 
     * @param type $extension
     * @return type
     */
    
    
    private function encrypt($extension) {
        return md5(time()) . '@' . strtotime('now') . '.' . $extension;
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

