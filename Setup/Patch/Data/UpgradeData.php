<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagentoEse\B2bCmsSampleData\Setup\Patch\Data;


use Magento\Cms\Model\PageFactory;
use Magento\Framework\App\State;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use MagentoEse\B2bCmsSampleData\Model\Banner;
use MagentoEse\B2bCmsSampleData\Model\Block;
use MagentoEse\B2bCmsSampleData\Model\Segment;


class UpgradeData implements DataPatchInterface, PatchVersionInterface
{
    /** @var Block  */
    protected $block;

    /** @var Segment  */
    protected $segment;

    /** @var Banner  */
    protected $banner;

    /** @var PageFactory  */
    protected $pageFactory;

    /** @var  */
    protected $state;

    /**
     * UpgradeData constructor.
     * @param State $state
     * @param Block $block
     * @param Segment $segment
     * @param Banner $banner
     * @param PageFactory $pageFactory
     */
    public function __construct(
        State $state,
        Block $block,
        Segment $segment,
        Banner $banner,
        PageFactory $pageFactory

    ) {
        $this->block = $block;
        $this->segment = $segment;
        $this->banner = $banner;
        $this->pageFactory = $pageFactory;
        try{
            $state->setAreaCode('adminhtml');
        }
        catch(LocalizedException $e){
            // left empty
        }
    }

    public function apply()
    {
        //add blocks
        $this->block->install(['MagentoEse_B2bCmsSampleData::fixtures/blocks/b2c_nonlog_home_blocks.csv']);

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

    public static function getDependencies()
    {
        return [InstallData::class];
    }

    public function getAliases()
    {
        return [];
    }

    public static function getVersion()
    {
       return '0.0.3';
    }
}
