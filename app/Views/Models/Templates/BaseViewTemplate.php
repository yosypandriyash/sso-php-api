<?php

namespace App\Views\Models\Templates;

abstract class BaseViewTemplate implements ViewTemplateInterface {

    protected string $template;

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }
}