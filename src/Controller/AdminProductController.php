<?php

namespace App\Controller;

use Swift_Mailer;
use Swift_Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\{TextType, TextareaType, MoneyType, SubmitType};
use App\Entity\Product;

class AdminProductController extends Controller
{
    private $mailer;

    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @Route("/admin/new-product", name="admin_new_product")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $product = new Product();

        $form = $this->createFormBuilder($product)
            ->add('title', TextType::class, [
                "required" => true,
                "attr" => [
                    "minlength" => 5
                ]
            ])
            ->add('description', TextareaType::class, [
                "required" => true,
                "attr" => [
                    "maxlength" => 100
                ]
            ])
            ->add('price', MoneyType::class, [
                "required" => true
            ])
            ->add('save', SubmitType::class, array('label' => 'Create product'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            $title = $form["title"]->getData();
            $message = (new Swift_Message("New product: $title"))
                ->setFrom('send@example.com')
                ->setTo('fake@example.com')
                ->setBody(
                    $this->renderView('email/email.html.twig', compact('product'))
                )
            ;
            $this->mailer->send($message);

            return $this->redirectToRoute('product');
        }

        return $this->render('admin_product/index.html.twig', [
            'controller_name' => 'AdminProductController',
            'form' => $form->createView()
        ]);
    }
}
