<?php
    namespace App\UI\_default;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Mailer\MailerInterface;
    use Symfony\Component\Mime\Email;
    use Symfony\Component\Routing\Annotation\Route;

    class RootController extends AbstractController {

        /**
         * @Route("", name="root", methods={"GET"})
         */
        public function index(){
            return $this->redirectToRoute('frontoffice.dashboard.index');
        }

    }