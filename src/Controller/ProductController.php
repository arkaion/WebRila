<?php

namespace App\Controller;
// src/Controller/ProductController.php
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index()
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1999);
        $product->setDescription('Ergonomic and stylish!');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }

    /**
     * @Route("/product/{id}", name="product_show")
     */
    public function show($id)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Check out this great product: '.$product->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }

    /**
     * @Route("/products", name="products")
     */
    public function showall()
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findAll();

        return $this->render('product/products.html.twig',['products'=>$products]);
    }

    /**
     * @Route("/product_add", name="product_add")
     */
    public function add(Request $request)
    {
        // just setup a fresh $task object (remove the dummy data)
        $product = new Product();

        $form = $this->createFormBuilder($product)

            ->add('name',TextType::class)
            ->add('price',IntegerType::class)
            ->add('description',TextAreaType::class)
            ->add('save',SubmitType::class, array('label'=>'Créer'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $product = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($product);
             $entityManager->flush();

            return $this->redirectToRoute('product_add');
        }

        return $this->render('product/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}