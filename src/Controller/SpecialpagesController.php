<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SpecialpagesController extends Controller
{
    /**
     * @Route("/page/about", name="starticPageAbout")
     */
    public function starticPageAbout()
    {
        return $this->render('specialpages/about.html.twig');
    }

    /**
     * @Route("/page/contact", name="starticPageContactUs")
     */
    public function starticPagecontactUs()
    {
        return $this->render('specialpages/connectUs.html.twig');
    }

    /**
     * @Route("/page/jobs", name="starticPageJobs")
     */
    public function starticPageJobs()
    {
        return $this->render('specialpages/jobs.html.twig');
    }

    /**
     * @Route("/page/jobs/term", name="starticPageJobsTerm")
     */
    public function starticPageJobsTerm()
    {
        return $this->render('specialpages/jobsTerm.html.twig');
    }

    /**
     * @Route("/findbest/notice/safetynotice", name="staticPageFindBestNotice")
     */
    public function staticPageFindBestNotice()
    {
        return $this->render('findBest/safetyNotice.html.twig');
    }

    /**
     * @Route("/findbest/home", name="staticPageFindBestHome")
     */
    public function staticPageFindBestHome()
    {
        return $this->render('findBest/home.html.twig');
    }
}
