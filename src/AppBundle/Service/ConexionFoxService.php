<?php

namespace AppBundle\Service;



class ConexionFoxService
{
    private $pdo;
    
    public function getPdo(){
        
        if($this->pdo == null){
            $options = array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION);
            $this->pdo = new \PDO('odbc:Driver={Microsoft Visual FoxPro Driver};SourceType=DBF;SourceDB=Tramites;Exclusive=No"');
        }
        
        return $this->pdo;
    }
    
}
