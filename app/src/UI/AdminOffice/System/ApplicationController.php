<?php
    namespace App\UI\AdminOffice\System;

    use App\Application\Services\SettingService;
    use App\Domain\Local\System\Forms\SettingSystemApplication;
    use App\Infrastructure\Forms\AdminOffice\System\Application\EditForm;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("system/application", name="system.application.")
     */
    class ApplicationController extends AbstractController {

        /**
         * @Route(".html", name="index", methods={"GET", "POST"})
         */
        public function index(Request $request, SettingService $settingService){
            $data = new SettingSystemApplication($settingService);
            $form = $this->createForm(EditForm::class, $data);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $settingService->setSetting('system.app.name', $data->getSystemAppName());

                return $this->redirectToRoute("adminoffice.system.application.index");
            }

            return $this->render("AdminOffice/System/Application/index.html.twig", [
                'form'  => $form->createView()
            ]);
        }

    }