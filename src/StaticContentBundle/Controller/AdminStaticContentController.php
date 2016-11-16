<?php

namespace StaticContentBundle\Controller;

use StaticContentBundle\Entity\StaticContent;
use StaticContentBundle\Form\Type\StaticContentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class AdminStaticContentController.
 *
 * @Route("/kontrollpanel")
 */
class AdminStaticContentController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Route("/statisk_innhold/header", name="cp_sc_header")
     */
    public function showHeaderAction(Request $request)
    {
        return $this->renderForm($request, 'header', 'Header');
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Route("/statisk_innhold/tagline", name="cp_sc_tagline")
     */
    public function showTaglineAction(Request $request)
    {
        return $this->renderForm($request, 'tagline', 'Tagline');
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Route("/statisk_innhold/deltaker", name="cp_sc_participant_info")
     */
    public function showParticipantAction(Request $request)
    {
        return $this->renderForm($request, 'participant_info', 'Deltaker');
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Route("/statisk_innhold/veileder", name="cp_sc_tutor_info")
     */
    public function showTutorAction(Request $request)
    {
        return $this->renderForm($request, 'tutor_info', 'Veileder');
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Route("/statisk_innhold/om_deltakere", name="cp_sc_about_participant")
     */
    public function showAboutParticipantAction(Request $request)
    {
        return $this->renderForm($request, 'about_participant', 'Om oss - For Deltakere');
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Route("/statisk_innhold/om_veiledere", name="cp_sc_about_tutor")
     */
    public function showAboutTutorAction(Request $request)
    {
        return $this->renderForm($request, 'about_tutor', 'Om oss - For Veiledere');
    }

    private function renderForm(Request $request, $idString, $label)
    {
        $content = $this->getDoctrine()->getRepository('StaticContentBundle:StaticContent')->findOneBy(array('idString' => $idString));
        if (is_null($content)) {
            $content = new StaticContent();
            $content->setIdString($idString);
        }

        $form = $this->createForm(new StaticContentType($label), $content);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $content->setLastEditedBy($this->getUser());
            $content->setLastEdited(new \DateTime());
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($content);
            $manager->flush();

            return $this->redirectToRoute('cp_sc_'.$idString);
        }

        return $this->render('@StaticContent/control_panel/show_form.html.twig', array(
            'form' => $form->createView(),
            'name' => $label,
        ));
    }
}
