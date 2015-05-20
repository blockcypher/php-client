<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherBaseModel;
use BlockCypher\Validation\ArgumentArrayValidator;

/**
 * Class AddressesList
 *
 * Information about a single line item.
 *
 * @package BlockCypher\Api
 *
 * @property string[] addresses
 */
class AddressesList extends BlockCypherBaseModel
{
    /**
     * Constructor passing addresses array. Default constructor can not be overridden
     *
     * @param string[] $addresses
     * @return AddressesList
     */
    public static function fromAddressesArray($addresses)
    {
        ArgumentArrayValidator::validate($addresses, 'addresses');
        $addressesList = new self();
        $addressesList->setAddresses($addresses);
        return $addressesList;
    }

    /**
     * @param \string[] $addresses
     * @return $this
     */
    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;
        return $this;
    }

    /**
     * Append Address to the list.
     *
     * @param string $address
     * @return $this
     */
    public function addAddress($address)
    {
        if (!$this->getAddresses()) {
            return $this->setAddresses(array($address));
        } else {
            return $this->setAddresses(
                array_merge($this->getAddresses(), array($address))
            );
        }
    }

    /**
     * @return \string[]
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Remove Address from the list.
     *
     * @param string $address
     * @return $this
     */
    public function removeAddress($address)
    {
        return $this->setAddresses(
            array_diff($this->getAddresses(), array($address))
        );
    }
}