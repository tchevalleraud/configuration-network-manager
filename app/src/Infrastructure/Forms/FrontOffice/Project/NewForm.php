<?php
    namespace App\Infrastructure\Forms\FrontOffice\Project;

    use OpenNetworkTools\OpenManufacturer;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
    use Symfony\Component\Form\Extension\Core\Type\FileType;
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
                    'choices'   => OpenManufacturer::$sourceModel,
                    'group_by'  => function($choice, $key, $value){
                        return OpenManufacturer::modelManufacturer($value);
                    },
                    'label'     => 'form.sourceModel',
                    'required'  => false
                ])
                ->add('sourceConfigFile', FileType::class, [
                    'label'     => 'form.sourceConfigFile',
                    'required'  => true
                ])
                ->add('destinationModel', ChoiceType::class, [
                    'choices'   => OpenManufacturer::$destinationModel,
                    'group_by'  => function($choice, $key, $value){
                        return OpenManufacturer::modelManufacturer($value);
                    },
                    'label'     => 'form.sourceModel',
                    'required'  => false
                ])
                ->add('submitAndNew', SubmitType::class)
                ->add('submit', SubmitType::class);
        }

    }