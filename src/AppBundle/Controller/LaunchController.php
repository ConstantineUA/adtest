<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Launch;
use AppBundle\Entity\Campaign;
use AppBundle\Form\LaunchType;

/**
 * Launch controller
 */
class LaunchController extends Controller
{
    use FlashMessageTrait;

    /**
     * Creates a new Launch for the given campaign
     *
     * @Route("/campaign/{id}/launch/", name="launchAdd")
     */
    public function createAction(Campaign $campaign, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('AppBundle:Campaign');
        if (!$repository->isAllowedToAddLaunch($this->getUser(), $campaign)) {
            $this->flash('flash_error', 'launchError');

            $this->redirectToRoute('campaignIndex');
        }

        $launch = new Launch();

        $form = $this->createForm(new LaunchType(), $launch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $launch->setCampaign($campaign);

            $em->persist($launch);
            $em->flush();

            $this->flash('flash_success', 'launchSaved');

            return $this->redirectToRoute('campaignSingleView', array(
                'id' => $campaign->getId(),
            ));
        }

        return $this->render('launch/new.html.twig', array(
            'form' => $form->createView(),
            'campaign' => $campaign,
        ));
    }
}
