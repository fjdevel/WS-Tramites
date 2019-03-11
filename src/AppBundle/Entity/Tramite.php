<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tramite
 *
 */
class TipoTramite
{
    /**
     * @var string
     *
     */
    private $numeroExpediente;

    /**
     * @var string
     *
     */
    private $estado;

    /**
     * @var string
     *
     */
    private $ubicacion;
    
    /**
     * @var integer
     *
     */
    private $tipoRespuesta;
    /**
     * @return string
     */
    public function getNumeroExpediente()
    {
        return $this->numeroExpediente;
    }

    /**
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @return string
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * @return number
     */
    public function getTipoRespuesta()
    {
        return $this->tipoRespuesta;
    }

    /**
     * @param string $numeroExpediente
     */
    public function setNumeroExpediente($numeroExpediente)
    {
        $this->numeroExpediente = $numeroExpediente;
    }

    /**
     * @param string $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @param string $ubicacion
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;
    }

    /**
     * @param number $tipoRespuesta
     */
    public function setTipoRespuesta($tipoRespuesta)
    {
        $this->tipoRespuesta = $tipoRespuesta;
    }




}
