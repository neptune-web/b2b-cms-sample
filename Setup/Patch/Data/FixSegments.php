<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagentoEse\B2bCmsSampleData\Setup\Patch\Data;

use Magento\Framework\App\State;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use MagentoEse\B2bCmsSampleData\Model\Segment;


class FixSegments implements DataPatchInterface
{

    /** @var Segment  */
    protected $segment;

    /** @var  */
    protected $state;

    /**
     * FixSegments constructor.
     * @param State $state
     * @param Segment $segment
     */
    public function __construct(
        State $state,
        Segment $segment

    ) {
        $this->segment = $segment;
        try{
            $state->setAreaCode('adminhtml');
        }
        catch(LocalizedException $e){
            // left empty
        }
    }

    public function apply()
    {
        //update segments
        $this->segment->install(['MagentoEse_B2bCmsSampleData::fixtures/segments.csv']);
    }

    public static function getDependencies()
    {
        return [InstallData::class,UpgradeData::class];
    }

    public function getAliases()
    {
        return [];
    }

}
