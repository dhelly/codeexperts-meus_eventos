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


## Licença

[MIT license](https://opensource.org/licenses/MIT).
