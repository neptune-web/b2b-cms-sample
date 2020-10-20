<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MagentoEse\B2bCmsSampleData\Model;

use Magento\CustomerSegment\Model\SegmentFactory;
use Magento\Framework\File\Csv;
use Magento\Framework\Setup\SampleData\Context as SampleDataContext;
use Magento\Framework\Setup\SampleData\FixtureManager;
use MagentoEse\DataInstall\Model\Converter;
use Magento\CustomerSegment\Model\ResourceModel\Segment as ResourceModel;
use Magento\CustomerSegment\Model\ResourceModel\Segment\CollectionFactory as SegmentCollection;

/**
 * Class Segment
 */
class Segment
{
    /** @var Converter */
    protected $converter;

    /**
     * @var Csv
     */
    protected $csvReader;

    /**
     * @var FixtureManager
     */
    protected $fixtureManager;

    /**
     * @var SegmentFactory
     */
    protected $segment;

    /** @var ResourceModel */
    protected $resourceModel;

    /** @var SegmentCollection */
    protected $segmentCollection;

    /**
     * Segment constructor.
     * @param SampleDataContext $sampleDataContext
     * @param SegmentFactory $segment
     * @param Converter $converter
     * @param ResourceModel $resourceModel
     * @param SegmentCollection $segmentCollection
     */
    public function __construct(
        SampleDataContext $sampleDataContext,
        SegmentFactory $segment,
        Converter $converter,
        ResourceModel $resourceModel,
        SegmentCollection $segmentCollection
    ) {
        $this->fixtureManager = $sampleDataContext->getFixtureManager();
        $this->csvReader = $sampleDataContext->getCsvReader();
        $this->segment = $segment;
        $this->converter = $converter;
        $this->resourceModel = $resourceModel;
        $this->segmentCollection = $segmentCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function install(array $fixtures)
    {
        foreach ($fixtures as $fileName) {
            $fileName = $this->fixtureManager->getFixture($fileName);
            if (!file_exists($fileName)) {
                throw new Exception('File not found: '.$fileName);
            }

            $rows = $this->csvReader->getData($fileName);
            $header = array_shift($rows);

            foreach ($rows as $row) {
                $data = [];
                foreach ($row as $key => $value) {
                    $data[$header[$key]] = $value;
                }
                $row = $data;

                $segment = $this->segment->create();

                $existingSegment = $this->segmentCollection->create()->
                addFieldToSelect('name')->addFieldToSelect('segment_id')
                ->addFieldToFilter('name',array('eq' => $row['name']))->getFirstItem();
                if($existingSegment){
                    $segment->load($existingSegment->getId());
                }
                $segment->addData(['website_ids'=>[1]]);
                $segment->setName($row['name']);
                $segment->setConditionsSerialized($this->converter->convertContent($row['conditions']));
                $cond = $this->converter->convertContent($row['conditions']);
                $segment->setConditionSql($this->converter->convertContent($row['sql']));
                $segment->setIsActive(1);
                $segment->addData(['apply_to'=>$data['apply_to']]);
                $this->resourceModel->save($segment);
            }
        }

    }
}
