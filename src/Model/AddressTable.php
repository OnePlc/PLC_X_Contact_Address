<?php
/**
 * AddressTable.php - Address Table
 *
 * Table Model for Contact Address
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

use Application\Controller\CoreController;
use Application\Model\CoreEntityTable;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Where;
use Laminas\Paginator\Paginator;
use Laminas\Paginator\Adapter\DbSelect;

class AddressTable extends CoreEntityTable {

    /**
     * AddressTable constructor.
     *
     * @param TableGateway $tableGateway
     * @since 1.0.0
     */
    public function __construct(TableGateway $tableGateway) {
        parent::__construct($tableGateway);

        # Set Single Form Name
        $this->sSingleForm = 'contactaddress-single';
    }

    /**
     * Get Contact Entity
     *
     * @param int $id
     * @return mixed
     * @since 1.0.0
     */
    public function getSingle($id) {
        # Use core function
        return $this->getSingleEntity($id,'Address_ID');
    }

    /**
     * Save Contact Entity
     *
     * @param Contact $oContact
     * @return int Contact ID
     * @since 1.0.0
     */
    public function saveSingle(Address $oContact) {
        $aData = [];

        $aData = $this->attachDynamicFields($aData,$oContact);

        $id = (int) $oContact->id;

        if ($id === 0) {
            # Add Metadata
            $aData['created_by'] = CoreController::$oSession->oUser->getID();
            $aData['created_date'] = date('Y-m-d H:i:s',time());
            $aData['modified_by'] = CoreController::$oSession->oUser->getID();
            $aData['modified_date'] = date('Y-m-d H:i:s',time());

            # Insert Contact
            $this->oTableGateway->insert($aData);

            # Return ID
            return $this->oTableGateway->lastInsertValue;
        }

        # Check if Contact Entity already exists
        try {
            $this->getSingle($id);
        } catch (\RuntimeException $e) {
            throw new \RuntimeException(sprintf(
                'Cannot update Address with identifier %d; does not exist',
                $id
            ));
        }

        # Update Metadata
        $aData['modified_by'] = CoreController::$oSession->oUser->getID();
        $aData['modified_date'] = date('Y-m-d H:i:s',time());

        # Update Contact
        $this->oTableGateway->update($aData, ['Address_ID' => $id]);

        return $id;
    }

    /**
     * Generate new single Entity
     *
     * @return Contact
     * @since 1.0.0
     */
    public function generateNew() {
        return new Address($this->oTableGateway->getAdapter());
    }
}