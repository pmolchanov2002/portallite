<?php

namespace AppBundle\Controller\Site;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Subscription;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;

class SubscriptionController extends Controller
{
    
    /**
     * @Route("/subscribe", name="subscribe")
     */
    public function subscribe(Request $request) {
    	
    	$result = true;
    	
    	$lang = $request->getPreferredLanguage(array('en', 'ru'));
    	$address = $request->request->get("address");
    	
    	$emailConstraint = new EmailConstraint();
    	$emailConstraint->message = 'Not an e-mail';
    	
    	$errors = $this->get('validator')->validateValue(
    			$address,
    			$emailConstraint
    			);
    	
    	if($address == "" || $errors != "") {
    		$result = false;
    	} else {	    	
	    	$subscription = new Subscription();
	    	$subscription->setAddress($address);
	    	
	    	$em = $this->getDoctrine()->getManager();
	    	$em->persist($subscription);
	    	$em->flush();
    	}
    	
    	return new JsonResponse(array(
    			'success' => $result,
    			'language' => $lang
    	));
    }

}
