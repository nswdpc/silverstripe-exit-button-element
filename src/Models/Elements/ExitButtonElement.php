<?php

namespace NSWDPC\ExitButton\Models\Elements;

use Codem\Utilities\HTML5\UrlField;
use DNADesign\Elemental\Models\BaseElement;
use NSWDPC\ExitButton\Models\ExitButton;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TextField;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;

/**
 * Provide an exit button element
 * @author James
 * @property ?string $ExitURL
 * @property ?string $Label
 * @property bool $UseEsc
 */
class ExitButtonElement extends BaseElement {

    /**
     * @inheritdoc
     */
    private static string $table_name = 'ExitButtonElement';

    /**
     * @inheritdoc
     */
    private static string $icon = 'font-icon-logout';

    /**
     * @inheritdoc
     */
    private static bool $inline_editable = true;

    /**
     * @inheritdoc
     */
    private static string $singular_name = 'Exit button';

    /**
     * @inheritdoc
     */
    private static string $plural_name = 'Exit buttons';

    /**
     * @inheritdoc
     */
    private static array $db = [
        'ExitURL' => 'Varchar(255)',
        'Label' => 'Varchar(255',
        'UseEsc' => 'Boolean'
    ];

    /**
     * @inheritdoc
     */
    private static string $title = 'Exit button';

    /**
     * @inheritdoc
     */
    private static string $description = 'Display a page exit button';

    /**
     * @inheritdoc
     */
    #[\Override]
    public function getType()
    {
        return _t('ExitButton.BLOCK_TYPE', 'Exit button');
    }

    /**
     * Return a rendered template for this model
     */
    #[\Override]
    public function forTemplate($holder = true) {
        $data = [];
        $button = ExitButton::create();
        $button->setId($this->getAnchor() . '-exit-button');
        $button->setLabel($this->Label ?? '');
        $button->setUseEsc($this->UseEsc == 1);
        if($this->ExitURL) {
            $button->setExitUrl($this->ExitURL);
        }

        $data['ExitButton'] = $button;
        return $this->customise(ArrayData::create($data))->renderWith(static::class);
    }

    /**
     * CMS fields for element
     */
    #[\Override]
    public function getCmsFields() {
        $fields = parent::getCmsFields();
        $fields->addFieldsToTab(
            'Root.Main',
            [
                UrlField::create(
                    'ExitURL',
                    _t('ExitButton.EXIT_URL', 'Exit URL')
                )->restrictToHttps()
                ->setRequiredParts(['scheme','host']),
                TextField::create(
                    'Label',
                    _t('ExitButton.EXIT_LABEL', 'Label for button')
                ),
                CheckboxField::create(
                    'UseEsc',
                    _t('ExitButton.EXIT_ENABLE_DOUBLE_ESCAPE', 'Enable double escape keypress')
                )
            ]
        );
        return $fields;
    }
}
