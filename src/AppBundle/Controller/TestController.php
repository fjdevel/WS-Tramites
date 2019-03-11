<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\HttpFoundation\Response;
use JMS\JobQueueBundle\Entity\Job;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TestController extends Controller
{
    /**
     * @Route("/test")
     */
    public function testAction(){
        $response = new Response('<html>hola</html>');
        $em = $this->getDoctrine()->getManager('default');
        $job = new Job('app:verificacion');
        $em->persist($job);
        $em->flush();
            
        return $response;
    }
}
