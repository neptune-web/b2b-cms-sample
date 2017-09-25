<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MagentoEse\B2bCmsSampleData\Model;

use Magento\Framework\Setup\SampleData\Context as SampleDataContext;

/**
 * Class Segment
 */
class Segment
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
     * @var \Magento\CustomerSegment\Model\Segment
     */
    protected $segment;

    /**
     * @param SampleDataContext $sampleDataContext
     * @param Segment $segment
     */
    public function __construct(
        SampleDataContext $sampleDataContext,
        \Magento\CustomerSegment\Model\Segment $segment,
    ) {
        $this->fixtureManager = $sampleDataContext->getFixtureManager();
        $this->csvReader = $sampleDataContext->getCsvReader();
        $this->segment = $segment
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

                $row['name'] = $this->segment->getName();
                $row['conditions'] = $this->segment->getConditionsSerialized();
                $row['sql'] = $this->segment->getConditionSql();
                $segment = $this->segment->create();
                $segment->loadPost($row);
                $segment->save();
            }
        }
    }
}
