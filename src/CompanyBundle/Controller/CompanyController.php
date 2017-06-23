<?php

namespace CompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\EntityRepository;

class CompanyController extends Controller
{
    /**
     * @Route("/company/worker", name="workers")
     */
    public function indexAction()
    {

        $em = $this->get('doctrine.orm.default_entity_manager');
        //$companies = $em->getRepository('CompanyBundle:Company');


        /*$entity = $em
            ->getRepository('CompanyBundle:Company')
            ->createQueryBuilder('e')
            ->join('e.CompanyBundle:Worker', 'r')
           // ->where('r.id = 1')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);*/
/*
        $qb = $em->createQueryBuilder();
        $qb->select('Company', 'Worker')
            ->from('CompanyBundle:Company', 'Company')
            ->join('Article.worker', 'Worker');*/
        //print_r($qb->getQuery()->getResult());



        return $this->render('CompanyBundle:company:index.html.twig');
    }
}