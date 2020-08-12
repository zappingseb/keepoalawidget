<?php

namespace KeepoalaWidget2\Widgets;

use Ceres\Widgets\Helper\BaseWidget;
use IO\Services\Order\Factories\OrderResultFactory;
use Ceres\Config\CeresHeaderConfig;

class KeepoalaWidgetWarenkorb extends BaseWidget
{
    protected $template = "KeepoalaWidget2::Widgets.KeepoalaWidgetWarenkorb";

    /**
     * @inheritdoc
     */
    protected function getTemplateData($widgetSettings, $isPreview)
    {
        /** @var OrderResultFactory $orderResultFactory */
        $orderResultFactory = pluginApp(OrderResultFactory::class);
        $order = $orderResultFactory->fillOrderResult();

        $shop_config = pluginApp(CeresHeaderConfig::class);
        $company_name = $config->get("KeepoalaWidget2.companycode")

        $keepoalaID = substr(md5($company_name), 0, 4) . '-' .  md5($order->id);

        return [
            'data' => $order,
            'totals' => $order['totals'],
            'shopname' => $company_name,
            'keepoalaID' => $keepoalaID,
            'showAdditionalPaymentInformation' => true
        ];
    }
    
    protected function getPreviewData($widgetSettings)
    {
        $shop_config = pluginApp(CeresHeaderConfig::class);
        $company_name = $shop_config->companyName;

        /** @var OrderResultFactory $orderResultFactory */
        $orderResultFactory = pluginApp(OrderResultFactory::class);
        $order = $orderResultFactory->fillOrderResult();

        $keepoalaID = substr(md5($company_name), 0, 4) . '-' . md5($order->id);
        return [
            'data' => $order,
            'totals' => $order['totals'],
            'shopname' => $company_name,
            'keepoalaID' => $keepoalaID,
            'showAdditionalPaymentInformation' => true
        ];
    }
}