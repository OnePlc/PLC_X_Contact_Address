<?php
/**
 * Address.php - Address Entity
 *
 * Entity Model for Contact Address
 *
 * @category Model
 * @package Contact\Address
 * @author Verein onePlace
 * @copyright (C) 2020 Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Contact\Address\Model;

use Application\Model\CoreEntityModel;

class Address extends CoreEntityModel {
    /**
     * Contact constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @since 1.0.0
     */
    public function __construct($oDbAdapter) {
        parent::__construct($oDbAdapter);

        # Set Single Form Name
        $this->sSingleForm = 'contactaddress-single';

        # Attach Dynamic Fields to Entity Model
        $this->attachDynamicFields();
    }

    /**
     * Set Entity Data based on Data given
     *
     * @param array $aData
     * @since 1.0.0
     */
    public function exchangeArray(array $aData) {
        $this->id = !empty($aData['Address_ID']) ? $aData['Address_ID'] : 0;

        $this->updateDynamicFields($aData);
    }

    public function getLabel() {
        return $this->street;
    }
}