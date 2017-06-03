<?php

namespace SayHiBundle\Controller;
use SayHiBundle\Entity\User;
use SayHiBundle\Entity\Address;
use SayHiBundle\Entity\Phone;
use SayHiBundle\Entity\Email;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;


class UserController extends Controller
{
    /**
     * @Route("/new", name= "new")
     * @Template("SayHiBundle:User:modify.html.twig")
     */
    public function newAction(Request $req)
    {
        if ($req->isMethod('GET')){
            $form = $this->createUserForm();
            return $this->render('SayHiBundle:User:new.html.twig', array(
                'form' => $form->createView()
            ));
        }
        elseif ($req ->isMethod('POST')){
            $form = $this->createUserForm();
            $form->handleRequest($req);
            if ($form->isSubmitted() && $form->isValid()) {
                $user = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->validateDbInsert($user, $req);
                return new RedirectResponse($this->generateUrl('show', array('id' => $user->getId())));
            }
            else{
                $this->addFlashbag($req, 'danger', 'incorrect form');
                return new RedirectResponse($this->generateUrl('new', array()));             
            }
        }
    }

    /**
     * @Route("/{id}/modify", name ="modify")
     */
    public function modifyAction(Request $req, $id)
    {
        if($req->isMethod('GET')){
            if ($this->checkIfUserExists($id, $req)){
                $userForm = $this->changeUserForm($id);
                $addressForm = $this->addAddressForm($id);
                $emailForm = $this->addEmailForm($id);
                $phoneForm = $this->addPhoneForm($id);
                return $this->render('SayHiBundle:User:modify.html.twig', array(
                    'userForm' => $userForm->createView(),
                    'addressForm' => $addressForm->createView(),
                    'emailForm' => $emailForm->createView(),
                    'phoneForm' => $phoneForm->createView()
                    ));
            }
            else{
                $this->addFlashbag($req, 'danger', 'no such user found');       
                return new RedirectResponse($this->generateUrl('showAll', array()));
            }
        }
        elseif($req->isMethod('POST')){
            $form = $this->changeUserForm($id);
            $form->handleRequest($req);
            if ($form->isSubmitted()) {
                $user = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->addFlashbag($req, 'info', 'details changed!');
                return new RedirectResponse($this->generateUrl('modify', array('id'=>$id)));
            }
       }
    }

    /**
     * @Route("/{id}/delete", name = "delete")
     */
    public function deleteAction(Request $req, $id)
    {
        if($this->checkIfUserExists($id, $req)){
            $loadedUser = $this -> findUserById($id);
            $em = $this->getDoctrine()->getManager();
            $em->remove($loadedUser);
            $em->flush();
        
            $this->addFlashbag($req, 'info', 'user deleted!');    
            return new RedirectResponse($this->generateUrl('showAll', array()));
        }
        else{
            $this->addFlashbag($req, 'danger', 'no such user found');
            return new RedirectResponse($this->generateUrl('showAll', array()));
        }
    }

    /**
     * @Route("/{id}", name = "show")
     */
    public function showAction($id)
    {
        $user = $this -> findUserById($id);
        $userPhones = [];
        foreach ($user->getPhones() as $phone){
            $userPhones[] = $phone;
        }
        $userEmails = [];
        foreach ($user->getEmails() as $email){
            $userEmails[] = $email;
        }
        return $this->render('SayHiBundle:User:show.html.twig', array(
            'user' => $user,
            'phones' => $userPhones,
            'emails' => $userEmails
            ));
    }

    /**
     * @Route("/", name = "showAll")
     */
    public function showAllAction(Request $req)
    {
        $fetchedUsers = [];
        if($req->isMethod('GET')){
            $repo = $this->getDoctrine()->getRepository('SayHiBundle:User');
            $fetchedUsers = $repo->findAll();
            if (!empty($req->query->get('userSearch'))){
                $toFind = $req->query->get('userSearch');
                $fetchedUsers = $repo->showAllLike($toFind);
            }
        }
        return $this->render('SayHiBundle:User:show_all.html.twig', array('fetchedUsers' => $fetchedUsers));
    }
    
    public function createUserForm(){
        $user = new User();
        $form = $this->createFormBuilder($user)
        ->setAction($this->generateUrl('new'))
        ->setMethod('POST')
        ->add('name', 'text')
        ->add('surname', 'text')
        ->add('description', 'textarea')
        ->add('save', 'submit', array('label' => 'Create User'))
        ->getForm();
        
        return $form;
    }
    
    public function changeUserForm($id){
        $user = $this -> findUserById($id);
        $form = $this->createFormBuilder($user)
        ->setAction($this->generateUrl('modify', array('id'=>$id)))
        ->setMethod('POST')
        ->add('name', 'text')
        ->add('surname', 'text')
        ->add('description', 'textarea')
        ->add('save', 'submit', array('label' => 'Change Details'))
        ->getForm();
        return $form;
    }
    
    public function addAddressForm($userId){
        $address = new Address();
        $user = $this -> findUserById($userId);
        $address -> addUser($user);
        $form = $this->createFormBuilder($address)
        ->setAction("/$userId/addAddress")
        ->setMethod('POST')
        ->add('city', 'text')
        ->add('street', 'text')
        ->add('streetNr', 'number')
        ->add('aptNr', 'number')
        ->add('save', 'submit', array('label' => 'Add new address'))
        ->getForm();
        
        return $form;
    }
    
    public function addEmailForm($userId){
        $email = new Email();
        $user = $this -> findUserById($userId);
        $email -> setUser($user);
        $form = $this->createFormBuilder($email)
        ->setAction("/$userId/addEmail")
        ->setMethod('POST')
        ->add('emailAddress', 'text')
        ->add('contactType', 'entity', array(
            'class' => 'SayHiBundle:ContactType',
            'choice_label' => 'description',
            ))
        ->add('save', 'submit', array('label' => 'Add new email'))
        ->getForm();
        
        return $form;
    }

    public function addPhoneForm($userId){
        $phone = new Phone();
        $user = $this -> findUserById($userId);
        $phone -> setUser($user);
        $form = $this->createFormBuilder($phone)
        ->setAction("/$userId/addPhone")
        ->setMethod('POST')
        ->add('number', 'text')
        ->add('contactType', 'entity', array(
            'class' => 'SayHiBundle:ContactType',
            'choice_label' => 'description',
            ))
        ->add('save', 'submit', array('label' => 'Add new phone number'))
        ->getForm();
        
        return $form;
    }
    
    public function checkIfUserExists($id, Request $req){
        $loadedUser = $this -> findUserById($id);
        if ($loadedUser==null){     
            return false;
        }
        else{
            return true;
        }
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
    
    public function findUserById($id){
        $userRepo = $this->getDoctrine()->getRepository('SayHiBundle:User');
        return $userRepo->find($id);
    }

}
