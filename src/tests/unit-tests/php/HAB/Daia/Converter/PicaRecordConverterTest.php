<?php

namespace HAB\Daia\Converter;

class PicaRecordConverterTest extends \PHPUnit_Framework_TestCase
{

    protected $converter;

    public function SetUp ()
    {
        $this->converter = new PicaRecordConverter();
        $this->reader    = new \HAB\Pica\Reader\PicaXmlReader();
    }

    public function testConvert ()
    {
        $daia     = new \HAB\Daia\Daia();
        $document = new \HAB\Daia\Document('718691423');
        $record   = $this->loadRecord('718691423')->getLocalRecordByILN(50);
        $items    = $this->converter->convert($record);
        array_map(array($document, 'addItem'), $items);
        $daia->addDocument($document);
        print_r($daia->toXml());
    }

    protected function loadRecord ($ppn)
    {
        $this->reader->open(
            file_get_contents(APP_DATADIR . "/records/{$ppn}.xml")
        );
        $record = $this->reader->read();
        $this->reader->close();
        return $record;
    }

}
