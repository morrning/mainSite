<?php

namespace App\Controller;

use App\Service\formMgr;
use App\Service\logMgr;
use App\Service\userMgr;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    /**
     * @Route("/user/login", name="userLogin")
     */
    public function userLogin(Request $request,formMgr $formMgr,userMgr $userMgr,logMgr $logMgr)
    {
        if($userMgr->isLogedIn())
            return $this->redirectToRoute('home');
        $form = $formMgr->renderForm('sysUserLogin.yml','normal');
        $form->handleRequest($request);
        $alert = null;
        if ($form->isSubmitted() && $form->isValid()) {
            if($userMgr->DoUserLogin($form->get('userName')->getData(),$form->get('password')->getData())){
                //login cerect
                $logMgr->log('وارد سیستم شد.','CORE');
                return $this->redirectToRoute('home');
            }
            //login incerect
            $alert = ['type'=>'danger','message'=>'نام کاربری یا کلمه عبور اشتباه است.'];
        }

        return $this->render('user/login.html.twig', [
            'form' => $form->createView(),
            'alert' => $alert
        ]);
    }

    /**
     * @Route("/user/logout", name="userLogout")
     */
    public function logout(Request $request, userMgr $userMgr, logMgr $logMgr)
    {
        $logMgr->log('از سیستم خارج شد.','CORE');
        $userMgr->DoUserLogout();
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/user/register", name="userRegister")
     */
    public function userRegister(Request $request,formMgr $formMgr,userMgr $userMgr,logMgr $logMgr)
    {


    }
}
