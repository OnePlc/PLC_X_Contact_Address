<?php
/**
 * AddressController.php - Main Controller
 *
 * Main Controller for Contact Address Plugin
 *
 * @category Controller
 * @package Contact\Address
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace OnePlace\Contact\Address\Controller;

use Application\Controller\CoreEntityController;
use Application\Model\CoreEntityModel;
use OnePlace\Contact\Address\Model\AddressTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;

class AddressController extends CoreEntityController {
    /**
     * Contact Table Object
     *
     * @since 1.0.0
     */
    protected $oTableGateway;

    /**
     * ContactController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param ContactTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter,AddressTable $oTableGateway,$oServiceManager) {
        $this->oTableGateway = $oTableGateway;
        $this->sSingleForm = 'contactaddress-single';
        parent::__construct($oDbAdapter,$oTableGateway,$oServiceManager);

        if($oTableGateway) {
            # Attach TableGateway to Entity Models
            if(!isset(CoreEntityModel::$aEntityTables[$this->sSingleForm])) {
                CoreEntityModel::$aEntityTables[$this->sSingleForm] = $oTableGateway;
            }
        }
    }

    /**
     * Save Address and attach it to contact
     *
     * @param $oContact saved Contact
     * @param $aFormData raw Form Data
     * @param $sState state of saving
     * @return bool true or false
     * @since 1.0.0
     */
    public function attachAddressToContact($oContact,$aRawFormData,$sState) {
        $aFormData = $this->parseFormData($aRawFormData);

        # Parse Raw Form Data for Address Fields
        $aAddressFields = $this->getFormFields($this->sSingleForm);
        $aAddressData = [];
        foreach($aAddressFields as $oField) {
            if(array_key_exists($oField->fieldkey,$aFormData)) {
                $aAddressData[$oField->fieldkey] = $aFormData[$oField->fieldkey];
            }
        }

        # Link Contact to ADdress
        $aAddressData['contact_idfs'] = $oContact->getID();
        if(isset($aRawFormData[$this->sSingleForm.'_address_primary_id'])) {
            $aAddressData['Address_ID'] = $aRawFormData[$this->sSingleForm.'_address_primary_id'];
        }

        # Generate New Address
        $oAddress = $this->oTableGateway->generateNew();

        # Attach Data
        $oAddress->exchangeArray($aAddressData);

        # Save to Database
        $iAddressID = $this->oTableGateway->saveSingle($oAddress);

        return true;
    }

    public function attachAddressForm($oItem = false) {
        $oForm = CoreEntityController::$aCoreTables['core-form']->select(['form_key'=>'contactaddress-single']);
        $aFields = [
            'address-base' => CoreEntityController::$aCoreTables['core-form-field']->select(['form' => 'contactaddress-single']),
        ];

        # Try to get adress table
        try {
            $oAddressTbl = CoreEntityController::$oServiceManager->get(AddressTable::class);
        } catch(\RuntimeException $e) {
            //echo '<div class="alert alert-danger"><b>Error:</b> Could not load address table</div>';
            return [];
        }

        if(!isset($oAddressTbl)) {
            return [];
        }

        $aAddresses = [];
        $oPrimaryAddress = false;
        if($oItem) {
            # load contact addresses
            $oAddresses = $oAddressTbl->fetchAll(false, ['contact_idfs' => $oItem->getID()]);
            # get primary address
            if (count($oAddresses) > 0) {
                $bFirst = true;
                foreach ($oAddresses as $oAddr) {
                    if($bFirst) {
                        $oPrimaryAddress = $oAddr;
                    } else {
                        $aAddresses[] = $oAddr;
                    }
                    $bFirst = false;
                }
            }
        }

        # Pass Data to View - which will pass it to our partial
        return [
            # must be named aPartialExtraData
            'aPartialExtraData' => [
                # must be name of your partial
                'contact_address'=> [
                    'oAddresses'=>$aAddresses,
                    'oPrimaryAddress'=>$oPrimaryAddress,
                    'oForm'=>$oForm,
                    'aFormFields'=>$aFields,
                ]
            ]
        ];
    }
}
