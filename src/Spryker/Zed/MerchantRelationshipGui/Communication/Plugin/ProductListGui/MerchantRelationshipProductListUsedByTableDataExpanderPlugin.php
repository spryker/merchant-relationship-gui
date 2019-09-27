<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationshipGui\Communication\Plugin\ProductListGui;

use Generated\Shared\Transfer\ProductListUsedByTableDataTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductListGuiExtension\Dependency\Plugin\ProductListUsedByTableDataExpanderPluginInterface;

/**
 * @method \Spryker\Zed\MerchantRelationshipGui\Business\MerchantRelationshipGuiFacadeInterface getFacade()
 * @method \Spryker\Zed\MerchantRelationshipGui\Communication\MerchantRelationshipGuiCommunicationFactory getFactory()
 */
class MerchantRelationshipProductListUsedByTableDataExpanderPlugin extends AbstractPlugin implements ProductListUsedByTableDataExpanderPluginInterface
{
    /**
     * {@inheritdoc}
     * - Expands table data with Merchant Relationships which use Product List.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductListUsedByTableDataTransfer $productListUsedByTableDataTransfer
     *
     * @return \Generated\Shared\Transfer\ProductListUsedByTableDataTransfer
     */
    public function expand(ProductListUsedByTableDataTransfer $productListUsedByTableDataTransfer): ProductListUsedByTableDataTransfer
    {
        return $this->getFactory()
            ->createProductListUsedByTableDataExpander()
            ->expandTableData($productListUsedByTableDataTransfer);
    }
}
