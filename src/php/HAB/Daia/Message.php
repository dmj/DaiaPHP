<?php

/**
 * The DAIA Message class file.
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
 * The DAIA Message node.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright Copyright (c) 2012 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3
 */
class Message extends Base\Node
{

    /**
     * XML local name.
     *
     * @var string
     */
    const XML_LOCAL_NAME = 'message';

    /**
     * Constructor.
     *
     * @param  string $content Message content
     * @param  string $lang Language code
     * @param  integer $errno Error number
     * @return void
     */
    public function __construct ($content, $lang, $errno = null)
    {
        $this->setLang($lang);
        $this->setContent($content);
        if ($errno !== null) {
            $this->setErrno($errno);
        }
    }

    /**
     * Set message language.
     *
     * @param  string $lang Language code
     * @return void
     */
    public function setLang ($lang)
    {
        $this->setAttribute('lang', $lang);
    }

    /**
     * Return message language.
     *
     * @return string Language code
     */
    public function getLang ()
    {
        return $this->getAttribute('lang');
    }

    /**
     * Return message content.
     *
     * @return string Message content
     */
    public function getContent ()
    {
        return $this->_content;
    }

    /**
     * Set message content.
     *
     * @param string $content Message content
     * @return void
     */
    public function setContent ($content)
    {
        $this->_content = $content;
    }

    /**
     * Set error number.
     *
     * @param  integer $errno Error number
     * @return void
     */
    public function setErrno ($errno)
    {
        $this->setAttribute('errno', $errno);
    }

    /**
     * Return error number.
     *
     * @return integer Error number or null if not set
     */
    public function getErrno ()
    {
        return $this->getAttribute('errno');
    }

}
