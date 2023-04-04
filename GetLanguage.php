<?php

namespace Wheelpros\CheckoutExtended\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Locale\TranslatedLists;
use Magento\Config\Model\Config\Source\Locale;
use Magento\Config\Model\Config\Source\Locale\Currency;

class GetLanguage implements ArgumentInterface
{
    /**
     * @var ScopeConfigInterface
     */
    protected ScopeConfigInterface $scopeConfig;
    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @var TranslatedLists
     */
    protected TranslatedLists $translatedLists;
    /**
     * @var Locale
     */
    protected Locale $locale;
    /**
     * @var Currency
     */
    protected Currency $currency;

    /**
     * @param ScopeConfigInterface  $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param TranslatedLists       $translatedLists
     * @param Locale                $locale
     * @param Currency              $currency
     */
    public function __construct(
        ScopeConfigInterface        $scopeConfig,
        StoreManagerInterface       $storeManager,
        TranslatedLists             $translatedLists,
        Locale                      $locale,
        Currency                    $currency
    ){
        $this->scopeConfig          = $scopeConfig;
        $this->storeManager         = $storeManager;
        $this->translatedLists      = $translatedLists;
        $this->locale               = $locale;
        $this->currency             = $currency;
    }
    /**
     * Get the language label for the current website's locale
     *
     * @return string
     */
    public function getLanguage(): string
    {
        $websiteId = $this->storeManager->getStore()->getWebsiteId();
        $localeCode = $this->scopeConfig->getValue('general/locale/code', ScopeInterface::SCOPE_WEBSITE, $websiteId);
        $localData = $this->locale->toOptionArray($localeCode);
        foreach ($localData as $data) {
            if ($data['value'] == $localeCode) {
                return $data['label'];
            }
        }
        return $localeCode;
    }

    /**
     * Get the currency label for the current website
     *
     * @return
     */
    public function getCurrency()
    {
        $local = $this->scopeConfig->getValue('currency/options/base');
        $check = $this->currency->toOptionArray($local);
        foreach ($check as $data) {
            return $data;
        }
        return $local;
    }
}
