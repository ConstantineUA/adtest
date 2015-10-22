<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Banner;
use AppBundle\Form\BannerType;
use AppBundle\AppBundle;

/**
 * Controller deals with managing banners
 *
 * @author constantine
 *
 */
class BannerController extends Controller
{
    use FlashMessageTrait;

    /**
     * Renders the list of available banners
     *
     * @Route("/banners/", name="bannerIndex")
     */
    public function indexAction()
    {
        $banners = $this->getDoctrine()->getRepository('AppBundle:Banner')
            ->findAllByUserForRender($this->getUser());

        $pageData = array(
            'banners' => $banners,
        );

        return $this->render('banner/index.html.twig', $pageData);
    }

    /**
     * Renders form to add a banner, adds a banner into the system
     *
     * @Route("/banner/add/", name="bannerAdd")
     */
    public function addAction(Request $request)
    {
        $banner = new Banner();

        $form = $this->createForm(new BannerType(), $banner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $banner->setUser($this->getUser());

            $em->persist($banner);
            $em->flush();

            $this->flash('flash_success', 'bannerAdded');

            return $this->redirectToRoute('bannerIndex');
        }

        return $this->renderEditForm($form);
    }

    /**
     * Form to edit a banner, stores changes
     *
     * @Route("/banner/edit/{id}", name="bannerEdit")
     */
    public function editAction(Banner $banner, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Banner');

        if (!$repository->isAllowedToModify($this->getUser(), $banner)) {
            $this->flash('flash_error', 'bannerEditError');

            return $this->redirectToRoute('bannerIndex');
        }

        $form = $this->createForm(new BannerType(), $banner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->flash('flash_success', 'bannerEditSuccess');

            return $this->redirectToRoute('bannerIndex');
        }

        return $this->renderEditForm($form);
    }

    /**
     * Deletes the given banner
     *
     * @Route("/banner/delete/{id}/", name="bannerDelete")
     */
    public function deleteAction(Banner $banner)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Banner');

        if ($repository->isAllowedToModify($this->getUSer(), $banner)) {
            $em->remove($banner);
            $em->flush();

            $this->flash('flash_success', 'bannerDeleteSuccess');
        } else {
            $this->flash('flash_error', 'bannerDeleteError');
        }

        return $this->redirectToRoute('bannerIndex');
    }

    /**
     * Returns the view for the given form
     *
     * @param AppBundle\Form\Type\BannerType $form
     */
    protected function renderEditForm($form)
    {
        return $this->render('banner/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds an appropriate contentunit for the given banner
     *
     * @param Banner $banner
     * @return AppBundle\Entity\Contentunit
     */
    protected function findContentunit(Banner $banner)
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('AppBundle:Contentunit')->findByImage($banner->getImageFile());
    }
}
