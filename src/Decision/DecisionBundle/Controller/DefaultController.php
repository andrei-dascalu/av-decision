<?php

namespace Decision\DecisionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {

        return $this->render('DecisionBundle:Default:index.html.twig');
    }

    public function showAction() {

        return $this->render('DecisionBundle:Default:index.html.twig');
    }
}
