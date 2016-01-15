<?php

namespace Modules\Gallery\Installer;

class RegisterDefaultPermissions
{

    public $defaultPermissions = [

        'manage-gallery' => [
            'display_name' => 'gallery::module-permissions.manage-gallery.display_name',
            'description' => 'gallery::module-permissions.manage-gallery.description'
        ],

    ];
}