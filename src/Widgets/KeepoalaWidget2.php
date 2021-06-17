<?php

namespace KeepoalaWidget2\Widgets;

use IO\Helper\Utils;
use Ceres\Widgets\Helper\BaseWidget;
use IO\Services\Order\Factories\OrderResultFactory;
use IO\Services\CustomerService;
use Ceres\Config\CeresHeaderConfig;
use Plenty\Plugin\ConfigRepository;
use Ceres\Contexts\OrderConfirmationContext;
use IO\Extensions\Filters\URLFilter;

class KeepoalaWidget2 extends BaseWidget
{
    protected $template = "KeepoalaWidget2::Widgets.KeepoalaWidget2";
    private $config;


    /**
     * @inheritdoc
     */
    protected function getTemplateData($widgetSettings, $isPreview)
    {
        /** @var OrderResultFactory $orderResultFactory */
        $orderResultFactory = pluginApp(OrderResultFactory::class);
        $order = $orderResultFactory->fillOrderResult();
        $customerService = pluginApp(CustomerService::class);

        $data2 = $customerService->getLatestOrder();

        $config = pluginApp(ConfigRepository::class);
        $company_name = $config->get("KeepoalaWidget2.companycode");

        $keepoalaID = $company_name . '-' .  md5($order->id);

        return [
            'data' => $order,
            'data2' => $data2->order->id,
            'lang' => Utils::getlang(),
            'totals' => $order['totals'],
            'shopname' => $company_name,
            'keepoalaID' => $keepoalaID,
            'orderID' =>  $data2->order->id,
            'email' => $data2->order->deliveryAddress->options[0]->value,
            'showAdditionalPaymentInformation' => true
        ];
    }
    
    protected function getPreviewData($widgetSettings)
    {
        $config = pluginApp(ConfigRepository::class);
        $company_name = $config->get("KeepoalaWidget2.companycode");

        /** @var OrderResultFactory $orderResultFactory */
        $orderResultFactory = pluginApp(OrderResultFactory::class);
        $order = $orderResultFactory->fillOrderResult();
        $customerService = pluginApp(CustomerService::class);
        $data2 = $customerService->getLatestOrder();

        $keepoalaID = $company_name . '-' . md5($order->id);
        return [
            'data' => $order,
            'totals' => $order['totals'],
            'data2' =>  $data2->order->id,
            'lang' => Utils::getlang(),
            'shopname' => $company_name,
            'keepoalaID' => $keepoalaID,
            'orderID' =>  $data2->order->id,
            'email' =>  $data2->order->deliveryAddress->options[0]->value,
            'showAdditionalPaymentInformation' => true
        ];
    }
}