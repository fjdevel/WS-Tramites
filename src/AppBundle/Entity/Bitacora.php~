<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bitacora
 *
 * @ORM\Table(name="bitacora", indexes={@ORM\Index(name="IDX_9087FEF93D7257F6", columns={"id_sesion"}), @ORM\Index(name="IDX_9087FEF9FCF8192D", columns={"id_usuario"})})
 * @ORM\Entity
 */
class Bitacora
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_bitacora", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="bitacora_id_bitacora_seq", allocationSize=1, initialValue=1)
     */
    private $idBitacora;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="time", nullable=true)
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_usuario", type="string", length=64, nullable=true)
     */
    private $nombreUsuario;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo_operacion", type="integer", nullable=true)
     */
    private $tipoOperacion;

    /**
     * @var \Sesion
     *
     * @ORM\ManyToOne(targetEntity="Sesion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_sesion", referencedColumnName="id_sesion")
     * })
     */
    private $idSesion;

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id_usuario")
     * })
     */
    private $idUsuario;
    /**
     * @return number
     */
    public function getIdBitacora()
    {
        return $this->idBitacora;
    }

    /**
     * @return DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @return string
     */
    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }

    /**
     * @return number
     */
    public function getTipoOperacion()
    {
        return $this->tipoOperacion;
    }

    /**
     * @return Sesion
     */
    public function getIdSesion()
    {
        return $this->idSesion;
    }

    /**
     * @return Usuario
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * @param number $idBitacora
     */
    public function setIdBitacora($idBitacora)
    {
        $this->idBitacora = $idBitacora;
    }

    /**
     * @param DateTime $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @param string $nombreUsuario
     */
    public function setNombreUsuario($nombreUsuario)
    {
        $this->nombreUsuario = $nombreUsuario;
    }

    /**
     * @param number $tipoOperacion
     */
    public function setTipoOperacion($tipoOperacion)
    {
        $this->tipoOperacion = $tipoOperacion;
    }

    /**
     * @param Sesion $idSesion
     */
    public function setIdSesion($idSesion)
    {
        $this->idSesion = $idSesion;
    }

    /**
     * @param Usuario $idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }



}
