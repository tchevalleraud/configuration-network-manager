<?php
    namespace App\UI\AdminOffice\System;

    use App\Application\Services\AWSS3Service;
    use App\Application\Services\SettingService;
    use App\Domain\Local\System\Forms\SettingSystemDesign;
    use App\Infrastructure\Forms\AdminOffice\System\Design\EditForm;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("system/design", name="system.design.")
     */
    class DesignController extends AbstractController {

        /**
         * @Route(".html", name="index", methods={"GET", "POST"})
         */
        public function index(AWSS3Service $AWSS3Service, Request $request, SettingService $settingService){
            $config = new SettingSystemDesign();
            $form = $this->createForm(EditForm::class, $config);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                if($config->getIconFile()){
                    $AWSS3Service->deleteObject("system", "icon.png");
                    $AWSS3Service->putObject("system", "icon.png", $config->getIconFile()->getContent());
                    $settingService->setSetting('system.design.icon', "icon.png");
                }

                if($config->getLogoFile()){
                    $AWSS3Service->deleteObject("system", "logo.png");
                    $AWSS3Service->putObject("system", "logo.png", $config->getLogoFile()->getContent());
                    $settingService->setSetting('system.design.logo', "logo.png");
                }

                return $this->redirectToRoute("adminoffice.system.design.index");
            }

            return $this->render("AdminOffice/System/Design/index.html.twig", [
                'form'  => $form->createView()
            ]);
        }

        /**
         * @Route("delete/icon.html", name="delete.icon", methods={"GET"})
         */
        public function deleteIcon(AWSS3Service $AWSS3Service, SettingService $settingService){
            $AWSS3Service->deleteObject('system', 'icon.png');
            $settingService->setSetting('system.design.icon', null);

            return $this->redirectToRoute("adminoffice.system.design.index");
        }

        /**
         * @Route("delete/logo.html", name="delete.logo", methods={"GET"})
         */
        public function deleteLogo(AWSS3Service $AWSS3Service, SettingService $settingService){
            $AWSS3Service->deleteObject('system', 'logo.png');
            $settingService->setSetting('system.design.logo', null);

            return $this->redirectToRoute("adminoffice.system.design.index");
        }

    }