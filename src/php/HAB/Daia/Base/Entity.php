<?php

/**
 * The DAIA Entity class file.
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
 * Abstract base class of DAIA entity nodes.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright Copyright (c) 2012 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3
 */
abstract class Entity extends Node
{

    /**
     * Constructor.
     *
     * @param  string $id Entity identifier
     * @param  string $href Entity href
     * @param  string $content Entity content
     * @return void
     */
    public function __construct ($id = null, $href = null, $content = null)
    {
        if ($id !== null) {
            $this->setId($id);
        }
        if ($href !== null) {
            $this->setHref($href);
        }
        if ($content !== null) {
            $this->setContent($content);
        }
    }

    /**
     * Return entity identifier.
     *
     * @return string Entity identifier
     */
    public function getId ()
    {
        return $this->getAttribute('id');
    }

    /**
     * Set entity identifier.
     *
     * @param  string $id Entity identifier
     * @return void
     */
    public function setId ($id)
    {
        $this->setAttribute('id', $id);
    }

    /**
     * Set entity href.
     *
     * @param  string $href Documeht href
     * @return void
     */
    public function setHref ($href)
    {
        $this->setAttribute('href', $href);
    }

    /**
     * Return entity href.
     *
     * @return string Entity href or null if not set
     */
    public function getHref ()
    {
        return $this->getAttribute('href');
    }

    /**
     * Set entity content language.
     *
     * NOT part of the official DAIA 0.5 specification.
     *
     * @param  string $lang Language code
     * @return void
     */
    public function setLang ($lang)
    {
        $this->setAttribute('lang');
    }

    /**
     * Return entity language.
     *
     * NOT part of the official DAIA 0.5 specification.
     *
     * @return string Language code
     */
    public function getLang ()
    {
        return $this->getAttribute('lang');
    }

    /**
     * Return entity content.
     *
     * @return string Entity content
     */
    public function getContent ()
    {
        return $this->_content;
    }

    /**
     * Set entity content.
     *
     * @param string $content Entity content
     * @return void
     */
    public function setContent ($content)
    {
        $this->_content = $content;
    }

}