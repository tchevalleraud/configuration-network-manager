<?php
    namespace App\UI\AdminOffice;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("authentication", name="authentication.")
     */
    class AuthenticationController extends AbstractController {

        /**
         * @Route(".html", name="index", methods={"GET"})
         */
        public function index(){
            return $this->redirectToRoute("adminoffice.authentication.local.index");
        }

    }