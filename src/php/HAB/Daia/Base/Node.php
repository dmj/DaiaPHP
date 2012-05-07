<?php

/**
 * The DAIA Node class file.
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
 * Abstract base class of DAIA nodes.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright Copyright (c) 2012 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3
 */
abstract class Node
{

    /**
     * Declare the XML namespace in this node?
     *
     * @var boolean
     */
    const DECLARE_XML_NAMESPACE = false;

    /**
     * Array of node attributes.
     *
     * Attributes are simple key-value pairs stored in an associative array.
     *
     * @var array
     */
    protected $_attributes = array();

    /**
     * Array of child nodes indexed by XML local name.
     *
     * @var array
     */
    protected $_nodes = array();

    /**
     * Text content, if any.
     *
     * @var string
     */
    protected $_content;

    /**
     * Return XML local name of node.
     *
     * @return string XML local name
     */
    public function getXmlLocalName ()
    {
        return static::XML_LOCAL_NAME;
    }

    /**
     * Write XML representation.
     *
     * @param  \XMLWriter $writer XML writer instance
     * @param  string|null $nsPrefix Namespace prefix
     * @return void
     */
    public function writeXml (\XMLWriter $writer, $nsPrefix = 'daia')
    {
        $lname = $this->getXmlLocalName();
        if (static::DECLARE_XML_NAMESPACE) {
            $writer->startElementNS($nsPrefix, $lname, \HAB\Daia\Daia::XML_NAMESPACE_URI);
        } else {
            $qname = $nsPrefix ? "{$nsPrefix}:{$lname}" : $lname;
            $writer->startElement($qname);
        }
        foreach ($this->getAttributes() as $name => $value) {
            if (is_bool($value)) {
                $writer->writeAttribute($name, $value ? 'true' : 'false');
            } else {
                $writer->writeAttribute($name, $value);
            }
        }
        foreach ($this->getNodes() as $name => $value) {
            if (!is_array($value)) {
                $value = array($value);
            }
            foreach ($value as $node) {
                $node->writeXml($writer, $nsPrefix);
            }
        }
        if ($this->_content) {
            $writer->text($this->_content);
        }
        $writer->endElement();
    }

    /**
     * Return JSON encodable array.
     *
     * @return array JSON encodable array
     */
    public function getJsonArray ()
    {
        $json = array();
        foreach ($this->getAttributes() as $name => $value) {
            if ($value) {
                $json[$name] = $value;
            }
        }
        foreach ($this->getNodes() as $name => $value) {
            if (is_array($value)) {
                $data = array_filter(array_map(function (\HAB\Daia\Base\Node $node) { return $node->getJsonArray(); }, $value),
                                     function (array $arr) { return !empty($arr); });
            } else {
                $data = $value->getJsonArray();
            }
            if ($data) {
                $json[$name] = $data;
            }
        }
        if ($this->_content) {
            $json['content'] = $this->_content;
        }

        return $json;
    }

    /**
     * Set a node attribute.
     *
     * @param  string $name Attribute name
     * @param  string $value Attribute value
     * @return void
     */
    protected function setAttribute ($name, $value)
    {
        $this->_attributes[$name] = $value;
    }

    /**
     * Return a node attribute value.
     *
     * @param  string $name Attribute name
     * @return mixed|null Attribute value or null if not set
     */
    protected function getAttribute ($name)
    {
        return isset($this->_attributes[$name]) ? $this->_attributes[$name] : null;
    }

    /**
     * Return array of node attributes.
     *
     * @return array Node attributes
     */
    protected function getAttributes ()
    {
        return $this->_attributes;
    }

    /**
     * Add a child node.
     *
     * Use this method to add repeatable child nodes that can be repeated. To
     * add a non-repeatable node use setNode() instead.
     *
     * @param  \HAB\Daia\Base\Node $node Node
     * @return void
     */
    protected function addNode (\HAB\Daia\Base\Node $node)
    {
        $nodes =& $this->_nodes;
        $name  = $node->getXmlLocalName();
        if (isset($nodes[$name])) {
            $nodes[$name] []= $node;
        } else {
            $nodes[$name] = array($node);
        }
    }

    /**
     * Set a child node.
     *
     * Use this method to add a non-repeatable child node.
     *
     * @param  \HAB\Daia\Base\Node $node
     * @return void
     */
    protected function setNode (\HAB\Daia\Base\Node $node)
    {
        $name = $node->getXmlLocalName();
        $this->_nodes[$name] = $node;
    }

    /**
     * Return array of child nodes indexed by node name.
     *
     * If optional argument $node is set return a single node or an array of
     * nodes with this name. If no nodes exist return an empty array.
     *
     * @param  string $name Node name
     * @return array Child nodes
     */
    protected function getNodes ($name = null)
    {
        if ($name) {
            if (isset($this->_nodes[$name])) {
                return $this->_nodes[$name];
            } else {
                return array();
            }
        } else {
            return $this->_nodes;
        }
    }
}