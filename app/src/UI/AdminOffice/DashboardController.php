<?php
    namespace App\UI\AdminOffice;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Session\SessionInterface;
    use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("dashboard", name="dashboard.")
     */
    class DashboardController extends AbstractController {

        /**
         * @Route(".html", name="index", methods={"GET"})
         */
        public function index(){
            return $this->render("AdminOffice/Dashboard/index.html.twig");
        }

    }