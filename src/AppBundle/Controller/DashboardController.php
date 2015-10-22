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
        return $this->render('dashboard.html.twig', array());
    }
}
