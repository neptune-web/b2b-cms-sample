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
     * Setup class for css
     *
     * @var \Magento\ThemeSampleData\Model\Css
     */
    private $css;

    /**
     * @var \Magento\CmsSampleData\Model\Page
     */
    private $page;

    /**
     * @var \Magento\CmsSampleData\Model\Block
     */
    private $block;

    /**
     * @param \Magento\CatalogSampleData\Model\Category $category
     * @param \Magento\ThemeSampleData\Model\Css $css
     * @param \Magento\CmsSampleData\Model\Page $page
     * @param \Magento\CmsSampleData\Model\Block $block
     */
    public function __construct(
        \Magento\CatalogSampleData\Model\Category $category,
        \Magento\ThemeSampleData\Model\Css $css,
        \Magento\CmsSampleData\Model\Page $page,
        \Magento\CmsSampleData\Model\Block $block
    ) {
        $this->category = $category;
        $this->css = $css;
        $this->page = $page;
        $this->block = $block;
    }

    /**
     * {@inheritdoc}
     */
    public function install()
    {
        $this->category->install(['MagentoEse_B2bCmsSampleData::fixtures/categories.csv']);
        $this->css->install(['MagentoEse_B2bCmsSampleData::fixtures/styles.css' => 'styles.css']);
        $this->page->install(['MagentoEse_B2bCmsSampleData::fixtures/pages/pages.csv']);
        $this->block->install(
            [
                'MagentoEse_B2bCmsSampleData::fixtures/blocks/categories_static_blocks.csv',
                'MagentoEse_B2bCmsSampleData::fixtures/blocks/categories_static_blocks_giftcard.csv',
                'MagentoEse_B2bCmsSampleData::fixtures/blocks/pages_static_blocks.csv',
            ]
        );
    }
}
