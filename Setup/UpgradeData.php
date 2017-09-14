<?php
/**
 * Copyright © 2017 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MagentoEse\B2bCmsSampleData\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class UpgradeData implements UpgradeDataInterface
{
    private $block;

    /**
     * @param \MagentoEse\CmsSampleData\Model\Block $block
     */
    public function __construct(
        \MagentoEse\B2bCmsSampleData\Model\Block $block
    ) {
        $this->block = $block;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '0.0.2') < 0
        ) {
          $this->block->install(['MagentoEse_B2bCmsSampleData::fixtures/blocks/b2c_nonlog_home_blocks.csv']);
        }
        $setup->endSetup();
    }
}
