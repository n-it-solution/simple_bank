<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;
class UserController extends AbstractController
{

    public $check = 'hhe';
    public $login = 0;
    function __construct(){
//        if(!empty($this->getUser())){
//            print_r($this->getUser());
//            if($this->getUser()->get)
//        }else{
//            $this->login = 0;
//        }
        $this->check = 'hello';
    }

    public function loginCheck(){
        $user = $this->getUser();
//        print_r($user);
//        return '50000';
        if(!empty($user)){
            if($user->getStatus() == 1){
                return 1;
            }else{
                return 2;
            }
        }else{
            return 0;
        }
//        return 0;
    }

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
                    $user->setStatus(2);
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

    public function new(){
                if(!empty($this->getUser())){
//            print_r($this->getUser());
//            if($this->getUser()->get)
        }else{
            $this->login = 0;
        }
        return false;
    }
    /**
     * @Route("/forget/password", name="forget_password")
     */
    public function recoverPassword(Request $request,\Swift_Mailer $mailer){
//        echo $this->loginCheck().'<br>';
        $checkStatus = $this->loginCheck();
//        echo $checkStatus;
        if ($checkStatus == 1){
            return $this->redirectToRoute('user');
        }elseif ($checkStatus == 2){
            return $this->redirectToRoute('profile_activate');
//            echo 'User account not activated yet';
        }elseif ($checkStatus == 0){
            $error = '';
            if($request->getMethod() =='POST'){
                $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $request->get('email')]);
                if(empty($user)){
                    $error = 'Email not found';
                }
                else{
//                    echo 'success';
//                $user->setEnabled(1);
//                $user = New User();
//                $now = New \DateTime();
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
                    $user->setConfirmationToken($a);
//                print_r( $now);
//                $user = New User();
                    $user->setResetRequest(1);
                    $user->setPasswordRequestedAt(New \DateTime());
//                echo date($now);
                    $em = $this->getDoctrine()->getManager();
                    $em->flush();

                    $message = (new \Swift_Message('Forget password code'))
                        ->setFrom('mirza.amanan@gmail.com')
                        ->setTo($user->getEmail())
                        ->setBody('Your pin code is '.$a);
                    $mailer->send($message);
                    $sid    = "AC4758d9bcbe2cdc2ad6b5e0cfa0fe3297";
                    $token  = "16be06db09767d4971362a12cda8041f";
                    $twilio = new Client($sid, $token);
                    $message = $twilio->messages
                        ->create("+".$user->getPhoneNumber(), // to
                            array(
                                "from" => "+19202807191",
                                "body" => "Your Verification code is " . $a
                            )
                        );}
                return $this->redirectToRoute('reset_password');
                }
            }
            return $this->render('user/forget_password.html.twig', [
                'error' => $error
            ]);
        }
//        return $this->redirectToRoute('fos_user_security_login');
    }

    /**
     * @Route("/reset/password", name="reset_password")
     */
    public function resetPass(Request $request){
        $form = 'code';
        $error = '';
//        print_r($this->getUser());
        $em = $this->getDoctrine()->getManager();
        if ($request->get('email') != '' and $request->get('pin_code') != ''){
            $check = $em->getRepository(User::class)->findOneBy([
                'email' => $request->get('email'),
                'confirmationToken' => $request->get('pin_code')
            ]);
            if (!empty($check)){
                return $this->redirectToRoute('fos_user_resetting_reset',[
                    'token' => $request->get('pin_code')
                ]);
//                if($request->getMethod() == 'POST'){
//                    if($request->get('password') != $request->get('confirmPassword')){
//                        $error = 'Password does not match';
//                    }else{

//                        $check->setPlainPassword($request->get('password'));
//                        $em->flush();
//                    }
//                }
                    $form = 1;
            }else{

            }

        }else{
//            echo 2;
        };
        return $this->render('user/reset_password.html.twig',[
            'form' => $form,
            'error' => $error
        ]);
    }


    /**
     * @Route("/profile/activate", name="profile_activate")
     */
    public function profileActivate(Request $request,\Swift_Mailer $mailer){
        $checkStatus = $this->loginCheck();
//        echo $checkStatus;
        if ($checkStatus == 0){
            return $this->redirectToRoute('fos_user_security_login');
        }elseif ($checkStatus == 2){
            $em = $this->getDoctrine()->getManager();
            if($request->get('action') == 'email'){
                $check = $em->getRepository(User::class)->findOneBy(['phoneNumber' => $this->getUser()->getPhoneNumber()]);
                if (!empty($check)) {
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
                    $message = (new \Swift_Message('Hello Email'))
                        ->setFrom('mirza.amanan@gmail.com')
                        ->setTo($check->getEmail())
                        ->setBody('Your pin code is '.$a);
                    $mailer->send($message);
                    $check->setCode($a);
                    $em->flush();
                    return $this->redirectToRoute('profile_activate');
                }
            }elseif ($request->get('action') == 'phone'){
                $check = $em->getRepository(User::class)->findOneBy(['phoneNumber' => $this->getUser()->getPhoneNumber()]);
                if (!empty($check)) {
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
                    $sid    = "AC4758d9bcbe2cdc2ad6b5e0cfa0fe3297";
                    $token  = "16be06db09767d4971362a12cda8041f";
                    $twilio = new Client($sid, $token);
                    $message = $twilio->messages
                        ->create("+".$check->getPhoneNumber(), // to
                            array(
                                "from" => "+19202807191",
                                "body" => "Your Verification code is " . $a
                            )
                        );}
                $check->setCode($a);
                $em->flush();
                return $this->redirectToRoute('profile_activate');
            }
            $error = '';
            if($request->getMethod() =='POST'){
                $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $this->getUser()->getEmail(), 'code' => $request->get('pin_code')]);
                if(empty($user)){
                    $error = 'Something wrong!';
                }
                else{
                    $user->setStatus(1);
                    $em = $this->getDoctrine()->getManager();
                    $em->flush();
                    return $this->redirectToRoute('user');
                }
            }
            return $this->render('user/profile_activate.html.twig', [
                'error' => $error
            ]);
        }elseif ($checkStatus == 1){
            return $this->redirectToRoute('user');
        }
        $error = '';

    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile(){
        $checkStatus = $this->loginCheck();
//        echo $checkStatus;
        if ($checkStatus == 0){
            return $this->redirectToRoute('fos_user_security_login');
        }elseif ($checkStatus == 2){
            return $this->redirectToRoute('profile_activate');
//            echo 'User account not activated yet';
        }elseif ($checkStatus == 1){
            if(empty($this->getUser())){
                return $this->redirectToRoute('user');
            }
            return $this->render('user/profile.html.twig', [

            ]);
        }
//        print_r($this->getUser());
    }
    /**
     * @Route("/profile/edit", name="profile_edit")
     */
    public function profileEdit(Request $request){
        $checkStatus = $this->loginCheck();
//        echo $checkStatus;
        if ($checkStatus == 0){
            return $this->redirectToRoute('fos_user_security_login');
        }elseif ($checkStatus == 2){
            return $this->redirectToRoute('profile_activate');
//            echo 'User account not activated yet';
        }elseif ($checkStatus == 1){
            $em = $this->getDoctrine()->getManager();
            if($request->getMethod() == 'POST'){
                $data = $request->request->all();
                $user = $em->getRepository(User::class)->find($this->getUser()->getid());
                $user->setGender($data['gender']);
                $user->setFirstname($data['fName']);
                $user->setLastname($data['lName']);
                $user->setEmail($data['email']);
                $user->setUsername($data['email']);
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
}
