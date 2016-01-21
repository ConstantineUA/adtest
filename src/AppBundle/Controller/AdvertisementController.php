<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller to deal with advertisments
 *
 * @author constantine
 *
 */
class AdvertisementController extends Controller
{
    /**
     * Action to send an advertisement details according to the incoming params
     *
     * @Route("/advertisment/", name="advertismentSimple", defaults={"contentunit": null, "campaign": null})
     * @Route("/advertisment/contentunit/{contentunit}/", name="advertismentContentunit", defaults={"campaign": null})
     * @Route("/advertisment/campaign/{campaign}/", name="advertismentCampaign", defaults={"contentunit": null})
     * @Route("/advertisment/contentunit/{contentunit}/campaign/{campaign}/", name="advertismentFull")
     */
    public function showAdAction($contentunit, $campaign)
    {
        if ($this->container->has('profiler')) {
            $this->container->get('profiler')->disable();
        }

        $em = $this->getDoctrine()->getEntityManager();

        $repository = $em->getRepository('AppBundle:Banner');
        $banner = $repository->findOneForAdvertisement($contentunit, $campaign);

        if ($banner) {
            $launch = $em->getRepository('AppBundle:Launch')->find($banner['launchId']);
            $launch->incrementHits();

            $em->flush();

            $banner['imageUrl'] = $this->generateImageUrl($banner);
        }

        $response = new JsonResponse($banner);
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * Prepares image url based on the banner image name
     *
     * @param array $banner
     * @return string
     */
    protected function generateImageUrl($banner)
    {
        if (!$banner['imageName']) {
            return '';
        }

        $request = $this->container->get('request');

        $urlHelper = $this->container->get('vich_uploader.templating.helper.uploader_helper');

        $url = $request->getUriForPath(
            $urlHelper->asset($banner, 'imageFile', 'AppBundle\Entity\Banner')
        );

        return $url;
    }
}
