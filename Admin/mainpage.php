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
    <a href="#" class="nav-link" data-section="doors">Drzwi</a>
    <a href="#" class="nav-link" data-section="qr_code_generate">qr code generate</a>
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
                    <th>email</th>
                    <th>Grupa</th>
                    <th>Status</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6">Ładowanie...</td>
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
                                <th>email</th>
                                <th>Grupa</th>
                                <th>Status</th>
                                <th>Akcje</th>
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
            cards: `
                <h1>Karty dostępu</h1>
                <button id="addCardButton">Dodaj Kartę Dostępu</button>
                <div class="table-container" id="cards-table-container">
                    <table id="cards-table">
                        <thead>
                            <tr>
                                <th>Nr karty</th>
                                <th>Data wydania</th>
                                <th>Data ważności</th>
                                <th>Strefy dostępu</th>
                                <th>Status</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6">Ładowanie...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="cardFormContainer" style="display: none;">
                    <h2 id="formTitle">Dodaj Kartę Dostępu</h2>
                    <form id="cardForm">
                        <label for="cardNumber">Nr karty:</label>
                        <input type="text" id="cardNumber" name="cardNumber" required>
                        <label for="issueDate">Data wydania:</label>
                        <input type="date" id="issueDate" name="issueDate" required>
                        <label for="expiryDate">Data ważności:</label>
                        <input type="date" id="expiryDate" name="expiryDate" required>
                        <label for="accessZones">Strefy dostępu:</label>
                        <input type="text" id="accessZones" name="accessZones" required>
                        <label for="status">Status:</label>
                        <select id="status" name="status">
                            <option value="1">Aktywna</option>
                            <option value="0">Nieaktywna</option>
                        </select>
                        <input type="hidden" id="cardId" name="cardId">
                        <button type="submit" id="submitButton">Dodaj</button>
                        <button type="button" id="cancelButton">Anuluj</button>
                    </form>
                </div>
            `,
            zones: `
                <h1>Strefy dostępu</h1>
                <div class="table-container" id="zones-table-container">
                    <table id="zones-table">
                        <thead>
                            <tr>
                                <th>ID Strefy</th>
                                <th>Nazwa Strefy</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2">Ładowanie...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            `,
            doors: `
                <h1>Drzwi</h1>
                <div class="table-container" id="doors-table-container">
                    <table id="doors-table">
                        <thead>
                            <tr>
                                <th>ID Drzwi</th>
                                <th>Numer Drzwi</th>
                                <th>Nazwa Drzwi</th>
                                <th>Strefy Dostępu</th>
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
            qr_code_generate: `
                <h1>Generowanie kodu QR</h1>
                <form action="../Backend/QR_code_generate.php" method="post">
                    <label for="drzwi_id">Wybierz Drzwi:</label>
                    <?php
                    require '../config.php';
                    $sql = "SELECT Drzwi_id, nr_drzwi, nazwa FROM drzwi";
                    $result = $conn->query($sql);
                    echo "<select id='drzwi_id' name='drzwi_id' required>";
                    echo "<option value=''>Wybierz...</option>";
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["Drzwi_id"] . "'>" . $row["nr_drzwi"] . " - " . $row["nazwa"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Brak dostępnych drzwi</option>";
                    }
                    echo "</select><br><br>";
                    $conn->close();
                    ?>
                    <label for="nr_drzwi">Numer Drzwi:</label>
                    <button type="submit">Generuj kod QR</button>
                </form>
            `
        };

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
                case 'doors':
                    loadDoorsTableData();
                    break;
                case 'qr_code_generate':
                    loadQrCodeGenerate();
                    break;
                default:
                    break;
            }
        }

        function loadEmployeesTableData() {
            const tableBody = document.querySelector('#employees-table tbody');
            tableBody.innerHTML = '<tr><td colspan="6">Ładowanie...</td></tr>';

            fetch('../Backend/get_employees.php')
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = '';
                    if (data.length === 0) {
                        tableBody.innerHTML = '<tr><td colspan="6">Brak Pracowników</td></tr>';
                    } else {
                        data.forEach(employee => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${employee.imie}</td>
                                <td>${employee.nazwisko}</td>
                                <td>${employee.email}</td>
                                <td>${employee.nazwa_grupy}</td>
                                <td class="${employee.konto_aktywne == 1 ? 'status-active' : 'status-noactive'}">${employee.konto_aktywne == 1 ? 'Aktywny' : 'Nieaktywny'}</td>
                                <td>
                                    <button onclick="editEmployee(${employee.pracownicy_id})">Edytuj</button>
                                    <button onclick="deleteEmployee(${employee.pracownicy_id})">Usuń</button>
                                    <button onclick="toggleEmployeeStatus(${employee.pracownicy_id})">${employee.konto_aktywne == 1 ? 'Zablokuj' : 'Odblokuj'}</button>
                                </td>
                            `;
                            tableBody.appendChild(row);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching employees:', error);
                    tableBody.innerHTML = '<tr><td colspan="6">Błąd podczas ładowania danych</td></tr>';
                });
        }

        function loadCardsTableData() {
            const tableBody = document.querySelector('#cards-table tbody');
            tableBody.innerHTML = '<tr><td colspan="6">Ładowanie...</td></tr>';

            fetch('../Backend/get_cards.php')
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = '';
                    if (data.length === 0) {
                        tableBody.innerHTML = '<tr><td colspan="6">Brak kart</td></tr>';
                    } else {
                        data.forEach(card => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${card.numer_seryjny}</td>
                                <td>${card.data_wydania}</td>
                                <td>${card.data_waznosci}</td>
                                <td>${card.strefy_dostepu}</td>
                                <td class="${card.karta_aktywna == 1 ? 'status-active' : 'status-noactive'}">${card.karta_aktywna == 1 ? 'Aktywna' : 'Nieaktywna'}</td>
                                <td>
                                    <button onclick="editCard(${card.karta_dostepu_id})">Edytuj</button>
                                    <button onclick="deleteCard(${card.karta_dostepu_id})">Usuń</button>
                                    <button onclick="toggleCardStatus(${card.karta_dostepu_id})">${card.karta_aktywna == 1 ? 'Zablokuj' : 'Odblokuj'}</button>
                                </td>
                            `;
                            tableBody.appendChild(row);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching cards:', error);
                    tableBody.innerHTML = '<tr><td colspan="6">Błąd podczas ładowania danych</td></tr>';
                });
        }

        function loadZonesTableData() {
            const tableBody = document.querySelector('#zones-table tbody');
            tableBody.innerHTML = '<tr><td colspan="2">Ładowanie...</td></tr>';

            fetch('../Backend/get_strefy.php')
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = '';
                    if (data.length === 0) {
                        tableBody.innerHTML = '<tr><td colspan="2">Brak Stref Dostępu</td></tr>';
                    } else {
                        data.forEach(zone => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${zone.Strefy_Dostepu_id}</td>
                                <td>${zone.nazwa_strefy}</td>
                            `;
                            tableBody.appendChild(row);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching zones:', error);
                    tableBody.innerHTML = '<tr><td colspan="2">Błąd podczas ładowania danych</td></tr>';
                });
        }

        function loadDoorsTableData() {
            const tableBody = document.querySelector('#doors-table tbody');
            tableBody.innerHTML = '<tr><td colspan="4">Ładowanie...</td></tr>';

            fetch('../Backend/get_doors.php')
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = '';
                    if (data.length === 0) {
                        tableBody.innerHTML = '<tr><td colspan="4">Brak Drzwi</td></tr>';
                    } else {
                        data.forEach(door => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${door.Drzwi_id}</td>
                                <td>${door.nr_drzwi}</td>
                                <td>${door.nazwa}</td>
                                <td>${door.Strefy_Dostepu_id}</td>
                            `;
                            tableBody.appendChild(row);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching doors:', error);
                    tableBody.innerHTML = '<tr><td colspan="4">Błąd podczas ładowania danych</td></tr>';
                });
        }

        function loadQrCodeGenerate() {
            const form = document.getElementById('qrForm');
            const qrCodeContainer = document.getElementById('qrCode');

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                const drzwiId = document.getElementById('drzwi_id').value;

                if (!drzwiId) {
                    alert('Wybierz drzwi przed wygenerowaniem kodu QR.');
                    return;
                }

                fetch('../Backend/qr_code_generate.php', {
                    method: 'POST',
                    body: new URLSearchParams(new FormData(this))
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        qrCodeContainer.innerHTML = `<img src="${data.qr_code}" alt="QR Code">`;
                    } else {
                        alert(data.message || 'Wystąpił błąd podczas generowania kodu QR.');
                    }
                })
                .catch(error => {
                    console.error('Błąd podczas komunikacji z serwerem:', error);
                    alert('Wystąpił błąd podczas komunikacji z serwerem.');
                });
            });
        }

        function showCardForm(card) {
            const formTitle = document.getElementById('formTitle');
            const cardForm = document.getElementById('cardForm');
            const cardId = document.getElementById('cardId');
            const cardNumber = document.getElementById('cardNumber');
            const issueDate = document.getElementById('issueDate');
            const expiryDate = document.getElementById('expiryDate');
            const accessZones = document.getElementById('accessZones');
            const status = document.getElementById('status');
            const submitButton = document.getElementById('submitButton');
            const cardFormContainer = document.getElementById('cardFormContainer');
            const cancelButton = document.getElementById('cancelButton');

            formTitle.innerText = card ? 'Edytuj Kartę Dostępu' : 'Dodaj Kartę Dostępu';
            submitButton.innerText = card ? 'Zapisz' : 'Dodaj';
            cardId.value = card ? card.karta_dostepu_id : '';
            cardNumber.value = card ? card.numer_seryjny : '';
            issueDate.value = card ? card.data_wydania : '';
            expiryDate.value = card ? card.data_waznosci : '';
            accessZones.value = card ? card.strefy_dostepu : '';
            status.value = card ? card.karta_aktywna : '1';

            cardFormContainer.style.display = 'block';

            cardForm.onsubmit = function(event) {
                event.preventDefault();

                const formData = new FormData(cardForm);
                const url = card ? '../Backend/update_card.php' : '../Backend/add_card.php';

                fetch(url, {
                    method: 'POST',
                    body: new URLSearchParams(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadCardsTableData();
                        cardFormContainer.style.display = 'none';
                        cardForm.reset();
                    } else {
                        alert(data.message || 'Wystąpił błąd podczas zapisywania danych.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Wystąpił błąd podczas komunikacji z serwerem.');
                });
            };

            cancelButton.onclick = function() {
                cardFormContainer.style.display = 'none';
                cardForm.reset();
            };
        }

        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                document.querySelectorAll('.nav-link').forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
                const section = this.getAttribute('data-section');
                contentElement.innerHTML = sections[section];
                loadTableData(section);

                if (section === 'cards') {
                    document.getElementById('addCardButton').onclick = function() {
                        showCardForm();
                    };
                }
            });
        });

        loadEmployeesTableData();
    });

    function editCard(cardId) {
        fetch(`../Backend/get_card.php?id=${cardId}`)
            .then(response => response.json())
            .then(card => showCardForm(card))
            .catch(error => console.error('Error fetching card:', error));
    }

    function deleteCard(cardId) {
        if (confirm('Czy na pewno chcesz usunąć tę kartę?')) {
            fetch(`../Backend/delete_card.php?id=${cardId}`, { method: 'DELETE' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadCardsTableData();
                    } else {
                        alert(data.message || 'Wystąpił błąd podczas usuwania karty.');
                    }
                })
                .catch(error => console.error('Error deleting card:', error));
        }
    }

    function toggleCardStatus(cardId) {
        fetch(`../Backend/toggle_card_status.php?id=${cardId}`, { method: 'POST' })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadCardsTableData();
                } else {
                    alert(data.message || 'Wystąpił błąd podczas zmiany statusu karty.');
                }
            })
            .catch(error => console.error('Error toggling card status:', error));
    }
</script>
</body>
</html>
