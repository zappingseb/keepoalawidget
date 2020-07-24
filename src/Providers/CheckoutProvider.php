<?php
 
namespace KeepoalaWidget2\Providers;
 
use IO\Helper\TemplateContainer;
use IO\Helper\ResourceContainer;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Templates\Twig;
 
class CheckoutProvider extends ServiceProvider
{
	public function register()
	{
 
	}
 
	public function boot(Twig $twig, Dispatcher $eventDispatcher)
    {
        $eventDispatcher->listen('IO.Resources.Import', function (ResourceContainer $container)
        {
            $container->addScriptTemplate('KeepoalaWidget2::Content.Scripts');
        }, 0);
    }
}