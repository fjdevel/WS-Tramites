<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Sesion;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Version;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
class LoginController extends FOSRestController
{
    /**
    * @Post("reset")
    *
    * @RequestParam(name="password", nullable=false)
    * @RequestParam(name="username", nullable=false)
    * @param ParamFetcher $paramFetcher
    *
    * @View
    */
    public function ResetPasswordAction(ParamFetcher $paramFetcher){
        
        
        $em = $this->getDoctrine()->getManager('default');
        $user = $em->getRepository("AppBundle:Usuario")->findOneByNombreUsuario($paramFetcher->get("username"));
        
        if (null === $user) {
            throw $this->createNotFoundException('usuario no encontrado');
        }else{
            $encoderFactory = $this->container->get('security.encoder_factory');
            $encoder = $encoderFactory->getEncoder($user);
            $encodedPassword = $encoder->encodePassword($paramFetcher->get("password"), $user->getCorreoElectronico());
            $user->setPassword($encodedPassword);
            $user->setClaveTemporal(false);
            $em->persist($user);
            $em->flush();
            $jsonContent = '{"reset": "true"}';
        }
        
        return new Response($jsonContent);
    }

    /**
    * @Get("/resetpassword/{token}")
    *
    * @param string $token
    *
    * @View
    */
    public function RecoveryPasswordAction($token){
        
        
        $em = $this->getDoctrine()->getManager('default');
        $user = $em->getRepository("AppBundle:Usuario")->findOneByTokenVerificacion($token);
        
        if (null === $user) {
            throw $this->createNotFoundException('usuario no encontrado');
        }

        if ($user->getClaveTemporal()==1){
            throw new BadRequestHttpException("Ya se ha solicitado un reestablecimiento de contraseña");
        }
        $encoderFactory = $this->container->get('security.encoder_factory');
        $encoder = $encoderFactory->getEncoder($user);
        $new_pass = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10/strlen($x)) )),1,10);
        $encodedPassword = $encoder->encodePassword($new_pass, $user->getCorreoElectronico());
        $user->setPassword($encodedPassword);
        $user->setClaveTemporal(true);
        $em->persist($user);
        $em->flush();
        $jsonContent = '{"recovery": "true"}';

        $message = \Swift_Message::newInstance()
        ->setSubject('Contraseña temporal establecida')
        ->setFrom('fjdevel@gmail.com')
        ->setTo($user->getCorreoElectronico())
        ->addPart('Su nueva contraseña temporal es: '.$new_pass,'text/plain')
        ;
        $this->get('mailer')->send($message);
        $user->setTokenVerificacion('');
        return new Response($jsonContent);
    }


    /**
    * @Post("recovery")
    *
    * @RequestParam(name="email", nullable=false)
    * @param ParamFetcher $paramFetcher
    *
    * @View
    */
    public function RequestRecoveryPasswordAction(ParamFetcher $paramFetcher){
        $em = $this->getDoctrine()->getManager('default');
        $user = $em->getRepository("AppBundle:Usuario")->findOneByCorreoElectronico($paramFetcher->get("email"));
        
        if (null === $user) {
            throw $this->createNotFoundException('usuario no encontrado');
        }

        if ($user->getClaveTemporal()==1){
            throw new BadRequestHttpException("Ya se ha solicitado un reestablecimiento de contraseña");
        }
        $encoderFactory = $this->container->get('security.encoder_factory');
        $encoder = $encoderFactory->getEncoder($user);
        $new_token = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10/strlen($x)) )),1,10);
        $encodedToken = $encoder->encodePassword($new_token, $user->getCorreoElectronico());
        $user->setTokenVerificacion($encodedToken);
        $em->persist($user);
        $em->flush();
        $this->get('notificacionesservice')->ResetPasswordNotificacion($user->getCorreoElectronico(),$user->getTokenVerificacion());
        $jsonContent = '{"recovery": "true"}';
        return new Response($jsonContent);
    }
    
    /**
     * @Post("login")
     * 
     * @RequestParam(name="username", nullable=false)
     * @RequestParam(name="password", nullable=false)
     * 
     * @param ParamFetcher $paramFetcher
     *
     * @View
     */
    public function cpostAction(ParamFetcher $paramFetcher){
        $timeZone = 'America/El_Salvador';
        $request = Request::createFromGlobals();
        
        $em = $this->getDoctrine()->getManager('default');
        
        $usuario = $em->getRepository("AppBundle:Usuario")->findOneByNombreUsuario($paramFetcher->get("username"));
        
        if($usuario != null){
            $encoderFactory = $this->container->get('security.encoder_factory');
            
            $data = array();
            
            if( !$encoderFactory->getEncoder($usuario)->isPasswordValid($usuario->getPassword(), $paramFetcher->get("password"), $usuario->getCorreoElectronico()) ) {
                $data['mensaje'] = 'Credenciales inválidas.';
                // $encoderFactory->getEncoder($usuario)->encodePassword($paramFetcher->get("password"), $usuario->getCorreoElectronico())
            }else{
                $sesion = new Sesion();
                
                $sesion->setIdUsuario($usuario);
                $sesion->setFecha((new \DateTime())->setTimeZone(new \DateTimeZone($timeZone)));
                $sesion->setFechaExpiracion((new \DateTime())->setTimeZone(new \DateTimeZone($timeZone)));
                $sesion->getFechaExpiracion()->add(new \DateInterval('PT30M'));
                $sesion->setToken(substr(strtr(base64_encode(random_bytes(32)), '+', '.'), 0, 32));
                $sesion->setIp($request->headers->get('bt-ip-cliente'));
                
                $em->persist($sesion);
                $em->flush();
                
                $data['accesstoken'] = $sesion->getToken();
                //esto es para verificar si la contraseña es temporal
                if ($usuario->getClaveTemporal()==1){
                    $data['temporal'] = "true";
                }
                header('keep-alive: timeout=1800, max=1800');
            }
        }
        
        return new Response(json_encode($data));
    }
}