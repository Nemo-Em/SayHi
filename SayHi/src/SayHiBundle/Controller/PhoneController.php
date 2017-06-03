<?php

namespace SayHiBundle\Controller;
use SayHiBundle\Entity\User;
use SayHiBundle\Entity\Phone;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;


class PhoneController extends Controller
{
    /**
     * @Route("/{id}/addPhone", name="addEmail")
     * @Template("SayHiBundle:Phone:add.html.twig")
     */
    public function addAction(Request $req, $id){
        if($req->isMethod('POST')){
            $phone = new Phone();
            $userRepo = $this->getDoctrine()->getRepository('SayHiBundle:User');
            $user = $userRepo->find($id);
            $phone -> setUser($user);
            $form = $this->createFormBuilder($phone)
            ->setAction("/$id/addPhone")
            ->setMethod('POST')
            ->add('number', 'text')
            ->add('contactType', 'entity', array(
                'class' => 'SayHiBundle:ContactType',
                'choice_label' => 'description',
                ))
            ->add('save', 'submit', array('label' => 'Add new phone'))
            ->getForm();
            $form->handleRequest($req);
            if ($form->isSubmitted() && $form->isValid()) {
                $phone = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($phone);
                $em->flush();
                $this->validateDbInsert($phone, $req);
            }
        }
        return $this->render('SayHiBundle:Phone:add.html.twig', array());
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
