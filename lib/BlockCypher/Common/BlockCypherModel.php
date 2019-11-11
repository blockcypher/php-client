<?php

namespace BlockCypher\Common;

use BlockCypher\Api\Error;
use BlockCypher\Converter\JsonConverter;
use BlockCypher\Core\BlockCypherLoggingManager;
use BlockCypher\Validation\JsonValidator;
use BlockCypher\Validation\ModelAccessorValidator;

/**
 * Generic Model class that all API domain classes extend
 * Stores all member data in a Hashmap that enables easy
 * JSON encoding/decoding
 */
class BlockCypherModel
{
    /**
     * Credentials to use for this call
     *
     * @var \BlockCypher\Auth\TokenCredential $credential
     */
    protected static $credential;

    private $_propMap = array();

    /**
     * Default Constructor
     *
     * You can pass data as a json representation or array object. This argument eliminates the need
     * to do $obj->fromJson($data) later after creating the object.
     *
     * @param null $data
     * @throws \InvalidArgumentException
     */
    public function __construct($data = null)
    {
        switch (gettype($data)) {
            case "NULL":
                break;
            case "string":
                JsonValidator::validate($data);
                $this->fromJson($data);
                break;
            case "array":
                $this->fromArray($data);
                break;
            default:
        }
    }

    /**
     * Fills object value from Json string
     *
     * @param $json
     * @return $this
     */
    public function fromJson($json)
    {
        //return $this->fromArray(JsonConverter::decode($json, true, 512, JSON_BIGINT_AS_STRING));
        return $this->fromArray(JsonConverter::decode($json, true));
    }

    /**
     * Fills object value from Array list
     *
     * @param $arr
     * @return $this
     */
    public function fromArray($arr)
    {
        if (!empty($arr)) {
            // Iterate over each element in array
            foreach ($arr as $k => $v) {
                // If the value is an array, it means, it is an object after conversion
                if (is_array($v)) {
                    // Determine the class of the object
                    if (($clazz = ReflectionUtil::getPropertyClass(get_class($this), $k)) != null) {
                        // If the value is an associative array, it means, its an object. Just make recursive call to it.
                        if (empty($v)) {
                            if (ReflectionUtil::isPropertyClassArray(get_class($this), $k)) {
                                // It means, it is an array of objects.
                                $this->assignValue($k, array());
                                continue;
                            }
                            $o = new $clazz();
                            //$arr = array();
                            $this->assignValue($k, $o);
                        } elseif (ArrayUtil::isAssocArray($v)) {
                            /** @var BlockCypherModel $o */
                            $o = new $clazz();
                            $o->fromArray($v);
                            $this->assignValue($k, $o);
                        } else {
                            // Else, value is an array of object/data
                            $arr = array();
                            // Iterate through each element in that array.
                            foreach ($v as $nk => $nv) {
                                if (is_array($nv)) {
                                    //BlockCypherLoggingManager::getInstance()->debug("new instance of class: $clazz");
                                    if (!class_exists($clazz)) {
                                        BlockCypherLoggingManager::getInstance()->error("Class not found: $clazz");
                                    } else {
                                        try {
                                            $o = new $clazz();
                                            $o->fromArray($nv);
                                            $arr[$nk] = $o;
                                        } catch (\Exception $e) {
                                            BlockCypherLoggingManager::getInstance()->error($e->getMessage());
                                        }
                                    }
                                } else {
                                    $arr[$nk] = $nv;
                                }
                            }
                            $this->assignValue($k, $arr);
                        }
                    } else {
                        $this->assignValue($k, $v);
                    }
                } else {
                    $this->assignValue($k, $v);
                }
            }
        }
        return $this;
    }

    private function assignValue($key, $value)
    {
        // If we find the getter setter, use that, otherwise use magic method.
        if (ModelAccessorValidator::validate($this, $this->convertToCamelCase($key))) {
            $setter = "set" . $this->convertToCamelCase($key);
            $this->$setter($value);
        } else {
            $this->__set($key, $value);
        }
    }

