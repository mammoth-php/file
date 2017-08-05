<?php

namespace Mammoth\Upload;


class File {
    
    private $path;
    
    private $size;
    
    private $type;
    
    private $message;
    
    private $erro;

    private $folder = '/';
    
    private $newName;

    public function __construct($path) {
        $this->path = $path;
    }
    
    public function setFolder(string $folder) {
        $this->folder = $folder;
        var_dump($folder);
        if(!file_exists($this->path . $this->folder)):
            mkdir($this->path . $this->folder);
        endif;
    }

    public function addRules(array $rules, array $message) {
        $this->size    = intval($rules['size'] * 1024); 
        $this->type    = explode('|', $rules['type']);
        $this->message = $message;
    }
    
    public function send($file, bool $newname = FALSE) : bool{
        $this->erro    = NULL;
        $pathFile      = pathinfo($file['name']);
        $this->newName = $pathFile['filename']; 
        if(in_array($pathFile['extension'], $this->type)):
            if($this->size >= $file['size']):
                $this->verifyFolder();
                $this->createNewName($newname);
                $this->newName .= ".{$pathFile['extension']}";
                return $this->upload($file);
            else:
                $this->erro['size'] = (isset($this->message['size'])) ? $this->message['size'] : "O arquivo excedeu o tamanho permitido de 2MB.";
                return FALSE;
            endif;
        else:
            $this->erro['type'] = (isset($this->message['type'])) ? $this->message['type'] : "O formato do arquivo não permitido.";
            return FALSE;
        endif;
        
    }
    
    private function verifyFolder() {
        if(!file_exists($this->path . $this->folder . date("Y-m-d"))):
            mkdir($this->path . $this->folder . date("Y-m-d"));
        endif;
    }
    
    private function createNewName(bool $newName){
        if($newName):
            $this->newName = md5(time()) . '@' . strtotime('now');
        endif;
    }
    
    private function upload($file) : bool{
        if(move_uploaded_file($file['tmp_name'], $this->path . $this->folder . date("Y-m-d") . '/' . $this->newName)):
            return TRUE;
        else:
            $this->erro['upload'] = (isset($this->message['type'])) ? $this->message['type'] : "Houve um erro com o upload do arquivo.";
            return FALSE;
        endif;
    }
    
    public function getErros(){
        return $this->erro;
    }
    
}

