<?php

namespace KeepoalaWidget\Widgets;

use Ceres\Widgets\Helper\BaseWidget;
use IO\Services\Order\Factories\OrderResultFactory;

class KeepoalaWidget extends BaseWidget
{
    /**
     * @inheritdoc
     */
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