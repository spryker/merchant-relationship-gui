<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationshipGui\Communication\Form;

use Generated\Shared\Transfer\CompanyBusinessUnitCollectionTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\Zed\Gui\Communication\Form\Type\Select2ComboBoxType;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @method \Spryker\Zed\MerchantRelationshipGui\Communication\MerchantRelationshipGuiCommunicationFactory getFactory()
 */
class MerchantRelationshipCreateForm extends AbstractType
{
    /**
     * @var string
     */
    public const OPTION_SELECTED_COMPANY = 'id_company';

    /**
     * @var string
     */
    public const OPTION_IS_PERSISTENCE_FORM = 'is_persistence_form';

    /**
     * @var string
     */
    public const OPTION_COMPANY_CHOICES = 'company_choices';

    /**
     * @var string
     */
    public const OPTION_MERCHANT_CHOICES = 'merchant_choices';

    /**
     * @var string
     */
    public const OPTION_ASSIGNED_COMPANY_BUSINESS_UNIT_CHOICES = 'assignee_company_business_unit_choices';

    /**
     * @var string
     */
    protected const FIELD_FK_COMPANY = 'fk_company';

    /**
     * @var string
     */
    protected const FIELD_FK_MERCHANT = 'fk_merchant';

    /**
     * @var string
     */
    protected const FIELD_FK_COMPANY_BUSINESS_UNIT = 'fk_company_business_unit';

    /**
     * @var string
     */
    protected const FIELD_ASSIGNED_COMPANY_BUSINESS_UNIT = 'assigneeCompanyBusinessUnits';

    /**
     * @var string
     */
    protected const COMPANY_FIELD_LABEL = 'Company';

    /**
     * @var string
     */
    protected const COMPANY_FIELD_PLACEHOLDER = 'Select Company';

    /**
     * @var string
     */
    protected const MERCHANT_FIELD_LABEL = 'Merchant';

    /**
     * @var string
     */
    protected const MERCHANT_FIELD_PLACEHOLDER = 'Select merchant';

    /**
     * @var string
     */
    protected const FK_COMPANY_BUSINESS_UNIT_FIELD_LABEL = 'Business Unit Owner';

    /**
     * @var string
     */
    protected const FK_COMPANY_BUSINESS_UNIT_FIELD_PLACEHOLDER = 'Select Business Unit';

    /**
     * @var string
     */
    protected const ASSIGNED_COMPANY_BUSINESS_UNIT_FIELD_LABEL = 'Assigned Business Units';

    /**
     * @var string
     */
    protected const ASSIGNED_COMPANY_BUSINESS_UNIT_FIELD_PLACEHOLDER = 'Select Business Units';

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'merchant-relationship';
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(static::OPTION_COMPANY_CHOICES);
        $resolver->setRequired(static::OPTION_SELECTED_COMPANY);
        $resolver->setRequired(static::OPTION_MERCHANT_CHOICES);
        $resolver->setRequired(static::OPTION_ASSIGNED_COMPANY_BUSINESS_UNIT_CHOICES);
        $resolver->setRequired(static::OPTION_IS_PERSISTENCE_FORM);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this
            ->addMerchantField($builder, $options[static::OPTION_MERCHANT_CHOICES])
            ->addCompanyField($builder, $options);

        if ($options[static::OPTION_SELECTED_COMPANY]) {
            $this
                ->addOwnerCompanyBusinessUnitField($builder, $options)
                ->addAssignedCompanyBusinessUnitField($builder, $options[static::OPTION_ASSIGNED_COMPANY_BUSINESS_UNIT_CHOICES]);
        }

