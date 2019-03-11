<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Sesion;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Version;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @RouteResource("Tramites")
 */
class TramitesController extends FOSRestController
{
    
    /**
     *
     * @QueryParam(name="anio", nullable=false)
     * @QueryParam(name="tipo_tramite", nullable=true)
     *
     * @param ParamFetcher $paramFetcher
     * @View
     *            
     */
    public function cgetAction(ParamFetcher $paramFetcher)
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
                
                $em = $this->getDoctrine()->getManager();
                
                $rsm = new ResultSetMapping();
                $rsm->addEntityResult('AppBundle:Tramite', 't');
                $rsm->addFieldResult('t', 'numeroExpediente', 'numeroExpediente');
                $rsm->addFieldResult('t', 'estado', 'estado');
                $rsm->addFieldResult('t', 'ubicacion', 'ubicacion');
                $rsm->addFieldResult('t', 'tiempo_respuesta', 'tiempoRespuesta');
                
                $emSqlServer = $this->getDoctrine()->getManager('sqlserver');
                
                
                
//                 $sql = "SELECT a.id, a.primer_nombre,a.segundo_nombre,a.tercer_nombre,a.primer_apellido,
//                         a.segundo_apellido, a.apellido_casada, a.fecha_nacimiento, a.numero_doc_ide_paciente AS doc,
//                         a.direccion, a.numero_expediente_cun,
//                         p.id AS pais_id,
//                         d.id AS departamento_id, 
//                         m.id AS municipio_id,
//                         s.id as sexo_id,
//                         ac.id AS area_cotizacion_id,
//                         a.id_usuario_registra,
//                         a.id_usuario_modifica,
//                         a.fecha_registro,
//                         a.fecha_modifica
//                         FROM ctl_paciente a
//                         LEFT JOIN ctl_pais p ON a.id_pais_nacimiento = p.id
//                         LEFT JOIN ctl_departamento d ON a.id_departamento_nacimiento = d.id
//                         LEFT JOIN ctl_municipio m ON a.id_municipio_nacimiento = m.id
//                         LEFT JOIN ctl_sexo s ON a.id_sexo = s.id
//                         LEFT JOIN ctl_area_cotizante ac ON a.id_area_cotizacion = ac.id
//                         WHERE nombre_completo_fonetico ilike soundexesp(?)||'%'
//                         AND apellido_completo_fonetico ilike soundexesp(?)||'%'
//                         ";
                
//                 $parametros = array();
//                 $parametros[1] = trim($paramFetcher->get('primerNombre'));
//                 $parametros[2] = trim($paramFetcher->get('primerApellido'));
//                 $num = 2;
//                 $segundo_apellido = " %'";
                
//                 foreach ($paramFetcher->all() as $criterionName => $criterionValue) {
                    
//                     if ($criterionName == "segundoNombre" && $criterionValue != null && $criterionValue != '') {
//                         $sql = $sql . " AND a.nombre_completo_fonetico ilike '% %'||soundexesp(?)||'%'";
//                         $num ++;
//                         $parametros[$num] = trim($criterionValue);
//                     }
                    
//                     if ($criterionName == "tercerNombre" && $criterionValue != null && $criterionValue != '') {
//                         $sql = $sql . " AND a.nombre_completo_fonetico ilike '% % %'||soundexesp(?)||'%'";
//                         $num ++;
//                         $parametros[$num] = trim($criterionValue);
//                     }
                    
//                     if ($criterionName == "segundoApellido" && $criterionValue != null && $criterionValue != '') {
//                         $sql = $sql . " AND apellido_completo_fonetico ilike '% %'||soundexesp(?)||'%'";
//                         $num ++;
//                         $parametros[$num] = trim($criterionValue);
//                         $segundo_apellido = " % %'";
//                     }
                    
//                     if ($criterionName == "apellidoCasada" && $criterionValue != null && $criterionValue != '') {
//                         $sql = $sql . " AND a.apellido_completo_fonetico ilike '%" . $segundo_apellido . "||soundexesp(?)||'%'";
//                         $num ++;
//                         $parametros[$num] = trim($criterionValue);
//                     }
                    
//                     if ($criterionName == "idPaciente" && $criterionValue != null && $criterionValue != '') {
//                         $sql = $sql . ' AND a.id = ? ';
//                         $num ++;
//                         $parametros[$num] = $criterionValue;
//                     }
//                 }
                
//                 /*
//                  * Yo no tengo la columna activo
//                  */
//                 // $sql = $sql.' AND a.activo=? ORDER BY a.primer_nombre,a.primer_apellido ASC';
//                 $sql = $sql . ' ORDER BY a.primer_nombre,a.primer_apellido ASC';
//                 // $num++;
//                 // $parametros[$num]= 't';
                
//                 $logger = new \Doctrine\DBAL\Logging\DebugStack();
//                 $this->getDoctrine()
//                     ->getConnection()
//                     ->getConfiguration()
//                     ->setSQLLogger($logger);
                
//                 $query = $em->createNativeQuery($sql, $rsm);
//                 $query->setParameters($parametros);
                
//                 $jsonContent = $serializer->serialize($query->getResult(), 'json');
                
//                 $executedQuery = $logger->queries[1];
                
//                 $idEstablecimeinto = $request->headers->get('bt-id-establecimiento');
                
//                 $bitacoraService = $this->container->get('bitacoraservice');
//                 $bitacoraService->saveOperation($sesion, $executedQuery['sql'] . $bitacoraService->plainParameters($executedQuery['params']), $bitacoraService::GET, $idEstablecimeinto);
                
//                 $this->getDoctrine()
//                     ->getConnection()
//                     ->getConfiguration()
//                     ->setSQLLogger(null);
                
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