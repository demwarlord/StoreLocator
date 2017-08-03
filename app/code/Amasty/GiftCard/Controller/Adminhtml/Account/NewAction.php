<?php

namespace Amasty\GiftCard\Controller\Adminhtml\Account;

class NewAction extends \Amasty\GiftCard\Controller\Adminhtml\Account
{

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Amasty_GiftCard::giftcard_account');

        $title = __('New Gift Code Account');
        $resultPage->getConfig()->getTitle()->prepend($title);
        $resultPage->addBreadcrumb($title, $title);

        return $resultPage;
    }
}
