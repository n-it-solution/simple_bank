<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestingController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
//        $userManager = $this->container->get('fos_user.user_manager');
//        $user = $userManager->createUser();
        $user = new User();
        $user->setEmail('mirza@gmail.c21om111');
        $user->setPlainPassword('h21hh111');
        $user->setUsername('hhh12111');
        $user->setPhoneNumber('1111');
        $user->setFirstname('Abdul');
        $user->setLastname('Manan');
        $user->setGender('m');
        $em = $this->getDoctrine()->getManager();
        $user->setEnabled(0);
//        $em->persist($user);
//        $em->flush();
        return $this->render('testing/index.html.twig', [
            'controller_name' => 'TestingController',
        ]);
    }
}
