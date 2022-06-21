<?php
    namespace App\UI\FrontOffice;

    use App\Application\Services\AWSS3Service;
    use App\Domain\Mysql\Project\Entity\Project;
    use App\Domain\Mysql\Project\Repository\ProjectRepository;
    use App\Infrastructure\Forms\FrontOffice\Project\EditForm;
    use App\Infrastructure\Forms\FrontOffice\Project\NewForm;
    use Doctrine\Persistence\ManagerRegistry;
    use OpenNetworkTools\OpenConfig;
    use OpenNetworkTools\OpenManufacturer;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

    /**
     * @Route("dashboard", name="dashboard.")
     */
    class DashboardController extends AbstractController {

        /**
         * @Route(".html", name="index", methods={"GET"})
         */
        public function index(ProjectRepository $projectRepository){
            return $this->render("FrontOffice/Dashboard/index.html.twig", [
                'projects'  => $projectRepository->findAll()
            ]);
        }

        /**
         * @Route("/new-project.html", name="new", methods={"GET", "POST"})
         */
        public function new(AWSS3Service $AWSS3Service, ManagerRegistry $doctrine, Request $request){
            $project = new Project();

            $form = $this->createForm(NewForm::class, $project);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $entityManager = $doctrine->getManager();
                $project->setSourceConfig($AWSS3Service->putObjectUpload("upload", $project->getSourceConfigFile()));
                $entityManager->persist($project);
                $entityManager->flush($project);

                if(array_key_exists("submitAndNew", $request->request->getIterator()->getArrayCopy()['new_form']))
                    return $this->redirectToRoute('frontoffice.dashboard.new');

                return $this->redirectToRoute('frontoffice.dashboard.index');
            }

            return $this->render("FrontOffice/Dashboard/new.html.twig", [
                'form'  => $form->createView()
            ]);
        }

        /**
         * @Route("/delete-project/{project}.html", name="delete", methods={"GET"})
         */
        public function delete(AWSS3Service $AWSS3Service, ManagerRegistry $doctrine, Project $project, Request $request){
            if($this->isCsrfTokenValid("delete-".$project->getId(), $request->get('_token'))){
                $entityManager = $doctrine->getManager();
                $AWSS3Service->deleteObjectUpload("upload", $project->getSourceConfig());
                $entityManager->remove($project);
                $entityManager->flush();

                return $this->redirectToRoute('frontoffice.dashboard.index');
            }
        }

        /**
         * @Route("/project/{project}.html", name="project", methods={"GET"})
         */
        public function project(Project $project){
            return $this->redirectToRoute('frontoffice.dashboard.project.overview', ['project' => $project->getId()]);
        }

        /**
         * @Route("/project/{project}/overview.html", name="project.overview", methods={"GET"})
         */
        public function projectOverview(UploaderHelper $helper, Project $project){
            $node = $this->getSourceNode($project);
            $node->loadConfigFile($project->getSourceConfig(), true, ['!']);
            $node->analyseConfigFile();

            return $this->render("FrontOffice/Dashboard/project.overview.html.twig", [
                'node'      => $node,
                'project'   => $project
            ]);
        }

        /**
         * @Route("/project/{project}/configuration/source.html", name="project.config.source", methods={"GET"})
         */
        public function projectConfigSource(UploaderHelper $helper, Project $project){
            $node = $this->getSourceNode($project);
            $node->loadConfigFile($project->getSourceConfig(), true, ['!']);
            $node->analyseConfigFile();

            return $this->render("FrontOffice/Dashboard/project.config.source.html.twig", [
                'node'      => $node,
                'project'   => $project
            ]);
        }

        /**
         * @Route("/project/{project}/configuration/destination.html", name="project.config.destination", methods={"GET"})
         */
        public function projectConfigDestination(UploaderHelper $helper, Project $project){
            $nodeSource = $this->getSourceNode($project);
            $nodeSource->loadConfigFile($project->getSourceConfig(), true, ['!']);
            $nodeSource->analyseConfigFile();

            $nodeDestination = $this->getDestinationNode($project, $nodeSource->getConfig());
            $nodeDestination->generateConfig();

            return $this->render("FrontOffice/Dashboard/project.config.destination.html.twig", [
                'node'      => $nodeDestination,
                'project'   => $project
            ]);
        }

        /**
         * @Route("/project/{project}/edit.html", name="project.edit", methods={"GET", "POST"})
         */
        public function projectEdit(AWSS3Service $AWSS3Service, ManagerRegistry $doctrine, Project $project, Request $request){
            $form = $this->createForm(EditForm::class, $project);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                if($project->getSourceConfigFile() !== null){
                    $AWSS3Service->deleteObjectUpload("upload", $project->getSourceConfig());
                    $project->setSourceConfig($AWSS3Service->putObjectUpload("upload", $project->getSourceConfigFile()));
                }

                $entityManager = $doctrine->getManager();
                $entityManager->persist($project);
                $entityManager->flush($project);

                return $this->redirectToRoute('frontoffice.dashboard.project.overview', ['project' => $project->getId()]);
            }

            return $this->render("FrontOffice/Dashboard/project.edit.html.twig", [
                'form'      => $form->createView(),
                'project'   => $project
            ]);
        }

        private function getDestinationNode(Project $project, OpenConfig $openConfig){
            $node = OpenManufacturer::modelInit($project->getDestinationModel());
            $node->setConfig($openConfig);

            return $node;
        }

        private function getSourceNode(Project $project){
            $node = OpenManufacturer::modelInit($project->getSourceModel());
            return $node;
        }

    }