<?php declare(strict_types=1);

namespace App\Component\Delivery\App\Controllers;

use Somnambulist\ApiBundle\Controllers\ApiController;

/**
 * Class IndexController
 *
 * @package    App\Component\Delivery\App
 * @subpackage App\Component\Delivery\App\Controllers\IndexController
 */
class IndexController extends ApiController
{

    public function __invoke()
    {
        return $this->render('component/welcome.html.twig');
    }
}

