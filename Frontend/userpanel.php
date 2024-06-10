<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Użytkownika</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <a href="../Admin/mainpage.php" class="admin-panel-link">Panel Administratora</a>
        <div class="user-info">
            Witaj użytkowniku.
        </div>
        <a href="../Backend/logout.php" class="admin-panel-link">Wyloguj się</a>
    </header>
    <nav>
        <a href="#" class="nav-link active" data-section="main">Panel główny</a>
        <a href="#" class="nav-link" data-section="history">Historia</a>
        <a href="#" class="nav-link" data-section="info">Informacje</a>
    </nav>
    <div class="content" id="content">
        <!-- Domyślna zawartość sekcji Panel główny -->
    </div>
    <footer>
        E-firma
    </footer>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const contentElement = document.getElementById('content');
        const navLinks = document.querySelectorAll('.nav-link');

        const sections = {
            main: `
                <h1>Twoje karty dostępu</h1>
                <div class="qr-container">
                    <div class="button-container">
                        <button id="scan-qr-button" class="login-button" type="button">Skanuj</button>
                        <button id="cancel-scan-button" class="login-button" type="button" style="display: none;">Anuluj skanowanie</button>
                        <button id="change-camera-button" class="login-button" type="button" style="display: none;">Zmień kamerę</button>
                    </div>
                    <div id="qr-reader"></div>
                </div>
                <div class="table-container">
                    <table id="cards-table">
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
                                <td colspan="5">Ładowanie...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            `,
            history: `
                <h1>Historia wejść</h1>
                <p>Tu znajdziesz najnowszą historię.</p>
            `,
            info: `
                <h1>Informacje</h1>
                <p>Tu znajdziesz informacje o użytkowniku.</p>
            `
        };

        function loadTableData() {
            const tableBody = document.querySelector('#cards-table tbody');
            tableBody.innerHTML = '<tr><td colspan="5">Ładowanie...</td></tr>';

            fetch('../Backend/get_cards_user.php')
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = '';
                    if (data.length === 0) {
                        tableBody.innerHTML = '<tr><td colspan="5">Brak kart</td></tr>';
                    } else {
                        data.forEach(card => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${card.numer_seryjny}</td>
                                <td>${card.data_wydania}</td>
                                <td>${card.data_waznosci}</td>
                                <td>${card.strefy_dostepu}</td>
                                <td class="${card.karta_aktywna == 1 ? 'status-active' : 'status-noactive'}">${card.karta_aktywna == 1 ? 'Aktywna' : 'Nieaktywna'}</td>
                            `;
                            tableBody.appendChild(row);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching cards:', error);
                    tableBody.innerHTML = '<tr><td colspan="5">Błąd podczas ładowania danych</td></tr>';
                });
        }

        // Load main section by default
        contentElement.innerHTML = sections['main'];
        loadTableData();

        // Event listeners for navigation links
        navLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                navLinks.forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
                const section = this.getAttribute('data-section');
                contentElement.innerHTML = sections[section];
                if (section === 'main') {
                    loadTableData();
                }
            });
        });

        const scanButton = document.getElementById('scan-qr-button');
        const cancelButton = document.getElementById('cancel-scan-button');
        const changeCameraButton = document.getElementById('change-camera-button');
        let html5QrcodeScanner = null;

        scanButton.addEventListener('click', function() {
            if (!html5QrcodeScanner) {
                html5QrcodeScanner = new Html5QrcodeScanner(
                    'qr-reader', 
                    { fps: 10, qrbox: 250 }
                );
                setupQrScanner();
            }
            html5QrcodeScanner.render(onScanSuccess);
            scanButton.disabled = true; // Disable scan button while scanning
        });

        async function onScanSuccess(decodedText, decodedResult) {
            console.log(`Scan result: ${decodedText}`, decodedResult);

            try {
                const response = await fetch('../Backend/get_dostep_po_QR.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ qr_code: decodedText }) // Klucz musi być 'qr_code'
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();
                if (data.access_granted) {
                    alert('Dostęp przyznany');
                } else {
                    alert('Dostęp nieprzyznany');
                }
            } catch (error) {
                console.error('Error processing QR code:', error);
                alert('Wystąpił błąd podczas przetwarzania kodu QR. Sprawdź konsolę deweloperską dla więcej informacji.');
            }
        }

        function setupQrScanner() {
            cancelButton.style.display = 'block';
            changeCameraButton.style.display = 'block';

            cancelButton.addEventListener('click', function() {
                html5QrcodeScanner.clear(); // Clear the QR scanner
                cancelButton.style.display = 'none';
                changeCameraButton.style.display = 'none';
                scanButton.disabled = false; // Re-enable scan button after cancelling
            });

            changeCameraButton.addEventListener('click', function() {
                html5QrcodeScanner.changeCamera(); // Change camera if available
            });
        }

    });

    </script>

</body>
</html>
