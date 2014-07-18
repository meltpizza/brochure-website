<?php

namespace Melt\AdminBundle\Controller;

use Melt\WebsiteBundle\Entity\Media;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/admin/media")
 */
class MediaController extends Controller
{
    /**
     * @Route("/", name="admin_media_index")
     * @Template()
     */
    public function indexAction()
    {
        $media = $this->getDoctrine()->getRepository('WebsiteBundle:Media')->findByActive(1);

        return array(
            'media' => $media
        );
    }//indexAction

    /**
     * @Route("/edit/{id}", name="admin_media_edit", defaults={"id":null})
     * @Template()
     */
    public function editAction($id)
    {
        if($id) {
            $media = $this->getDoctrine()->getRepository('WebsiteBundle:Media')->find($id);
        } else  {
            $media = new Media();
        }

        $form = $this->createFormBuilder($media)
                     ->setAction($this->generateUrl('admin_media_save', array('id'=>$id)))
                     ->add('title'   , 'text')
                     ->add('link'    , 'text')
                     ->add('author'  , 'text')
                     ->add('created' , 'text')
                     ->add('save'    , 'submit')
                     ->getForm();

        //print '<pre>'; print_r($media);
        //die;

        return array(
            'form'  => $form->createView(),
            'media' => $media
        );
    }//editAction


    /**
     * @Route("/save/{id}", name="admin_media_save" )
     * @Template()
     */
    public function saveAction($id)
    {
        $request = $this->getRequest();

        if($id) {
            $media = $this->getDoctrine()->getRepository('WebsiteBundle:Media')->find($id);
        } else  {
            $media = new Media();
        }

        $form = $this->createFormBuilder($media)
                     ->add('title'   , 'text')
                     ->add('link'    , 'text')
                     ->add('author'  , 'text')
                     ->add('created' , 'text')
                     ->add('save'    , 'submit')
                     ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Media saved');

            return $this->redirect($this->generateUrl('admin_media_index'));
        } else {
            return $this->redirect($this->generateUrl('admin_media_edit', array('id' => $media->getId())) );
        }
    }//saveAction

}//MediaController
