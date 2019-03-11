<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Sesion;
use AppBundle\Entity\TipoDeTramite;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Version;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @RouteResource("TipoTramites")
 */
class TipoTramiteController extends FOSRestController
{
    
    public function cgetAction()
    {
        $request = Request::createFromGlobals();
        $sesionService = $this->container->get('sesionservice');
        $sesion = $sesionService->getSession($request->headers->get('x-xrd-token'), $request->headers->get('x-xrd-userid'));
        $estadoSesion = $sesionService->getSessionStatus($sesion);
        
        if ($estadoSesion == $sesionService::SESION_VALIDA) {
            $normalizer = new ObjectNormalizer();
            $encoder = new JsonEncoder();
            
            $serializer = new Serializer(array(
                $normalizer
            ), array(
                $encoder
            ));
            
            $productos = $this->getDoctrine()->getRepository(TipoDeTramite::class)->findAll();
            
            $jsonContent = $serializer->serialize($productos, 'json');
            
            return new Response($jsonContent);
        } else if ($estadoSesion == $sesionService::SESION_NO_ENCONTRADA) {
            $jsonContent = '{"error": 1010, "descripcion": "No se ha iniciado sesión"}';
            return new Response($jsonContent, 401);
        } else {
            $jsonContent = '{"error": 1020, "descripcion": "La sesión ha expirado"}';
            return new Response($jsonContent, 401);
        }
    }
}