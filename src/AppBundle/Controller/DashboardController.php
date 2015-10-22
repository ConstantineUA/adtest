<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * The controller to render static pages inside the dashboard
 *
 * @author constantine
 *
 */
class DashboardController extends Controller
{
    /**
     * Renders the dashboard
     *
     * @Route("/dashboard/", name="dashboard")
     */
    public function indexAction()
    {
        $twig = $this->get('twig');

        $adJs = $twig->render('/advertisement/inject.js.html.twig', array());
        $adContainer = $twig->render('/advertisement/inject.container.html.twig', array());

        $pageData = array(
            'adJs' => $adJs,
            'adContainer' => $adContainer,
        );

        return $this->render('dashboard.html.twig', $pageData);
    }
}
