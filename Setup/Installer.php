<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MagentoEse\B2bCmsSampleData\Setup;

use Magento\Framework\Setup;

class Installer implements Setup\SampleData\InstallerInterface
{
    /**
     * @var \Magento\CatalogSampleData\Model\Category
     */
    private $category;

    /**
     * @var \Magento\CmsSampleData\Model\Page
     */
    private $page;

    /**
     * @var \Magento\CmsSampleData\Model\Block
     */
    private $block;

    /**
     * @param \MagentoEse\CatalogSampleData\Model\Category $category
     * @param \MagentoEse\CmsSampleData\Model\Page $page
     * @param \MagentoEse\CmsSampleData\Model\Block $block
     */
    public function __construct(
        //\MagentoEse\CatalogSampleData\Model\Category $category,
        \MagentoEse\B2bCmsSampleData\Model\Page $page,
        \MagentoEse\B2bCmsSampleData\Model\Block $block
    ) {
        //$this->category = $category;
        $this->page = $page;
        $this->block = $block;
    }

    /**
     * {@inheritdoc}
     */
    public function install()
    {
        //$this->category->install(['MagentoEse_B2bCmsSampleData::fixtures/categories.csv']);
        $this->page->install(['MagentoEse_B2bCmsSampleData::fixtures/pages/pages.csv']);
        $this->block->install(
            [
                'MagentoEse_B2bCmsSampleData::fixtures/blocks/pages_static_blocks.csv',
            ]
        );
    }
}
