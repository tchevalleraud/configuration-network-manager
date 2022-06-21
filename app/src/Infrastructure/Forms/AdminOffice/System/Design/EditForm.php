<?php
    namespace App\Infrastructure\Forms\AdminOffice\System\Design;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Vich\UploaderBundle\Form\Type\VichImageType;

    class EditForm extends AbstractType {

        public function buildForm(FormBuilderInterface $builder, array $options) {
            parent::buildForm($builder, $options);

            $builder
                ->add('iconFile', VichImageType::class, [
                    'allow_delete'      => true,
                    'asset_helper'      => true,
                    'delete_label'      => 'delete',
                    'download_label'    => 'down',
                    'label'             => 'form.icon',
                    'required'          => false,
                ])
                ->add('logoFile', VichImageType::class, [
                    'allow_delete'      => true,
                    'asset_helper'      => true,
                    'delete_label'      => 'delete',
                    'download_label'    => 'down',
                    'label'             => 'form.logo',
                    'required'          => false,
                ])
                ->add('submit', SubmitType::class);
        }

    }