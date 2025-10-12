<!-- 1er layout -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smalland - Plateforme de Formation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-very-green {
            background-color: #10b981;
        }

        .text-very-green {
            color: #10b981;
        }

        .border-very-green {
            border-color: #10b981;
        }
    </style>
</head>
@include('partials.navbar')

<body class="bg-gray-50">


    <!-- Contenu principal -->
    <main>
        @yield('content')
    </main>

    <!-- Scripts -->
    <script>
        function completeLesson(lessonId) {
            fetch(`/lessons/${lessonId}/complete`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`lesson-${lessonId}`).classList.add('bg-green-50', 'border-green-200');
                        document.getElementById(`check-${lessonId}`).classList.remove('hidden');

                        // Mettre à jour la progression
                        location.reload();
                    }
                });
        }
    </script>
</body>

</html>


<!-- 2eme layout -->

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Small-Land</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #558b2f;
            --secondary-color: #7cb342;
            --accent-color: #ffd54f;
            --light-color: #f5f5f5;
            --dark-color: #263238;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #1b5e20;
            border-color: #1b5e20;
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .hero-section {
            background: url('/assets/img/2.jpg');
            ;

            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            margin-bottom: 50px;
        }

        .card {
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .category-badge {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .footer {
            background-color: var(--dark-color);
            color: white;
            padding: 40px 0;
        }

        .module-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--secondary-color);
        }

        .product-price {
            font-weight: bold;
            color: var(--primary-color);
        }

        .rating {
            color: #ffc107;
        }

        .dashboard-header {
            background-color: var(--primary-color);
            color: white;
            padding: 40px 0;
            margin-bottom: 30px;
        }

        .card {
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .footer {
            background-color: var(--dark-color);
            color: white;
            padding: 40px 0;
        }

        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--secondary-color);
        }

        .progress-bar {
            background-color: var(--primary-color);
        }

        .sidebar {
            position: sticky;
            top: 20px;
        }

        .sidebar .nav-link {
            color: var(--dark-color);
            padding: 12px 20px;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: var(--primary-color);
            color: white;
        }

        .sidebar .nav-link i {
            width: 24px;
            text-align: center;
            margin-right: 10px;
        }

        .course-progress {
            height: 8px;
        }

        .stats-card {
            text-align: center;
            padding: 20px;
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .continue-btn {
            position: absolute;
            bottom: 15px;
            right: 15px;
        }

        .certificate-badge {
            position: absolute;
            top: 15px;
            right: 15px;
        }

        a{
            text-decoration: none;
        }
    </style>
</head>

<body>


    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
@include('partials.footer')
