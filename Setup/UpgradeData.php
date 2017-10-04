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
    private $banner;

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
        \MagentoEse\B2bCmsSampleData\Model\Segment $segment,
        \MagentoEse\B2bCmsSampleData\Model\Banner $banner,
        \Magento\Cms\Model\PageFactory $pageFactory

    ) {
        $this->block = $block;
        $this->segment = $segment;
        $this->banner = $banner;
        $this->pageFactory = $pageFactory;
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
          //add new homepage blocks
          $this->block->install(['MagentoEse_B2bCmsSampleData::fixtures/blocks/b2c_nonlog_home_blocks.csv']);
        }
        if (version_compare($context->getVersion(), '0.0.3') < 0
        ) {
          //add segments
          $this->segment->install(['MagentoEse_B2bCmsSampleData::fixtures/segments.csv']);

          //add banners
          $this->banner->install(['MagentoEse_B2bCmsSampleData::fixtures/banners.csv']);

          //update homepage with banners
          $this->pageFactory->create()
              ->load('home')
              ->setContent('<p>{{widget type="Magento\Banner\Block\Widget\Banner" display_mode="fixed" types="content" rotate="" banner_ids="1,2,3" template="widget/block.phtml" unique_id="f58b68666f48bd5966fe77080ddaecde"}}</p><p>{{widget type="Magento\CatalogWidget\Block\Product\ProductsList" show_pager="0" products_count="5" template="product/widget/content/grid.phtml" conditions_encoded="^[`1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Combine`,`aggregator`:`all`,`value`:`1`,`new_child`:``^],`1--1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`category_ids`,`operator`:`==`,`value`:`4`^]^]"}}</p>')
              ->save();
        }
        $setup->endSetup();
    }
}
