<?php

namespace App\Controller;

use App\Entity\Transaction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    /**
     * @Route("/transaction/send/report", name="transaction_send_report")
     */
    public function transactionSend()
    {
        $transactions = $this->getDoctrine()->getRepository(Transaction::class)->findBy(['Sender' => $this->getUser()->getId()],['id'=> 'DESC']);
        return $this->render('report/transaction_send_report.html.twig', [
            'transactions' => $transactions,
        ]);
    }
    /**
     * @Route("/transaction/received/report", name="transaction_received_report")
     */
    public function transactionReceived()
    {
        $transactions = $this->getDoctrine()->getRepository(Transaction::class)->findBy(['Receiver' => $this->getUser()->getId()],['id'=> 'DESC']);
        return $this->render('report/transaction_received_report.html.twig', [
            'transactions' => $transactions,
        ]);
    }
}