        $this->executeMerchantRelationshipCreateFormExpanderPlugins($builder, $options);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return void
     */
    protected function executeMerchantRelationshipCreateFormExpanderPlugins(FormBuilderInterface $builder, array $options): void
    {
        $merchantRelationshipCreateFormExpanderPlugins = $this->getFactory()
            ->getMerchantRelationshipCreateFormExpanderPlugins();

        foreach ($merchantRelationshipCreateFormExpanderPlugins as $merchantRelationshipCreateFormExpanderPlugin) {
            $builder = $merchantRelationshipCreateFormExpanderPlugin->expand($builder, $options);
        }
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return $this
     */
    protected function addCompanyField(FormBuilderInterface $builder, array $options)
    {
        $builder->add(static::FIELD_FK_COMPANY, Select2ComboBoxType::class, [
            'label' => static::COMPANY_FIELD_LABEL,
            'placeholder' => static::COMPANY_FIELD_PLACEHOLDER,
            'choices' => array_flip($options[static::OPTION_COMPANY_CHOICES]),
            'mapped' => false,
            'data' => $options[static::OPTION_SELECTED_COMPANY],
            'constraints' => [
                new NotBlank(),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $choices
     *
     * @return $this
     */
    protected function addMerchantField(FormBuilderInterface $builder, array $choices)
    {
        $builder->add(static::FIELD_FK_MERCHANT, Select2ComboBoxType::class, [
            'label' => static::MERCHANT_FIELD_LABEL,
            'placeholder' => static::MERCHANT_FIELD_PLACEHOLDER,
            'choices' => array_flip($choices),
            'constraints' => [
                new NotBlank(),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return $this
     */
    protected function addOwnerCompanyBusinessUnitField(FormBuilderInterface $builder, array $options)
    {
        $constraints = [];
        if ($options[static::OPTION_IS_PERSISTENCE_FORM]) {
            $constraints = [new NotBlank()];
        }

        $builder->add(static::FIELD_FK_COMPANY_BUSINESS_UNIT, Select2ComboBoxType::class, [
            'label' => static::FK_COMPANY_BUSINESS_UNIT_FIELD_LABEL,
            'placeholder' => static::FK_COMPANY_BUSINESS_UNIT_FIELD_PLACEHOLDER,
            'choices' => array_flip($options[static::OPTION_ASSIGNED_COMPANY_BUSINESS_UNIT_CHOICES]),
            'required' => $options[static::OPTION_IS_PERSISTENCE_FORM],
            'constraints' => $constraints,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $choices
     *
     * @return $this
     */
    protected function addAssignedCompanyBusinessUnitField(FormBuilderInterface $builder, array $choices)
    {
        $builder->add(static::FIELD_ASSIGNED_COMPANY_BUSINESS_UNIT, Select2ComboBoxType::class, [
            'label' => static::ASSIGNED_COMPANY_BUSINESS_UNIT_FIELD_LABEL,
            'placeholder' => static::ASSIGNED_COMPANY_BUSINESS_UNIT_FIELD_PLACEHOLDER,
            'choices' => array_flip($choices),
            'required' => false,
            'multiple' => 'true',
        ]);

        $this->addModelTransformer($builder);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return void
     */
    protected function addModelTransformer(FormBuilderInterface $builder): void
    {
        $builder->get(static::FIELD_ASSIGNED_COMPANY_BUSINESS_UNIT)->addModelTransformer(
            new CallbackTransformer(
                $this->getAssignedBusinessUnitTransformer(),
                $this->getAssignedBusinessUnitReverseTransformer(),
            ),
        );
    }

    /**
     * @return callable
     */
    protected function getAssignedBusinessUnitTransformer(): callable
    {
        return function ($businessUnitCollection): array {
            if (!$businessUnitCollection) {
                return [];
            }
            $businessUnits = $businessUnitCollection->getCompanyBusinessUnits();
            if (!$businessUnits) {
                return [];
            }
            $result = [];
            foreach ($businessUnits as $businessUnit) {
                $result[] = $businessUnit->getIdCompanyBusinessUnit();
            }

            return $result;
        };
    }

    /**
     * @return callable
     */
    private function getAssignedBusinessUnitReverseTransformer(): callable
    {
        return function ($data): CompanyBusinessUnitCollectionTransfer {
            $companyBusinessUnitCollectionTransfer = new CompanyBusinessUnitCollectionTransfer();
            foreach ($data as $id) {
                $companyBusinessUnitCollectionTransfer->addCompanyBusinessUnit(
                    (new CompanyBusinessUnitTransfer())
                        ->setIdCompanyBusinessUnit($id),
                );
            }

            return $companyBusinessUnitCollectionTransfer;
        };
    }
}
