<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Campaign;
use AppBundle\Form\CampaignType;

/**
 * Controller to deal with campaigns CRUD actions
 *
 * @author constantine
 *
 */
class CampaignController extends Controller
{
    use FlashMessageTrait;

    /**
     * Renders the list of available campaigns
     *
     * @Route("/campaigns/", name="campaignIndex")
     */
    public function indexAction()
    {
        $campaigns = $this->getDoctrine()->getRepository('AppBundle:Campaign')
            ->findAllByUserForRender($this->getUser());

        $pageData = array(
            'campaigns' => $campaigns,
        );

        return $this->render('campaign/index.html.twig', $pageData);
    }

    /**
     * Renders the single campaign
     *
     * @Route("/campaign/view/{id}", name="campaignSingleView")
     */
    public function singleViewAction($id)
    {
        $campaign = $this->getDoctrine()->getRepository('AppBundle:Campaign')
            ->findOneByIdForRender($this->getUser(), $id);

        $pageData = array(
            'campaign' => $campaign,
        );

        return $this->render('campaign/view.html.twig', $pageData);
    }

    /**
     * Adds new campaign
     *
     * @Route("/campaign/add/", name="campaignAdd")
     */
    public function addAction(Request $request)
    {
        $campaign = new Campaign();

        $form = $this->createForm(new CampaignType(), $campaign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $campaign->setUser($this->getUser());

            $em->persist($campaign);
            $em->flush();

            $this->flash('flash_success', 'campaignAdded');

            return $this->redirectToRoute('campaignIndex');
        }

        return $this->render('campaign/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
