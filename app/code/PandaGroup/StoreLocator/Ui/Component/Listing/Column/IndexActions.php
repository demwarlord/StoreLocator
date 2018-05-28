<?php

namespace PandaGroup\StoreLocator\Ui\Component\Listing\Column;

class IndexActions extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Url path
     */
    const URL_PATH_EDIT = 'storelocator/index/edit';
    const URL_PATH_DELETE = 'storelocator/index/delete';
    const URL_PATH_DETAILS = 'storelocator/index/details';

    /**
     * URL builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;


    /**
     * constructor
     *
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['storelocator_id'])) {
                    $item[$this->getData('name')] = [
                        'edit'   => [
                            'href'  => $this->urlBuilder->getUrl(
                                static::URL_PATH_EDIT,
                                [
                                    'id' => $item['storelocator_id']
                                ]
                            ),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href'    => $this->urlBuilder->getUrl(
                                static::URL_PATH_DELETE,
                                [
                                    'id' => $item['storelocator_id']
                                ]
                            ),
                            'label'   => __('Delete'),
                            'confirm' => [
                                'title'   => __('Delete "${ $.$data.name }"'),
                                'message' => __('Are you sure you wan\'t to delete a "${ $.$data.name }" store?')
                            ]
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }


//    /**
//     * Prepare Data Source
//     *
//     * @param array $dataSource
//     * @return array
//     */
//    public function prepareDataSource(array $dataSource)
//    {
///*
//        if (isset($dataSource['data']['items'])) {
//            foreach ($dataSource['data']['items'] as & $item) {
//                if (isset($item['post_id'])) {
//                    $item[$this->getData('name')] = [
//                        'edit' => [
//                            'href' => $this->_urlBuilder->getUrl(
//                                static::URL_PATH_EDIT,
//                                [
//                                    'post_id' => $item['post_id']
//                                ]
//                            ),
//                            'label' => __('Edit')
//                        ],
//                        'delete' => [
//                            'href' => $this->_urlBuilder->getUrl(
//                                static::URL_PATH_DELETE,
//                                [
//                                    'post_id' => $item['post_id']
//                                ]
//                            ),
//                            'label' => __('Delete'),
//                            'confirm' => [
//                                'title' => __('Delete "${ $.$data.name }"'),
//                                'message' => __('Are you sure you wan\'t to delete the Post "${ $.$data.name }" ?')
//                            ]
//                        ]
//                    ];
//                }
//            }
//        }
//*/
//        if (isset($dataSource['data']['items'])) {
//            foreach ($dataSource['data']['items'] as &$item) {
//
//                $name = $this->getData('name');
//                if (isset($item['id']) && $this->isOrderIncrementId($item['id'])) {
//                    $item[$name]['view_order'] = [
//
//
//                        'href' => $this->getRowUrl($item),
//
//
//                        'label' => __('View Store'),
//                    ];
//                }
//            }
//        }
//
//        return $dataSource;
//    }
//
//    public function isOrderIncrementId($orderId)
//    {
//        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
//        $orderInterface = $objectManager->create('\Magento\Sales\Api\Data\OrderInterface');
//        $order = $orderInterface->load($orderId);
//        if($order->getId()) {
//            return true;
//        }
//        return false;
//    }
//
//    public function getRowUrl($item)
//    {
//        return  $this->_urlBuilder->getUrl('storelocator/index/index', ['id' => $item['id']]);
//    }
}
