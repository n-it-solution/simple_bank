<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;
class UserController extends AbstractController
{
    /**
     * @Route("/slider", name="slider")
     */
    public function slider(){
        return $this->render('slider.html.twig');
    }
    /**
     * @Route("/register", name="user")
     */
    public function index(Request $request)
    {
        if(!empty($this->getUser())){
            return $this->redirectToRoute('profile');
        }
        $error = '';
        $em = $this->getDoctrine()->getManager();
        if($request->getMethod() == 'POST'){
        $data = $request->request->all();
        if($data['password'] == $data['confirmPassword']){
            $check = $em->getRepository(User::class)->findOneBy(['email' => $data['email']]);
            if (empty($check)){
                $check = $em->getRepository(User::class)->findOneBy(['phoneNumber' => $data['phone']]);
                if (empty($check)) {
                    $sid    = "AC4758d9bcbe2cdc2ad6b5e0cfa0fe3297";
                    $token  = "16be06db09767d4971362a12cda8041f";
                    $twilio = new Client($sid, $token);
                    function randomPassword()
                    {
                        $alphabet = "0123456789";
                        $pass = array(); //remember to declare $pass as an array
                        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
                        for ($i = 0; $i < 6; $i++) {
                            $n = rand(0, $alphaLength);
                            $pass[] = $alphabet[$n];
                        }
                        return implode($pass); //turn the array into a string
                    }
                    $a = randomPassword();
                    $message = $twilio->messages
                        ->create("+".$data['phone'], // to
                            array(
                                "from" => "+19202807191",
                                "body" => "Your Verification code is " . $a
                            )
                        );
                    $user = New User();
                    $user->setCode($a);
                    $user->setGender($data['Gender']);
                    $user->setFirstname($data['First_Name']);
                    $user->setLastname($data['Last_Name']);
                    $user->setEmail($data['email']);
                    $user->setUsername($data['email']);
                    $user->setPlainPassword($data['password']);
                    $user->setType($data['Account-type']);
                    $user->setPhoneNumber($data['phone']);
                    $user->setEnabled(1);
                    $user->setStatus(0);
                    function randomPassword1()
                    {
                        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
                        $pass = array(); //remember to declare $pass as an array
                        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
                        for ($i = 0; $i < 10; $i++) {
                            $n = rand(0, $alphaLength);
                            $pass[] = $alphabet[$n];
                        }
                        return implode($pass); //turn the array into a string
                    }

                    $a = randomPassword1();
                    $b = randomPassword1();
                    $user->setApiKey($a);
                    $user->setClientToken($b);
                    $em->persist($user);
                    $em->flush();
                    return $this->redirectToRoute('profile_activate',['code' => 1]);
                }
                else {
                    $error = 'Phone number already registered!';
                }
            }
            else{
                $error = 'Email already registered';
            }
        }else{
            $error = 'password must be same';
        }

        }
        return $this->render('user/user.html.twig', [
            'error' => $error,
        ]);
    }
    /**
     * @Route("/profile/activate", name="profile_activate")
     */
    public function profileActivate(Request $request){
        $error = '';
        if($request->getMethod() =='POST'){
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $request->get('email'), 'code' => $request->get('code1')]);
            if(empty($user)){
                $error = 'Something wrong!';
            }
            else{
                $user->setEnabled(1);
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                return $this->redirectToRoute('fos_user_security_login');
            }
        }
        return $this->render('user/profile_activate.html.twig', [
            'error' => $error
        ]);
    }
    /**
     * @Route("/profile", name="profile")
     */
    public function profile(){
        if(empty($this->getUser())){
            return $this->redirectToRoute('user');
        }
        return $this->render('user/profile.html.twig', [

        ]);
    }
    /**
     * @Route("/profile/edit", name="profile_edit")
     */
    public function profileEdit(Request $request){
        if(empty($this->getUser())){
            return $this->redirectToRoute('user');
        }
        $em = $this->getDoctrine()->getManager();
        if($request->getMethod() == 'POST'){
            $data = $request->request->all();
                        $user = $em->getRepository(User::class)->find($this->getUser()->getid());
                        $user->setGender($data['gender']);
                        $user->setFirstname($data['fName']);
                        $user->setLastname($data['lName']);
                        $user->setEmail($data['email']);
                        $user->setUsername($data['username']);
//                        $user->setPlainPassword($data['pass']);
                        $user->setType($data['type']);
                        $user->setPhoneNumber($data['pNumber']);
                        $user->setEnabled(1);
                        $em->flush();

        }
        return $this->render('user/user_edit.html.twig', [
        ]);
    }
}
