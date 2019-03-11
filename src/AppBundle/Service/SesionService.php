<?php

namespace AppBundle\Service;


use AppBundle\Entity\Sesion;
use Doctrine\ORM\EntityManager;
use Symfony\Component\BrowserKit\Response;

class SesionService
{
    private $em;
    
    const SESION_NO_ENCONTRADA = 0;
    const SESION_EXPIRADA = 1;
    const SESION_VALIDA = 2;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getSession($token, $userId){
        return $this->em->getRepository("AppBundle:Sesion")->findOneBy(array('token'=>$token,'idUsuario'=>$userId));
        
    }
    
    public function getSessionStatus($sesion){

        $timeZone = 'America/El_Salvador';
        $fechaHoraActual = (new \DateTime())->setTimeZone(new \DateTimeZone($timeZone));
        
        if($sesion != null){
            if($fechaHoraActual->format('d/m/Y H:i:s') > $sesion->getFechaExpiracion()->format('d/m/Y H:i:s')){
                    return $this::SESION_EXPIRADA;
                }else{
                    $sesion->setFechaExpiracion($fechaHoraActual->add(new \DateInterval('PT30M')));
                    
                    $this->em->persist($sesion);
                    $this->em->flush();
                }
        }else{
           return $this::SESION_NO_ENCONTRADA;
        }
        
        return $this::SESION_VALIDA;
    }
}
