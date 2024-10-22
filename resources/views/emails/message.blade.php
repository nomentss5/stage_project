{{-- ajouter !! pour respecter les espacement et les paragraphe --}}
{{-- <p>{!! $messageBody !!}</p> --}}

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reponse candidature</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            padding: 20px;
        }
        .signature {
            margin-top: 20px;
        }
        .contact {
            margin-top: 10px;
            font-size: 0.9em;
            color: #555;
        }
    </style>
</head>
<body>

<div class="container">
    <p>Bonjour, </p>

    <p>{!! $messageBody !!}</p>

    <div class="signature">
        <p>Merci de votre attention !</p>
    </div>

    <div class="contact">
        <p>Tel: +261 (0) 20 22 467 12 | Mob: +261 (0) 32 05 218 25</p>
        <p><a href="http://www.althea.mg">www.althea.mg</a></p>
        <p>BP 9195A - Antananarivo 102 - Madagascar</p>
    </div>
</div>

</body>
</html>



