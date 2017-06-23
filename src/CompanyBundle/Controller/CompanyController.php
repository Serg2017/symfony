<?php

namespace CompanyBundle\Controller;

use CompanyBundle\CompanyBundle;
use CompanyBundle\Form\Type\WorkerFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\EntityRepository;
use CompanyBundle\Entity\Worker;
use Symfony\Component\HttpFoundation\Request;

class CompanyController extends Controller
{
    /**
     * @Route("/company/worker", name="listWorkers")
     */
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $companies = $em
            ->getRepository('CompanyBundle:Company')
            ->createQueryBuilder('c')
            ->join('c.workers', 'w')
            //->where('w.id =')
            //->select('c', 'w')
            ->getQuery()
            ->getResult();

        return $this->render('CompanyBundle:company:index.html.twig', [
            'companies' => $companies,
        ]);
    }

    /**
     * @Route("/company/worker/add", name="addWorker")
     */
    public function addAction(Request $request)
    {
        $worker = new Worker();
        $form = $this->createForm(WorkerFormType::class, $worker);
        $form->handleRequest($request);

        if($request->isMethod('POST')) {
            if($form->isSubmitted() && $form->isValid()) {
                //print_r($request->request);
                $em = $this->get('doctrine.orm.default_entity_manager');
                $em->persist($worker);
                $em->flush($worker);

                return $this->redirectToRoute('listWorkers');
            }

            return $this->redirectToRoute('addWorker');
        }

        return $this->render('CompanyBundle:company:add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/company/worker/update/{id}", name="updateWorker")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $workerInfo = $em->getRepository('CompanyBundle:Worker')->find($id);
        $form = $this->createForm(WorkerFormType::class, $workerInfo);
        $form->handleRequest($request);

        if($request->isMethod('POST')) {
            if($form->isSubmitted() && $form->isValid()) {
                $em->persist($workerInfo);
                $em->flush($workerInfo);

                return $this->redirectToRoute('listWorkers');
            }

            return $this->redirectToRoute('updateWorker');
        }

        return $this->render('CompanyBundle:company:update.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}