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
}
