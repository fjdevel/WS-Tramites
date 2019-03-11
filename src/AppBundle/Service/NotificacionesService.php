<?php

namespace AppBundle\Service;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
class NotificacionesService{
    private $mailer;
    private $templating;
    private $correoRemitente = "fjdevel@gmail.com";

    public function __construct(\Swift_Mailer $mailer,EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }
    public function GenerarCorreo($asunto,$destinatario,$template,$arg)
    {
        $message = \Swift_Message::newInstance()
                    ->setSubject($asunto)
                    ->setFrom($this->correoRemitente)
                    ->setTo($destinatario)
                    ->setBody(
                        $this->templating->render(
                            $template,
                            $arg
                        ),
                        'text/html'
                    );
        $this->mailer->send($message);
                    
    }

    public function nuevoUsuario($correo,$token)
    {
        $this->GenerarCorreo(
            'Verificacion de registro',
            $correo,
            'AppBundle:Emails:email-registro.html.twig',
            array('token'=>$token)
            );
        
    }
    //Se ha dejado el parametro arg porque no esta muy claro que argumentos recibira
    public function ResetPasswordNotificacion($correo,$token)
    {
        $urlsegura = 'http://127.0.0.1:8000/resetpassword/'.$token;
        $this->GenerarCorreo(
            'Cambio de contraseña',
            $correo,
            'AppBundle:Emails:email-recuperar-contrasena.html.twig',
            array(
                'urlsegura'=>$urlsegura
            )
        );
    }

    public function MemorandoNotificacion($correo,$nombreTramite,$numTramite,$nomProyecto)
    {
        $this->GenerarCorreo(
            'Notificacion de Tramite',
            $correo,
            'AppBUndle:Emails:email-memorando-notificacion.html.twig',
            array(
                'nombreTramite'  =>  $nombreTramite,
                'numeroTramite'  =>  $numTramite,
                'nombreProyecto' =>  $nomProyecto
            )
        );
    }
    public function TramiteFinalizadoNotificacion($correo,$nombreTramite,$numTramite,$nomProyecto)
    {
        $this->GenerarCorreo(
            'Notificacion de Tramite Finalizado',
            $correo,
            'AppBUndle:Emails:email-tramite-finalizado-notificacion.html.twig',
            array(
                'nombreTramite'  =>  $nombreTramite,
                'numeroTramite'  =>  $numTramite,
                'nombreProyecto' =>  $nomProyecto
            )
        );
    }
    public function TramiteNoReingresado($correo,$nombreTramite,$numTramite,$nomProyecto)
    {
        $this->GenerarCorreo(
            'Notificacion de Tramite retirado y no reingresado enun periodo de 5 meses',
            $correo,
            'AppBUndle:Emails:email-nenirabdi-no-reingresado.html.twig',
            array(
                'nombreTramite'  =>  $nombreTramite,
                'numeroTramite'  =>  $numTramite,
                'nombreProyecto' =>  $nomProyecto
            )
        );
    }


}