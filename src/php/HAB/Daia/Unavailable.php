<?php

/**
 * The DAIA Unavailable class file.
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

namespace HAB\Daia;

/**
 * The DAIA unavailable node.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright Copyright (c) 2012 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3
 */
class Unavailable extends Base\Availability
{

    /**
     * XML local name.
     *
     * @var string
     */
    const XML_LOCAL_NAME = 'unavailable';

    /**
     * Set availability queue size.
     *
     * @param  string $queue Availability queue size
     * @return void
     */
    public function setQueue ($queue)
    {
        $this->setAttribute('queue', $queue);
    }

    /**
     * Return availability queue.
     *
     * @return string Availability queue size
     */
    public function getQueue ()
    {
        return $this->getAttribute('queue');
    }

    /**
     * Set expected availability.
     *
     * @param  string $queue Expected availability
     * @return void
     */
    public function setExpected ($expected)
    {
        $this->setAttribute('expected', $expected);
    }

    /**
     * Return expected availability.
     *
     * @return string Expected availability
     */
    public function getExpected ()
    {
        return $this->getAttribute('expected');
    }

}
