<?php
    namespace App\Infrastructure\Forms\FrontOffice\Project;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Vich\UploaderBundle\Form\Type\VichFileType;

    class NewForm extends AbstractType {

        public function buildForm(FormBuilderInterface $builder, array $options) {
            parent::buildForm($builder, $options);

            $builder
                ->add('name', TextType::class, [
                    'label'     => 'form.name',
                    'required'  => true
                ])
                ->add('description', TextareaType::class, [
                    'label'     => 'form.description',
                    'required'  => false
                ])
                ->add('sourceModel', ChoiceType::class, [
                    'choices'   => [
                        'ERS 4500'  => 'extreme-ers-4500'
                    ],
                    'group_by'  => function($choice, $key, $value){
                        if(str_contains($value, "extreme")) return "Extreme Networks";
                        if(str_contains($value, "juniper")) return "Juniper";
                        return "Unknown";
                    },
                    'label'     => 'form.sourceModel',
                    'required'  => false
                ])
                ->add('sourceConfigFile', VichFileType::class, [
                    'label'     => 'form.sourceConfigFile',
                    'required'  => false
                ])
                ->add('destinationModel', ChoiceType::class, [
                    'choices'   => [
                        'ERS 4500'  => 'extreme-ers-4500',
                        '5420'      => 'extreme-xos-5420'
                    ],
                    'group_by'  => function($choice, $key, $value){
                        if(str_contains($value, "extreme") && str_contains($value, "-xos")) return "Extreme Networks - XOS";
                        if(str_contains($value, "extreme") && str_contains($value, "-voss")) return "Extreme Networks - VOSS";
                        if(str_contains($value, "extreme")) return "Extreme Networks";
                        if(str_contains($value, "juniper")) return "Juniper";
                        return "Unknown";
                    },
                    'label'     => 'form.sourceModel',
                    'required'  => false
                ])
                ->add('submitAndNew', SubmitType::class)
                ->add('submit', SubmitType::class);
        }

    }