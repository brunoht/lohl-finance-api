<?php

namespace App\Actions\Command;

use App\Interfaces\FormInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Form
{
    const METHOD_CREATE = 'POST';
    const METHOD_UPDATE = 'PUT';

    /**
     * Command instance
     *
     * @var Command
     */
    private Command $command;

    /**
     * Validation errors
     *
     * @var array
     */
    private array $validation = [];

    /**
     * Is the data valid?
     *
     * @var bool
     */
    private bool $isValid = false;

    /**
     * Sleep time (seconds)
     *
     * @var int
     */
    private int $sleep;

    /**
     * The title of the form
     *
     * @var string|null
     */
    private string|null $title;

    /**
     * The data of the form
     *
     * @var array
     */
    private array $data;

    /**
     * The rules of the form
     *
     * @var array
     */
    private $rules;

    /**
     * The labels of the form
     *
     * @var array
     */
    private $labels;

    /**
     * Show all validation errors
     *
     * @var bool
     */
    private bool $showAll;

    /**
     * Reveal the password
     *
     * @var bool
     */
    private bool $reveal;

    /**
     * The method of the form. POST or PUT
     */
    private string $method;

    /**
     * Instantiate the form
     *
     * @param Command $command
     * @param bool $showAll
     * @param int $sleep
     * @param bool $reveal
     * @param string $method
     */
    public function __construct(
        Command $command,
        bool $showAll = false,
        int $sleep = 1,
        bool $reveal = false,
        string $method = self::METHOD_CREATE
    ) {
        $this->command = $command;
        $this->showAll = $showAll;
        $this->title = null;
        $this->sleep = $sleep;
        $this->reveal = $reveal;
        $this->method = $method;
    }

    /**
     * Run the form
     */
    public function run() : void
    {
        // check if Command implemetns FormInterface
        if (!($this->command instanceof FormInterface)) {
            $this->command->error('Class must implement FormInterface');
            return;
        }

        // prepare the form
        $this->title = $this->command->title();
        $this->data = $this->command->data();
        $this->labels = $this->command->labels();
        $this->rules = $this->command->rules();

        do {
            system('clear'); // clear the console

            // show the title
            if (!$this->title || $this->title === "Data") {
                $this->title = "Data";
            } else {
                $message = $this->method === self::METHOD_CREATE ? 'Create a new ' : 'Update a ';
                $this->command->info($message . $this->title);
                $this->command->newLine();
            }

            // show the data
            $this->command->table(
                ['#', 'Field', 'Value'],
                $this->dataToTable($this->data)
            );
            $this->command->newLine();

            // validate the new data
            $this->validate($this->data);

            // ask for the field to change
            $key = $this->command->ask('Field # (Press Enter to submit)');

            // when digit a number, find the key by the number
            if (is_numeric($key)) {
                $key = array_keys($this->data)[$key - 1];
            }

            // update the field and finish process
            if (!$finish = empty($key))
            {
                if (array_key_exists($key, $this->data))
                {
                    system('clear'); // clear the console

                    // get the label
                    $label = $this->labels[$key] ?? $this->convertText($key);

                    // get the value
                    if (!$this->reveal && $key === 'password')
                    {
                        $password = $this->command->secret($label . ':');
                        $repeat = $this->command->secret('Repeat ' . $label . ':');

                        // check if the passwords match
                        if ($password === $repeat) $value = $password;
                        else
                        {
                            // show the error message
                            $this->command->error('Passwords do not match');
                            sleep($this->sleep);
                            continue;
                        }
                    }
                    else
                    {
                        // get the value
                        $value = $this->command->ask($label . ' (NULL to clear field)', $this->data[$key]);
                    }

                    // convert Null to null
                    if ($value === "Null" || $value === "null" || $value === "NULL") $value = null;

                    // update the data
                    $this->data[$key] = $value;
                    $this->command->info($label . ' updated successfully');

                    // wait a few seconds
                    sleep($this->sleep);
                }
                else $this->command->error('Invalid key');
            }
            else $confirmFinish = $this->command->confirm('Do you want to finish?', false);

        } while (!$finish || !$confirmFinish);

        // define the method
        $method = $this->method === self::METHOD_CREATE ? 'created' : 'updated';

        if ($this->isValid)
        {
            // submit the data
            $this->command->onSubmit($this->data);

            // show the success message
            $message = "{$this->title} {$method} successfully";
            $this->command->info($message);
        }
         else
         {
            // show the error message
            $message = "{$this->title} not {$method}. Invalid data.";
            $this->command->error($message);
        }
    }

    /**
     * Validate the new data
     *
     * @return bool
     */
    protected function validate(array $data): bool
    {
        // reset validation
        $this->isValid = true;
        $this->validation = [];

        // apply validation rules
        $this->validationRules();

        // print validation errors
        if (count($this->validation) > 0) {
            $this->command->alert('Validation errors');

            foreach ($this->validation as $field => $errors) {
                // show the field name
                if ($this->showAll) $this->command->error($this->labels[$field] ?? $this->convertText($field));

                // to show the field only once
                $attempted = false;

                // show the errors
                foreach ($errors as $error) {
                    if(!$attempted) {
                        $this->command->info(' - ' . $error);
                        if (!$this->showAll) $attempted = true;
                    }
                }
            }
        }

        // return if the data is valid
        return $this->isValid;
    }

    /**
     * Add a new rule
     *
     * @param string $key
     * @param string $rule
     * @return $this
     */
    public function addRule(string $key, string $rule)
    {
        $this->rules[$key] = $rule;
        return $this;
    }

    /**
     * Convert the text to a readable format
     *
     * @param string $text
     * @return string
     */
    protected function convertText(string $text): string
    {
        // convert _ to space
        $text = str_replace('_', ' ', $text);

        // convert each word to uppercase
        $text = ucwords($text);

        return $text;
    }

    /**
     * Convert the data to a table format
     *
     * @param array $data
     * @return array
     */
    protected function dataToTable(array $data): array
    {
        $count = 1;
        $table = [];
        foreach ($data as $key => $value) {
            if (!$this->reveal && $key === 'password') $value = str_repeat('*', strlen($value));
            $table[] = [$count++, $this->labels[$key] ?? $this->convertText($key), $value];
        }
        return $table;
    }

    /**
     * Call the validation rules
     */
    private function validationRules()
    {
        // loop through the rules
        foreach ($this->rules as $key => $rule) {
            $value = $this->data[$key];
            $label = $this->labels[$key] ?? $this->convertText($key);

            // break every rule by |
            $rules = explode('|', $rule);

            foreach($rules as $rule) {

                // break every rule by : and create parameters
                $param = explode(':', $rule);

                // get the rule
                $rule = $param[0];

                // break parameters by , and create parameters
                $params = explode(',', $param[1] ?? '');

                if (!method_exists($this, 'rule_' . $rule)) {
                    $this->command->error('Rule ' . $rule . ' does not exist');
                    continue;
                }

                // call the rule method
                call_user_func([$this, 'rule_' . $rule], $key, $value, $label, $params);
            }
        }
    }

    /* ===================================================================== */
    /*                             VALIDATION RULES                          */
    /* ===================================================================== */

    private function rule_required($key, $value, $label, $params) : void
    {
        if (empty($value)) {
            $this->validation[$key][] = $label . ' is required';
            $this->isValid = false;
        }
    }

    private function rule_string($key, $value, $label, $params) : void
    {
        if(empty($value)) return;
        if (!is_string($value)) {
            $this->validation[$key][] = $label . ' must be a string';
            $this->isValid = false;
        }
    }

    private function rule_integer($key, $value, $label, $params) : void
    {
        if(empty($value)) return;
        if (!is_numeric($value)) {
            $this->validation[$key][] = $label . ' must be an integer';
            $this->isValid = false;
        }
    }

    private function rule_numeric($key, $value, $label, $params) : void
    {
        if(empty($value)) return;
        if (!is_numeric($value)) {
            $this->validation[$key][] = $label . ' must be a number';
            $this->isValid = false;
        }
    }

    private function rule_email($key, $value, $label, $params) : void
    {
        if(empty($value)) return;
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->validation[$key][] = $label . ' format is invalid';
            $this->isValid = false;
        }
    }

    private function rule_unique($key, $value, $label, $params) : void
    {
        if(empty($value)) return;
        if (DB::table($params[0])->where($params[1], $value)->exists()) {
            $this->validation[$key][] = $label . ' already exists';
            $this->isValid = false;
        }
    }

    private function rule_min($key, $value, $label, $params) : void
    {
        if(empty($value)) return;
        $min = $params[0];
        if (strlen($value) < $min) {
            $this->validation[$key][] = $label . ' must have at least ' . $min . ' characters';
            $this->isValid = false;
        }
    }

    private function rule_max($key, $value, $label, $params) : void
    {
        if(empty($value)) return;
        $max = $params[0];
        if (strlen($value) > $max) {
            $this->validation[$key][] = $label . ' must have at most ' . $max . ' characters';
            $this->isValid = false;
        }
    }

    private function rule_format($key, $value, $label, $params) : void
    {
        if(empty($value)) return;
        if (count(explode(" ", $value)) < 2) {
            $this->validation[$key][] = $label . ' must have at least 2 words';
            $this->isValid = false;
        }
    }

    private function rule_min_words($key, $value, $label, $params) : void
    {
        if(empty($value)) return;
        $min = $params[0];
        if (count(explode(" ", $value)) < $min) {
            $this->validation[$key][] = $label . ' must have at least ' . $min . ' words';
            $this->isValid = false;
        }
    }

    private function rule_max_words($key, $value, $label, $params) : void
    {
        if(empty($value)) return;
        $max = $params[0];
        if (count(explode(" ", $value)) > $max) {
            $this->validation[$key][] = $label . ' must have at most ' . $max . ' words';
            $this->isValid = false;
        }
    }

    private function rule_cpf($key, $value, $label, $params) : void
    {
        if(empty($value)) return;
        if (!preg_match('/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/', $value)) {
            $this->validation[$key][] = $label . ' format is invalid. Use 000.000.000-00';
            $this->isValid = false;
        }
    }

    private function rule_date_format($key, $value, $label, $params) : void
    {
        if(empty($value)) return;
        if (!preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $value)) {
            $this->validation[$key][] = $label . ' format is invalid. Use dd/mm/yyyy';
            $this->isValid = false;
        }
    }

    private function rule_whatsapp($key, $value, $label, $params) : void
    {
        if(empty($value)) return;
        if (!preg_match('/^\d{11}$/', $value)) {
            $this->validation[$key][] = $label . ' format is invalid. Use 00000000000';
            $this->isValid = false;
        }
    }

    private function rule_phone($key, $value, $label, $params) : void
    {
        if(empty($value)) return;
        if (!preg_match('/^\d{10,11}$/', $value)) {
            $this->validation[$key][] = $label . ' format is invalid. Use 0000000000 or 00000000000';
            $this->isValid = false;
        }
    }

    private function rule_nullable($key, $value, $label, $params) : void
    {
        // do nothing
        return;
    }
}
