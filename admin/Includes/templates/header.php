<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="GoodFood">
    <meta name="description" content="GoodFood - La meilleure plateforme pour découvrir et commander vos plats préférés.">
    <meta name="keywords" content="restaurant, commande, livraison, plats, GoodFood">
    
    <title>GoodFood</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="Design/images/favicon.png">

    <!-- EXTERNAL CSS LINKS -->
    <link rel="stylesheet" href="Design/css/bootstrap.min.css">
    <link rel="stylesheet" href="Design/fonts/css/all.min.css"> <!-- Icônes FontAwesome -->
    <link rel="stylesheet" href="Design/css/main.css">

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prata&display=swap" rel="stylesheet">

    <!-- ANIMATIONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        /* Styles Modernes et Fluides */
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
            animation: fadeInBody 0.8s ease-in-out;
        }

        /* Navbar moderne */
        .navbar {
            background: linear-gradient(90deg, #ff6b6b, #e63946);
            padding: 15px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 22px;
            color: #fff !important;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
            font-size: 18px;
            font-weight: 500;
            transition: all 0.3s ease-in-out;
            position: relative;
        }

        .navbar-nav .nav-link::after {
            content: "";
            display: block;
            width: 0;
            height: 3px;
            background: #ffe66d;
            transition: width 0.3s ease-in-out;
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
        }

        .navbar-nav .nav-link:hover::after {
            width: 100%;
        }

        /* Boutons stylisés */
        .btn-primary {
            background: linear-gradient(90deg, #ff6b6b, #e63946);
            border: none;
            transition: all 0.3s ease-in-out;
            padding: 12px 20px;
            font-weight: bold;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background: #d62839;
            transform: scale(1.08);
        }

        /* Animation d’apparition */
        @keyframes fadeInBody {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="animate__animated animate__fadeIn">
