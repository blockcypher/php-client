<?php

namespace BlockCypher\Common;

/**
 * Class BlockCypherBaseModel
 * Base Model class. It contains common properties to all model classes.
 *
 * @package BlockCypher\Common
 *
 * @property string error
 * @property string[] errors
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
     * @param string $error
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
     * @return \string[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param \string[] $errors
     * @return $this
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * Remove error from the list.
     *
     * @param string $error
     * @return $this
     */
    public function removeError($error)
    {
        return $this->setErrors(
            array_diff($this->getErrors(), array($error))
        );
    }
}
