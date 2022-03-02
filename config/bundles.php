<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Symfony\Bundle\DebugBundle\DebugBundle::class => ['dev' => true],
    Symfony\Bundle\MonologBundle\MonologBundle::class => ['all' => true],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class => ['dev' => true, 'test' => true],
    Somnambulist\Bundles\ApiBundle\SomnambulistApiBundle::class => ['all' => true],
    Somnambulist\Bundles\FractalBundle\SomnambulistFractalBundle::class => ['all' => true],
    Somnambulist\Bundles\FormRequestBundle\SomnambulistFormRequestBundle::class => ['all' => true],
    App\Resources\ResourcesBundle::class => ['all' => true],
];
