<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagentoEse\B2bCmsSampleData\Setup\Patch\Data;


use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use MagentoEse\B2bCmsSampleData\Model\Block;
use MagentoEse\B2bCmsSampleData\Model\Page;


class InstallData implements DataPatchInterface, PatchVersionInterface
{


    /**
     * @var Page
     */
    private $page;

    /**
     * @var Block
     */
    private $block;

    /**
     * @param Page $page
     * @param Block $block
     */
    public function __construct(
        Page $page,
        Block $block
    ) {
        $this->page = $page;
        $this->block = $block;
    }

    /**
     * {@inheritdoc}
     */

    public function apply()
    {
        $this->page->install(['MagentoEse_B2bCmsSampleData::fixtures/pages/pages.csv']);
        $this->block->install(
            [
                'MagentoEse_B2bCmsSampleData::fixtures/blocks/pages_static_blocks.csv',
            ]
        );
    }

    public static function getDependencies()
    {
        return [];
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
