# Laravel Estudos
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sobre o Laravel Mastery

Curso de laravel da plataforma [Code Experts](https://codeexperts.com.br/). Instrutor Nanderson Castro.

### Recursos e Ferramentas
- [Laravel versão 8](https://laravel.com/)
- [Vscode](https://code.visualstudio.com/)
- [Dbeaver](https://dbeaver.io/ )

## Projeto

**Projeto inicial: meusEventos**

- Instalando o laravel via composer
> composer global require laravel/installer

- Criar um projeto no laravel
> laravel new meusEventos

- Executar o servidor embutido
> php artisan serve 

- Criar um arquivo de migração
> php artisan make:migration create_events_table

- Rodando as migrations
> php artisan migrate

- Criando um model
> php artisan make:model Event

- Tinker - Terminal do laravel. Ótima ferramenta para depurar código.
> php artisan tinker

---
Trabalhando com factory e Seeds
Criando uma factory
> php artisan make:factory EventFactory

Lembrando que a Factory fica conectada ao nosso Model, nesse caso *Event*

Criando a seed *user* e *event*
> php artisan make:seed UserTableSeeder
> php artisan make:seed UserTableSeeder

Alterando a table *event*
> php artisan make:migration alter_events_table_add_column_slug --table=events

Atualizando e apagando 
> php artisan migrate:refresh --seed
--- 
### Eloquent
Active record 

	$event = new \App\Model\Event();
	$event->title = "Evento";
	$event->description = "Descrição do evento";
	$event->body = "corpo do evento";
	$event->start_event = date('Y-m-d H:i:s');
	$event->slug = \Illuminate\Support\Str::slug($event->title);
	 
	$event->save();
 

Mass Assignment

	$event = [
		'title' => 'Titulo',
		'description'=> 'descricao',
		'body' => 'corpo',
		'slug' => '',
		'start_event' => date('Y-m-d H:i:s')
	];
	
	\App\Model\Event::create($event);

É necessário configurar o fillable
| protected $fillable = ['title', 'description', 'body', 'start_event', 'slug'];


### Controler
Event
> php artisan make:controller EventController

Criando a tabela *profile*
> php artisan make:model Profile -m

	Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->text('about')->nullable();
            $table->string('phone', 15)->nullable();
            $table->text('social_network')->nullable();
            $table->timestamps();
        });

### Criando novas factores e usando o tinker

> php artisan make:factory PhotoFactory

Método *Definition*

	'photo' => $this->faker->imageUrl(),

> php artisan make:factory ProfileFactory

Método *Definition*

	'about' => $this->faker->paragraph,
	'phone' => $this->faker->phoneNumber,
	'social_network' => 'facebook-twitter-instagram'

No tinker

> namespace App\Models

Gerando via factory dados, mas não persiste como utilizado com o métido *create()*
> Photo::factory()->make()

Usando as factores como relacionamento entre as tabelas

Criando um evento com três fotos
> Event::factory()->has(Photo::factory(3))->create()

Método *has* pode ser usado tanto para relacionamento 1:1, 1:n e n:m
Pode ser simplificado

> Event::factory()->hasPhotos(3)->create()

Photos representa o nome do método photos() no nosso model. Ele é responsável pela ligação com eventos

Usuário com profile
> User::factory()->has(Profile::factory())->create()

Alternativa
> User::factory()->hasProfile()->create()

Criando um usuário com um perfil vinculado
> Profile::factory()->for(User::factory())->create()

Alternativa
> Profile::factory()->forUser()->create()

#### Incrementando nossas seeds

Event:

	Event::factory(30)
				->hasPhotos(4)
				->hasCategories(3)
				->create();

User

	User::factory(50)
			->hasProfile()
			->create();
			
Para executar:
> php artisan migrate:fresh e php artisan db:seed

ou
> php artisan migrate:fresh --seed

### Blade

Passando valores nas rotas

	Route::get('/', function () {
	    $events = Event::all();
	    return view('welcome', [
		'events' => $events
	    ]);
	});

outra opção é usando a função *compact()* do php

	Route::get('/', function () {
	    $events = Event::all();
	    return view('welcome', compact('events'));
	});


Resolvendo problema da função *format()* para o **start_event** do Model Event e transformar o start_event em uma instância do carbon

Model Event:

	protected $dates = ['start_event'];

No blade:

	<strong>{{ $event->start_event->format('d/m/Y H:i:s') }}</strong>

### Formulários

Para usar a paginação do bootstrap temos que modificar

1 - abrir o arquivo `app\Providers\AppServiceProvider.php`
2 - adicionar ao método `register`:

	Paginator::useBootstrap();
	




## Licença

[MIT license](https://opensource.org/licenses/MIT).
