<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
	
	private $pageTypes = array (
			1 => 'page',
			2 => 'lenta',
			3 => 'contact',
			4 => 'schedule',
			5 => 'results',
			6 => 'faq'
	);
	
    /**
     * @Route("/", name="homePage")
     */
    public function homePage(Request $request)
    {
    	$lang = $request->getPreferredLanguage(array('en', 'ru'));
    	//$lang = 'ru';
    	return $this->redirectToRoute("page", array('pageId' => 'home.'.$lang));
    }
    
    /**
     * @Route("/admin", name="admin_homepage")
     */
    public function welcomeAdmin()
    {
    	// replace this example code with whatever you need
    	return $this->render('admin/view/welcome_admin.html.twig');
    }
    
    /**
     * @Route("/mail", name="mail")
     */
    public function mail(Request $request) {
    	$lang = $request->getPreferredLanguage(array('en', 'ru'));
    	$emailSetting = $this->getEmailSetting($lang);
    	if($emailSetting != null) {
    		return $this->redirect('mailto:'.$emailSetting->getValue());
    	} else {
    		return $this->redirect('/');
    	}
    }
    
    /**
     * @Route("/error", name="error")
     */
    public function errorPage(Request $request) {
    	$site = $this->getParameter('site');
    	$lang = $request->getPreferredLanguage(array('en', 'ru'));
    	$parameters = array(
    			'menus' => $this->loadMenu($lang),
    			'settings' => $this->loadSettings($lang),
    			'events' => $this->loadEvents($lang)
    	);
    	return $this->render('site/'.$site.'/views/'.$lang.'/error.html.twig', $parameters);
    }
    
    /**
     * @Route("/m/page/{pageId}", name="mobilePage")
     */
    public function displayMobilePage($pageId)
    {
    	return $this->redirectToRoute("page", array('pageId' => $pageId));
    }
    
    /**
     * @Route("/m/page/{pageId}/{articleId}", name="mobileArticleOnPage")
     */
    public function displayMobilePageWithArticle($pageId, $articleId)
    {
    	return $this->redirectToRoute("articleOnPage", 
    			array(
    					'pageId' => $pageId,
    					'articleId' => $articleId
    			));
    }
    
    /**
     * @Route("/page/{pageId}", name="page")
     */
    public function displayPage($pageId, Request $request)
    {
    	$site = $this->getParameter('site');
    	$em = $this->getDoctrine ()->getManager();
    	$lang = $request->getPreferredLanguage(array('en', 'ru'));
    	
    	$page = $em->getRepository ( 'AppBundle:Page' )->find($pageId);
    	
    	if(empty($page)) {
    		return $this->redirectToRoute("error");
    	}
	    
    	$lang = $page->getLanguage()->getCode();
	    $type = $page->getType()->getId();
    	
    	$pageType = $this->pageTypes[$type];
    	
    	$parameters = array(
    			'menus' => $this->loadMenu($lang),
    			'events' => $this->loadEvents($lang),
    			'settings' => $this->loadSettings($lang),
    			'page' => $page,
    			'articleId' => 0
    	);
    	
       	if($pageType == 'schedule') {	
	    	$parameters = array_merge($parameters, array(
	    			'classes' => $this->loadClassesForStudents(),
	    			'lessons' => $this->loadLessons()
	    	));
    	}
    	
    	$searchString = $request->query->get('s');
    	if(!empty($searchString)) {
    		$result = $this->findArticlesByKeyword($searchString);
    		foreach($result as $article) {
    			$page->addArticle($article);
    		}
    	}
    	
	   	return $this->render('site/'.$site.'/views/'.$lang.'/'.$pageType.'.html.twig', $parameters);
    }
    
    /**
     * @Route("/page/{pageId}/{articleId}", name="articleOnPage")
     */
    public function displayPageWithArticle($pageId, $articleId)
    {
    	$site = $this->getParameter('site');
    	$em = $this->getDoctrine ()->getManager();
    	 
    	$page = $em->getRepository ( 'AppBundle:Page' )->find($pageId);
    	$lang = $page->getLanguage()->getCode();
    	$pageType = $this->pageTypes[1];
    	
    	$parameters = array(
    		'menus' => $this->loadMenu($lang),
    		'events' => $this->loadEvents($lang),
    		'settings' => $this->loadSettings($lang),
    		'page' => $page,
    		'articleId' => $articleId
    	);
    	 
    	return $this->render('site/'.$site.'/views/'.$lang.'/'.$pageType.'.html.twig', $parameters);
    }
 
    private function loadMenu($lang) {
    	$em = $this->getDoctrine ()->getManager();
    	 
    	$q = $em->getRepository ( 'AppBundle:Menu' )
    	->createQueryBuilder ( 'm' )
    	->where ( 'm.parent is null' )
    	->andWhere('m.language = :lang')
    	->setParameter ( "lang", $lang )
    	->orderBy('m.sortOrder', 'ASC');
    	
    	$menus = $q->getQuery ()->execute();
    	
    	return $menus;
    }
    
    private function getEmailSetting($lang) {
    	$em = $this->getDoctrine ()->getManager();
    
    	$q = $em->getRepository ( 'AppBundle:Setting' )
    	->createQueryBuilder ( 's' )
    	->join('s.type', 't')
    	->where('t.id = 8')
    	->andWhere('s.language = :lang')
    	->setParameter('lang', $lang);
    	 
    	$email = $q->getQuery ()->getSingleResult();
    		 
    	return $email;
    }
    
    private function loadEvents($lang) {
    	$em = $this->getDoctrine ()->getManager();
    
    	$q = $em->getRepository ( 'AppBundle:Event' )
    	->createQueryBuilder ( 'm' )
    	->where('m.language = :lang')
    	->setParameter ( "lang", $lang );
    	 
    	$events = $q->getQuery ()->execute();
    	 
    	return $events;
    }
    
    private function loadSettings($lang) {
    	$em = $this->getDoctrine ()->getManager();
    
    	$q = $em->getRepository ( 'AppBundle:Setting' )
    	->createQueryBuilder ( 's' )
    	->where('s.language = :lang')
    	->setParameter ( "lang", $lang );
    
    	$settings = $q->getQuery ()->execute();
    
    	return $settings;
    }
    
    private function loadClassesForStudents() {
    	$classesForLesson = $this->getDoctrine()
    	->getRepository('AppBundle:Lesson')
    	->createQueryBuilder('l')
    	->join('l.classOfStudents', 'cl')
    	->join('cl.year', 'y')
    	->groupBy('l.classOfStudents')
    	->addOrderBy('cl.ordinal')
    	->where('y.active=true')
    	->getQuery()->execute();
    	
    	return $classesForLesson;
    }
    
    private function loadLessons() {
    	$lessons = $this->getDoctrine()
    	->getRepository('AppBundle:Lesson')
    	->createQueryBuilder('l')
    	->join('l.classOfStudents', 'cl')
    	->join('cl.year', 'y')
    	->join('l.period', 'p')
    	->orderBy('cl.ordinal')
    	->addOrderBy('p.ordinal')
    	->where('y.active=true')
    	->getQuery()->execute();
    	
    	return $lessons;
    }
    
    private function findArticlesByKeyword($searchString) {
    	$articles = $this->getDoctrine()
    	->getRepository('AppBundle:Article')
    	->createQueryBuilder('a')
    	->where('a.content like :searchString')
    	->orWhere('a.title like :searchString')
    	->orWhere('a.description like :searchString')
    	->andWhere('a.pages is not empty')
    	->setParameter('searchString', '%'.$searchString.'%')
    	->getQuery()->execute();
    	 
    	return $articles;    	
    }

}
