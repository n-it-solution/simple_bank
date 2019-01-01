<?php

namespace App\Controller;

use App\Entity\Currency;
use App\Entity\Transaction;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
    /**
     * @Route("/api")
     */
{
    /**
     * @Route("/", name="api_index")
     */
    public function index(Request $request)
    {
        $apiKey = $request->headers->get('api-key');
        $cliendToken = $request->headers->get('client-token');
        return $this->json(['api_key' => $apiKey, 'client_token' => $cliendToken]);
    }

    /**
     * @Route("/send", name="api_send")
     */
    public function apiSend(Request $request,\Swift_Mailer $mailer)
    {
        $apiKey = $request->headers->get('api-key');
        $cliendToken = $request->headers->get('client-token');
        $em = $this->getDoctrine()->getManager();
        $status = '';
        $receiver = $request->get('receiver');
        $amount = $request->get('amount');
        $dec = $request->get('description');
        $currency = $request->get('currency');
        $check = $em->getRepository(User::class)->findOneBy(['Api_key' => $apiKey, 'Client_token' => $cliendToken]);
        if(empty($check)){
            $status = 'Please check your api key and client token';
        }elseif ($check->isEnabled() == false){
            $status = 'Your account is expired';
        }elseif($receiver == '' || $amount == '' || $dec == '' || $currency == ''){
            $status = 'Something is missing check';
        }else{
            $receiverCheck = $em->getRepository(User::class)->findOneBy(['email' => $receiver , 'enabled' => 1]);
            if(empty($receiverCheck)){
                $status = 'Receiver email not found in database';
            }else{
                $currency = $em->getRepository(Currency::class)->findOneBy(['Name' => $currency]);
                $received = $em->getRepository(Transaction::class)->findByReceiver($check->getId(),$currency->getId());
                $sended = $em->getRepository(Transaction::class)->findBySender($check->getId(),$currency->getId());
                $total = $received[0][1]-$sended[0][1];
                if($total >= $amount){
                    $transaction = New Transaction();
                    $transaction->setAmount($amount);
                    $transaction->setSender($check);
                    $transaction->setDescription($dec);
                    $transaction->setReceiver($receiverCheck);
                    $transaction->setCurrency($currency);
                    $transaction->setType(1);
                    $transaction->setDate(date('Y/m/d H:i:s'));
                    $em->persist($transaction);
                    $em->flush();
                    $status = 'Amount send';
                    $message = (new \Swift_Message('Hello Email'))
                        ->setFrom('mirza.amanan@gmail.com')
                        ->setTo($receiverCheck->getEmail())
                        ->setBody(
                            $this->renderView(
                            // templates/emails/registration.html.twig
                                'emails/trans.html.twig',
                                [
                                    'name' => $this->getUser()->getFirstName().' '.$this->getUser()->getLastName(),
                                    'receiver' => $receiverCheck->getFirstName().' '.$receiverCheck->getLastName(),
                                    'amount' => $amount,
                                    'currency' => $currency->getName()
                                ]
                            ),
                            'text/html'
                        );
                    $mailer->send($message);
                }else{
                    $status = "You did't have enough balanced to send";
                }

            }
        }
        return $this->json(array('status' => $status));
    }
 /**
     * @Route("/req/send", name="api_req_send")
     */
    public function apiReqSend(Request $request,\Swift_Mailer $mailer)
    {
        $apiKey = $request->headers->get('api-key');
        $cliendToken = $request->headers->get('client-token');
        $em = $this->getDoctrine()->getManager();
        $status = '';
        $receiver = $request->get('receiver');
        $amount = $request->get('amount');
        $dec = $request->get('description');
        $currency = $request->get('currency');
        $check = $em->getRepository(User::class)->findOneBy(['Api_key' => $apiKey, 'Client_token' => $cliendToken]);
        if(empty($check)){
            $status = 'Please check your api key and client token';
        }elseif ($check->isEnabled() == false){
            $status = 'Your account is expired';
        }elseif($receiver == '' || $amount == '' || $dec == '' || $currency == ''){
            $status = 'Something is missing check';
        }else{
            $receiverCheck = $em->getRepository(User::class)->findOneBy(['email' => $receiver , 'enabled' => 1]);
            if(empty($receiverCheck)){
                $status = 'Receiver email not found in database';
            }else{
                $currency = $em->getRepository(Currency::class)->findOneBy(['Name' => $currency]);
                    $transaction = New Transaction();
                    $transaction->setAmount($amount);
                    $transaction->setSender($receiverCheck);
                    $transaction->setDescription($dec);
                    $transaction->setReceiver($check);
                    $transaction->setCurrency($currency);
                    $transaction->setType(3);
                    $transaction->setDate(date('Y/m/d H:i:s'));
                    $em->persist($transaction);
                    $em->flush();
                    $status = 'Amount send';
                $message = (new \Swift_Message('Hello Email'))
                    ->setFrom('mirza.amanan@gmail.com')
                    ->setTo($receiverCheck->getEmail())
                    ->setBody(
                        $this->renderView(
                        // templates/emails/registration.html.twig
                            'emails/trans_req.html.twig',
                            [
                                'name' => $check->getFirstName().' '.$check->getLastName(),
                                'receiver' => $receiverCheck->getFirstName().' '.$receiverCheck->getLastName(),
                                'amount' => $amount,
                                'currency' => $currency->getName()
                            ]
                        ),
                        'text/html'
                    );
                $mailer->send($message);

            }
        }
        return $this->json(array('status' => $status));
    }


}
