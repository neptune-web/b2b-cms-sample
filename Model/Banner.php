<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MagentoEse\B2bCmsSampleData\Model;

use Magento\Framework\Setup\SampleData\Context as SampleDataContext;

/**
 * Class Banner
 */
class Banner
{
    /**
     * @var \Magento\Framework\File\Csv
     */
    protected $csvReader;

    /**
     * @var \Magento\Framework\Setup\SampleData\FixtureManager
     */
    protected $fixtureManager;

    /**
     * @var \Magento\Banner\Model\Banner
     */
    protected $banner;

    /**
     * @param SampleDataContext $sampleDataContext
     * @param Banner $banner
     */
    public function __construct(
        SampleDataContext $sampleDataContext,
        \Magento\Banner\Model\BannerFactory $banner
    ) {
        $this->fixtureManager = $sampleDataContext->getFixtureManager();
        $this->csvReader = $sampleDataContext->getCsvReader();
        $this->banner = $banner;
      }

    /**
     * {@inheritdoc}
     */
    public function install(array $fixtures)
    {
        foreach ($fixtures as $fileName) {
            $fileName = $this->fixtureManager->getFixture($fileName);
            if (!file_exists($fileName)) {
                continue;
            }

            $rows = $this->csvReader->getData($fileName);
            $header = array_shift($rows);

            foreach ($rows as $row) {
                $data = [];
                foreach ($row as $key => $value) {
                    $data[$header[$key]] = $value;
                }
                $row = $data;

                $banner = $this->banner->create();
                $banner->setName($row['name']);
                $banner->setIsEnabled(1);
                $banner->setTypes('content');
                $banner->setStoreContents(array($row['store_id'],$row['banner_content']));
                $banner->save();
            }
        }
    }
}
