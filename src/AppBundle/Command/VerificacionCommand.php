<?php
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
// se usa el contenedor por si se ocupara otro servicio
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
class VerificacionCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:verificacion');//asi se llamara el comando al usar la consola
            
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // access the container using getContainer()
        $mailer = $this->getContainer()->get('mailer');
        $notificacion = $this->getContainer()->get('notificacionesservice');
        $notificacion->nuevoUsuario("fjdevel@gmail.com","tokendepruba");
    }
}