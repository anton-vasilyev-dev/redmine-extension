<?php

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class EntityModel implements InputFilterAwareInterface
{
    protected $_id;

    protected $_inputFilter;

    public function exchangeArray($data)
    {
        if (array_key_exists('inputFilter', $data)) {
            unset($data['inputFilter']);
        }
        foreach ($data as $key => $value) {
            $filteredKey = lcfirst(implode('', array_map('ucfirst', explode('_', $key))));
            if (property_exists($this, '_' . $filteredKey) && method_exists($this, 'set' . ucfirst($filteredKey))) {
                $this->{'set' . ucfirst($filteredKey)}($value);
            }
        }
    }

    public function getArrayCopy()
    {
        $data = get_object_vars($this);
        $publicData = array();
        foreach ($data as $key => $value) {
            if (method_exists($this, 'get' . ucfirst(substr($key, 1, strlen($key))))) {
                $publicData[substr($key, 1, strlen($key))] = $value;
            }
        }
        unset($publicData['inputFilter']);

        return $publicData;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if ($this->_inputFilter == null) {
            $inputFilter = new InputFilter();
            /*$factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));/*

            $inputFilter->add($factory->createInput(array(
                'name'     => 'artist',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'title',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));
            */

            $this->_inputFilter = $inputFilter;
        }

        return $this->_inputFilter;
    }

    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }
}