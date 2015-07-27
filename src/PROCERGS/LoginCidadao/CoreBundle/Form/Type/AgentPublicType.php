<?php

namespace PROCERGS\LoginCidadao\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgentPublicType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('fileOfficialDiary', 'vich_file',
			array(
				'required' => false,
				'allow_delete' => true,
				'label' => 'form.fileOfficialDiary',
				'translation_domain' => 'FOSUserBundle'
			)
		);
		$builder->add('fileOcupation', 'vich_file',
			array(
				'required' => false,
				'allow_delete' => true,
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
		$builder->add('dateNomination', 'text',
			array(
				'required' => false,
                'label' => 'form.dateNomination',
				'translation_domain' => 'FOSUserBundle',
                'attr' => array('pattern' => '[0-9/]*', 'class' => 'form-control dateNomination')
			)
		);
		$builder->add('dateStartRole', 'text',
			array(
				'required' => false,
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
