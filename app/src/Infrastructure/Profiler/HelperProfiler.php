<?php
    namespace App\Infrastructure\Profiler;

    use Symfony\Bundle\FrameworkBundle\DataCollector\AbstractDataCollector;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;

    class HelperProfiler extends AbstractDataCollector {

        private Request $request;
        private Response $response;

        public function collect(Request $request, Response $response, \Throwable $exception = null) {
            $this->request = $request;
            $this->response = $response;
        }

        public static function getTemplate(): ?string {
            return '_profiler/Helper/template.html.twig';
        }

    }