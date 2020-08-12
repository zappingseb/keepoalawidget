<?php

namespace KeepoalaWidget2\Widgets;

use Ceres\Widgets\Helper\BaseWidget;
use IO\Services\Order\Factories\OrderResultFactory;
use Ceres\Config\CeresHeaderConfig;
use Plenty\Plugin\ConfigRepository;

class KeepoalaWidget2 extends BaseWidget
{
    protected $template = "KeepoalaWidget2::Widgets.KeepoalaWidget2";

    /**
     * @inheritdoc
     */
    protected function getTemplateData($widgetSettings, $isPreview, ConfigRepository $config)
    {
        /** @var OrderResultFactory $orderResultFactory */
        $orderResultFactory = pluginApp(OrderResultFactory::class);
        $order = $orderResultFactory->fillOrderResult();

        $company_name = $config->get("KeepoalaWidget2.companycode");

        $keepoalaID = $company_name . '-' .  md5($order->id);

        return [
            'data' => $order,
            'totals' => $order['totals'],
            'shopname' => $company_name,
            'keepoalaID' => $keepoalaID,
            'showAdditionalPaymentInformation' => true
        ];
    }
    
    protected function getPreviewData($widgetSettings, ConfigRepository $config)
    {
        $company_name = $config->get("KeepoalaWidget2.companycode");

        /** @var OrderResultFactory $orderResultFactory */
        $orderResultFactory = pluginApp(OrderResultFactory::class);
        $order = $orderResultFactory->fillOrderResult();

        $keepoalaID = $company_name . '-' . md5($order->id);
        return [
            'data' => $order,
            'totals' => $order['totals'],
            'shopname' => $company_name,
            'keepoalaID' => $keepoalaID,
            'showAdditionalPaymentInformation' => true
        ];
    }
}