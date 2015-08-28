<?php

namespace PROCERGS\LoginCidadao\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgentPublicType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{

		$builder->add('isAgentPublic', 'checkbox',
			array(
				'required' => false,
				'label' => 'form.isAgentPublic',
				'translation_domain' => 'FOSUserBundle',
				'mapped' => false,
                'attr' => array('class' => 'isAgentPublic')
			)
		);

		$builder->add('fileOfficialDiary', 'vich_file',
			array(
				'required' => false,
				'allow_delete' => true, // not mandatory, default is true
				'download_link' => true, // not mandatory, default is true
				'label' => 'form.fileOfficialDiary',
				'translation_domain' => 'FOSUserBundle'
			)
		);
		$builder->add('fileOcupation', 'vich_file',
			array(
				'required' => false,
				'allow_delete' => true, // not mandatory, default is true
				'download_link' => true, // not mandatory, default is true
				'label' => 'form.fileOcupation',
				'translation_domain' => 'FOSUserBundle'
			)
		);
		$builder->add('registration', 'text',
			array(
				'required' => false,
				'label' => 'form.registration',
				'translation_domain' => 'FOSUserBundle'
			)
		);
		$builder->add('dateNomination', 'date',
			array(
				'required' => false,
                'format' => 'dd/MM/yyyy',
                'widget' => 'single_text',
                'label' => 'form.dateNomination',
				'translation_domain' => 'FOSUserBundle',
                'attr' => array('pattern' => '[0-9/]*', 'class' => 'form-control dateNomination')
			)
		);
		$builder->add('dateStartRole', 'date',
			array(
				'required' => false,
                'format' => 'dd/MM/yyyy',
                'widget' => 'single_text',
                'label' => 'form.dateStartRole',
				'translation_domain' => 'FOSUserBundle',
                'attr' => array('pattern' => '[0-9/]*', 'class' => 'form-control dateStartRole')
			)
		);
	}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PROCERGS\LoginCidadao\CoreBundle\Entity\AgentPublic',
        ));
    }

    public function getName()
    {
        return 'procergs_agentpublic_profile';
    }
}
