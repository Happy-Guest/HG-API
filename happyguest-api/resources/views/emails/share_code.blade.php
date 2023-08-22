<!DOCTYPE html>
<html>
<head>
    <title>Envio de Código - Hotel de Leiria</title>
</head>
<body>
    <p>Olá,</p>
    <p>Foi criado um código de acesso para a sua reserva no nosso hotel!</p>
    <p>Instale a nossa aplicação para ter acesso a diversas funcionalidades.</p>
    <p>Tais como: Reservas, avaliações, pedidos, informações e muito mais...</p>
    <br>
    <p><b>Código:{{ $code->code}}</b></p>
    <p><b>Quarto(s):</b> {{ implode(', ', $code->rooms) }}</p>
    <p><b>Data de Entrada:</b> {{ $code->entry_date }}</p>
    <p><b>Data de Saída:</b> {{ $code->exit_date }}</p>
    <br>
    <p>Obrigado, Boa Estadia!</p>
    <p>Hotel de Leiria</p>
    <br>
    <p>HappyGuest</p>
</body>
</html>
