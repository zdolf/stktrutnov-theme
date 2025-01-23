<?php namespace LZaplata\Pages\Controllers;

use Backend;
use BackendMenu;
use Backend\Classes\Controller;

class Blocks extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = [
        'lzaplata.pages.block'
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('LZaplata.Pages', 'main-menu-item', 'side-menu-item2');
    }

}