    /**
     * Converts the input key into a valid Setter Method Name
     *
     * @param $key
     * @return mixed
     */
    private function convertToCamelCase($key)
    {
        return str_replace(' ', '', ucwords(str_replace(array('_', '-'), ' ', $key)));
    }

    /**
     * Sets Credential
     *
     * @deprecated Pass ApiContext to create/get methods instead
     * @param \BlockCypher\Auth\TokenCredential $credential
     */
    public static function setCredential($credential)
    {
        self::$credential = $credential;
    }

    /**
     * Returns a list of Object from Array or Json String. It is generally used when your json
     * contains an array of this object
     *
     * @param mixed $data Array object or json string representation
     * @return array
     */
    public static function getList($data)
    {
        // Return Null if Null
        if ($data === null) {
            return null;
        }

        if (is_a($data, get_class(new \stdClass()))) {
            //This means, root element is object

            $accessibleProperties = get_object_vars($data);

            if (count($accessibleProperties) == 1
                && (isset($accessibleProperties['error']) || isset($accessibleProperties['errors']))
            ) {
                // Object is only an error {"error":"message"} or {"errors":["error1":"message1"]}
                return new Error(JsonConverter::encode($data));
            } else {
                return new static(JsonConverter::encode($data));
            }
        }

        $list = array();

        if (is_array($data)) {
            $data = JsonConverter::encode($data);
        }

        if (JsonValidator::validate($data)) {
            // It is valid JSON
            $decoded = JsonConverter::decode($data);
            if ($decoded === null) {
                return $list;
            }
            if (is_array($decoded)) {
                foreach ($decoded as $k => $v) {
                    $list[] = self::getList($v);
                }
            }
            if (is_a($decoded, get_class(new \stdClass()))) {
                //This means, root element is object
                $list[] = new static(JsonConverter::encode($decoded));
            }
        }

        return $list;
    }

    /**
     * Magic Get Method
     *
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        if ($this->__isset($key)) {
            return $this->_propMap[$key];
        }
        return null;
    }

    /**
     * Magic Set Method
     *
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        ModelAccessorValidator::validate($this, $this->convertToCamelCase($key));
        if (!is_array($value) && $value === null) {
            $this->__unset($key);
        } else {
            $this->_propMap[$key] = $value;
        }
    }

    /**
     * Magic isSet Method
     *
     * @param $key
     * @return bool
     */
    public function __isset($key)
    {
        return isset($this->_propMap[$key]);
    }

    /**
     * Magic Unset Method
     *
     * @param $key
     */
    public function __unset($key)
    {
        unset($this->_propMap[$key]);
    }

    /**
     * Magic Method for toString
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJSON(128);
    }

    /**
     * Returns object JSON representation
     *
     * @param int $options http://php.net/manual/en/json.constants.php
     * @return string
     */
    public function toJSON($options = 0)
    {
        //$options = $options | JSON_HEX_AMP | JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES;

        $options = $options | 2 | 64; // $options | JSON_HEX_AMP | JSON_UNESCAPED_SLASHES;

        return JsonConverter::encode($this->toArray(), $options);
    }

    /**
     * Returns array representation of object
     *
     * @return array
     */
    public function toArray()
    {
        return $this->_convertToArray($this->_propMap);
    }

    /**
     * Converts Params to Array
     *
     * @param $param
     * @return array
     */
    private function _convertToArray($param)
    {
        $ret = array();
        foreach ($param as $k => $v) {
            if ($v instanceof BlockCypherModel) {
                $ret[$k] = $v->toArray();
            } else if (is_array($v) && sizeof($v) <= 0) {
                $ret[$k] = array();
            } else if (is_array($v)) {
                $ret[$k] = $this->_convertToArray($v);
            } else {
                $ret[$k] = $v;
            }
        }
        // If the array is empty, which means an empty object,
        // we need to convert array to StdClass object to properly
        // represent JSON String
        if (sizeof($ret) <= 0) {
            $ret = new BlockCypherModel();
        }
        return $ret;
    }
}
