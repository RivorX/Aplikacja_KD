<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Użytkownika</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
        }
        header {
            background-color: #f8f9fa;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-panel-link {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }
        .user-info {
            display: flex;
            align-items: center;
        }
        .user-info img {
            border-radius: 50%;
            margin-right: 15px;
        }
        .user-info div {
            text-align: left;
        }
        nav {
            background-color: #d1d5db;
            padding: 10px;
            display: flex;
            justify-content: center;
        }
        nav a {
            color: #4b5563;
            text-decoration: none;
            margin: 0 15px;
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: bold;
        }
        nav a.active, nav a:hover {
            background-color: #6b7280;
            color: white;
        }
        .content {
            padding: 20px;
        }
        .content h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .table-container {
            margin-top: 20px;
        }
        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-container th, .table-container td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .table-container th {
            background-color: #f8f9fa;
        }
        .status-active {
            color: green;
            font-weight: bold;
        }
        footer {
            background-color: #6b7280;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <header>
        <a href="/Admin/mainpage" class="admin-panel-link">Panel Administratora</a>
        <div class="user-info">
            Witaj użytkowniku.
        </div>
        <a href="/Backend/logout.php" class="admin-panel-link">Wyloguj się</a>
    </header>
    <nav>
        <a href="#" class="nav-link active" data-section="main">Panel główny</a>
        <a href="#" class="nav-link" data-section="announcements">Ogłoszenia</a>
        <a href="#" class="nav-link" data-section="card">Karta</a>
        <a href="#" class="nav-link" data-section="info">Informacje</a>
    </nav>
    <div class="content" id="content">
        <!-- Domyślna zawartość sekcji Panel główny -->
        <h1>Twoje karty dostępu</h1>
        <button type="button">Skanuj</button>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nr karty</th>
                        <th>Data wydania</th>
                        <th>Data ważności</th>
                        <th>Strefy dostępu</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>23432424</td>
                        <td>2024-05-04</td>
                        <td>2024-05-04</td>
                        <td>Brak</td>
                        <td class="status-active">Aktywna</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <footer>
        E-firma
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contentElement = document.getElementById('content');
            const navLinks = document.querySelectorAll('.nav-link');

            const sections = {
                main: `
                    <h1>Twoje karty dostępu</h1>
                    <button type="button">Skanuj</button>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nr karty</th>
                                    <th>Data wydania</th>
                                    <th>Data ważności</th>
                                    <th>Strefy dostępu</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>23432424</td>
                                    <td>2024-05-04</td>
                                    <td>2024-05-04</td>
                                    <td>Brak</td>
                                    <td class="status-active">Aktywna</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                `,
                announcements: `
                    <h1>Ogłoszenia</h1>
                    <p>Tu znajdziesz najnowsze ogłoszenia.</p>
                `,
                card: `
                    <h1>Twoje karty dostępu</h1>
                    <button type="button">Skanuj</button>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nr karty</th>
                                    <th>Data wydania</th>
                                    <th>Data ważności</th>
                                    <th>Strefy dostępu</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>23432424</td>
                                    <td>2024-05-04</td>
                                    <td>2024-05-04</td>
                                    <td>Brak</td>
                                    <td class="status-active">Aktywna</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                `,
                info: `
                    <h1>Informacje</h1>
                    <p>Tu znajdziesz informacje o użytkowniku.</p>
                `
            };

            navLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    navLinks.forEach(nav => nav.classList.remove('active'));
                    this.classList.add('active');

                    const section = this.getAttribute('data-section');
                    contentElement.innerHTML = sections[section];
                });
            });
        });
    </script>
</body>
</html>
