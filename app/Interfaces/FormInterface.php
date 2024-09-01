<?php

namespace App\Interfaces;

use App\Actions\Command\Form;

interface FormInterface
{
    /**
     * Set the title
     *
     * @return string
     */
    public function title() : string;

    /**
     * Set the data
     *
     * @return array
     */
    public function data() : array;

    /**
     * Set the labels
     *
     * @return array
     */
    public function labels() : array;

    /**
     * Set the rules
     *
     * @return array
     */
    public function rules() : array;

    /**
     * Action called when the form is submitted
     *
     * @param array $data
     * @return void
     */
    public function onSubmit(array $data): void;
}
