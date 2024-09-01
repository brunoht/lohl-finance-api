# Command

Adiciona funcionalidades ao Artisan Console do Laravel.

## Form

É possível criar formulários rapidamente para serem utlizados como meio de interação com o usuário através do terminal (linha de comando). Com poucos passos, é possível ter um formulário completo capaz de Adicionar (CREATE) ou Editar (UPDATE) objetos que serão persistidos no banco de dados, assim como um formulário HTML.

Um Form nada mais é do que um Command do Artisan Console que implementa uma interface FormInterface e instancia um Objeto Form.

## Criando um Form

Para criar um Form é necessário ter uma classe que extende Command exclusiva para este form.

```shell
php artisan make:command ConsumerForm
```

Você precisa informar ao Command que ele deve se comportar como um Form. Para isso, abra o arquivo gerado e edite conforme o exemplo abaixo:

```php
<?php

namespace App\Console\Commands;


use App\Actions\Command\Form;

use App\Interfaces\FormInterface;

use Illuminate\Console\Command;


class ConsumerForm extends Command implements FormInterface
{
    protected $signature = 'app:consumer-form';

    protected $description = 'Create a new customer';


    public function handle()
    {
        $form = new Form($this);

        $form->run();

        return 0;
    }


    /**
     * Set the data
     *
     * @return array
     */
    public function data() : array
    {
        return [];
    }


    /**
     * Set the title (optional)
     *
     * @return string
     */
    public function title() : string
    {
        return "Title";
    }


    /**
     * Set the labels (optional)
     *
     * @return array
     */
    public function labels() : array
    {
        return [];
    }


    /**
     * Set the rules (optional)
     *
     * @return array
     */
    public function rules() : array
    {
        return [];
    }


    /**
     * Action called when the form is submitted
     *
     * @param array $data
     * @return void
     */
    public function onSubmit(array $data): void
    {
        // implement here
    }
}
```

Explicação:

Nas linhas 26 e 27 foram adicionadas as importações de classe e da interface do Form. Nas linhas 38 e 39 o Form foi instanciado e o método run() faz a chamada que exibe o formulário no terminal. A partir da linha 43 em diante foram implementados os métodos que estão presentes na interface do Form.

A seguir, vamos entender o que cada método é responsável e como eles serão utilizados para a preparação e funcionamento do formulário.

## Data

O método data deve implementar um array no formato $key => $value, onde $key é o nome do campo do formulário e $value é o valor inicial deste campo. 

> Por padrão, um Form tem o comportamente de criação de objetos (CREATE), mas abordaremos mais tarde como alterar isso.

Perceba que esta será a estrutura do seu formulário. Uma vez que o campo foi adicionado em data() ele sempre estará visível no Form.

```php
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
```

## Intância do Form

A instância da classe Form permite diversas configurações que personalizarão o comportamento do seu formulário.

```php
$form = new Form(Command $command, string $method, bool $showAll, int $sleep, bool $reveal);
```

### Command $command (Obrigatório)

É obrigatório informar ao Form o próprio objeto Command onde o formulário está sendo implemetado.

Esta é a assinatura padrão para instanciar um Form:

```php
$form = new Form($this)
```

### string $method

O parãmetro $method define se o formulário será utilizado para Criar (CREATE) ou Editar (UPDATE) um objeto. Por padrão, este valor está definido como CREATE.

```php
// CREATE

$form = new Form($this, Form::METHOD_CREATE)


// UPDATE

$form = new Form($this, Form::METHOD_UPDATE)
```

Perceba que o próprio Form já fornece as constantes permitidas neste parâmetro.

- **Form::METHOD_CREATE** -> define que o formulário terá comportamento de criação de dados. É semelhante ao método POST no HTML.

- **Form::METHOD_UPDATE** -> define que o formulário terá comportamento de edição de dados. É semelhrante ao método PUT no HTML.

### bool $showAll

Este parâmetro define a forma como os erros de validação dos campos do formulário serão exibidos.

```php
// Exibe apenas a primeira regra não atendida (padrão)
$form = new Form($this, Form::METHOD_CREATE, false)

// Exibe todas as regras não atendidadas de uma só vez
$form = new Form($this, Form::METHOD_CREATE, true)
```

### int $sleep

Define o tempo (em segundos) que uma mensagem de status deve permanecer na tela até que o fluxo do formulário prossiga.

Por padrão, este valor está definido para 1 segundo.

```php
$form = new Form($this, Form::METHOD_CREATE, false, 1)
```

### bool $reveal

Define o comportamento de campos de senha. Quando um campo tiver o nome "password", por padrão, os dados armazenados neste campo ficam ocultos na tela do formulário e, no modo de edição do campo, os valores digitados no terminal não aparecem e ainda será exigida dupla verificação para garantir que o campo contém exatamente o valor desejado pelo usuário.

```php
// Oculta os valores de campos de senha
$form = new Form($this, Form::METHOD_CREATE, false, 1, false)

// Revela os valores de campos de senha
$form = new Form($this, Form::METHOD_CREATE, false, 1, true)
```

### Parâmetros nas opções do Comando

Você pode permitir que todos esses parâmetros sejam definidos no momento em que o comando é chamado no terminal. Veja um exemplo.

> Vale ressaltar que este é apenas um exemplo de implementação. Personalize conforme necessidade.

```php
protected $signature = 'customer:create {--a|all : List all validation errors} {--s|sleep=1 : Sleep time (seconds)} {--r|reveal : Reveal the password}';


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
```

