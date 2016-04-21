<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Links;
use AppBundle\Entity\RemoveLink;
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
        if($this->isAdmin()){
            $links = $em->getRepository('AppBundle:Links')->findAll();
        }else{
            $links = $em->getRepository('AppBundle:Links')->findBy(
                array(
                    'active' => true
                )
            );
        }

        return $this->render('links/index.html.twig', array(
            'links' => $links,
            'requests' => false
        ));
    }
    public function isAdmin(){
        return $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN');
    }
    /**
     * Creates a new Links entity.
     *
     * @Route("/new", name="links_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $link = new Links('įtraukti');
        $form = $this->createForm('AppBundle\Form\LinksRequestType', $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $link = $form->getData();
            if($link->getRequestType() == 'įtraukti'){
                $em = $this->getDoctrine()->getManager();

                $rp = $em->getRepository('AppBundle:Links');
                $linkResult = $rp->createQueryBuilder('p')
                    ->where('p.link = :link')
                    ->setParameter('link', $link->getLink())
                    ->getQuery()
                    ->setMaxResults(1)
                    ->getOneOrNullResult();
                if(is_null($linkResult)){
                    $user = $this->getUser();
                    $link->setUser($user);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($link);
                    $em->flush();

                    return $this->redirectToRoute('links_show', array('id' => $link->getId()));
                }else{
                    $linkResult
                        ->setBlocked(true)
                        ->setActive(true)
                        ->setActionRequired(false)
                        ->setRequestType('');
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($linkResult);
                    $em->flush();
                    return $this->redirectToRoute('links_show', array('id' => $linkResult->getId()));
                }
            }
            if($link->getRequestType() == 'išimti'){

            }
        }

        return $this->render('links/new.html.twig', array(
            'link' => $link,
            'form' => $form->createView(),
            'request' => 'įtraukti'
        ));
    }
    /**
     * Creates a new Links entity.
     *
     * @Route("/requestRemove", name="links_request_remove")
     * @Method({"GET", "POST"})
     */
    public function newRemoveAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $links = $em->getRepository('AppBundle:Links')->findBy(
            array(
                'active' => 'TRUE',
                'blocked' => 'FALSE'
            )
        );

        $removeLink = new RemoveLink();
        
        $form = $this->createFormBuilder($removeLink)
            ->add('linkId', EntityType::class, 
                array(
                    'choice_label' => function($item){
                        return $item->getTitle();
                    },
                    'choice_value' => function($item){
                        return $item->getId();
                    },
                    'class' => 'AppBundle:Links',
                    'em' => $em,
                    'query_builder' => function ($er) {
                        return $er->createQueryBuilder('i')
                            ->where('i.active = :checkValue AND i.blocked = :blocked')
                            ->setParameters(array('checkValue' => true, 'blocked' => false));
                    },
                    'attr' => array('class' => 'form-control')
                ))
            ->add('save', SubmitType::class, array('label' => 'Išimti', 'attr' => array( 'class' => 'btn btn-success')))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $link = $form->getData();
            
            if($link->getLinkId()->getBlocked())
                return $this->redirectToRoute('links_index');
            $link->getLinkId()->setActionRequired(true);
            $link->getLinkId()->setRequestType('išimti');
            $em = $this->getDoctrine()->getManager();
            $em->persist($link->getLinkId());
            $em->flush();
            return $this->redirectToRoute('links_index');
            
        }

        return $this->render('links/new.html.twig', array(
            'form' => $form->createView()
        ));
    }
    /**
    * 
    * Shows all requests
    * @Route("/requests", name="links_requests")
    * @Method({"GET", "POST"})
    * 
    */
    public function getAllRequests(){
        $em = $this->getDoctrine()->getManager();

        $links = $em->getRepository('AppBundle:Links')->findBy(
            array(
                'actionrequired' => true
            )
        );

        return $this->render('links/index.html.twig', array(
            'links' => $links,
            'requests' => true
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
    * 
    * Accept request
    * @Route("/{id}/acceptRequest", name="links_accept_requests")
    * @Method({"GET", "POST"})
    * 
    */
    public function acceptRequest(Links $link){
        
        if($link->getRequestType() == 'išimti')
            $link->setActive(false);
        if($link->getRequestType() == 'įtraukti')
            $link->setActive(true);
        $link->setActionRequired(false);  
        $link->setRequestType(''); 
        $em = $this->getDoctrine()->getManager();
        $em->persist($link);
        $em->flush();
        mail ($link->getUser()->getEmail(), "Tavo prašymas buvo įvykdytas.", "Tavo prašymas " + $link->getRequestType() + "URL: " + $link->getLink() + " buvo įvykdytas.");
        //mail (  string $to , string $subject , string $message [, string $additional_headers [, string $additional_parameters ]] )
        return $this->redirectToRoute('links_requests');
    }

    /**
    * 
    * Accept request
    * @Route("/{id}/refuseRequest", name="links_refuse_requests")
    * @Method({"GET", "POST"})
    * 
    */
    public function refuseRequest(Links $link){
        $link->setActionRequired(false);  
        $link->setRequestType('');
        $em = $this->getDoctrine()->getManager();
        $em->persist($link);
        $em->flush();
        mail ($link->getUser()->getEmail(), "Tavo prašymas buvo atmestas.", "Tavo prašymas " + $link->getRequestType() + "URL: " + $link->getLink() + " buvo atmestas." );
        return $this->redirectToRoute('links_requests');
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
