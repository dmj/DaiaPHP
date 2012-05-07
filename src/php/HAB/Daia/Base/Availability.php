<?php

/**
 * The DAIA Availability class file.
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

namespace HAB\Daia\Base;

/**
 * Abstract base class of availability information nodes.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright Copyright (c) 2012 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3
 */
abstract class Availability extends MessageNode
{

    /**
     * Constructor.
     *
     * @param  string $service Service identifier
     * @return void
     */
    public function __construct ($service = null)
    {
        if ($service) {
            $this->setService($service);
        }
    }

    /**
     * Add limitation information.
     *
     * @param  \HAB\Daia\Limitation $limitation Limitation
     * @return void
     */
    public function addLimitation (\HAB\Daia\Limitation $limitation)
    {
        $this->addNode($limitation);
    }

    /**
     * Set service identifier.
     *
     * @param  string $service Service identifier
     * @return void
     */
    public function setService ($service)
    {
        $this->setAttribute('service', $service);
    }

    /**
     * Return service identifier.
     *
     * @return  string Service identifier or null if not set
     */
    public function getService ()
    {
        return $this->getAttribute('service');
    }

    /**
     * Set availability href.
     *
     * @param  string $href Availability href
     * @return void
     */
    public function setHref ($href)
    {
        $this->setAttribute('href', $href);
    }

    /**
     * Return availability href.
     *
     * @return string Availability href or null if not set
     */
    public function getHref ()
    {
        return $this->getAttribute('href');
    }

}