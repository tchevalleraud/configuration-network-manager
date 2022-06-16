<?php
    namespace App\UI\BackOffice;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("dashboard", name="dashboard.")
     */
    class DashboardController extends AbstractController {

        /**
         * @Route(".html", name="index", methods={"GET"})
         */
        public function index(){
            return $this->render("BackOffice/Dashboard/index.html.twig");
        }

    }