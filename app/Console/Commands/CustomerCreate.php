<?php

namespace App\Console\Commands;

use App\Actions\Command\Form;
use App\Helpers\Date;
use App\Helpers\Password;
use App\Interfaces\FormInterface;
use App\Models\User;
use Illuminate\Console\Command;

class CustomerCreate extends Command implements FormInterface
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer:create {--a|all : List all validation errors} {--s|sleep=1 : Sleep time (seconds)} {--r|reveal : Reveal the password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new customer';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Set the method
        $method = Form::METHOD_CREATE;

        // Get options
        $showAll = $this->option('all');
        $sleep = $this->option('sleep');
        $reveal = $this->option('reveal');

        // Create a new form
        $form = new Form($this, $method, $showAll, $sleep, $reveal);

        // Run the form
        $form->run();

        return 0;
    }

    /**
     * Set the title
     *
     * @return string
     */
    public function title() : string
    {
        return "Customer";
    }

    /**
     * Set the data
     *
     * @return array
     */
    public function data() : array
    {
        return [
            'name' => '',
            'email' => '',
            'whatsapp' => '',
            'cpf' => '',
            'password' => Password::generate(),
            'birthdate' => '',
            'phone_01' => '',
            'phone_02' => '',
            'address' => '',
            'address_number' => '',
            'address_complement' => '',
            'address_neighborhood' => '',
            'address_postcode' => '',
            'address_city' => '',
            'address_state' => '',
            'address_country' => 'Brasil',
        ];
    }

    /**
     * Set the labels
     *
     * @return array
     */
    public function labels() : array
    {
        return [
            'name' => 'Nome',
            'cpf' => 'CPF',
            'password' => 'Senha',
            'birthdate' => 'Data Nascimento',
            'phone_01' => 'Fone 01',
            'phone_02' => 'Fone 02',
            'address' => 'Logradouro',
            'address_number' => 'Número',
            'address_complement' => 'Complemento',
            'address_neighborhood' => 'Bairro',
            'address_postcode' => 'CEP',
            'address_city' => 'Cidade',
            'address_state' => 'Estado',
            'address_country' => 'País',
        ];
    }

    /**
     * Set the rules
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'name' => 'required|min_words:2',
            'email' => 'required|email|unique:users,email',
            'whatsapp' => 'required|whatsapp',
            'cpf' => 'required|cpf|unique:users,cpf',
            'password' => 'required',
            'birthdate' => 'required|date_format:d/m/Y',
            'phone_01' => 'phone',
            'phone_02' => 'phone',
        ];
    }

    /**
     * Action called when the form is submitted
     *
     * @param array $data
     * @return void
     */
    public function onSubmit(array $data): void
    {
        // Create a new user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'whatsapp' => $data['whatsapp'],
            'password' => bcrypt($data['password']),
            'cpf' => $data['cpf'],
        ]);

        // Create a new customer
        $user->customer()->create([
            'user_id' => $user->id,
            'birthdate' => Date::formatFromConsole($data['birthdate']),
            'phone_01' => $data['phone_01'],
            'phone_02' => $data['phone_02'],
            'address' => $data['address'],
            'address_number' => $data['address_number'],
            'address_complement' => $data['address_complement'],
            'address_neighborhood' => $data['address_neighborhood'],
            'address_postcode' => $data['address_postcode'],
            'address_city' => $data['address_city'],
            'address_state' => $data['address_state'],
            'address_country' => $data['address_country'],
        ]);
    }
}
