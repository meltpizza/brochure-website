<?php

namespace Melt\WebsiteBundle\Controller;

use Melt\WebsiteBundle\Entity\Subscriber;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
     * @Template()
     */
    public function registerAction()
    {
        $request = $this->get('request')->request;

        $email = filter_var( strtolower( $request->get('email')), FILTER_SANITIZE_EMAIL);
        if( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
        }

        $subscriber = new Subscriber();
        $subscriber->setEmail($email);
        $subscriber->setCreated(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($subscriber);
        $em->flush();

        print 'Done'; die;
        return array();
    }
}
