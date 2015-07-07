<?php

namespace BlockCypher\Common;

/**
 * Class BlockCypherBaseModel
 * Base Model class. It contains common properties to all model classes.
 *
 * @package BlockCypher\Common
 *
 * @property string error
 * @property \BlockCypher\Api\Error[] errors
 */
class BlockCypherBaseModel extends BlockCypherModel
{
    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param string $error
     * @return $this
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * Append error to the list.
     *
     * @param \BlockCypher\Api\Error $error
     * @return $this
     */
    public function addError($error)
    {
        if (!$this->getErrors()) {
            return $this->setErrors(array($error));
        } else {
            return $this->setErrors(
                array_merge($this->getErrors(), array($error))
            );
        }
    }

    /**
     * @return \BlockCypher\Api\Error[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param \BlockCypher\Api\Error[] $errors
     * @return $this
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * @return \string[]
     */
    public function getAllErrorMessages()
    {
        if ($this->error === null) {
            return $this->getErrorMessages();
        } else {
            return array_merge(array($this->error), $this->getErrorMessages());
        }
    }

    /**
     * @return \string[]
     */
    public function getErrorMessages()
    {
        $errorMessages = array();
        foreach ($this->errors as $error) {
            $errorMessages[] = $error->getError();
        }
        return $errorMessages;
    }

    /**
     * Remove error from the list.
     *
     * @param \BlockCypher\Api\Error $error
     * @return $this
     */
    public function removeError($error)
    {
        return $this->setErrors(
            array_diff($this->getErrors(), array($error))
        );
    }
}
