<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Usuario;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Version;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;



/**
 * @RouteResource("Usuarios")
 */
class UsuarioController extends FOSRestController
{
    
    /**
     * 
     * @RequestParam(name="username", nullable=false)
     * @RequestParam(name="password", nullable=false)
     * @RequestParam(name="nombres", nullable=false)
     * @RequestParam(name="apellidos", nullable=false)
     * @RequestParam(name="num_licencia", nullable=false)
     * @RequestParam(name="doc_identidad", nullable=false)
     * @RequestParam(name="correo_e", nullable=false)
     * 
     * 
     * @param ParamFetcher $paramFetcher
     *
     * @View
     */
    public function cpostAction(ParamFetcher $paramFetcher){
        $em = $this->getDoctrine()->getManager('default');
        
        $usuario = new Usuario();
                
        $usuario->setApellidos( $paramFetcher->get("apellidos"));
        $usuario->setCorreoElectronico( $paramFetcher->get("correo_e"));
        $usuario->setDocumentoIdentidad( $paramFetcher->get("doc_identidad"));
        $usuario->setNombre( $paramFetcher->get("nombres"));
        $usuario->setNombreUsuario( $paramFetcher->get("username"));
        $usuario->setNumLicencia( $paramFetcher->get("num_licencia"));
        $usuario->setPassword( $paramFetcher->get("password"));
        // aqui se declara que la cuenta esta sin verificar
        $usuario->setCuentaVerificada(false);
        //se generara un token aleatorio
        $encoderFactory = $this->container->get('security.encoder_factory');
        $encoder = $encoderFactory->getEncoder($usuario);
        $new_token = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10/strlen($x)) )),1,10);
        $encodedToken = $encoder->encodePassword($new_token, $paramFetcher->get("correo_e"));
        $usuario->setTokenVerificacion($encodedToken);
        $notificacion = $this->get('notificacionesservice');
        $notificacion->nuevoUsuario($paramFetcher->get("correo_e"),$encodedToken);
                
        $em->persist($usuario);
        $em->flush();
        
        $jsonContent = '{"valido": "true"}';
        
        return new Response($jsonContent);
    }
    
    /**
     ** @QueryParam(name="username", nullable=false)
     * 
     * 
     * @param ParamFetcher $paramFetcher
     *
     * @View
     */
    public function cgetAction(ParamFetcher $paramFetcher){
        $em = $this->getDoctrine()->getManager('default');
        
        $normalizer = new ObjectNormalizer();
        $encoder = new JsonEncoder();
        
        $serializer = new Serializer(array(
            $normalizer
        ), array(
            $encoder
        ));
        
        $usuario = $em->getRepository("AppBundle:Usuario")->findOneByNombreUsuario($paramFetcher->get("username"));
        
        if($usuario != null){
            $jsonContent = '{"valido":"false","descripcion":"El nombre de usuario solicitado ya existe"}';
            return new Response($jsonContent, 400);
        }else{
            $jsonContent = '{"valido": "true"}';
            return new Response($jsonContent);
        }
        
        return new Response($jsonContent);
    }
}