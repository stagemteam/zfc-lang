<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2018 Stagem Team
 * This source file is subject to The MIT License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 *
 * @category Stagem
 * @package Stagem_Question
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace Stagem\ZfcLang\Block\Grid;

use Popov\ZfcDataGrid\Block\AbstractGrid;

class LangGrid extends AbstractGrid
{
    protected $backButtonTitle = '';

    public function init()
    {
        $grid = $this->getDataGrid();
        $grid->setId('lang');
        $grid->setTitle('Languages');

        $rendererOptions = $grid->getToolbarTemplateVariables();

        $rendererOptions['navGridDel'] = true;
        $rendererOptions['inlineNavCancel'] = true;
        $rendererOptions['navGridRefresh'] = true;

        $grid->setToolbarTemplateVariables($rendererOptions);

        $colId = $this->add([
            'name' => 'Select',
            'construct' => ['id', 'lang'],
            'identity' => true,
        ])->getDataGrid()->getColumnByUniqueId('lang_id');

        $this->add([
            'name' => 'Select',
            'construct' => ['name', 'lang'],
            'label' => 'Name',
            'identity' => false,
            'width' => 3,
        ]);

        $this->add([
            'name' => 'Select',
            'construct' => ['locale', 'lang'],
            'label' => 'Locale',
            'identity' => false,
            'width' => 3,
        ]);

        $this->add([
            'name' => 'Select',
            'construct' => ['isActive', 'lang'],
            'label' => 'Active',
            'identity' => false,
            'width' => 1,
            'filter_select_options' => [[
                '0' => 'No',
                '1' => 'Yes',
            ]],
        ]);

        $this->add([
            'name' => 'Action',
            'construct' => ['edit'],
            'label' => ' ',
            'width' => 1,
            'formatters' => [[
                'name' => 'Link',
                'attributes' => ['class' => 'pencil-edit-icon', 'target' => '_blank'],
                'link' => ['href' => '/admin/lang/edit', 'placeholder_column' => $colId]
            ]],
        ]);

        return $this;
    }
}