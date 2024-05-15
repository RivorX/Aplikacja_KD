<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administratora</title>
    <link rel="stylesheet" href="../Frontend/style.css">
</head>
<body>
<header>
    <a href="../Frontend/userpanel.php" class="admin-panel-link">Panel Użytkownika</a>
    <div class="user-info">
        Witaj Adminie.
    </div>
    <a href="../Backend/logout.php" class="admin-panel-link">Wyloguj się</a>
</header>
<nav>
    <a href="#" class="nav-link active" data-section="employees">Pracownicy</a>
    <a href="#" class="nav-link" data-section="cards">Karty Dostępu</a>
    <a href="#" class="nav-link" data-section="zones">Strefy</a>
</nav>

<div class="content" id="content">
    <!-- Domyślna zawartość sekcji Pracownicy -->
    <h1>Pracownicy</h1>
    <div class="table-container" id="employees-table-container">
        <table id="employees-table">
            <thead>
                <tr>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>Stanowisko</th>
                    <th>Dział</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4">Ładowanie...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<footer>
    E-firma
</footer>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const contentElement = document.getElementById('content');
        const sections = {
            employees: `
                <h1>Pracownicy</h1>

                <div class="table-container" id="employees-table-container">
                    <table id="employees-table">
                        <thead>
                            <tr>
                                <th>Imię</th>
                                <th>Nazwisko</th>
                                <th>Stanowisko</th>
                                <th>Dział</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4">Ładowanie...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            `,
            cards: `
            <h1>Karty dostępu</h1>

            <div class="table-container" id="cards-table-container">
                <table id="cards-table">
                    <thead>
                        <tr>
                            <th>Nr karty</th>
                            <th>Data wydania</th>
                            <th>Data ważności</th>
                            <th>Strefy dostępu</th>
                            <th>Status</th>
                            <th>Akcje</th> <!-- Nowa kolumna na akcje -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6">Ładowanie...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            `,
            zones: `
                <h1>Strefy dostępu</h1>
                <p>Tutaj wyświetlamy strefy dostępu.</p>
            `
        };

        // Uruchamianie funkcji do ładowania danych dla danej sekcji
        function loadTableData(section) {
            switch (section) {
                case 'employees':
                    loadEmployeesTableData();
                    break;
               case 'cards':
                    loadCardsTableData();
                    break;
                case 'zones':
                    loadZonesTableData();
                    break;
                default:
                    break;
            }
        }


        function loadEmployeesTableData() {
            const tableBody = document.querySelector('#employees-table tbody');
            tableBody.innerHTML = '<tr><td colspan="4">Ładowanie...</td></tr>';

            // Tutaj można dodać kod do pobrania danych pracowników z bazy danych
        }
        function loadCardsTableData() {
                const tableBody = document.querySelector('#cards-table tbody');
                tableBody.innerHTML = '<tr><td colspan="6">Ładowanie...</td></tr>'; <!-- Zmiana na 6 kolumn -->

                fetch('../Backend/get_cards.php')
                    .then(response => response.json())
                    .then(data => {
                        tableBody.innerHTML = '';
                        if (data.length === 0) {
                            tableBody.innerHTML = '<tr><td colspan="6">Brak kart</td></tr>'; <!-- Zmiana na 6 kolumn -->
                        } else {
                            data.forEach(card => {
                                const row = document.createElement('tr');
                                row.innerHTML = `
                                    <td>${card.numer_seryjny}</td>
                                    <td>${card.data_wydania}</td>
                                    <td>${card.data_waznosci}</td>
                                    <td>${card.strefy_dostepu}</td>
                                    <td class="${card.karta_aktywna === 'Aktywna' ? 'status-active' : 'status-noactive'}">${card.karta_aktywna === 0 ? 'Aktywna' : 'Nieaktywna'}</td>
                                    <td>
                                        <button onclick="editCard(${card.id})">Edytuj</button>
                                        <button onclick="deleteCard(${card.id})">Usuń</button>
                                        <button onclick="toggleCardStatus(${card.id})">${card.karta_aktywna === 0 ? 'Zablokuj' : 'Odblokuj'}</button>
                                    </td>
                                `;
                                tableBody.appendChild(row);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching cards:', error);
                        tableBody.innerHTML = '<tr><td colspan="6">Błąd podczas ładowania danych</td></tr>'; <!-- Zmiana na 6 kolumn -->
                    });
            }



        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                document.querySelectorAll('.nav-link').forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
                const section = this.getAttribute('data-section');
                contentElement.innerHTML = sections[section];
                loadTableData(section);
            });
        });

        // Initial load of employees data
        loadEmployeesData();
    });
</script>
</body>
</html>
