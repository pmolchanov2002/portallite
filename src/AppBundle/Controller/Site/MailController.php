<?php

namespace AppBundle\Controller\Site;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Article;

class MailController extends Controller {
	
	/**
	 * @Route("/mail", name="mail")
	 */
	public function mail(Request $request) {
		$pageService = $this->get ( 'PageService' );
		$lang = $request->getPreferredLanguage ( array (
				'en',
				'ru' 
		) );
		$emailSetting = $pageService->getEmailSetting ( $lang );
		if ($emailSetting != null) {
			return $this->redirect ( 'mailto:' . $emailSetting->getValue () );
		} else {
			return $this->redirect ( '/' );
		}
	}
}
