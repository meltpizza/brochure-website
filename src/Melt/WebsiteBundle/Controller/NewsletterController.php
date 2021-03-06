<?php

namespace Melt\WebsiteBundle\Controller;

use Melt\WebsiteBundle\Entity\Subscriber;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/newsletter")
 */
class NewsletterController extends Controller
{
    /**
     * @Route("/register", name="newsletter_register")
     * @Method("POST")
     */
    public function registerAction()
    {
        $request = $this->get('request')->request;

        $email = filter_var( strtolower( $request->get('email')), FILTER_SANITIZE_EMAIL);
        if( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
            return $this->redirect($this->generateUrl('newsletter_error'));
        }

        $subscriber = new Subscriber();
        $subscriber->setEmail($email);
        $subscriber->setCreated(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($subscriber);
        $em->flush();

        return $this->redirect($this->generateUrl('newsletter_accepted'));
    }

    /**
     * @Route("/accepted", name="newsletter_accepted")
     * @Cache(expires="+2 days", public="true")
     * @Template()
     */
    public function acceptedAction()
    {
        //very quick & dirty
        return array();
    }

    /**
     * @Route("/error", name="newsletter_error")
     * @Cache(expires="+2 days", public="true")
     * @Template()
     */
    public function errorAction()
    {
        //very quick & dirty
        return array();
    }
}
