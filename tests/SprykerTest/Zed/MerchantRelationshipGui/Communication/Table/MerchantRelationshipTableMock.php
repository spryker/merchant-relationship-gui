<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\MerchantRelationshipGui\Communication\Table;

use Spryker\Zed\MerchantRelationshipGui\Communication\Table\MerchantRelationshipTable;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

class MerchantRelationshipTableMock extends MerchantRelationshipTable
{
    /**
     * @return $this
     */
    protected function init()
    {
        $this->request = new Request();
        $config = $this->newTableConfiguration();
        $config->setPageLength($this->getLimit());
        $config = $this->configure($config);
        $this->setConfiguration($config);

        return $this;
    }

    /**
     * @return array
     */
    public function fetchData(): array
    {
        return $this->init()->prepareData($this->config);
    }

    /**
     * @param \Twig\Environment $twig
     *
     * @return void
     */
    public function setTwig(Environment $twig): void
    {
        $this->twig = $twig;
    }
}
