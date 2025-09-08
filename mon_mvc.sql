
--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(4, 'admin', '$2y$10$zoLxh2NrJLt3nCXUKrMFA.wvDzmOdalrHoE92lO.JjK6XG/5GvWNS');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `name` varchar(75) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(35) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `name`, `phone`, `email`, `message`, `created_at`) VALUES
(14, 'zied ', '76548', 'benalizied64@yahoo.fr', 'bien et merci', '2025-05-26 00:52:10'),
(15, 'sj', '9876', 'chouasouj@gmail.com', 'peux tu bla bla', '2025-05-26 03:36:45'),
(17, 'ba z', '98742', 'k@k.d', 'uauaua', '2025-05-26 04:41:12'),
(18, 'malak', '543', 'malekhatbi24@gmail.com', 'ok malak ', '2025-05-26 04:42:41'),
(19, 'malakzi', '9999', 'mkzied@yahoo.fr', 'excellent service', '2025-05-27 02:02:33'),
(21, 'soujoud', '232323', 'benalizied64@yahoo.fr', 'hi zied, avex vous des produits cuisinieres?', '2025-05-29 04:59:39');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_firstname` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_address` varchar(500) NOT NULL,
  `customer_phone` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `customer_firstname`, `customer_email`, `customer_address`, `customer_phone`, `total_amount`, `order_date`, `status`) VALUES
