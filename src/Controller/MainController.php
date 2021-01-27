<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MathService;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main", methods = {"GET", "POST"})
     */
    public function index(Request $request): Response
    {
        $mathServ = new MathService();
        $defaultData = [];
        if ($_SERVER['APP_ENV'] == 'dev')
            $defaultData = ['name' => 'admin', 'input' => 1, 'output' => 1];
        $form = $this->createFormBuilder($defaultData)
            ->add('name', TextType::class)
            ->add('input', NumberType::class)
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'sqr' => 'sqr',
                    'sqrt' => 'sqrt',
                    'del' => 'del',
                    'neg' => 'neg',
                ],
            ])
            //->add('output', TextType::class)
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        $ans = 'Your answer is: ';

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();
            $input = $data['input'];
            $type = $data['type'];
            $output = $mathServ->$type($input);
            $ans = $ans . $output;
            //$form->get('output')->setData($output);
            //$data['output'] = $output;
            //return $this->redirectToRoute('main');
        }

        return $this->render('main/index.html.twig', [
            'controller_name' => "MATH",
            'form' => $form->createView(),
            'ans' => $ans
        ]);
    }
}
