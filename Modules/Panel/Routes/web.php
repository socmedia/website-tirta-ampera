<?php

use Illuminate\Support\Facades\Route;
use Modules\Panel\Http\Controllers\PanelController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

require __DIR__ . '/panel/main.php';
require __DIR__ . '/panel/website.php';
require __DIR__ . '/panel/access_control_list.php';
// require __DIR__ . '/panel/accounting.php';
// require __DIR__ . '/panel/hrm.php';
// require __DIR__ . '/panel/inventory.php';
// require __DIR__ . '/panel/project.php';