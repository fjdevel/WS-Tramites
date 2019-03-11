<?php

namespace AppBundle\Service;


use AppBundle\Entity\Bitacora;
use AppBundle\Entity\Sesion;
use Doctrine\ORM\EntityManager;

class BitacoraService
{
    private $em;
    
    public const GET = 0;
    public const POST = 1;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function saveOperation(Sesion $sesion, $actionQuery, $tipoOperacion, $idEstablecimiento){

        $timeZone = 'America/El_Salvador';
        $fechaHoraActual = (new \DateTime())->setTimeZone(new \DateTimeZone($timeZone));
        
        $bitacora = new Bitacora();
        
        $bitacora->setFecha($fechaHoraActual);
        $bitacora->setIdUsuario($sesion->getIdUsuario());
        $bitacora->setSesionId($sesion);
        $bitacora->setTipoOperacion($tipoOperacion);
        $bitacora->setUser_name($sesion->getIdUsuario()->getUsername());
        $bitacora->setOperacion($actionQuery);
        $bitacora->setIdEstablecimiento($idEstablecimiento);
        
        $this->em->persist($bitacora);
        $this->em->flush();
    }
    
    
    public function plainParameters($params){
        $out = ' => [';
        
        foreach ($params as $value){
            if($value instanceof \DateTime){
                $out = $out . $value->format('d/m/Y H:i:s') . ',';
            }else{
                $out = $out . $value . ',';
            }
        }
        
        $out = substr($out, 0, strlen($out)-1);
        $out = $out . ']';
        
        return $out;
    }
}
