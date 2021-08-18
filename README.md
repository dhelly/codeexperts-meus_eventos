# Laravel Estudos

<a href="https://packagist.org/packages/laravel/framework">
<img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sobre o Laravel Mastery

Curso de laravel da plataforma [Code Experts](https://codeexperts.com.br/). Instrutor Nanderson Castro.

### Recursos e Ferramentas

- [Laravel versão 8](https://laravel.com/)
- [Vscode](https://code.visualstudio.com/)
- [Dbeaver](https://dbeaver.io/ )

## Projeto

### Projeto inicial: meusEventos

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

### Controller

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

### Refatorando as Rotas

Nomeando e criando agrupamento

    // Event
    Route::prefix('/admin')->name('admin.')->group(function () {
        Route::prefix('/events')->name('events.')->group(function () {

        Route::get('/', [
                \App\Http\Controllers\Admin\EventController::class,
                'index'])->name('index');

        Route::get('/create', [
                \App\Http\Controllers\Admin\EventController::class,
                'create'
            ])->name('create');
        Route::post('/store', [
                \App\Http\Controllers\Admin\EventController::class,
                'store'
            ])->name('store');

        Route::get('/{event}/edit', [
                \App\Http\Controllers\Admin\EventController::class,
                'edit'
            ])->name('edit');
        Route::post('/update/{event}', [
                \App\Http\Controllers\Admin\EventController::class,
                'update'
                ])->name('update');

        Route::get('/destroy/{event}', [
                \App\Http\Controllers\Admin\EventController::class,
                'destroy'
            ])->name('destroy');
        });
    });

### Validações

Nos controles

    //validation
    $request->validate([
        'title' => 'required|min:30',
        'description' => 'required',
        'body' => 'required',
        'start_event' => 'required'
    ], [
        'required' => 'Este campo é obrigatório',
        'min' => 'Este campo precisa ter no mínimo :min caracteres'
    ]);

Nas views:

    <div class="form-group mb-2">
        <label>Titulo do Evento</label>
        <input type="text" name="title" class="form-control {{ ($errors->has('title') ? 'is-invalid' : '') }}">

        @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <div class="form-group my-2">
        <label>Descrição Rápida</label>
        <input type="text" name="description" class="form-control {{ ($errors->has('description') ? 'is-invalid' : '') }}">

        @if ($errors->has('description'))
            <div class="invalid-feedback">
                @foreach ($errors->get('description') as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
    </div>

Lembrado que no Laravel existe várias formas para se chegar ao mesmo resultado, no exemplo acima mostramos duas formas.

Trabalhar com o Request

> php artisan make:request EventRequest

Passamos as validações que colocamos no controller para o EventRequest no método rule

    public function rules()
    {
    return [
        'title' => 'required|min:30',
        'description' => 'required',
        'body' => 'required',
        'start_event' => 'required'
    ];
    }

Setamos o *authorize()* para true

Sobrescrevemos o método *message()* no request e adicionamos nossa tradução

    public function message()
    {
        return [
            'required' => 'Este campo é obrigatório',
            'min' => 'Este campo precisa ter no mínimo :min caracteres'
        ];
    }

Agora a validação foi entrega para uma camada acima para fazer o serviço.

### Controllers como Recurso

Criando um controller com o resource defindo

>php artisan make:controller Event --resource
ou
>php artisan make:controller Event -r

![Rotas do Resource](https://github.com/dhelly/codeexperts-meus_eventos/blob/main/.git_assets/recurso.png)

Recursos Aninhados
Criamos uma rota com recurso manualmente

    Route::resource('events.photos', \App\Http\Controllers\Admin\EventPhotoController::class);

Criamos o controller
> php artisan make:controller Admin\\EventPhotoController -r

![Rotas do Resource Aninhados](https://github.com/dhelly/codeexperts-meus_eventos/blob/main/.git_assets/recurso_aninhado.png)

Outra forma de aninhar as rotas

    Route::resources(
        [
            'events' => \App\Http\Controllers\Admin\EventController::class,
            'events.photos' => \App\Http\Controllers\Admin\EventPhotoController::class
        ],
        [
            'except' => ['destroy']
        ]
    );

![Listagem de Rotas](https://github.com/dhelly/codeexperts-meus_eventos/blob/main/.git_assets/listagem_rotas.png)

Delegando ao construtor a injeção de dependência do Model no controller Events

    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

### Laravel UI

Instalando pacote

> composer require laravel/ui

Gerando agora as telas de autenticação e os presets do projeto para o bootstrap, que já estamos trabalhando, com telas de autenticação(flag --auth)

> php artisan ui bootstrap --auth

Scaffolding criados... rodar os comandos

> npm install && npm run dev

Erro no linux: Skipping 'fsevents' build as platform linux is not supported

> npm install -f

Conectar um evento a um usuário

1 - Criando a migração

> php artisan make:migration alter_table_events_add_column_owner_id --table=events

Na migration

    $table->foreignId('owner_id')->nullable()->constrained('users')->cascadeOnDelete();

Lembrando que a definição *users* como parâmetro é devido ao nome da nossa coluna não ser o nome da tabela.A exclusão da coluna se dá pela composição do nome da tabela + nome da coluna + palavra "foreign'

    $table->dropForeign('events_owner_id_foreign');
    $table->dropColumn('owner_id');

Lembrando de guarda a devida ordem de execução da tabela

Mapear no Models os relacionamentos

Em *event*:

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

Em *user*:

    public function events()
    {
        return $this->hasMany(Event::class, 'owner_id');
    }

O atributo *owner_id*, informa ao Laravel que o nome correto da coluna. Por conversão o laravel procurar a coluna *user_id*

Construindo os mapeamentos nas seeds Users

    public function run()
    {
        User::factory(50)
                    ->has(
                        Event::factory(30)
                        ->hasPhotos(4)
                        ->hasCategories(3)
                    )
                    ->hasProfile()
                    ->create();
    }

Roda novamente:

> php artisan migrate:refresh --seed

Atribuindo o *owner* na filtragem de eventos. Ou seja, na listagem de eventos apenas os eventos criado pelo usuário será exibido.

Método de listagem:

    $events = auth()->user()->events()->paginate(10);

Método Store:

    public function store(EventRequest $request)
    {

        $event = $request->all();
        $event['slug'] = Str::slug($event['title']);

        $event = $this->event->create($event);
        $event->owner()->associate(auth()->user());
        $event->save();

        return redirect()->route('admin.events.index');
    }

### Melhorias no Projeto

Accessors e Mutators - Exemplo do simples de uso no nosso projeto. Lembrando que eles tem prioridade de execução dentro do model

    /** Accessos */

    public function getTitleAttribute()
    {
        return 'Evento: ' . $this->attributes['title'];
    }

    public function getOwnerNameAttribute()
    {
        return !$this->owner ? 'Sem organizador' : $this->owner->name;
    }

    /** Mutators */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

Melhorando o campo de Inserção de data

1 - Adicionar o pacote *ImputMask* como dependência de desenvolvimento(-D)

> npm install inputmask -D

2 - Adicionar no resource>js>bootstrap.js

    var Inputmask = require('inputmask');

3 - Adicionar aos formulários

Criar e editar evento:

    @section('scripts')
        <script>
            el = document.querySelector('input[name=start_event]');

            let im = new Inputmask('99/99/9999 99:99:99');
            im.mask(el);
        </script>
    @endsection

4 - Criando um mutator para formatar

    public function setStartEventAttribute($value)
    {
        $this->attributes['start_event'] = (\DateTime::createFromFormat('d/m/Y H:i', $value))
                                            ->format('Y-m-d H:i');
    }

Criando um Middleware para evitar o acesso de eventos de outros usuários

Criando o middleware

> php artisan make:middleware CheckUserCanAccessEventToEditMiddleware

Existem várias formas de incluir um middleware. Uma das formas mais usadas é colocar nas rotas, mas para situações como essa, que é preciso aplicar em apenas um método, uma solução possível é inserir diretamente no método. Essa forma será por nós utilizada.

No construtor do Evento:

    $this->middleware('user.can.edit.event')->only(['edit', 'update']);

Para fazer um teste preliminar podemos usar o dd(__CLASS__) no middleware

Implementando o middleware

    public function handle(Request $request, Closure $next)
    {

        $event = Event::find($request->route()->parameter('event'));

        if (!auth()->user()->events->contains($event)) {
            abort(403);
        }

        return $next($request);
    }

Implementando o botão search

View: site.blade.php:

    <form class="form-inline my-2 my-lg-0">
        <input
            class="form-control mr-sm-2"
            type="search"
            placeholder="Buscar eventos..."
            aria-label="Search"
            name="s"
            value="{{ request()->query('s') }}"
        >
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>

Controller Home:

    public function index()
    {
        $events = $this->event
            ->orderBy('start_event', 'DESC');

        // if ($query = request()->query('s')) {
        //     $events->where('title', 'LIKE', '%' . $query . '%');
        // }

        $events->when($search = request()->query('s'), function ($queryBuilder) use ($search) {
            $queryBuilder->where('title', 'LIKE', '%' . $search . '%');
        });

        $events = $events->paginate(15);

        // $events = [];
        return view('home', compact('events'));
    }

Compartilhando categorias em todas as views do layout.site

Usando AppServiceProvider

    view()->share('categories', \App\Models\Category::all(['name', 'slug']));
    //ou 
    view()->composer('layouts.site', function ($view) {
        $view->with('categories', \App\Models\Category::all(['name', 'slug']));
    });

Melhorando a view composer

Criando uma pasta no "app\Http\Views\Composer". Criamos a classe *CategoriesViewComposer*

    <?php

    namespace App\Http\Views\Composer;

    use App\Models\Category;

    class CategoriesViewComposer
    {
        private $category;

        public function __construct(Category $category)
        {
            $this->category = $category;
        }

        public function compose($view)
        {
            return $view->with('categories', $this->category->all(['name', 'slug']));
        }
    }

Alteramos o ServiceProvide para chamar o nosso CategoriesViewComposer

    view()->composer('layouts.site', 'App\Http\Views\Composer\CategoriesViewComposer@compose');

Melhorando ainda mais: criando um provide para o código acima.
Criar um provide

> php artisan make:provider ViewComposerServiceProvider

Copiamos o código para boot

    view()->composer('layouts.site', 'App\Http\Views\Composer\CategoriesViewComposer@compose');

Fazemos como o laravel reconheça nosso provider: na pasta config, no arquivo *app.php*, no método provider

    App\Providers\ViewComposerServiceProvider::class,

Melhorando o método *getEventHome* para só mostrar os eventos que ainda vão acontecer

    // $events->whereRaw('DATE(start_event) >= DATE(NOW())');
    $events->whereDate('start_event', '>=', now());

### Upload de Arquivos

Permitindo um banner na chamada do evento

> php artisan make:migration alter_events_table_add_banner_column --table=events

Código da migration:

    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('banner')->nullable();
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('banner');
        });
    }

Rodar a migrate

> php artisan migrate

- Atualizar o fillable de *event*
- Colocar o campo no formulário
- Alterar o form para aceitar arquivo - enctype="multipart/form-data"

Método store do Event

    $banner = $request->file('banner');
    $event = $request->all();
    $event['banner'] = $banner->store('banner', 'public');
    //or
    $event['banner'] = $request->file('banner')->store('banner', 'public');

Validando o tipo de arquivo enviado - Editar o arquivo *EventRequest.php*

    public function rules()
    {
        return [
            'title' => 'required|min:30',
            'description' => 'required',
            'body' => 'required',
            'start_event' => 'required',
            'banner' => 'image'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Este campo é obrigatório',
            'min' => 'Este campo precisa ter no mínimo :min caracteres',
            'image' => 'Arquivo de imagem inválido.'
        ];
    }

Criar o link simbólico para pasta públic

> php artisan storage:link

Código para remoção da imagem quando for substituída

    public function update($event, EventRequest $request)
    {
        $event = $this->event->findOrFail($event);
        $eventData = $request->all();

        if ($banner = $request->file('banner')) {
            if (Storage::disk('public')->exists($event->banner)) {
                Storage::disk('public')->delete($event->banner);
            }
            $eventData['banner'] = $banner->store('banner', 'public');
        }


        $event->update($eventData);

        return redirect()->back();
    }

## Licença

[MIT license](https://opensource.org/licenses/MIT).
