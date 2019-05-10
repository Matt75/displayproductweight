<?php
/**
 * 2007-2019 PrestaShop SA and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2019 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0  Academic Free License (AFL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class DisplayProductWeight extends Module implements WidgetInterface
{
    /**
     * @var array List of hooks you use
     */
    public $hooks = [
        'displayProductPriceBlock',
    ];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->name = 'displayproductweight';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Matt75';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7.0.0',
            'max' => '1.7.99.99',
        ];

        parent::__construct();

        $this->displayName = $this->l('Display product weight');
        $this->description = $this->l('Adds product weight on product page and product card');
    }

    /**
     * Install Module
     *
     * @return bool
     */
    public function install()
    {
        return parent::install()
            && $this->registerHook($this->hooks);
    }

    /**
     * Display on front office by Hook name
     *
     * @param string $hookName
     * @param array $configuration
     *
     * @return string
     */
    public function renderWidget($hookName, array $configuration)
    {
        if ('displayProductPriceBlock' === $hookName
            && isset($configuration['type'])
            && 'weight' === $configuration['type']
        ) {
            $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));

            return $this->display(__FILE__, 'displayProductPriceBlock.tpl');
        }

        return '';
    }

    /**
     * Get Smarty variables for rendering by Hook name
     *
     * @param string $hookName
     * @param array $configuration
     *
     * @return array
     */
    public function getWidgetVariables($hookName, array $configuration)
    {
        return [
            'weight' => $configuration['product']['weight'] ? sprintf('%.3f', $configuration['product']['weight']) : 0,
            'weight_unit' => Configuration::get('PS_WEIGHT_UNIT'),
        ];
    }
}