## Titulo do Form

Informe o nome no Singular do objeto que está sendo manipulando pelo formulário. Se você deixar em branco o formulário ocultará o título e como retorno do evento de submit, exibirá uma mensagem padrão.

```php
/**
 * Set the title (optional)
 *
 * @return string
 */
public function title() : string
{
    return "Consumer";
}
```

## Labels

Você deve ter notado que o Form converte automaticamente os nomes de campo que estão no formato nome_do_campo para Nome Do Campo. Mesmo este recurso ser automático, você pode sobrescever essa automação informando exatamente o nome desejado para o campo.

Não é obrigatório sobrescrever todos os campos. Você só precisa colocar neste array os campos que terão o label substituído. Os que não estiverem presentes neste array, permanecerão os valores gerados pela automação.

```php
/**
 * Set the labels (optional)
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
```

## Rules

O método rules() define as regras de validação dos campos do formulário.

O array deve ser montado no formato $key => $value, onde $key é o nome do campo e $value é uma string com as regras definidas para aquele campo.

Cada regra de validação deve ser separada por | e não pode conter espaços entre elas.

Não é obrigatório listar todos os campos. Você só precisa colocar neste array os campos que terão alguma regra específica de validação. Os campos que não estiverem presentes neste array aceitarão qualquer valor informado pelo usuário.

```php
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
```

### Regras disponíveis

- required
- string
- integer
- numeric
- email
- unique:[table],[field]
- min:[number]
- max:[number]
- min_words:[number]
- max_words:[number]
- date_format:[dateformat]
- phone
- whatsapp
- cpf

#### required

Torna o campo obrigatório, desta forma o usuário será obrigado a preenchê-lo com algum valor.

#### string

Torna o campo somente texto. Se o usuário informar um número, por exemplo, o campo se torna inválido.

#### integer

Torna o campo somente número inteiro. Se o usuário colocar outro valor ou texto, o campo se torna inválido.

#### email

Verifica se o input do usuário respeita o formato de email. Caso contrário, o campo se torna inválido.

#### unique

Verifica se o valor de um campo já existe no banco de dados. Para isso, são necessários dois parâmetros: nome da tabela do banco de dados, campo da tabela a ser buscado o valor. Se houver algum registro na table e campo informado, invalida o campo.

```php
['email' => 'required|email|unique:users,email']
```

#### min

Define o número mínimo de caracteres que o campo deve ter. Abaixo disso invalida o campo. É necessário informar a quantidade desejada como parãmetro.

```php
// o campo description deve ter no mínimo 100 caracteres digitados
['description' => 'min:100']
```

#### max

Define o tamanho máximo de caracteres que um campo deve ter. Acima disso invalida o campo.

```php
// o campo description deve ter no mínimo 100 caracteres digitados e no máximo 300 caracteres
['description' => 'min:100|max:300']
```

#### min_words

Define a quantidade mínima de palavras no campo. Abaixo disso, invalida o campo.

```php
// Define que o campo nome precisa ter, no mínimo, duas palavas (nome e sobrenome)
['name' => 'required|min_words:2']
```

#### max_words

Define a quantidade máxima de palavras no campo. Acima disso, invalida o campo.

```php
// Define que o campo nome precisa ter, no mínimo e no máximo, duas palavas (nome e sobrenome)
['name' => 'required|min_words:2|max_words:2']
```

#### date_format

Define que o campo deva conter uma data seguindo um formato específico. Este formato deve ser informado como parâmetro da regra. Caso a data informada não atenda esse padrão, o campo é invalidado.

```php
// Define que o campo seja uma data no formato dd/mm/aaaa
'birthdate' => 'required|date_format:d/m/Y',
```

#### phone

Define que o campo seja um telefone no formato 0000000000 (telefone fixo) ou 00000000000 (celular com o digito adicional).

#### whatsapp

Define que o campo seja um número whatsapp de 11 caracteres.

#### cpf

Define que o campo respeite o formato 000.000.000-00.


## Validation Rules

Uma Validation Rule é um método especial dentro da classe Form que verifica e valida se um valor de um input do terminal segue uma regra ou padrão. Caso a regra não seja atentida, o campo, portanto, deve ser invalidado.

#### Caller

Toda Validation Rule tem um CALLLER que é o nome que será utilizado na regra de um campo que chama a regra desejada. Um exemplo de caller é o required, ou seja, uma regra criada deve ter o caller exatamente da forma como será utilizada na regra do campo.

### Criando novas Validation Rules

É possível criar novas regras implementando-as na classe Form. Uma regra precisa seguir o seguinte padrão:

```php
private function rule_[caller]($key, $value, $label, $params) : void
{
    // do something
    return;
}
```

- rule_: é um prefixo obrigatório que sempre deve estar presente de forma a indetificar que aquele método é uma Validation Rule
- caller: é o nome da regra, a forma como será chamada em um array de regras
- $key: nome do campo
- $value: é o valor do input que será testado para saber se atende ou não a regra
- $label: é o nome amigável de um campo (é o que é exibido no lugar do nome campo do bd)
- $params: são os parãmetros que a regra precisa para poder realizar a validação

```php
// implementação da regra unique

private function rule_unique($key, $value, $label, $params) : void
{
    if (empty($value)) return;

    if (DB::table($params[0])->where($params[1], $value)->exists()) 
    {
        $this->validation[$key][] = $label . ' already exists';
    
        $this->isValid = false;
    }
}
```
