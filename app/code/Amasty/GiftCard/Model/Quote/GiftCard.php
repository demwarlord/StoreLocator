<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2017 Amasty (https://www.amasty.com)
 * @package Amasty_GiftCard
 */

namespace Amasty\GiftCard\Model\Quote;

use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
use Magento\Quote\Model\Quote;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote\Address\Total;
use Magento\Store\Model\StoreManagerInterface;

class GiftCard extends AbstractTotal
{
    /**
     * @var \Amasty\GiftCard\Model\AccountFactory
     */
    protected $accountModel;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var \Amasty\GiftCard\Model\ResourceModel\Account
     */
    protected $accountResourceModel;
    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $priceCurrency;
    /**
     * @var \Amasty\GiftCard\Helper\Data
     */
    protected $dataHelper;
    /**
     * @var \Amasty\GiftCard\Model\ResourceModel\Quote\Collection
     */
    protected $giftCardQuoteCollection;

    protected $giftCardLabel = [];
    protected $giftCardAmount;

    public function __construct(
        \Amasty\GiftCard\Model\AccountFactory $accountModel,
        StoreManagerInterface $storeManager,
        \Amasty\GiftCard\Model\ResourceModel\Account $accountResourceModel,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Amasty\GiftCard\Helper\Data $dataHelper,
        \Amasty\GiftCard\Model\ResourceModel\Quote\CollectionFactory $giftCardQuoteCollection
    ) {
        $this->accountModel = $accountModel;
        $this->storeManager = $storeManager;
        $this->accountResourceModel = $accountResourceModel;
        $this->priceCurrency = $priceCurrency;
        $this->dataHelper = $dataHelper;
        $this->giftCardQuoteCollection = $giftCardQuoteCollection;
    }

    public function collect(
        Quote $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Total $total
    ) {
        if (!$this->dataHelper->isEnableGiftFormInCart($quote)) {
            $this->dataHelper->removeAllCards($quote);
        }

        $rate = $quote->getBaseToQuoteRate();

        $giftCardQuoteCollection = $this->giftCardQuoteCollection->create()
            ->addFieldToFilter('quote_id', ['eq' => $quote->getId()])
            ->joinAccount()
        ;

        $giftAmount = 0;
        $baseGiftAmount = 0;

        $grandTotal = $total->getGrandTotal();
        $subTotal = $total->getSubtotal();
        $baseSubTotal = $total->getBaseSubtotal();

        $shippingAmount = $total->getData('shipping_amount');
        $baseShippingAmount = $total->getData('base_shipping_amount');

        if ($baseSubTotal) {
            $this->giftCardLabel = [];
            foreach ($giftCardQuoteCollection as $giftCard) {
                $currentValue = $giftCard->getCurrentValue();
                $currentValueRate = $currentValue * $rate;
                $giftCard->setGiftAmount($currentValue);
                $giftCard->setBaseGiftAmount($currentValueRate);
                $giftCard->save();

                $giftAmount += $currentValueRate;
                $baseGiftAmount += $currentValue;

                $this->giftCardLabel[] = $giftCard->getCode();

                if ($subTotal - $giftAmount < 0) {
                    $giftAmount = $subTotal;
                    $baseGiftAmount = $baseSubTotal;

                    if ($this->dataHelper->isAllowedToPaidForShipping()) {
                        $delta = $currentValue - $subTotal;
                        $baseDelta = $currentValueRate - $baseSubTotal;
                        $giftAmount += ($shippingAmount > $delta) ? $delta : $shippingAmount;
                        $baseGiftAmount += ($baseShippingAmount > $baseDelta) ? $baseDelta : $baseShippingAmount;
                    }

                    $giftCard->setGiftAmount($giftAmount);
                    $giftCard->setBaseGiftAmount($baseGiftAmount);
                    $giftCard->save();
                    break;
                }
            }

            $total->setTotalAmount($this->getCode(), -$giftAmount);
            $total->setBaseTotalAmount($this->getCode(), -$baseGiftAmount);

            $total->setAmastyGift($giftAmount);
            $total->setBaseAmastyGift($baseGiftAmount);

            $quote->setAmastyGift($giftAmount);
            $quote->setBaseAmastyGift($baseGiftAmount);

            $total->setGrandTotal($grandTotal - $giftAmount);
            $total->setBaseGrandTotal($total->getBaseGrandTotal() - $baseGiftAmount);

            $this->giftCardAmount = $giftAmount;
        }

        return $this;
    }

    public function fetch(Quote $quote, Total $total)
    {

        return [
            'code' => $this->getCode(),
            'title' => __(implode(', ', $this->giftCardLabel)),
            'value' => - $this->giftCardAmount
        ];

    }

}