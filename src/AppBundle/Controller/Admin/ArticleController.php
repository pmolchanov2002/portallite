<?php

// src/AppBundle/Controller/ArticleController.php
namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Article;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\OrderBy;

class ArticleController extends Controller
{

    private $displayRoute = 'app_article_display';

    /**
     * @Route("/admin/web/article/create")
     */
    public function create(Request $request)
    {
        $article = new Article();
        $article->setCreated(new \DateTime("now"));
        $form = $this->createFormBuilder($article)
            ->add('title', 'text', array('label' => 'Title:'))
            ->add('created', 'date', array('label' => 'Date:'))
            ->add('author', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:User',
            		'label' => 'Author: ',
            		'query_builder' => function (EntityRepository $er) {
            		return $er->createQueryBuilder('u')
            		->join('u.roles', 'r')
            		->where('r.id = :id')
            		->setParameter('id', 5);
            		}))
            ->add('icon', 'entity', array(
            		'multiple' => false,
            		'required' => false,
            		'class' => 'AppBundle:Media',
            		'choice_label' => 'description',
            		'label' => 'Icon: ',
            		'query_builder' => function (EntityRepository $er) {
            		return $er->createQueryBuilder('p')
            			->where('p.type = 1')
            			->orWhere('p.type = 5');
            		}))
            ->add('description', 'markdown', array('label' => 'Description:'))
            ->add('content', 'markdown', array('label' => 'Body:'))
      		->add('language', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Language',
            		'choice_label' => 'nativeName',
            		'label' => 'Language: '))
            ->add('type', 'entity', array(
       				'multiple' => false,
      				'class' => 'AppBundle:ArticleType',
            		'choice_label' => 'name',
            		'label' => 'Type: '))
            ->add('status', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Status',
            		'choice_label' => 'name',
            		'label' => 'Status: '))
            ->add('pages', 'entity', array(
            		'multiple' => true,
            		'expanded' => true,
            		'class' => 'AppBundle:Page',
            		'required' => false,
            		'choice_label' => 'id',
            		'label' => 'Page: '))
            ->add('images', 'entity', array(
            		'multiple' => true,
            		'expanded' => true,
            		'class' => 'AppBundle:Media',
            		'choice_label' => 'description',
            		'label' => 'Images: ',
            		'query_builder' => function (EntityRepository $er) {
            			return $er->createQueryBuilder('p')
            			->where('p.type = 1')
            			->orderBy('p.id','DESC');
            		}))
            ->add('videos', 'entity', array(
            		'multiple' => true,
            		'expanded' => true,
            		'class' => 'AppBundle:Media',
            		'choice_label' => 'description',
            		'label' => 'Video: ',
            		'query_builder' => function (EntityRepository $er) {
            		return $er->createQueryBuilder('p')
            		->where('p.type = 5')
            		->orderBy('p.id','DESC');
            		}))
            ->add('audios', 'entity', array(
            		'multiple' => true,
            		'expanded' => true,
            		'class' => 'AppBundle:Media',
            		'choice_label' => 'description',
            		'label' => 'Audio: ',
            		'query_builder' => function (EntityRepository $er) {
            		return $er->createQueryBuilder('p')
            		->where('p.type = 6')
            		->orderBy('p.id','DESC');
            		}))
            ->add('documents', 'entity', array(
            		'multiple' => true,
           			'expanded' => true,
       				'class' => 'AppBundle:Media',
       				'choice_label' => 'description',
            		'label' => 'Documents: ',
            		'query_builder' => function (EntityRepository $er) {
            			return $er->createQueryBuilder('p')
            			->where('p.type = 2')
            			->orWhere('p.type = 3');
            		}))
            ->add('save', 'submit', array('label' => 'Create'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $article = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/article.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/web/article/edit/{id}")
     * @ParamConverter("article", class="AppBundle:Article")     
     */
    public function edit($article, Request $request)
    {
        if(!isset($article)) {
            return new Response("Article not found");
        }
        $form = $this->createFormBuilder($article)
            ->add('title', 'text', array('label' => 'Title:'))
            ->add('created', 'date', array('label' => 'Date:'))
            ->add('author', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:User',
            		'label' => 'Author: ',
            		'query_builder' => function (EntityRepository $er) {
            		return $er->createQueryBuilder('u')
            		->join('u.roles', 'r')
            		->where('r.id = :id')
            		->setParameter('id', 5);
            		}))
            ->add('icon', 'entity', array(
            		'multiple' => false,
            		'required' => false,
            		'class' => 'AppBundle:Media',
            		'choice_label' => 'description',
            		'label' => 'Icon: ',
            		'query_builder' => function (EntityRepository $er) {
            			return $er->createQueryBuilder('p')
            			->where('p.type = 1')
            			->orWhere('p.type = 5');
            		}))
            ->add('description', 'markdown', array('label' => 'Description:'))
            ->add('content', 'markdown', array('label' => 'Body:'))
      		->add('language', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Language',
            		'choice_label' => 'nativeName',
            		'label' => 'Language: '))
            ->add('type', 'entity', array(
       				'multiple' => false,
      				'class' => 'AppBundle:ArticleType',
            		'choice_label' => 'name',
            		'label' => 'Type: '))
            ->add('status', 'entity', array(
            		'multiple' => false,
            		'class' => 'AppBundle:Status',
            		'choice_label' => 'name',
            		'label' => 'Status: '))
            ->add('pages', 'entity', array(
            		'multiple' => true,
            		'expanded' => true,
            		'class' => 'AppBundle:Page',
            		'required' => false,
            		'choice_label' => 'id',
            		'label' => 'Page: '))
            ->add('images', 'entity', array(
      				'multiple' => true,
            		'expanded' => true,
            		'class' => 'AppBundle:Media',
            		'choice_label' => 'description',
            		'label' => 'Images: ',
            		'query_builder' => function (EntityRepository $er) {
            		return $er->createQueryBuilder('p')
            		->where('p.type = 1')
            		->orderBy('p.id','DESC');
           			}))
           	->add('videos', 'entity', array(
         			'multiple' => true,
      				'expanded' => true,
       				'class' => 'AppBundle:Media',
           			'choice_label' => 'description',
           			'label' => 'Video: ',
           			'query_builder' => function (EntityRepository $er) {
           			return $er->createQueryBuilder('p')
           			->where('p.type = 5')
           			->orderBy('p.id','DESC');
           			}))
           	->add('audios', 'entity', array(
           			'multiple' => true,
           			'expanded' => true,
           			'class' => 'AppBundle:Media',
           			'choice_label' => 'description',
           			'label' => 'Audio: ',
           			'query_builder' => function (EntityRepository $er) {
           			return $er->createQueryBuilder('p')
           			->where('p.type = 6')
           			->orderBy('p.id','DESC');
           			}))
            ->add('documents', 'entity', array(
            		'multiple' => true,
            		'expanded' => true,
            		'class' => 'AppBundle:Media',
            		'choice_label' => 'description',
            		'label' => 'Documents: ',
            		'query_builder' => function (EntityRepository $er) {
            		return $er->createQueryBuilder('p')
            		->where('p.type = 2')
            		->orWhere('p.type = 3');
            		}))
            ->add('save', 'submit', array('label' => 'Save'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $article = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute($this->displayRoute);
        }    

        return $this->render('admin/form/article.html.twig', array(
            'form' => $form->createView(),
        ));
    }

     /**
     * @Route("/admin/web/article/delete/{id}")
     * @ParamConverter("article", class="AppBundle:Article")
     */
    public function delete($article)
    {
        if(!isset($article)) {
            return new Response("Article not found");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        //return new Response("Class was deleted");
        return $this->redirectToRoute($this->displayRoute);
    }

     /**
     * @Route("/admin/web/article", name="app_article_display")
     */       
    public function display() {
        $articles = $this->getDoctrine()
        ->getRepository('AppBundle:Article')
    	->createQueryBuilder('a')
    	->orderBy('a.id', 'DESC')
    	->getQuery()->execute();
        return $this->render('admin/view/article.html.twig',  array('articles' => $articles));
    }
}