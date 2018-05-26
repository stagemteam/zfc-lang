<?php
namespace Stagem\ZfcLang\Form\Admin;

use Zend\Form\Form;
use Zend\I18n\Translator\TranslatorAwareInterface;
use Stagem\ZfcLang\TranslatorAwareTrait;

class LangForm extends Form implements TranslatorAwareInterface
{
    use TranslatorAwareTrait;

    public function init() {
        $this->setName('lang');

        $this->add([
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
        ]);

        $this->add([
            'name' => 'mnemo',
            'type' => 'text',
            'attributes' => [
                'placeholder' => $this->getTranslator()->translate('Example: uk ...'),
            ],
            'options' => [
                'label' => $this->getTranslator()->translate('Enter mnemo ...'),
            ]
        ]);

        $this->add([
            'name' => 'locale',
            'type' => 'text',
            'attributes' => [
                'placeholder' => $this->getTranslator()->translate('Example: uk_UA ...'),
            ],
            'options' => [
                'label' => $this->getTranslator()->translate('Enter locale ...'),
            ]
        ]);

        $this->add([
            'name' => 'name',
            'type' => 'text',
            'attributes' => [
                'placeholder' => $this->getTranslator()->translate('Example: Українська ...'),
            ],
            'options' => [
                'label' => $this->getTranslator()->translate('Enter locale ...'),
            ]
        ]);

        $this->add([
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'isActive',
            'options' => [
                //'label' => $this->translate('Right'),
                'label' => 'Active',
                'use_hidden_element' => true,
                'checked_value' => 1,
                'unchecked_value' => 0,
            ],
            'attributes' => [
                //'value' => '0',
                'class' => 'form-control',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => $this->translate('Save'),
                'class' => 'btn btn-primary',
            ]
        ]);
    }

    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return [];
    }
}