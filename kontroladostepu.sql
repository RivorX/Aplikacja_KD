-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 15, 2024 at 10:01 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kontroladostepu`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `aktualnosci`
--

CREATE TABLE `aktualnosci` (
  `Aktualnosci_id` int(11) NOT NULL,
  `tytul` varchar(45) NOT NULL,
  `opis` text NOT NULL,
  `data_nadania` datetime NOT NULL,
  `obraz` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `aktualnosci`
--

INSERT INTO `aktualnosci` (`Aktualnosci_id`, `tytul`, `opis`, `data_nadania`, `obraz`) VALUES
(1, 'Systemy kontroli dostępu', 'Wysoka jakość wykonania i zastosowanie systemów ułatwiających identyfikację zdecydowanie ułatwiają proces zarządzania budynkiem, a także znacznie poprawiają bezpieczeństwo. Kontrola dostępu do drzwi za pośrednictwem urządzeń zaprojektowanych w oparciu o rozpoznawanie twarzy to jedna z możliwości chętnie wykorzystywanych w biurowcach, szkołach, hotelach, a nawet centrach handlowych. Algorytm uczenia się gwarantuje niezawodność, a zastosowane mechanizmy umożliwiają szybkie rozpoznanie twarzy poniżej 2 s. System kontroli wejść i wyjść jest równie prosty w obsłudze, co w montażu.', '2024-04-23 18:34:36', NULL),
(2, 'Systemy kontroli dostępu', 'Wysoka jakość wykonania i zastosowanie systemów ułatwiających identyfikację zdecydowanie ułatwiają proces zarządzania budynkiem, a także znacznie poprawiają bezpieczeństwo. Kontrola dostępu do drzwi za pośrednictwem urządzeń zaprojektowanych w oparciu o rozpoznawanie twarzy to jedna z możliwości chętnie wykorzystywanych w biurowcach, szkołach, hotelach, a nawet centrach handlowych. Algorytm uczenia się gwarantuje niezawodność, a zastosowane mechanizmy umożliwiają szybkie rozpoznanie twarzy poniżej 2 s. System kontroli wejść i wyjść jest równie prosty w obsłudze, co w montażu.', '2024-04-23 18:34:36', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `drzwi`
--

CREATE TABLE `drzwi` (
  `Drzwi_id` int(11) NOT NULL,
  `nr_drzwi` varchar(45) NOT NULL,
  `nazwa` varchar(45) NOT NULL,
  `WeWy` varchar(45) NOT NULL,
  `Strefy_Dostepu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `grupy`
--

