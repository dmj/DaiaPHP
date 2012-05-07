<?php

/**
 * The DAIA Document class file.
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
 * The DAIA document node.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright Copyright (c) 2012 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3
 */
class Document extends Base\MessageNode
{

    /**
     * XML local name.
     *
     * @var string
     */
    const XML_LOCAL_NAME = 'document';

    /**
     * Constructor.
     *
     * @param  string $id Document identifier
     * @param  string $href Document href
     * @return void
     */
    public function __construct ($id, $href = null)
    {
        $this->setId($id);
        if ($href !== null) {
            $this->setHref($href);
        }
    }

    /**
     * Set document identifier.
     *
     * @param  string $id Document identifier
     * @return void
     */
    public function setId ($id)
    {
        $this->setAttribute('id', $id);
    }

    /**
     * Return document identifier.
     *
     * @return string Document identifier
     */
    public function getId ()
    {
        return $this->getAttribute('id');
    }

    /**
     * Set document href.
     *
     * @param  string $href Documeht href
     * @return void
     */
    public function setHref ($href)
    {
        $this->setAttribute('href', $href);
    }

    /**
     * Return document href.
     *
     * @return string Document href or null if not set
     */
    public function getHref ()
    {
        return $this->getAttribute('href');
    }

    /**
     * Add item node.
     *
     * @param  \HAB\Daia\Item $item Item node
     * @return void
     */
    public function addItem (\HAB\Daia\Item $item)
    {
        $this->addNode($item);
    }

    /**
     * Return item nodes.
     *
     * @return array Item nodes
     */
    public function getItems ()
    {
        return $this->getNodes(Item::XML_LOCAL_NAME);
    }

}