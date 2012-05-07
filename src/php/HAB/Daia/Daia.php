<?php

/**
 * The DAIA Daia class file.
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
 * The DAIA root node.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright Copyright (c) 2012 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3
 */
class Daia extends Base\MessageNode
{

    /**
     * DAIA version identifier.
     *
     * @var string
     */
    const VERSION = '0.5';

    /**
     * XML local name of DAIA root node.
     *
     * @var string
     */
    const XML_LOCAL_NAME = 'daia';

    /**
     * XML namespace URI of DAIA.
     *
     * @var string
     */
    const XML_NAMESPACE_URI = 'http://ws.gbv.de/daia/';

    /**
     * Declare the XML namespace in this node?
     *
     * @var boolean
     */
    const DECLARE_XML_NAMESPACE = true;

    /**
     * Constants for defined services.
     *
     * @var string
     */
    const SERVICE_PRESENTATION = 'presentation';
    const SERVICE_LOAN = 'loan';
    const SERVICE_OPENACCESS = 'openaccess';
    const SERVICE_INTERLOAN = 'interloan';

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct ()
    {
        $this->setAttribute('version', self::VERSION);
        $this->setAttribute('timestamp', date('c'));
    }

    /**
     * Set institution node.
     *
     * @param  \HAB\Daia\Institution $institution Institution node
     * @return void
     */
    public function setInstitution (\HAB\Daia\Institution $institution)
    {
        $this->setNode($institution);
    }

    /**
     * Return institution node.
     *
     * @return \HAB\Daia\Institution Institution node
     */
    public function getInstitution ()
    {
        return $this->getNodes(Institution::XML_LOCAL_NAME);
    }

    /**
     * Add a document node.
     *
     * @param  \HAB\Daia\Document $document Document node
     * @return void
     */
    public function addDocument (\HAB\Daia\Document $document)
    {
        $this->addNode($document);
    }

    /**
     * Return all document nodes.
     *
     * @return array Document nodes
     */
    public function getDocuments ()
    {
        return $this->getNodes(Document::XML_LOCAL_NAME);
    }

    /**
     * Return XML representation of the entire DAIA structure.
     *
     * @return string XML representation of the DAIA structure
     */
    public function toXml ()
    {
        $writer = new \XMLWriter();
        $writer->openMemory();
        $writer->setIndent(true);
        $writer->setIndentString('    ');
        $this->writeXml($writer, 'd');
        return $writer->flush();
    }

    /**
     * Return JSON representation of the entire DAIA structure
     *
     * @return string JSON representation of the DAIA structure
     */
    public function toJson ()
    {
        $json = $this->getJsonArray();
        $json['schema'] = Daia::XML_NAMESPACE_URI;
        return json_encode($json);
    }
}