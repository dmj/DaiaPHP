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
     * Map of copy records to DAIA items.
     *
     * @var \SplObjectStorage
     */
    protected $itemStorage;

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
        $this->itemStorage = new \SplObjectStorage();
        foreach ($localRecord->getCopyRecords() as $copyRecord) {
            $this->itemStorage->attach($copyRecord, $this->createItems($copyRecord));
        }
        $this->addAvailability();
        return $this->finalize();
    }

    /**
     * Return array of DAIA items for a copy record.
     *
     * @param  \HAB\Pica\Record\CopyRecord $copyRecord
     * @return array
     */
    protected function createItems (\HAB\Pica\Record\CopyRecord $copyRecord)
    {
        return array(new \HAB\Daia\Item());
    }

    /**
     * Add availability information.
     *
     * @return void
     */
    protected function addAvailability ()
    {
    }

    /**
     * Return final array of DAIA items.
     *
     * @return array
     */
    protected function finalize ()
    {
        $items = array();
        foreach ($this->itemStorage as $copyRecordItems) {
            $items = array_merge($items, $copyRecordItems);
        }
        return $items;
    }
}