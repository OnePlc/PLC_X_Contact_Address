<?php
/**
 * module.config.php - Address Config
 *
 * Main Config File for Address Address Plugin
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

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    # Address Module - Routes
    'router' => [
        'routes' => [
            'contact-address-setup' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/contact/address/setup',
                    'defaults' => [
                        'controller' => Controller\InstallController::class,
                        'action'     => 'checkdb',
                    ],
                ],
            ],
        ],
    ], # Routes

    # View Settings
    'view_manager' => [
        'template_path_stack' => [
            'contact-address' => __DIR__ . '/../view',
        ],
    ],
];
