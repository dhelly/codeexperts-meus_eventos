<div>
    <p>
        Olá <strong>{{ $user->name }}</strong>, tudo bem? Espero que sim!!!
        <br><br>
        Sua inscrição no evento <strong>{{ $event->title }}</strong> foi realizada
        com sucesso!
        <br>
        Muito obrigada por sua inscrição.
    </p>
    <hr>
    E-mail enviado em {{ date('d/m/Y H:i:s') }} por Events Sistemas.
</div>
