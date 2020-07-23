<?php

namespace KeepoalaWidget\Widgets;

use Ceres\Widgets\Helper\BaseWidget;
use IO\Services\Order\Factories\OrderResultFactory;

class KeepoalaWidget extends BaseWidget
{
    protected $template = "KeepoalaWidget::Widgets.KeepoalaWidget";

    /**
     * @inheritdoc
     */
    protected function getTemplateData($widgetSettings, $isPreview)
    {
        /** @var OrderResultFactory $orderResultFactory */
        $orderResultFactory = pluginApp(OrderResultFactory::class);
        $order = $orderResultFactory->fillOrderResult();

        return [
            'data' => $order,
            'totals' => $order['totals'],
            'showAdditionalPaymentInformation' => true
        ];
    }
    
    protected function getPreviewData($widgetSettings)
    {
        /** @var OrderResultFactory $orderResultFactory */
        $orderResultFactory = pluginApp(OrderResultFactory::class);
        $order = $orderResultFactory->fillOrderResult();

        return [
            'data' => $order,
            'totals' => $order['totals'],
            'showAdditionalPaymentInformation' => true
        ];
    }
}