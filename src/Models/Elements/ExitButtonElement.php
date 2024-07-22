<?php

namespace NSWDPC\ExitButton\Models\Elements;

use Codem\Utilities\HTML5\UrlField;
use DNADesign\Elemental\Models\BaseElement;
use NSWDPC\ExitButton\Models\ExitButton;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;

/**
 * Provide an exit button element
 * @author James
 */
class ExitButtonElement extends BaseElement {

    /**
     * @inheritdoc
     */
    private static $table_name = 'ExitButtonElement';

    /**
     * @inheritdoc
     */
    private static $icon = 'font-icon-logout';

    /**
     * @inheritdoc
     */
    private static $inline_editable = true;

    /**
     * @inheritdoc
     */
    private static $singular_name = 'Exit button';

    /**
     * @inheritdoc
     */
    private static $plural_name = 'Exit buttons';

    /**
     * @inheritdoc
     */
    private static $db = [
        'ExitURL' => 'Varchar(255)'
    ];

    /**
     * @inheritdoc
     */
    private static $title = 'Exit button';

    /**
     * @inheritdoc
     */
    private static $description = 'Display a page exit button';

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return _t('ExitButton.BLOCK_TYPE', 'Exit button');
    }

    /**
     * Return a rendered template for this model
     */
    public function forTemplate($holder = true) {
        $data = [];
        $button = ExitButton::create();
        $button->setId($this->getAnchor() . '-exit-button');
        if($this->ExitURL) {
            $button->setExitUrl($this->ExitURL);
        }
        $data['ExitButton'] = $button;
        return $this->customise(ArrayData::create($data))->renderWith(static::class);
    }

    /**
     * CMS fields for element
     */
    public function getCmsFields() {
        $fields = parent::getCmsFields();
        $fields->addFieldToTab(
            'Root.Main',
            UrlField::create(
                'ExitURL',
                _t('ExitButton.EXIT_URL', 'Exit URL')
            )->restrictToHttps()
            ->setRequiredParts(['scheme','host'])
        );
        return $fields;
    }
}
