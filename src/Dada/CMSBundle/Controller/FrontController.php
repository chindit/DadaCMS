<?php

namespace Dada\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontController extends Controller
{
    public function indexAction()
    {
        return $this->render('DadaCMSBundle:Front:index.html.twig');
    }
}
