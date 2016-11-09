<?php

// src/AppBundle/Service/GradeService.php
namespace AppBundle\Service;

use AppBundle\Entity\Menu;
use AppBundle\Entity\Setting;
use AppBundle\Entity\Event;
use AppBundle\Entity\Article;
use AppBundle\Entity\Page;

use Doctrine\ORM\EntityManager;


class PageService {

	protected $em;
	
	public $pageTypes = array (
			1 => 'page',
			2 => 'lenta',
			3 => 'contact',
			4 => 'schedule',
			5 => 'results',
			6 => 'faq',
			7 => 'archive'
	);
	
	public $months = array (
			'ru' => array (
					1 => 'Январь',
					2 => 'Февраль',
					3 => 'Март',
					4 => 'Апрель',
					5 => 'Май',
					6 => 'Июнь',
					7 => 'Июль',
					8 => 'Август',
					9 => 'Сентябрь',
					10 => 'Октябрь',
					11 => 'Ноябрь',
					12 => 'Декабрь'
			
			),
			'en' => array (
					1 => 'January',
					2 => 'February',
					3 => 'March',
					4 => 'April',
					5 => 'May',
					6 => 'June',
					7 => 'July',
					8 => 'August',
					9 => 'September',
					10 => 'October',
					11 => 'November',
					12 => 'December'
			
			)
	);

	public function __construct(EntityManager $entityManager)
	{
		$this->em = $entityManager;
	}
	
	public function loadMenu($lang) {
		$q = $this->em->getRepository ( 'AppBundle:Menu' )
		->createQueryBuilder ( 'm' )
		->where ( 'm.parent is null' )
		->andWhere('m.language = :lang')
		->setParameter ( "lang", $lang )
		->orderBy('m.sortOrder', 'ASC');
		 
		$menus = $q->getQuery ()->execute();
		 
		return $menus;
	}
	
	public function getEmailSetting($lang) {
		$q = $this->em->getRepository ( 'AppBundle:Setting' )
		->createQueryBuilder ( 's' )
		->join('s.type', 't')
		->where('t.id = 8')
		->andWhere('s.language = :lang')
		->setParameter('lang', $lang);
	
		$email = $q->getQuery ()->getSingleResult();
		 
		return $email;
	}
	
	public function loadEvents($lang) {
		$q = $this->em->getRepository ( 'AppBundle:Event' )
		->createQueryBuilder ( 'm' )
		->where('m.language = :lang')
		->setParameter ( "lang", $lang );
	
		$events = $q->getQuery ()->execute();
	
		return $events;
	}
	
	public function loadSettings($lang) {
		$q = $this->em->getRepository ( 'AppBundle:Setting' )
		->createQueryBuilder ( 's' )
		->where('s.language = :lang')
		->setParameter ( "lang", $lang );
	
		$settings = $q->getQuery ()->execute();
	
		return $settings;
	}
	
	public function findArticlesByKeyword($searchString) {
		$articles = $this->em
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
	
	public function getArticleArchive($page) {
		 
		$result = $this->em
		->getRepository('AppBundle:Page')
		->createQueryBuilder('p')
		->join('p.articles', 'a')
		->select("YEAR(a.created) AS year, MONTH(a.created) AS month, count(a.id) as total")
		->where('p.id = :pageId')
		->groupBy('year')
		->addGroupBy('month')
		->orderBy('year', 'DESC')
		->addOrderBy('month', 'DESC')
		->setParameter("pageId", $page->getId())
		->getQuery()
		->getResult();
		 
		return $result;
	}
	
	public function findArticlesInArchive($page, $month, $year) {
			
		$result = $this->em
		->getRepository('AppBundle:Article')
		->createQueryBuilder('a')
		->join('a.pages', 'p')
		->where('p.id = :pageId')
		->andWhere('YEAR(a.created) = :year')
		->andWhere('MONTH(a.created) = :month')
		->orderBy('a.created', 'DESC')
		->setParameter("pageId", $page->getId())
		->setParameter("month", $month)
		->setParameter("year", $year)
		->getQuery()
		->getResult();
			
		return $result;
	}
	
	
	
}