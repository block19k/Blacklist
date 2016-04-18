<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Links;
use AppBundle\Form\LinksType;

/**
 * Links controller.
 *
 * @Route("/links")
 */
class LinksController extends Controller
{
    /**
     * Lists all Links entities.
     *
     * @Route("/", name="links_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $links = $em->getRepository('AppBundle:Links')->findAll();

        return $this->render('links/index.html.twig', array(
            'links' => $links,
        ));
    }

    /**
     * Creates a new Links entity.
     *
     * @Route("/new", name="links_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $link = new Links();
        $form = $this->createForm('AppBundle\Form\LinksRequestType', $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($link);
            $em->flush();

            return $this->redirectToRoute('links_show', array('id' => $link->getId()));
        }

        return $this->render('links/new.html.twig', array(
            'link' => $link,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Links entity.
     *
     * @Route("/{id}", name="links_show")
     * @Method("GET")
     */
    public function showAction(Links $link)
    {
        $deleteForm = $this->createDeleteForm($link);

        return $this->render('links/show.html.twig', array(
            'link' => $link,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Links entity.
     *
     * @Route("/{id}/edit", name="links_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Links $link)
    {
        $deleteForm = $this->createDeleteForm($link);
        $editForm = $this->createForm('AppBundle\Form\LinksType', $link);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($link);
            $em->flush();

            return $this->redirectToRoute('links_edit', array('id' => $link->getId()));
        }

        return $this->render('links/edit.html.twig', array(
            'link' => $link,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Links entity.
     *
     * @Route("/{id}", name="links_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Links $link)
    {
        $form = $this->createDeleteForm($link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($link);
            $em->flush();
        }

        return $this->redirectToRoute('links_index');
    }

    /**
     * Creates a form to delete a Links entity.
     *
     * @param Links $link The Links entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Links $link)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('links_delete', array('id' => $link->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
