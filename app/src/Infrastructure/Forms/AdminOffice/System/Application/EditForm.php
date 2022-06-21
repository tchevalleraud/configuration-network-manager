<?php
    namespace App\Infrastructure\Forms\AdminOffice\System\Application;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Vich\UploaderBundle\Form\Type\VichImageType;

    class EditForm extends AbstractType {

        public function buildForm(FormBuilderInterface $builder, array $options) {
            parent::buildForm($builder, $options);

            $builder
                ->add("system_app_name", TextType::class, [
                    'label'     => 'form.name',
                    'required'  => false
                ])
                ->add('submit', SubmitType::class);
        }

    }