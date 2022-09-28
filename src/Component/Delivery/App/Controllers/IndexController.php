<?php declare(strict_types=1);

namespace App\Component\Delivery\App\Controllers;

use App\Resources\Delivery\App\AbstractController;

class IndexController extends AbstractController
{

    public function __invoke()
    {
        return $this->render('component/welcome.html.twig');
    }
}