(10, 'Ziad', 'Ben Ali', 'benalizied83@gmail.com', 'b', '4184468760', 857.99, '2025-05-31 07:31:30', 'pending'),
(11, 'Ziad', 'Ben Ali', 'benalizied83@gmail.com', 'n', '4184468760', 388.00, '2025-05-31 07:54:51', 'pending'),
(12, 'ben ali', 'ba', 'benalizievvvvd64@yahoo.fr', 'm', '4389783478', 1356.99, '2025-05-31 08:01:33', 'pending'),
(13, 'ben ali', 'ba', 'benalizievvvvd64@yahoo.fr', 'm', '4389783478', 155.00, '2025-05-31 08:38:37', 'pending'),
(14, 'ben ali', 'ba', 'benalizievvvvd64@yahoo.fr', 'm', '4389783478', 155.00, '2025-05-31 08:38:50', 'pending'),
(15, 'ben ali', 'ba', 'benalizievvvvd64@yahoo.fr', 'n', '4389783478', 189.99, '2025-05-31 08:48:47', 'pending'),
(16, 'ben ali', 'ba', 'benalizievvvvd64@yahoo.fr', '16-6525 Rue Hochelaga, Montréal, QC, H1N 1X7', '88', 1000.00, '2025-05-31 08:53:10', 'pending'),
(17, 'neige', 'cote', 'benalizievvvvd64@yahoo.fr', '16-6525 Rue Hochelaga, Montréal, QC, H1N 1X7', '4389783478', 167.00, '2025-05-31 08:54:24', 'pending'),
(18, 'neigeccccccccc', 'cote', 'benalizievvvvd64@yahoo.fr', '16-6525 Rue Hochelaga, Montréal, QC, H1N 1X7', '99', 222.00, '2025-05-31 08:56:30', 'pending'),
(19, 'neige', 'cote', 'benalizievvvvd64@yahoo.fr', '16-6525 Rue Hochelaga, Montréal, QC, H1N 1X7', '9900', 155.00, '2025-05-31 08:58:14', 'pending'),
(20, 'neige', 'cote', 'benalizievvvvd64@yahoo.fr', '16-6525 Rue Hochelaga, Montréal, QC, H1N 1X7', '4389783478', 1000.00, '2025-05-31 09:04:16', 'pending'),
(21, 'laaaaaaaaaaa', 'cote', 'benalizievvvvd64@yahoo.fr', '16-6525 Rue Hochelaga, Montréal, QC, H1N 1X7', '33', 155.00, '2025-05-31 09:08:36', 'pending'),
(22, 'hhh', 'cote', 'benalizievvvvd64@yahoo.fr', '62 hlgaaaaaaaa', '331', 1656.00, '2025-05-31 09:54:34', 'pending'),
(23, 'hhh', 'cote', 'benalizievvvvd64@yahoo.fr', 'anjou', '3314445', 1252.00, '2025-06-03 13:51:41', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `item_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `quantity`, `unit_price`, `item_total`) VALUES
(23, 10, 'souris', 1, 189.99, 189.99),
(24, 10, 'Smartphone Pro14', 4, 167.00, 668.00),
(25, 11, 'me', 1, 333.00, 333.00),
(26, 11, 'stade', 1, 55.00, 55.00),
(27, 12, 'ordinateur acer', 1, 1000.00, 1000.00),
(28, 12, 'souris', 1, 189.99, 189.99),
(29, 12, 'Smartphone Pro14', 1, 167.00, 167.00),
(30, 13, 'smartphone', 1, 155.00, 155.00),
(31, 14, 'smartphone', 1, 155.00, 155.00),
(32, 15, 'souris', 1, 189.99, 189.99),
(33, 16, 'ordinateur acer', 1, 1000.00, 1000.00),
(34, 17, 'Smartphone Pro14', 1, 167.00, 167.00),
(35, 18, 'Mic PC', 1, 222.00, 222.00),
(36, 19, 'smartphone', 1, 155.00, 155.00),
(37, 20, 'smartphone portable 5G', 1, 1000.00, 1000.00),
(38, 21, 'smartphone', 1, 155.00, 155.00),
(39, 22, 'smartphone', 1, 155.00, 155.00),
(40, 22, 'ordinateur acer', 1, 1000.00, 1000.00),
(41, 22, 'Smartphone Pro14', 3, 167.00, 501.00),
(42, 23, 'me', 3, 333.00, 999.00),
(43, 23, 'stade', 1, 55.00, 55.00),
(44, 23, 'pc hp i7', 2, 99.00, 198.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `qtt` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `description`, `qtt`) VALUES
(2, 'Smartphone Pro14', 167.00, 'images/images2.jpeg', 'deniere version de pro', 122),
(3, 'souris', 189.99, 'images/sr3.jpeg', 'souris blutooth detectable', 23),
(4, 'ordinateur acer', 1000.00, 'images/acer.jpeg', NULL, NULL),
(7, 'smartphone', 155.00, 'images/smart1', NULL, 99),
(8, 'smartphone portable 5G', 1000.00, 'images/smart5g.png', '5ieme generation', 234),
(9, 'tablette LG', 220.00, '../public/images/6822e4777a4d9_moi.jpeg', 'une tablette pour triple fonction', 0),
(10, 'me', 333.00, 'images/2.png', NULL, NULL),
(13, 'stade', 55.00, 'images/stade.jpg', NULL, NULL),
(14, 'pc hp i7', 99.00, 'images/Z (Note Cards).gif', NULL, NULL),
(20, 'Imprimante  Canon', 143.00, '../public/images/6826a484a8652_imprimente canon.jpg', 'Imprimante multifonction Maxify MB2150 Canon\r\n', 23),
(22, 'cle usb 2.0', 15.00, '../public/images/6827adf96595a_usb.jpg.crdownload', ' Clé USB d’une capacité de plus de 4 Go', 22),
(23, 'usb charging', 15.90, '../public/images/6827b2989ca4b_usb-charging.jpeg', 'USB 2.0 – Micro-USB to USB Cable – High-Speed A Male to Micro B (10 Feet) 2 Pack', 2),
(24, 'Apple VR/MR', 233.00, '../public/images/682c0cab5c852_682790f0ad14c_appleArVr.png', 'lunettte numerique d enregistrement video', 55),
(25, 'Android  A16 5g malak', 150.00, '../public/images/682c136f95b89_dd.png', 'telephone android galaxy capacite 256 gb', 1),
(26, 'ServerBox Tv', 54.00, '../public/images/683285a39b197_356759200_798191238509874_3234353008516108844_n.jpg', 'Box toute option', 37),
(27, 'Mic PC', 222.00, '../public/images/6833ecd3f1c2d_mic-PC.png', ' Microphone HD Voice Earphone', 3),
(28, 'Laptop', 888.00, '../public/images/683518eb88088_images2.jpeg', 'Laptop 5ieme generation i9', 332),
(29, 'Yealink BH71 Pro Mono Bluetooth Headset', 188.00, '../public/images/683ad2080ceb9_blth.png', '‎Calling, Professional Applications, Using with Various Devices', 54),
(30, ' Car Charger,67W ', 76.00, '../public/images/683ad35c57fee_blth2.png', 'Charges 3 devices simultaneously.\r\n', 87),
(31, 'zied ben ali', 222.00, '../public/images/683f343346c09_mario.png', 'good tv', 77);

-- --------------------------------------------------------

--
-- Table structure for table `publicite_produit`
--

CREATE TABLE `publicite_produit` (
  `id_pub` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `taille` varchar(50) DEFAULT NULL,
  `couleur` varchar(50) DEFAULT NULL,
  `description_generale` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publicite_produit`
--

INSERT INTO `publicite_produit` (`id_pub`, `id_produit`, `taille`, `couleur`, `description_generale`) VALUES
(1, 22, '40 cm', 'bleu', 'usb 2 , 2.0\r\nplug and play'),
(2, 20, '33*29', 'noir', 'imprimente 3 en 1 ,\r\ncouleur/noir et blanc'),
(4, 27, 'moyen', 'noir', 'Headsets USB/3.5mm with Microphone HD Voice Earphone for PC/Laptop/phone');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `publicite_produit`
--
ALTER TABLE `publicite_produit`
  ADD PRIMARY KEY (`id_pub`),
  ADD KEY `fk_id_produit` (`id_produit`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `publicite_produit`
--
ALTER TABLE `publicite_produit`
  MODIFY `id_pub` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `publicite_produit`
--
ALTER TABLE `publicite_produit`
  ADD CONSTRAINT `fk_id_produit` FOREIGN KEY (`id_produit`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


/htdocs
├── index.php
├── app/
│   ├── controllers/
│   │   ├── Controller.php
│   │   └── ProductController.php
│   ├── models/
│   │   ├── Model.php
│   │   └── ProductModel.php
│   └── views/
│       └── products/
│           └── index.php
├── config/
│   └── Database.php
└── public/
    ├── images/
    │   ├── acer.jpeg
    │   ├── images2.jpeg
    │   ├── sr3.jpeg
    │   └── ... (autres images)
    └── .htaccess