<?php

namespace Decision\DecisionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {

        return $this->render('DecisionBundle:Default:index.html.twig');
    }

    public function showAction() {

    	return $this->render('DecisionBundle:Default:index.html.twig', array('name' =>"Test"));
    }
}