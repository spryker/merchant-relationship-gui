<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationshipGui\Communication;

use Generated\Shared\Transfer\MerchantRelationshipTransfer;
use Orm\Zed\MerchantRelationship\Persistence\SpyMerchantRelationshipQuery;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\MerchantRelationshipGui\Communication\Form\DataProvider\MerchantRelationshipFormDataProvider;
use Spryker\Zed\MerchantRelationshipGui\Communication\Form\DeleteMerchantRelationshipForm;
use Spryker\Zed\MerchantRelationshipGui\Communication\Form\MerchantRelationshipCreateForm;
use Spryker\Zed\MerchantRelationshipGui\Communication\Form\MerchantRelationshipEditForm;
use Spryker\Zed\MerchantRelationshipGui\Communication\Table\MerchantRelationshipTable;
use Spryker\Zed\MerchantRelationshipGui\Dependency\Facade\MerchantRelationshipGuiToCompanyBusinessUnitFacadeInterface;
use Spryker\Zed\MerchantRelationshipGui\Dependency\Facade\MerchantRelationshipGuiToCompanyFacadeInterface;
use Spryker\Zed\MerchantRelationshipGui\Dependency\Facade\MerchantRelationshipGuiToMerchantFacadeInterface;
use Spryker\Zed\MerchantRelationshipGui\Dependency\Facade\MerchantRelationshipGuiToMerchantRelationshipFacadeInterface;
use Spryker\Zed\MerchantRelationshipGui\MerchantRelationshipGuiDependencyProvider;
use Symfony\Component\Form\FormInterface;

class MerchantRelationshipGuiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @param \Generated\Shared\Transfer\MerchantRelationshipTransfer|null $data
     * @param array<string, mixed> $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getMerchantRelationshipCreateForm(?MerchantRelationshipTransfer $data = null, array $options = []): FormInterface
    {
        return $this->getFormFactory()->create(MerchantRelationshipCreateForm::class, $data, $options);
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantRelationshipTransfer|null $data
     * @param array<string, mixed> $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getMerchantRelationshipEditForm(?MerchantRelationshipTransfer $data = null, array $options = []): FormInterface
    {
        return $this->getFormFactory()->create(MerchantRelationshipEditForm::class, $data, $options);
    }

    /**
     * @return \Spryker\Zed\MerchantRelationshipGui\Communication\Form\DataProvider\MerchantRelationshipFormDataProvider
     */
    public function createMerchantRelationshipFormDataProvider(): MerchantRelationshipFormDataProvider
    {
        return new MerchantRelationshipFormDataProvider(
            $this->getMerchantRelationshipFacade(),
            $this->getMerchantFacade(),
            $this->getCompanyBusinessUnitFacade(),
            $this->getCompanyFacade(),
        );
    }

    /**
     * @param int|null $idCompany
     *
     * @return \Spryker\Zed\MerchantRelationshipGui\Communication\Table\MerchantRelationshipTable
     */
    public function createMerchantRelationshipTable(?int $idCompany = null): MerchantRelationshipTable
    {
        return new MerchantRelationshipTable($this->getPropelMerchantRelationshipQuery(), $idCompany);
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createDeleteMerchantRelationshipForm(): FormInterface
    {
        return $this->getFormFactory()->create(DeleteMerchantRelationshipForm::class, [], [
            'fields' => [],
        ]);
    }

    /**
     * @return \Spryker\Zed\MerchantRelationshipGui\Dependency\Facade\MerchantRelationshipGuiToCompanyFacadeInterface
     */
    public function getCompanyFacade(): MerchantRelationshipGuiToCompanyFacadeInterface
    {
        return $this->getProvidedDependency(MerchantRelationshipGuiDependencyProvider::FACADE_COMPANY);
    }

    /**
     * @return \Spryker\Zed\MerchantRelationshipGui\Dependency\Facade\MerchantRelationshipGuiToCompanyBusinessUnitFacadeInterface
     */
    public function getCompanyBusinessUnitFacade(): MerchantRelationshipGuiToCompanyBusinessUnitFacadeInterface
    {
        return $this->getProvidedDependency(MerchantRelationshipGuiDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT);
    }

    /**
     * @return \Spryker\Zed\MerchantRelationshipGui\Dependency\Facade\MerchantRelationshipGuiToMerchantFacadeInterface
     */
    public function getMerchantFacade(): MerchantRelationshipGuiToMerchantFacadeInterface
    {
        return $this->getProvidedDependency(MerchantRelationshipGuiDependencyProvider::FACADE_MERCHANT);
    }

    /**
     * @return \Spryker\Zed\MerchantRelationshipGui\Dependency\Facade\MerchantRelationshipGuiToMerchantRelationshipFacadeInterface
     */
    public function getMerchantRelationshipFacade(): MerchantRelationshipGuiToMerchantRelationshipFacadeInterface
    {
        return $this->getProvidedDependency(MerchantRelationshipGuiDependencyProvider::FACADE_MERCHANT_RELATIONSHIP);
    }

    /**
     * @return \Orm\Zed\MerchantRelationship\Persistence\SpyMerchantRelationshipQuery
     */
    public function getPropelMerchantRelationshipQuery(): SpyMerchantRelationshipQuery
    {
        return $this->getProvidedDependency(MerchantRelationshipGuiDependencyProvider::PROPEL_MERCHANT_RELATIONSHIP_QUERY);
    }

    /**
     * @return array<\Spryker\Zed\MerchantRelationshipGuiExtension\Dependency\Plugin\MerchantRelationshipCreateFormExpanderPluginInterface>
     */
    public function getMerchantRelationshipCreateFormExpanderPlugins(): array
    {
        return $this->getProvidedDependency(MerchantRelationshipGuiDependencyProvider::PLUGINS_MERCHANT_RELATIONSHIP_CREATE_FORM_EXPANDER);
    }

    /**
     * @return array<\Spryker\Zed\MerchantRelationshipGuiExtension\Dependency\Plugin\MerchantRelationshipEditFormExpanderPluginInterface>
     */
    public function getMerchantRelationshipEditFormExpanderPlugins(): array
    {
        return $this->getProvidedDependency(MerchantRelationshipGuiDependencyProvider::PLUGINS_MERCHANT_RELATIONSHIP_EDIT_FORM_EXPANDER);
    }
}
