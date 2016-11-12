<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Article;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\OrderBy;

class MailController extends Controller {
	
	
	/**
	 * @Route("/admin/mail/article/{article}", name="mail_article")
	 * @ParamConverter("article", class="AppBundle:Article")
	 */
	public function mail($article, Request $request) {
		if (! isset ( $article )) {
			return new Response ( "Article not found" );
		}
		
		$em = $this->getDoctrine ()->getManager ();
		$subscriptions = $em->getRepository ( 'AppBundle:Subscription' )->findAll ();
		$recipients = array ();
		
		foreach ( $subscriptions as $subscription ) {
			$this->sendEmail ( $article, $subscription->getAddress() );
			$recipients [] = $subscription->getAddress();
		}
		
		$session = $request->getSession ();
		$session->set ( 'recipients', $recipients );
		
		return $this->redirectToRoute ( "app_mail_message_success" );
	}
	
	/**
	 * @Route("/admin/mail/message/success", name="app_mail_message_success")
	 */
	public function display_success(Request $request) {
		$session = $request->getSession ();
		$recipients = $session->get ( 'recipients' );
		
		return $this->render ( 'admin/view/success.html.twig', array (
				'recipients' => $recipients 
		) );
	}
	
	private function sendEmail(Article $article, $recepient) {
// 		$body = $this->renderView ( 'mail/message.html.twig', array (
// 				'notification' => $notification,
// 				'user' => $user 
// 		) );

		$body = $article->getContent();
		
		$message = \Swift_Message::newInstance ()->setSubject ( $article->getTitle() )
		->setFrom ( 'no-reply@rocana.org' )
		->setTo ( $recepient )
		->setBody ( $body, 'text/html' );
		
		$this->get ( 'mailer' )->send ( $message );
		return;
	}
}
