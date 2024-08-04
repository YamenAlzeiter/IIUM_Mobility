<?php

namespace common\components;

use Yii;
use yii\base\Widget;
use yii\bootstrap5\Html;

class WizardWidget extends Widget
{
    public $steps = [];
    public $content;

    public function init()
    {
        parent::init();
        if (empty($this->steps)) {
            $this->steps = [];
        }
    }

    public function run()
    {
        return Html::tag('div',
            $this->renderWizardContainer(),
            ['id' => 'page', 'class' => 'site']
        );
    }

    protected function renderWizardContainer()
    {
        return Html::tag('div',
            Html::tag('div',
                $this->renderWizardProgress() . $this->renderWizardForm(),
                ['class' => 'wizard-form-box']
            ),
            ['class' => 'wizard-container']
        );
    }

    protected function renderWizardProgress()
    {
        $stepsHtml = '';
        foreach ($this->steps as $index => $step) {
            $class = $index === 0 ? 'step active' : 'step'; // Make the first step active by default
            $stepsHtml .= Html::tag('li',
                Html::tag('span', $step['number']) . Html::tag('p', $step['label']),
                ['class' => $class]
            );
        }

        return Html::tag('div',
            Html::tag('ul', $stepsHtml, ['class' => 'wizard-progress-steps']),
            ['class' => 'wizard-progress']
        );
    }

    protected function renderWizardForm()
    {
        return Html::tag('div', $this->content, ['class' => 'wizard-form']);
    }
}
