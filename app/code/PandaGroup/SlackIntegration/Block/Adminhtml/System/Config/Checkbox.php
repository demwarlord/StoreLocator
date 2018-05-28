<?php

namespace PandaGroup\SlackIntegration\Block\Adminhtml\System\Config;

use Magento\Framework\Data\Form\Element\AbstractElement;

class Checkbox extends \Magento\Config\Block\System\Config\Form\Field
{
    const CONFIG_PATH = 'slackintegration_config/general/';

    protected $_template = 'PandaGroup_SlackIntegration::system/config/checkbox.phtml';

    protected $_values = null;

    /**
     * Checkbox constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
    /**
     * Retrieve element HTML markup.
     *
     * @param AbstractElement $element
     *
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $this->setNamePrefix($element->getName())
            ->setHtmlId($element->getHtmlId());

        return $this->_toHtml();
    }

    public function getValues()
    {
        $values = [];
        $optionArray = \PandaGroup\SlackIntegration\Model\Config\Source\Checkbox::toOptionArray();
        foreach ($optionArray as $value) {
            $values[$value['value']] = $value['label'];

        }
        return $values;
    }

    /**
     * Get checked value.
     * @param  $name
     * @return boolean
     */
    public function isChecked()
    {
        $name = $this->getHtmlId();
        $name = explode('_', $name);
        $name = $name[sizeof($name) - 1];
        if (is_null($this->_values)) {
            $data = $this->getConfigData();
            if (isset($data[self::CONFIG_PATH . $name])) {
                return true;
            } else {
                return false;
            }
        }
    }

}