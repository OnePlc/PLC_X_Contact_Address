<?php
/**
 * Module.php - Module Class
 *
 * Module Class File for Address Address Plugin
 *
 * @category Config
 * @package Contact\Address
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Contact\Address;

use Application\Controller\CoreEntityController;
use Laminas\Mvc\MvcEvent;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\EventManager\EventInterface as Event;
use Laminas\ModuleManager\ModuleManager;
use OnePlace\Contact\Address\Controller\AddressController;
use OnePlace\Contact\Address\Model\AddressTable;
use OnePlace\Contact\Model\ContactTable;

class Module {
    /**
     * Module Version
     *
     * @since 1.0.0
     */
    const VERSION = '1.0.4';

    /**
     * Load module config file
     *
     * @since 1.0.0
     * @return array
     */
    public function getConfig() : array {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(Event $e)
    {
        // This method is called once the MVC bootstrapping is complete
        $application = $e->getApplication();
        $container    = $application->getServiceManager();
        $oDbAdapter = $container->get(AdapterInterface::class);
        $tableGateway = $container->get(AddressTable::class);

        # Register Filter Plugin Hook
        CoreEntityController::addHook('contact-edit-before',(object)['sFunction'=>'attachAddressForm','oItem'=>new AddressController($oDbAdapter,$tableGateway,$container)]);
        CoreEntityController::addHook('contact-add-before',(object)['sFunction'=>'attachAddressForm','oItem'=>new AddressController($oDbAdapter,$tableGateway,$container)]);
        CoreEntityController::addHook('contact-view-before',(object)['sFunction'=>'attachAddressForm','oItem'=>new AddressController($oDbAdapter,$tableGateway,$container)]);
        CoreEntityController::addHook('contact-add-after-save',(object)['sFunction'=>'attachAddressToContact','oItem'=>new AddressController($oDbAdapter,$tableGateway,$container)]);
        CoreEntityController::addHook('contact-edit-after-save',(object)['sFunction'=>'attachAddressToContact','oItem'=>new AddressController($oDbAdapter,$tableGateway,$container)]);
    }

    /**
     * Load Models
     */
    public function getServiceConfig() : array {
        return [
            'factories' => [
                # Address Plugin - Base Model
                Model\AddressTable::class => function($container) {
                    $tableGateway = $container->get(Model\AddressTableGateway::class);
                    return new Model\AddressTable($tableGateway,$container);
                },
                Model\AddressTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Address($dbAdapter));
                    return new TableGateway('contact_address', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    } # getServiceConfig()

    /**
     * Load Controllers
     */
    public function getControllerConfig() : array {
        return [
            'factories' => [
                Controller\AddressController::class => function($container) {
                    $oDbAdapter = $container->get(AdapterInterface::class);
                    $tableGateway = $container->get(AddressTable::class);

                    # hook start
                    # hook end
                    return new Controller\AddressController(
                        $oDbAdapter,
                        $tableGateway,
                        $container
                    );
                },
                # Installer
                Controller\InstallController::class => function($container) {
                    $oDbAdapter = $container->get(AdapterInterface::class);
                    return new Controller\InstallController(
                        $oDbAdapter,
                        $container->get(Model\AddressTable::class),
                        $container
                    );
                },
            ],
        ];
    } # getControllerConfig()
}
