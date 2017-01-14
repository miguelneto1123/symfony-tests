<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 13/01/17
 * Time: 21:40
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Customer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{

    /**
     * @Route("/signup", name="signup")
     */
    public function signUpAction(Request $request)
    {
        $cus = new Customer();

        $form = $this->createFormBuilder($cus)
            ->add('username',TextType::class, array('label' => false))
            ->add('email',EmailType::class, array('label' => false))
            ->add('password', PasswordType::class, array('label' => false))
            ->add('save', SubmitType::class, array('label' => 'Log In'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $cus = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($cus);
            $em->flush();

            return $this->redirectToRoute("success");

        }
        return $this->render('login/signup.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $cus = new Customer();

        $form = $this->createFormBuilder($cus)
            ->add('email',EmailType::class, array('label' => false))
            ->add('password', PasswordType::class, array('label' => false))
            ->add('save', SubmitType::class, array('label' => 'Log In'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $cus = $form->getData();

            $search = $this->getDoctrine()->getRepository('AppBundle:Customer')->findOneByEmail($cus->getEmail());
            if (!$search){
                return $this->render('login/login2.html.twig', array(
                    'form' => $form->createView()
                ));
            }
            else{
                if ($search->getPassword() != $cus->getPassword()){
                    return $this->render('login/login3.html.twig', array(
                        'form' => $form->createView()
                    ));
                }
                return $this->redirectToRoute('successlogin', array(
                    'username' => $search->getUsername()
                ));
            }

        }

        return $this->render('login/login.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/success", name="success")
     */
    public function successAction()
    {
        return new Response('<html><body>User created</body></html>');
    }

    /**
     * @Route("/{username}", name="successlogin")
     */
    public function successLoginAction($username)
    {
        return new Response('<html><body>Hello, '.$username.'</body></html>');
    }
}