<?php

namespace SayHiBundle\Controller;
use SayHiBundle\Entity\User;
use SayHiBundle\Entity\Address;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;


class AddressController extends Controller
{
    /**
     * @Route("/{id}/addAddress", name="addAddress")
     * @Template("SayHiBundle:Address:add.html.twig")
     */
    public function addAction(Request $req, $id){
        if($req->isMethod('POST')){
            $address = new Address();
            $userRepo = $this->getDoctrine()->getRepository('SayHiBundle:User');
            $user = $userRepo->find($id);
            $address -> addUser($user);
            $form = $this->createFormBuilder($address)
            ->setAction("/$id/addAddress")
            ->setMethod('POST')
            ->add('city', 'text')
            ->add('street', 'text')
            ->add('streetNr', 'number')
            ->add('aptNr', 'number')
            ->add('save', 'submit', array('label' => 'Add new address'))
            ->getForm();
            $form->handleRequest($req);
            if ($form->isSubmitted() && $form->isValid()) {
                $address = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $user->setAddress($address);
                $em->persist($address);
                $em->flush();
                $this->validateDbInsert($address, $req);
            }
        }
        return $this->render('SayHiBundle:Address:add.html.twig', array());
    }
    
    public function addFlashbag(Request $req, $type, $message){
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
