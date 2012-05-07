<?php

/**
 * The DAIA Label class file.
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
 * The DAIA label node.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright Copyright (c) 2012 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3
 */
class Label extends Base\Node
{
    /**
     * XML local name.
     *
     * @var string
     */
    const XML_LOCAL_NAME = 'label';

    /**
     * Constructor.
     *
     * @param  string $label Label content
     * @return void
     */
    public function __construct ($content)
    {
        $this->_content = $content;
    }
    /**
     * Return label content.
     *
     * @return string Label content
     */
    public function getContent ()
    {
        return $this->_content;
    }

    /**
     * Set label content.
     *
     * @param string $content Label content
     * @return void
     */
    public function setContent ($content)
    {
        $this->_content = $content;
    }

}
