<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Usuario
 *
 * @ORM\Table(name="usuario", uniqueConstraints={@ORM\UniqueConstraint(name="usuario_num_licencia_key", columns={"num_licencia"}), @ORM\UniqueConstraint(name="usuario_documento_identidad_key", columns={"documento_identidad"})})
 * @ORM\Entity
 */
class Usuario
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_usuario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="usuario_id_usuario_seq", allocationSize=1, initialValue=1)
     */
    private $idUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_usuario", type="string", length=64, nullable=true)
     */
    private $nombreUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=128, nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=128, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=128, nullable=true)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="num_licencia", type="string", length=10, nullable=true)
     */
    private $numLicencia;

    /**
     * @var string
     *
     * @ORM\Column(name="documento_identidad", type="string", length=16, nullable=true)
     */
    private $documentoIdentidad;

    /**
     * @var string
     *
     * @ORM\Column(name="correo_electronico", type="string", length=64, nullable=true)
     */
    private $correoElectronico;

    /**
     *
     * @ORM\Column(name="clave_temporal", type="boolean", nullable=true)
     */
    private $claveTemporal = false;

    /**
     *
     * @ORM\Column(name="cuenta_verificada", type="boolean", nullable=true)
     */
    private $cuentaVerificada = false;

    /**
     *
     * @ORM\Column(name="token_verificacion", type="string", nullable=true)
     */
    private $tokenVerificacion;

    /**
     * @param string $tokenVerificacion
     */
    public function setTokenVerificacion($tokenVerificacion)
    {
        $this->tokenVerificacion = $tokenVerificacion;
    }
    
    /**
     * @return string
     */
    public function getTokenVerificacion()
    {
        return $this->tokenVerificacion;
    }
    
    /**
     * @return number
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * @return string
     */
    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @return string
     */
    public function getNumLicencia()
    {
        return $this->numLicencia;
    }

    /**
     * @return string
     */
    public function getDocumentoIdentidad()
    {
        return $this->documentoIdentidad;
    }

    /**
     * @return string
     */
    public function getCorreoElectronico()
    {
        return $this->correoElectronico;
    }

    /**
     * @param number $idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    /**
     * @param string $nombreUsuario
     */
    public function setNombreUsuario($nombreUsuario)
    {
        $this->nombreUsuario = $nombreUsuario;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @param string $apellidos
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @param string $numLicencia
     */
    public function setNumLicencia($numLicencia)
    {
        $this->numLicencia = $numLicencia;
    }

    /**
     * @param string $documentoIdentidad
     */
    public function setDocumentoIdentidad($documentoIdentidad)
    {
        $this->documentoIdentidad = $documentoIdentidad;
    }

    /**
     * @param string $correoElectronico
     */
    public function setCorreoElectronico($correoElectronico)
    {
        $this->correoElectronico = $correoElectronico;
    }




    /**
     * Set claveTemporal
     *
     * @param boolean $claveTemporal
     *
     * @return Usuario
     */
    public function setClaveTemporal($claveTemporal)
    {
        $this->claveTemporal = $claveTemporal;

        return $this;
    }

    /**
     * Get claveTemporal
     *
     * @return boolean
     */
    public function getClaveTemporal()
    {
        return $this->claveTemporal;
    }

    /**
     * Set cuentaVerificada
     *
     * @param boolean $cuentaVerificada
     *
     * @return Usuario
     */
    public function setCuentaVerificada($cuentaVerificada)
    {
        $this->cuentaVerificada = $cuentaVerificada;

        return $this;
    }

    /**
     * Get cuentaVerificada
     *
     * @return boolean
     */
    public function getCuentaVerificada()
    {
        return $this->cuentaVerificada;
    }
}
