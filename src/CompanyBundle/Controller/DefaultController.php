<?php

namespace CompanyBundle\Controller;

use CompanyBundle\Entity\Company;
use CompanyBundle\Form\Type\CompanyFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/company")
     */
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $companies = $em->getRepository('CompanyBundle:Company');

        $query = $companies->createQueryBuilder('t')
            ->select("t.id, t.name, t.description, t.telephone, t.amountWorker, t.status")
            ->getQuery();

        $companies = $query->getResult();


        return $this->render('CompanyBundle:Default:index.html.twig', [
            'companies' => $companies,
        ]);
    }

    /**
     * @Route("/company/add/")
     */
    public function addAction(Request $request)
    {
        $company = new Company();
        $form = $this->createForm(CompanyFormType::class, $company);
        $form->handleRequest($request);
        if($request->isMethod('POST')) {
            if($form->isSubmitted() && $form->isValid()) {
                $em = $this->get('doctrine.orm.default_entity_manager');
                $em->persist($company);
                $em->flush($company);
            }

            return $this->render('CompanyBundle:Default:add.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        return $this->render('CompanyBundle:Default:add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/company/update/{id}")
     */
    public function updateAction(Request $request, $id)
    {
        $company = new Company();
        $form = $this->createForm(CompanyFormType::class, $company);
        $form->handleRequest($request);
        if($request->isMethod('POST')) {
            if($form->isSubmitted() && $form->isValid()) {
                $em = $this->get('doctrine.orm.default_entity_manager');
                $company = $em->getRepository('CompanyBundle:Company')->find($id);
                $em->persist($company);
                $em->flush($company);
                return $this->redirect('/company');
            }

            return $this->render('CompanyBundle:Default:update.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        return $this->render('CompanyBundle:Default:update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/company/delete/{id}")
     */
    public function deleteAction($id)
    {

        $em = $this->get('doctrine.orm.default_entity_manager');
        $company = $em->getRepository('CompanyBundle:Company')->find($id);

        $em->remove($company);
        $em->flush();

        return $this->redirect('/company');
    }






}
