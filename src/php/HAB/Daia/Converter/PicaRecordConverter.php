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
     * Items indexed by sequence number.
     *
     * @var array
     */
    protected $items;

    /**
     * The currently processed {@link \HAB\Pica\Record\LocalRecord}.
     *
     * @var \HAB\Pica\Record\LocalRecord
     */
    protected $record;

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
        $this->reset();
        $this->record = $localRecord;
        $this->executeFieldCallbacks();
        $this->prune();
        return $this->getItems();
    }

    /**
     * Return a map of field based callbacks.
     *
     * The field callback map is an associative array with the body of a
     * regular expression matching a Pica+ field shorthand as key and a
     * callback function is value.
     *
     * During conversion {@link self::convert()} iterates of the array and
     * calls the callback function with all matching {@link
     * \HAB\Pica\Record\Field fields}.
     *
     * @return array
     */
    protected function getFieldCallbackMap ()
    {
        return array();
    }

    /**
     * Execute field callbacks.
     *
     * @see  self::getFieldCallbackMap()
     *
     * @return void
     */
    protected function executeFieldCallbacks ()
    {
        foreach ($this->getFieldCallbackMap() as $regexp => $callback) {
            $fields = $this->getRecord()->getFields($regexp);
            array_map($callback, $fields);
        }
    }

    /**
     * Prune the set of DAIA items.
     *
     * This method is called in {@link self::convert()} before the set of
     * items is returned.
     *
     * @return void
     */
    protected function prune ()
    {
    }

    /**
     * Reset the converter.
     *
     * Ereases all information about a previous run. This method is called
     * before every conversion in {@link self::convert()}.
     *
     * @return void
     */
    protected function reset ()
    {
        $this->items = array();
        $this->record = null;
    }


    // Internal accessors for the current set of items. You should use these
    // accessors instead of manipulating the $items property directly.

    /**
     * Return item identified by sequence number.
     *
     * Creates a new {@link \HAB\Daia\Item} if necessary.
     *
     * @param  integer $seqno Sequence number
     * @return \HAB\Daia\Item
     */
    protected function getItem ($seqno)
    {
        if (!isset($this->items[$seqno])) {
            $this->items[$seqno] = new \HAB\Daia\Item();
        }
        return $this->items[$seqno];
    }

    /**
     * Set the item identified by sequence number.
     *
     * @param  integer $seqno Sequence number
     * @param  \HAB\Daia\Item $item DAIA Item
     * @return void
     */
    protected function setItem ($seqno, \HAB\Daia\Item $item)
    {
        $this->items[$seqno] = $item;
    }

    /**
     * Remove the item identified by sequence number.
     *
     * Does nothing if no item with the given sequence number exists.
     *
     * @param  integer $seqno Sequence number
     * @return void
     */
    protected function unsetItem ($seqno)
    {
        if (isset($this->items[$seqno])) {
            unset($this->items[$seqno]);
        }
    }

    /**
     * Return true if the set of items contains an item at the specified
     * position.
     *
     * @param  integer $seqno Sequence number
     * @return boolean
     */
    protected function hasItem ($seqno)
    {
        return isset($this->items[$seqno]);
    }

    /**
     * Return the current set of items.
     *
     * @return array
     */
    protected function getItems ()
    {
        return $this->items;
    }

    // Internal accessors for the current record. Use these to retrieve the
    // record.

    protected function getRecord ()
    {
        return $this->record;
    }

}