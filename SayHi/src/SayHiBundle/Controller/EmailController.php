<?php

namespace SayHiBundle\Controller;
use SayHiBundle\Entity\User;
use SayHiBundle\Entity\Email;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;


class EmailController extends Controller
{
    /**
     * @Route("/{id}/addEmail", name="addEmail")
     * @Template("SayHiBundle:Email:add.html.twig")
     */
    public function addAction(Request $req, $id){
        if($req->isMethod('POST')){
            $email = new Email();
            $userRepo = $this->getDoctrine()->getRepository('SayHiBundle:User');
            $user = $userRepo->find($id);
            $email -> setUser($user);
            $form = $this->createFormBuilder($email)
            ->setAction("/$id/addEmail")
            ->setMethod('POST')
            ->add('emailAddress', 'text')
            ->add('contactType', 'entity', array(
                'class' => 'SayHiBundle:ContactType',
                'choice_label' => 'description',
                ))
            ->add('save', 'submit', array('label' => 'Add new email'))
            ->getForm();
            $form->handleRequest($req);
            if ($form->isSubmitted() && $form->isValid()) {
                $email = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($email);
                $em->flush();
                $this->validateDbInsert($email, $req);
            }
        }
        return $this->render('SayHiBundle:Email:add.html.twig', array());
    }
    
    public function addFlashbag($req, $type, $message){
        $req->getSession()
        ->getFlashBag()
        ->add($type, $message);
    }
    
    public function validateDbInsert($object, Request $req){
        if(null != $object->getId()) {
            $this->addFlashbag($req, 'success', 'request success!');
        }
        else{
            $this->addFlashbag($req, 'danger', 'request failed');
        }
    }

}
