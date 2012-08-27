<?php

/**
 * The DAIA PicaRecordConverter class file.
 *
 * This file is part of DaiaPHP.
 *
 * DaiaPHP is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DaiaPHP is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DaiaPHP.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright Copyright (c) 2012 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3
 */

namespace HAB\Daia\Converter;

/**
 * A converter that builds a set of {@link \HAB\Daia\Item DAIA items} based on
 * a {@link \HAB\Pica\Record\LocalRecord Pica+ local record}.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright Copyright (c) 2012 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3
 */
class PicaRecordConverter
{

    /**
     * Collection of items indexed by copy record.
     *
     * @var \SplObjectStorage
     */
    protected $itemCollection;

    /**
     * Currently processed local record.
     *
     * @var \HAB\Pica\Record\LocalRecord
     */
    protected $localRecord;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct ()
    {
    }

    /**
     * Convert a local record to a set of DAIA items.
     *
     * @param  \HAB\Pica\Record\LocalRecord $localRecord Local record to convert
     * @return array Set of DAIA items
     */
    public function convert (\HAB\Pica\Record\LocalRecord $localRecord)
    {
        $this->init($localRecord);
        $this->createItemCollection();
        $this->addAvailability();
        return $this->prune();
    }

    /**
     * Initialize converter for a new converting process.
     *
     * @param  \HAB\Pica\Record\LocalRecord $localRecord Local record to convert
     * @return void
     */
    protected function init (\HAB\Pica\Record\LocalRecord $localRecord)
    {
        $this->itemCollection = new \SplObjectStorage();
        $this->localRecord    = $localRecord;
    }

    /**
     * Create initial DAIA item collection.
     *
     * @return void
     */
    protected function createItemCollection ()
    {
        foreach ($this->localRecord->getCopyRecords() as $copyRecord) {
            $items = $this->createItems($copyRecord);
            if (!empty($items)) {
                $this->itemCollection->attach($copyRecord, $items);
            }
        }
    }

    /**
     * Return array of items for a copy record.
     *
     * @param  \HAB\Pica\Record\CopyRecord $copyRecord
     * @return array
     */
    protected function createItems (\HAB\Pica\Record\CopyRecord $copyRecord)
    {
        $item = new \HAB\Daia\Item();
        $sigField = $copyRecord->getFirstMatchingField('209A');
        if ($sigField) {
            list($sig, $loc) = $sigField->getSubfields('a', 'f');
            if ($sig) {
                $item->setLabel(
                    new \HAB\Daia\Label($sig->getValue())
                );
            }
            if ($loc) {
                $storage = new \HAB\Daia\Storage();
                $storage->setContent($loc->getValue());
            }
        }
        $epnField = $copyRecord->getFirstMatchingField('201@');
        if ($epnField) {
            list($epn) = $epnField->getSubfields('e');
            if ($epn) {
                $item->setId($epn->getValue());
            }
        }
        return array($item);
    }

    /**
     * Add availability information to DAIA item collection.
     *
     * @return void
     */
    protected function addAvailability ()
    {
        foreach ($this->itemCollection as $copyRecord) {
            // Get general availability indicator
            $indField = $copyRecord->getFirstMatchingField('209A');
            if ($indField) {
                list($ind) = $indField->getSubfields('d');
                if ($ind) {
                    $items = $this->itemCollection->offsetGet($copyRecord);
                    foreach ($this->getServiceConstructors($ind->getValue()) as $serviceConstructor) {
                        $availability = call_user_func($serviceConstructor, $copyRecord);
                        if ($availability) {
                            \HAB\Helper::mapMethod($items, 'addAvailability', array($availability));
                        }
                    }
                }
            }
        }
    }

    /**
     * Return service constructors for general availability indicator.
     *
     * @param  string $ind General availability indicator
     * @return array
     */
    protected function getServiceConstructors ($ind)
    {
        $map = $this->getServiceConstructorMap();
        return isset($map[$ind]) ? $map[$ind] : array();
    }

    /**
     * Return service constructor map.
     *
     * @return array
     */
    protected function getServiceConstructorMap ()
    {
        return array(
            'u' => array(
                array($this, 'servicePresentation'),
                array($this, 'serviceLoan'),
                array($this, 'serviceInterloan'),
            )
        );
    }

    /**
     * Return final set of DAIA items.
     *
     * @return array
     */
    protected function prune ()
    {
        $items = array();
        foreach ($this->itemCollection as $copyRecord) {
            $recordItems = $this->itemCollection->offsetGet($copyRecord);
            if (!empty($recordItems)) {
                $items = array_merge($items, $recordItems);
            }
        }
        return $items;
    }

    /// Service constructors

    protected function servicePresentation (\HAB\Pica\Record\CopyRecord $copyRecord)
    {
        return new \HAB\Daia\Available('presentation');
    }

    protected function serviceLoan (\HAB\Pica\Record\CopyRecord $copyRecord)
    {
        $avail = new \HAB\Daia\Available('loan');
        return $avail;
    }

    protected function serviceInterloan (\HAB\Pica\Record\CopyRecord $copyRecord)
    {
        return new \HAB\Daia\Available('interloan');
    }

    protected function serviceOpenAccess (\HAB\Pica\Record\CopyRecord $copyRecord)
    {
        return new \HAB\Daia\Available('openaccess');
    }

}