CREATE TABLE `grupy` (
  `Grupy_id` int(11) NOT NULL,
  `nazwa_grupy` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `grupy`
--

INSERT INTO `grupy` (`Grupy_id`, `nazwa_grupy`) VALUES
(1, 'Super admin'),
(2, 'admin'),
(3, 'pracownik');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `karta_dostepu`
--

CREATE TABLE `karta_dostepu` (
  `Karta_Dostepu_id` int(11) NOT NULL,
  `Pracownicy_id` int(11) NOT NULL,
  `numer_seryjny` int(11) NOT NULL,
  `data_wydania` date NOT NULL,
  `data_waznosci` date NOT NULL,
  `karta_aktywna` tinyint(1) NOT NULL DEFAULT 0,
  `inne_dane` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `karta_dostepu`
--

INSERT INTO `karta_dostepu` (`Karta_Dostepu_id`, `Pracownicy_id`, `numer_seryjny`, `data_wydania`, `data_waznosci`, `karta_aktywna`, `inne_dane`) VALUES
(1, 2, 23432424, '2024-04-23', '2025-04-22', 0, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `karta_dostepu_has_strefy_dostepu`
--

CREATE TABLE `karta_dostepu_has_strefy_dostepu` (
  `Karta_Dostepu_id` int(11) NOT NULL,
  `Strefy_Dostepu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `karta_dostepu_has_strefy_dostepu`
--

INSERT INTO `karta_dostepu_has_strefy_dostepu` (`Karta_Dostepu_id`, `Strefy_Dostepu_id`) VALUES
(1, 2),
(1, 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `logi_kart`
--

CREATE TABLE `logi_kart` (
  `Logi_kart_id` int(11) NOT NULL,
  `Karta_Dostepu_id` int(11) NOT NULL,
  `Strefy_Dostepu_id` int(11) NOT NULL,
  `data_proby` datetime NOT NULL,
  `dostęp_przyznany` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE `pracownicy` (
  `Pracownicy_id` int(11) NOT NULL,
  `Grupy_id` int(11) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `imie` varchar(45) NOT NULL,
  `nazwisko` varchar(45) NOT NULL,
  `konto_aktywne` tinyint(1) NOT NULL,
  `Data_edycji` datetime DEFAULT NULL,
  `Data_utworzenia` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `pracownicy`
--

INSERT INTO `pracownicy` (`Pracownicy_id`, `Grupy_id`, `email`, `password`, `imie`, `nazwisko`, `konto_aktywne`, `Data_edycji`, `Data_utworzenia`) VALUES
(1, 1, 'jan@example.com', '$2y$10$VsrteT4E.e7al.QlmEtD0u6VVYTMvb.BnDYcpyfOX6oqnWZ3fyOb6', 'Jan', 'Kowalski', 1, NULL, '2024-04-23 16:52:42'),
(2, 1, 'rafilix11@gmail.com', '$2y$10$VsrteT4E.e7al.QlmEtD0u6VVYTMvb.BnDYcpyfOX6oqnWZ3fyOb6', 'Admin', 'Admin', 1, NULL, '2024-05-14 19:21:29');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rodzaj_drzwi_has_logi_kart`
--

CREATE TABLE `rodzaj_drzwi_has_logi_kart` (
  `Drzwi_id` int(11) NOT NULL,
  `Logi_kart_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('KRMyTRYYepJGL4uaSTafYp9U0RoLSxBkVxVTBvR1', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 OPR/107.0.0.0 (Edition std-1)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUXcwSkVxVWhtcHFsazI0WW1xVVl5Qkp5Q2VrTlF0QW5ZUjJ5SjhUNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1713889391);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `strefy_dostepu`
--

CREATE TABLE `strefy_dostepu` (
  `Strefy_Dostepu_id` int(11) NOT NULL,
  `nazwa_strefy` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `strefy_dostepu`
--

INSERT INTO `strefy_dostepu` (`Strefy_Dostepu_id`, `nazwa_strefy`) VALUES
(1, 'Strefa A'),
(2, 'Strefa B'),
(3, 'Strefa C'),
(4, 'Wyjście z obiektu');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `aktualnosci`
--
ALTER TABLE `aktualnosci`
  ADD PRIMARY KEY (`Aktualnosci_id`);

--
-- Indeksy dla tabeli `drzwi`
--
ALTER TABLE `drzwi`
  ADD PRIMARY KEY (`Drzwi_id`),
  ADD KEY `fk_Strefy_Dostepu3_idx` (`Strefy_Dostepu_id`);

--
-- Indeksy dla tabeli `grupy`
--
ALTER TABLE `grupy`
  ADD PRIMARY KEY (`Grupy_id`);

--
-- Indeksy dla tabeli `karta_dostepu`
--
ALTER TABLE `karta_dostepu`
  ADD PRIMARY KEY (`Karta_Dostepu_id`),
  ADD KEY `fk_Pracownicy8_idx` (`Pracownicy_id`);

--
-- Indeksy dla tabeli `karta_dostepu_has_strefy_dostepu`
--
ALTER TABLE `karta_dostepu_has_strefy_dostepu`
  ADD PRIMARY KEY (`Karta_Dostepu_id`,`Strefy_Dostepu_id`),
  ADD KEY `fk_Strefy_Dostepu1_idx` (`Strefy_Dostepu_id`),
  ADD KEY `fk_Karta_Dostepu2_idx` (`Karta_Dostepu_id`);

--
-- Indeksy dla tabeli `logi_kart`
--
ALTER TABLE `logi_kart`
  ADD PRIMARY KEY (`Logi_kart_id`),
  ADD KEY `fk_Strefy_Dostepu2_idx` (`Strefy_Dostepu_id`),
  ADD KEY `fk_Karta_Dostepu3_idx` (`Karta_Dostepu_id`);

--
-- Indeksy dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`Pracownicy_id`),
  ADD KEY `fk_Grupy1_idx` (`Grupy_id`);

--
-- Indeksy dla tabeli `rodzaj_drzwi_has_logi_kart`
--
ALTER TABLE `rodzaj_drzwi_has_logi_kart`
  ADD PRIMARY KEY (`Drzwi_id`,`Logi_kart_id`),
  ADD KEY `fk_Logi_kart1_idx` (`Logi_kart_id`),
  ADD KEY `fk_Rodzaj_drzwi1_idx` (`Drzwi_id`);

--
-- Indeksy dla tabeli `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeksy dla tabeli `strefy_dostepu`
--
ALTER TABLE `strefy_dostepu`
  ADD PRIMARY KEY (`Strefy_Dostepu_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktualnosci`
--
ALTER TABLE `aktualnosci`
  MODIFY `Aktualnosci_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `drzwi`
--
ALTER TABLE `drzwi`
  MODIFY `Drzwi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grupy`
--
ALTER TABLE `grupy`
  MODIFY `Grupy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `karta_dostepu`
--
ALTER TABLE `karta_dostepu`
  MODIFY `Karta_Dostepu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logi_kart`
--
ALTER TABLE `logi_kart`
  MODIFY `Logi_kart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pracownicy`
--
ALTER TABLE `pracownicy`
  MODIFY `Pracownicy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `strefy_dostepu`
--
ALTER TABLE `strefy_dostepu`
  MODIFY `Strefy_Dostepu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `drzwi`
--
ALTER TABLE `drzwi`
  ADD CONSTRAINT `fk_Strefy_Dostepu3` FOREIGN KEY (`Strefy_Dostepu_id`) REFERENCES `strefy_dostepu` (`Strefy_Dostepu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `karta_dostepu`
--
ALTER TABLE `karta_dostepu`
  ADD CONSTRAINT `fk_Pracownicy8` FOREIGN KEY (`Pracownicy_id`) REFERENCES `pracownicy` (`Pracownicy_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `karta_dostepu_has_strefy_dostepu`
--
ALTER TABLE `karta_dostepu_has_strefy_dostepu`
  ADD CONSTRAINT `fk_Karta_Dostepu2` FOREIGN KEY (`Karta_Dostepu_id`) REFERENCES `karta_dostepu` (`Karta_Dostepu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Strefy_Dostepu1` FOREIGN KEY (`Strefy_Dostepu_id`) REFERENCES `strefy_dostepu` (`Strefy_Dostepu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `logi_kart`
--
ALTER TABLE `logi_kart`
  ADD CONSTRAINT `fk_Karta_Dostepu3` FOREIGN KEY (`Karta_Dostepu_id`) REFERENCES `karta_dostepu` (`Karta_Dostepu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Strefy_Dostepu2` FOREIGN KEY (`Strefy_Dostepu_id`) REFERENCES `strefy_dostepu` (`Strefy_Dostepu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD CONSTRAINT `fk_Grupy1` FOREIGN KEY (`Grupy_id`) REFERENCES `grupy` (`Grupy_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rodzaj_drzwi_has_logi_kart`
--
ALTER TABLE `rodzaj_drzwi_has_logi_kart`
  ADD CONSTRAINT `fk_Logi_kart1` FOREIGN KEY (`Logi_kart_id`) REFERENCES `logi_kart` (`Logi_kart_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Rodzaj_drzwi1` FOREIGN KEY (`Drzwi_id`) REFERENCES `drzwi` (`Drzwi_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
