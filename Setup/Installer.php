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
     * @var \MagentoEse\B2bCmsSampleData\Model\Page
     */
    private $page;

    /**
     * @var \MagentoEse\B2bCmsSampleData\Model\Block
     */
    private $block;

    /**
     * @param \MagentoEse\B2bCmsSampleData\Model\Page $page
     * @param \MagentoEse\B2bCmsSampleData\Model\Block $block
     */
    public function __construct(
        \MagentoEse\B2bCmsSampleData\Model\Page $page,
        \MagentoEse\B2bCmsSampleData\Model\Block $block
    ) {
        $this->page = $page;
        $this->block = $block;
    }

    /**
     * {@inheritdoc}
     */
    public function install()
    {
        $this->page->install(['MagentoEse_B2bCmsSampleData::fixtures/pages/pages.csv']);
        $this->block->install(
            [
                'MagentoEse_B2bCmsSampleData::fixtures/blocks/pages_static_blocks.csv',
            ]
        );
    }
}
