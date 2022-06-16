<?php
    namespace App\Application\Twig;

    use Twig\Extension\AbstractExtension;
    use Twig\TwigFilter;

    class TwigUpperExtension extends AbstractExtension {

        public function getFilters(){
            return [
                new TwigFilter('upperword', [$this, 'upperWord'])
            ];
        }

        public function upperWord(string $data){
            $words = explode(" ", $data);
            foreach ($words as $k => $word){
                $words[$k] = ucfirst($word);
            }
            return implode(" ", $words);
        }

    }