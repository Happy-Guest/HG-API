<!DOCTYPE html>
<html>
<head>
    <title>Partilha de Avaliação - Hotel de Leiria</title>
</head>
<body>
    <p>Olá,</p>
    <p>Foi partilhada uma avaliação do Hotel de Leiria consigo.</p>
    <br>
    <p><b>Autor:</b> {{ $review->user_id ? $review->user->name : 'Anónimo' }}</p>
    <p><b>Estrelas (1 a 5):</b> {{ $review->stars }}</p>
    <p><b>Comentário:</b> {{ $review->comment }}</p>
    <br>
    <p>Obrigado,</p>
    <p>Hotel de Leiria</p>
    <br>
    <p>HappyGuest</p>
</body>
</html>
