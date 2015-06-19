<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherBaseModel;
use BlockCypher\Validation\ArgumentArrayValidator;

/**
 * Class AddressList
 *
 * Information about a single line item.
 *
 * @package BlockCypher\Api
 *
 * @property string[] addresses
 */
class AddressList extends BlockCypherBaseModel
{
    /**
     * Constructor passing addresses array. Default constructor can not be overridden
     *
     * @param string[] $addresses
     * @return AddressList
     */
    public static function fromAddressesArray($addresses)
    {
        ArgumentArrayValidator::validate($addresses, 'addresses');
        $addressList = new self();
        $addressList->setAddresses($addresses);
        return $addressList;
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