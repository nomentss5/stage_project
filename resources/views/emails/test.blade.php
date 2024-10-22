<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation à passer un test</title>
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
            font-size: 0.9em;
            color: #555;
        }
        .contact-container {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            margin-top: 20px;
        }
        .contact-image img {
            width: 225px; /* Taille de l'image */
        }
    </style>
</head>
<body>

<div class="container">
    <p>Bonjour, </p>

    <p>Message test ,</p>
    <div class="signature">
        <p>À très bientôt !</p>
    </div>

    <div class="contact-container">
        <div class="contact">
            <p>Email : recrutement@althea.mg</p>
            <p>Tel: +261 (0) 20 22 467 12 | Mob: +261 (0) 32 05 218 25</p>
            <p><a href="http://www.althea.mg">www.althea.mg</a></p>
            <p>BP 9195A - Antananarivo 102 - Madagascar</p>
        </div>
    
        <!-- Image à côté de la section contact -->
    </div>
    <div class="contact-image">
        <img src="{{ asset('images/mail_image.png') }}" alt="Logo">
    </div>
</div>

</body>
</html>