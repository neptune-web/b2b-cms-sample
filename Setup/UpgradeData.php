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
    private $segment;

    /**
     * App State
     *
     * @var \Magento\Framework\App\State
     */
    protected $state;

    /**
     * @param \MagentoEse\B2bCmsSampleData\Model\Block $block
     * @param \MagentoEse\B2bCmsSampleData\Model\Segment $segment
     */
    public function __construct(
        \Magento\Framework\App\State $state,
        \MagentoEse\B2bCmsSampleData\Model\Block $block,
        \MagentoEse\B2bCmsSampleData\Model\Segment $segment
    ) {
        $this->block = $block;
        $this->segment = $segment;
        try{
            $state->setAreaCode('adminhtml');
        }
        catch(\Magento\Framework\Exception\LocalizedException $e){
            // left empty
        }
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '0.0.2') < 0
        ) {
          $this->block->install(['MagentoEse_B2bCmsSampleData::fixtures/blocks/b2c_nonlog_home_blocks.csv']);
        }
        if (version_compare($context->getVersion(), '0.0.3') < 0
        ) {
          $this->segment->install(['MagentoEse_B2bCmsSampleData::fixtures/segments.csv']);
        }
        $setup->endSetup();
    }
}
