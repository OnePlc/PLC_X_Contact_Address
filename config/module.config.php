<?php
/**
 * module.config.php - Address Config
 *
 * Main Config File for Contact Address Plugin
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
    # View Settings
    'view_manager' => [
        'template_path_stack' => [
            'contact-address' => __DIR__ . '/../view',
        ],
    ],
];
