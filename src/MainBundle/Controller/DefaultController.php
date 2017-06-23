<?php

namespace MainBundle\Controller;

use MainBundle\Entity\User;

use MainBundle\Form\Type\UserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class DefaultController extends Controller
{
    /**
     * @Route("/login")
     */
    public function indexAction(Request $request)
    {
        $user = new User();
        $form =$this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if($request->isMethod('POST')) {
            if($form->isSubmitted() && $form->isValid()) {
                $em = $this->get('doctrine.orm.default_entity_manager');
                $em->persist($user);
                $em->flush($user);
            }

            return $this->render('MainBundle:Default:index.html.twig',[
                'form' => $form->createView(),
            ]);
        }

        return $this->render('MainBundle:Default:index.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}
