<?php
/**
 * AddressTable.php - Address Table
 *
 * Table Model for Address Address
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
     * Get Address Entity
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
     * @param Address $oAddress
     * @return int Request ID
     * @since 1.0.0
     */
    public function saveSingle(Address $oAddress) {
        $aDefaultData = [
            'label' => $oAddress->label,
        ];

        return $this->saveSingleEntity($oAddress,'Address_ID',$aDefaultData);
    }

    /**
     * Generate new single Entity
     *
     * @return Address
     * @since 1.0.0
     */
    public function generateNew() {
        return new Address($this->oTableGateway->getAdapter());
    }
}