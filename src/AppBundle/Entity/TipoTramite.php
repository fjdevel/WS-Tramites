<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoTramite
 *
 * @ORM\Table(name="tipo_tramite")
 * @ORM\Entity
 */
class TipoDeTramite
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_tipo_tramite", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="tipo_tramite_id_tipo_tramite_seq", allocationSize=1, initialValue=1)
     */
    private $idTipoTramite;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_tramite", type="string", length=1, nullable=true)
     */
    private $codigoTramite;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=128, nullable=true)
     */
    private $nombre;
    /**
     * @return number
     */
    public function getIdTipoTramite()
    {
        return $this->idTipoTramite;
    }

    /**
     * @return string
     */
    public function getCodigoTramite()
    {
        return $this->codigoTramite;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param number $idTipoTramite
     */
    public function setIdTipoTramite($idTipoTramite)
    {
        $this->idTipoTramite = $idTipoTramite;
    }

    /**
     * @param string $codigoTramite
     */
    public function setCodigoTramite($codigoTramite)
    {
        $this->codigoTramite = $codigoTramite;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }



}
