<?php

/**
 * The DAIA Item class file.
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
 * The DAIA item node.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright Copyright (c) 2012 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3
 */
class Item extends Base\MessageNode
{

    /**
     * XML local name.
     *
     * @var string
     */
    const XML_LOCAL_NAME = 'item';

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct ()
    {
    }

    /**
     * Set item label node.
     *
     * @param  \HAB\Daia\Label $label Label node
     * @return void
     */
    public function setLabel (\HAB\Daia\Label $label)
    {
        $this->setNode($label);
    }

    /**
     * Return item label node.
     *
     * @return \HAB\Daia\Label|null Item label node
     */
    public function getLabel ()
    {
        return $this->getNodes(Label::XML_LOCAL_NAME);
    }

    /**
     * Set item department node.
     *
     * @param  \HAB\Daia\Department $department Department
     * @return void
     */
    public function setDepartment (\HAB\Daia\Department $department)
    {
        $this->setNode($department);
    }

    /**
     * Return item department node.
     *
     * @return \HAB\Daia\Department Department node
     */
    public function getDepartment ()
    {
        return $this->getNodes(Department::XML_LOCAL_NAME);
    }

    /**
     * Set item storage node.
     *
     * @param  \HAB\Daia\Storage $storage Storage node
     * @return void
     */
    public function setStorage (\HAB\Daia\Storage $storage)
    {
        $this->setNode($storage);
    }

    /**
     * Return item storage node.
     *
     * @return \HAB\Daia\Storage Storage node
     */
    public function getStorage ()
    {
        return $this->getNodes(Storage::XML_LOCAL_NAME);
    }

    /**
     * Add availability information node.
     *
     * @param  \HAB\Daia\Base\Availability $availability Availability information node
     * @return void
     */
    public function addAvailability (\HAB\Daia\Base\Availability $availability)
    {
        $this->addNode($availability);
    }

    /**
     * Return availability nodes.
     *
     * If optional argument $service is set, return only availability
     * information for this service.
     *
     * @param  string $service Service identifier
     * @return array Availability nodes
     */
    public function getAvailability ($service = null)
    {
        $nodes  = array_merge($this->getNodes(Available::XML_LOCAL_NAME), $this->getNodes(Unavailable::XML_LOCAL_NAME));
        if ($service) {
            $filter = function (\HAB\Daia\Availability $node) use ($service) { return $service === $node->getService(); };
        } else {
            $filter = \HAB\Helper::constantly(true);
        }
        return array_filter($nodes, $filter);
    }

    /**
     * Set item identifier.
     *
     * @param  string $id Item identifier
     * @return void
     */
    public function setId ($id)
    {
        $this->setAttribute('id', $id);
    }

    /**
     * Return item identifier.
     *
     * @return string Item identifier
     */
    public function getId ()
    {
        return $this->getAttribute('id');
    }

    /**
     * Set item href.
     *
     * @param  string $href Item href
     * @return void
     */
    public function setHref ($href)
    {
        $this->setAttribute('href', $href);
    }

    /**
     * Return item href.
     *
     * @return string item href
     */
    public function getHref ()
    {
        return $this->getAttribute('href');
    }

}