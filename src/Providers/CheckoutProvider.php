<?php
 
namespace KeepoalaWidget2\Providers;
 
use IO\Helper\TemplateContainer;
use IO\Helper\ResourceContainer;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Templates\Twig;
use Plenty\Modules\Order\Pdf\Events\OrderPdfGenerationEvent;
use Plenty\Modules\Order\Pdf\Models\OrderPdfGeneration;
use Plenty\Modules\Document\Models\Document;
use KeepoalaWidget2\Services\Logger;
use KeepoalaWidget2\Services\Config;
use Ceres\Config\CeresHeaderConfig;

class CheckoutProvider extends ServiceProvider
{

    const PDF_LINEBREAK = PHP_EOL;


	public function register()
	{
 
	}
 
	public function boot(Twig $twig, Dispatcher $eventDispatcher, Logger $logger, Config $config)
    {
        $eventDispatcher->listen('IO.Resources.Import', function (ResourceContainer $container)
        {
            $container->addScriptTemplate('KeepoalaWidget2::Content.Scripts');
        }, 0);

        $this->registerInvoicePdfGeneration($eventDispatcher, $logger, $config);
    }

    private function registerInvoicePdfGeneration(
        Dispatcher $eventDispatcher,
        Logger $logger,
        Config $config
    ) {

        if ($config->get("global.qrorder")) {
            // Listen for the document generation event
            $eventDispatcher->listen(OrderPdfGenerationEvent::class,
                function (OrderPdfGenerationEvent $event) use ($logger) {

                    /** @var Order $order */
                    $order = $event->getOrder();
                    $docType = $event->getDocType();

                    $shop_config = pluginApp(CeresHeaderConfig::class);
                    $company_name = $shop_config->companyName;

                    $keepoalaID = substr(md5($company_name), 0, 4) . '-' .  md5($order->id);
                    $link = "https://www.keepoala.com/enter-code/?code=" . $keepoalaID;
                    if ($docType == Document::ORDER_CONFIRMATION) {

                        try {
                            $orderPdfGenerationModel = pluginApp(OrderPdfGeneration::class);
                            $orderPdfGenerationModel->language = 'de';
                            $orderPdfGenerationModel->image = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=".$link;
                            $orderPdfGenerationModel->imageHeight = 120;
                            $orderPdfGenerationModel->imageWidth = 120;
                            $orderPdfGenerationModel->link = $link;

                            $orderPdfGenerationModelAdvice = pluginApp(OrderPdfGeneration::class);
                            $orderPdfGenerationModelAdvice->language = "de";
                            $orderPdfGenerationModelAdvice->advice = "TestText";

                        } catch (\Exception $e) {
                            $message = "KeepoalaWidget2" . '::' . 'Adding PDF comment failed for order '
                                . $order->id;
                            $logger->error($message, $e->getMessage());
                            return;
                        }
                        /** @var \Plenty\Modules\Order\Pdf\Models\OrderPdfGeneration $orderPdfGenerationModel */
                        /** $orderPdfGenerationModel = pluginApp(OrderPdfGeneration::class);

                        $orderPdfGenerationModel->language = 'de';

                        **/
                        /* ADD IMAGE */
                        $event->addOrderPdfGeneration($orderPdfGenerationModel)->addOrderPdfGeneration($orderPdfGenerationModelAdvice);
                    }
                }
            );
        }
    }
}