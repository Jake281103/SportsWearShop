-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 25, 2024 at 07:14 AM
-- Server version: 8.0.40-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sixtynine`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`) VALUES
(1, 'mg mg', 'mg@gmail.com', '$2y$10$xjMu8GjZzk2xNBs6gepQXOPt9NrK692ozia13KOhITAtkLcNM4ot6'),
(2, 'Kyaw Kyaw', 'kyaw@gmail.com', '$2y$10$P8G.NMFoKRrTgaZd7ATrp.Mv44biQiTUSduq7uqdnp7zm.FAsxAL2'),
(3, 'aung aung', 'aung@gmail.com', '$2y$10$36Nsqgw1NngxoDfOmafIoudZJ6alx24vY8Tekt0H7JYzWRSnNUeQC');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `products_id` int NOT NULL,
  `size_id` int NOT NULL,
  `count` int NOT NULL,
  `totalprice` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `products_id`, `size_id`, `count`, `totalprice`) VALUES
(5, 1, 6, 11, 1, 200.19),
(6, 1, 6, 13, 2, 400.38),
(7, 1, 8, 2, 2, 628.44);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'running shoes'),
(2, 'basketball shoes'),
(3, 'top & t-shirts'),
(4, 'shorts'),
(5, 'socks'),
(6, 'bags'),
(7, 'headwears'),
(8, 'football shoes'),
(9, 'training & gym'),
(10, 'sweatshirts');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE `orderdetail` (
  `id` int NOT NULL,
  `orders_id` int NOT NULL,
  `products_id` int NOT NULL,
  `quantity` int NOT NULL,
  `totalprice` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orderdetail`
--

INSERT INTO `orderdetail` (`id`, `orders_id`, `products_id`, `quantity`, `totalprice`) VALUES
(1, 3, 2, 1, 147.99),
(2, 4, 2, 1, 147.99),
(3, 5, 2, 1, 147.99),
(4, 5, 15, 2, 78.00),
(5, 6, 7, 2, 199.98),
(6, 6, 6, 1, 200.19),
(7, 7, 8, 2, 628.44);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `totalprice` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `totalprice`) VALUES
(1, 1, 225.99),
(2, 1, 225.99),
(3, 1, 225.99),
(4, 1, 225.99),
(5, 1, 225.99),
(6, 7, 400.17),
(7, 7, 628.44);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `crid` int NOT NULL,
  `crnumber` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `crname` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `expdate` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ccv` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`crid`, `crnumber`, `crname`, `expdate`, `ccv`) VALUES
(1, '222222222222', 'thaw maung oo', '11/25', '222');

-- --------------------------------------------------------

--
-- Table structure for table `productreview`
--

CREATE TABLE `productreview` (
  `id` int NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` int NOT NULL,
  `products_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `productreview`
--

INSERT INTO `productreview` (`id`, `title`, `content`, `rating`, `products_id`, `user_id`) VALUES
(2, 'perfect', 'I got the perfect product. It is better than one that I was expected.', 5, 8, 1),
(3, 'good', 'I have found the perfect product, and it surpasses my expectations.', 4, 8, 1),
(4, 'Nice Once', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage.', 5, 7, 1),
(5, 'Perfect', 'Smooth on the outside and brushed soft on the inside, this roomy fleece sweatshirt is an easy layer when you want a little extra warmth.', 5, 6, 1),
(6, 'Perfect', 'Smooth on the outside and brushed soft on the inside, this roomy fleece sweatshirt is an easy layer when you want a little extra warmth.', 5, 6, 1),
(7, 'Wonderful', 'an energized ride for everyday road running, day or night. Experience lighter-weight energy return with dual Air Zoom units and a ReactX foam midsole.', 5, 5, 1),
(8, 'All Fine', 'an energized ride for everyday road running, day or night. Experience lighter-weight energy return with dual Air Zoom units and a ReactX foam midsole.', 4, 5, 1),
(9, 'this is fine', 'an energized ride for everyday road running, day or night. Experience lighter-weight energy return with dual Air Zoom units and a ReactX foam midsole.', 3, 5, 1),
(10, 'Perfect Running Shoe', 'When visiting our site, pre-selected companies may access and use certain information on your device and about this web page to serve relevant ads or personalised content.', 5, 1, 7),
(11, 'Perfect', 'We, the \'Publisher\', and a select group of trusted partners (850), known as \'Vendors\', need your consent for data-processing purposes. These purposes include to store and/or access information on a device,', 3, 2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `type`, `price`, `url`, `category_id`) VALUES
(1, 'Nike Alphafly 3 ', 'Fine-tuned for marathon speed, the Alphafly 3 helps push you beyond what you thought possible. Three innovative technologies power your run: A double dose of Air Zoom units helps launch you into your next step; a full-length carbon fiber plate helps propel you forward with ease; and a heel-to-toe ZoomX foam midsole helps keep you fresh from start to 26.2. Time to leave your old personal records in the dust.', 'male', 285.00, 'assets/images/img/products/prodcut1.png', 1),
(2, 'Nike G.T. Hustle 3', 'One step can makes all the difference when it\'s game point, like a sneaky successful back-door layup that\'s blocked if not for a sliver of separation, or a last-second leap at your opponent that sends their 3 clanking off the rim. We used insights from female athletes to make the G.T. Hustle 2 soft, supportive and lightweight—which every basketball player needs.', 'male', 147.99, 'assets/images/img/products/Wednesday-6th-November-2024-562110328.png', 2),
(3, 'Nike Phantom Luna 2 Elite', 'Obsessed with perfecting your craft? We made this for you. In the middle of the storm, with chaos swirling all around you, you\'ve calmly found the final third of the pitch, thanks to your uncanny mix of on-ball guile and grace.', 'male', 379.00, 'assets/images/img/products/Wednesday-6th-November-2024-637302235.png', 8),
(5, 'Nike Pegasus 41 Premium', 'Responsive cushioning in the winterized Pegasus provides an energized ride for everyday road running, day or night. Experience lighter-weight energy return with dual Air Zoom units and a ReactX foam midsole.', 'male', 150.00, 'assets/images/img/products/Friday-8th-November-2024-1791780464.png', 1),
(6, 'Jordan Brooklyn Fleece', 'Meet Jordan\'s take on the season\'s most festive print. Smooth on the outside and brushed soft on the inside, this roomy fleece sweatshirt is an easy layer when you want a little extra warmth.', 'female', 200.19, 'assets/images/img/products/Friday-8th-November-2024-1894359230.jpeg', 3),
(7, 'Phoenix Fleece Women\'s Artist Collection', 'Artist Anna Deller-Yee\'s work highlights the full spectrum of feminine expression through rich floral hues. With cosy fleece and soft brush strokes, this spacious sweatshirt blurs the lines between comfy essential and statement piece.', 'male', 99.99, 'assets/images/img/products/Friday-8th-November-2024-1028551478.png', 3),
(8, 'Nike Pegasus 41', 'Responsive cushioning in the Pegasus provides an energised ride for everyday road running. Experience lighter-weight energy return with dual Air Zoom units and a ReactX foam midsole.', 'female', 314.22, 'assets/images/img/products/Friday-8th-November-2024-263511355.png', 1),
(9, 'Nike Pegasus 41 Premium', 'Responsive cushioning in the winterized Pegasus provides an energised ride for everyday road running, day or night. Experience lighter-weight energy return with dual Air Zoom units and a ReactX foam midsole.', 'female', 315.00, 'assets/images/img/products/Friday-8th-November-2024-1676758138.jpeg', 1),
(10, 'Nike Dri-FIT One', 'These shorts are the ones that are down for everything you do—from long walks to HIIT to running errands. Their silky-smooth, ultra-soft woven fabric is balanced with sweat-wicking tech so you have ultimate comfort while feeling dry as you work out. ', 'female', 75.80, 'assets/images/img/products/Friday-8th-November-2024-1987027428.png', 4),
(11, 'Nike Pro 365', 'The Nike Pro 365 Shorts wrap you in stretchy fabric featuring Dri-FIT Technology, to keep you feeling supported and dry during intense workouts. ', 'female', 46.00, 'assets/images/img/products/Friday-8th-November-2024-2001533328.png', 4),
(12, 'Nike One', 'These loose-fitting shorts are the Ones that are down for everything you do. Ultra-lightweight and smooth, their woven fabric is equipped with moisture-wicking tech for those sweat-heavy moments.', 'female', 75.00, 'assets/images/img/products/Friday-8th-November-2024-976107764.png', 4),
(13, 'Sabrina 2 \'Colour Vision\' EP', 'Sabrina Ionescu\'s success is no secret. Her game is based on living in the gym, getting in rep after rep to perfect her craft. The Sabrina 2 sets you up to do more, so you\'re ready to go when it\'s game time.', 'female', 309.00, 'assets/images/img/products/Friday-8th-November-2024-1422032275.jpeg', 2),
(14, 'Book 1 EP', 'Devin Booker is a craftsman who can lose a defender with an ankle-snatching \"stutter/go\", then come back with a series of spellbinding jabs into a splashed jumper. Book\'s signature shoe gives him the tools he needs to carve. ', 'male', 359.00, 'assets/images/img/products/Friday-8th-November-2024-2099721883.png', 2),
(15, 'Nike Everyday Wool', 'From an early morning walk to hiking your local trail, these socks are built to keep up with you. A breathable and moisture-wicking wool blend is incredibly durable and hugs your feet with all-day comfort.', 'female', 39.00, 'assets/images/img/products/Friday-8th-November-2024-1326437993.png', 5),
(16, 'Nike Everyday Plus Cushioned', 'These sweat-wicking beauties are more than just breathable. They feature a reinforced heel and toe for increased durability as well as a supportive band around the arch and extra cushioning under the heel and forefoot to help keep your feet cool and comfortable.', 'female', 32.00, 'assets/images/img/products/Friday-8th-November-2024-2143714212.png', 5),
(17, 'Nike Everyday Plus Cushioned', 'You need socks that can keep up with your tempo. With extra cushioning under the heel and forefoot, a supportive arch band and sweat-wicking fabric, these socks will help keep you dry and comfortable all day long.', 'male', 29.00, 'assets/images/img/products/Friday-8th-November-2024-1025136720.png', 5),
(18, 'Nike Premium', 'Sleek, modern and made from durable polyester, the Nike Backpack is a storage staple. Its large zipped compartment comfortably fits shoes or gym clothes along with your books and laptop for school.', 'female', 75.00, 'assets/images/img/products/Friday-8th-November-2024-1182673352.jpeg', 6),
(19, 'Puffle Tote Bag', 'Puff up your style with voluminous flare. A large main compartment with a cinch closure helps keep your stuff secure, and an internal slip pocket helps keep you organised.', 'female', 159.00, 'assets/images/img/products/Friday-8th-November-2024-693294122.png', 6),
(20, 'Nike Brasilia', 'Stay organised, whatever your day holds. The main compartment of this backpack features a sleeve that can hold up to a 15\" laptop. ', 'male', 78.99, 'assets/images/img/products/Friday-8th-November-2024-45841636.png', 6),
(21, 'Football Hard-Case Duffel Bag', 'The Nike Academy Team Hard-Case Duffel Bag is a durable design built to keep you organised. Its hard bottom helps keep your gear safe, while multiple carrying points give you options when going to and from the pitch.', 'male', 77.89, 'assets/images/img/products/Friday-8th-November-2024-1977323960.png', 6),
(22, 'Nike Utility Speed 2.0 Backpack', 'Keep your gear organised with exterior zipped front pockets for small items and a spacious main compartment with a luggage-style zip that opens fully to the bottom. ', 'male', 157.00, 'assets/images/img/products/Friday-8th-November-2024-392057717.jpeg', 6),
(23, 'Nike Premium Duffel Bag', 'Made for weekend trips or extensive gym sessions, this duffel can do it all. The large main compartment features small pockets to help keep your items organised.', 'male', 82.44, 'assets/images/img/products/Friday-8th-November-2024-918495599.png', 6),
(24, 'Luka 3 PF', 'Shift your game into high gear with the lightest Luka yet. Designed to help you create space through acceleration, the Luka 3 features full-length Cushlon 3.0 foam for a smooth heel-to-toe transition.', 'male', 250.00, 'assets/images/img/products/Friday-8th-November-2024-1576683694.png', 2),
(25, 'Tatum 2 PF \'Lemonade\'', 'On those days when the sun just won\'t let up and your brow\'s wet with sweat, what\'s more refreshing than a glass of ice-cold lemonade?', 'male', 309.00, 'assets/images/img/products/Friday-8th-November-2024-1706696698.jpeg', 2),
(26, 'Nike G.T. Cut 3 EP Electric', 'Designed to help you create space for stepback jumpers and backdoor cuts, its sticky multi-court traction helps you stop in an instant and shift gears at will. ', 'male', 379.00, 'assets/images/img/products/Friday-8th-November-2024-55620516.jpeg', 2),
(27, 'Nike Mercurial Vapor 16 Club', 'The Vapor 16 is made with speed in mind. Mix that velocity with touch and comfort? It’s goal time.\r\n\r\n', 'male', 89.00, 'assets/images/img/products/Friday-8th-November-2024-844701515.png', 8),
(28, 'Nike Streetgato', 'Rule the streets in the Nike Streetgato. They blend performance details with streetwear flair so you can be ready to play at any moment.', 'male', 79.90, 'assets/images/img/products/Friday-8th-November-2024-1234263325.jpeg', 8),
(29, 'Nike Tiempo Legend 10 Club', 'The synthetic leather contours to your foot and doesn\'t overstretch, giving you better control. Lighter and sleeker than any other Tiempo to date.', 'male', 59.90, 'assets/images/img/products/Friday-8th-November-2024-1678439962.png', 8),
(30, 'Nike React Gato', 'The Nike React Gato brings a new level of underfoot control and cushioning to the court. Flexible pods improve your feel on the ball and Nike React cushioning keeps you moving as you drag and cut across the court.', 'male', 89.90, 'assets/images/img/products/Friday-8th-November-2024-1921156342.png', 8),
(31, 'Nike Dri-FIT Stride', 'The Nike Dri-FIT Stride Shorts have a lightweight feel designed for unrestricted movement. They\'re smooth to the touch with extra breathability on the upper back', 'male', 89.00, 'assets/images/img/products/Friday-8th-November-2024-30409125.png', 4),
(32, 'Nike Dri-FIT Challenger', 'With plenty of pocket space, you\'ll never have to leave your valuables (like your phone and keys) behind. Plus, their 23cm (approx.) inseam and relaxed fit give you the room to move comfortably on your journey, no matter what the distance is.', 'male', 39.00, 'assets/images/img/products/Friday-8th-November-2024-1588908431.jpeg', 4),
(33, 'Nike Dri-FIT Apex', 'Channel early-noughties vibes in the Nike Apex, our mid-depth bucket hat that dials up the cool factor of any outfit. Stretchy, sweat-wicking fabric and a sweatband keep you feeling as good as you look.', 'male', 45.00, 'assets/images/img/products/Friday-8th-November-2024-96305897.png', 7),
(34, 'Nike Dri-FIT Club', 'ts curved bill and metal Swoosh logo give your look a clean finish, while sweat-wicking fabric helps you stay cool and comfortable as you make the most of warm, sunny weather.', 'male', 35.00, 'assets/images/img/products/Friday-8th-November-2024-95598288.png', 7),
(35, 'Nike Peak Beanie', 'This ultra-soft knit beanie has Swooshes and snowflakes knitted directly into its festive pattern.', 'female', 45.00, 'assets/images/img/products/Friday-8th-November-2024-1510885966.jpeg', 7),
(36, 'Nike Dri-FIT Fly', 'The 5-panel low-depth design features stretchy, sweat-wicking fabric that will keep you fresh through every move. ', 'female', 35.00, 'assets/images/img/products/Friday-8th-November-2024-195157790.jpeg', 7),
(37, 'Nike Zenvy', 'Whether it\'s yoga or a bike ride or a walk, you can move freely in our unbelievably soft Nike Zenvy leggings. Their InfinaSoft fabric is lightweight—but still squat-proof!', 'female', 79.00, 'assets/images/img/products/Friday-8th-November-2024-1842891985.png', 9),
(38, 'Nike Universa', 'Our Nike Universa leggings help smooth and lift, stretching freely with your every move. Wherever your workout takes you, their squat-proof', 'female', 78.00, 'assets/images/img/products/Friday-8th-November-2024-308357277.png', 9),
(39, 'Nike One Classic Cropped Twist Top', 'Up for a workout or down to chill, this Nike One Classic top is ready for whatever you are. Lightweight, silky-smooth fabric dries quickly and works for wherever your day takes you.', 'female', 19.90, 'assets/images/img/products/Friday-8th-November-2024-1226071219.png', 9),
(40, 'Nike Dri-FIT', 'Keep your team covered in the Nike Dri-FIT Jacket. Soft woven fabric uses sweat-wicking technology to help keep you covered, cool and comfortable.', 'male', 67.90, 'assets/images/img/products/Friday-8th-November-2024-950435914.png', 9),
(41, 'Nike Dri-FIT Training Trousers', 'The Nike Dri-FIT Team Training Trousers are lightweight, flexible and designed to help you stay dry through your entire workout.', 'male', 49.90, 'assets/images/img/products/Friday-8th-November-2024-2063622524.', 9),
(42, 'Nike Dri-FIT Fitness T-shirt', 'Stay cool with every rep in this soft tee, highlighted by a big, bold Swoosh graphic. Nike Dri-FIT technology moves sweat away from your skin for quicker evaporation', 'male', 34.66, 'assets/images/img/products/Friday-8th-November-2024-1650793526.png', 9),
(43, 'Nike Club Fleece', 'Go big on comfort with this spacious Club Fleece crew. This midweight French terry fabric (with unbrushed loops on the inside) gives structure, breathability and softness', 'male', 99.00, 'assets/images/img/products/Friday-8th-November-2024-805240992.jpeg', 10),
(44, 'Long-Sleeve Fitness Crew', 'Sometimes you run a marathon, sometimes you run to the corner shop. Do it all 24/7, 365 in this long-sleeve, relaxed-fit layer.', 'male', 49.90, 'assets/images/img/products/Friday-8th-November-2024-2091039453.png', 10),
(45, 'Jordan Flight Fleece', 'With a slightly oversized fit, this crew neck is easy to pull on and perfect for layering. The heavy snow wash effect gives vintage vibes', 'female', 59.90, 'assets/images/img/products/Friday-8th-November-2024-739340967.jpeg', 10);

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`id`, `name`) VALUES
(1, '37'),
(2, '38'),
(3, '39'),
(4, '40'),
(5, '41'),
(6, '42'),
(7, '43'),
(8, '44'),
(9, '45'),
(10, 'xs'),
(11, 's'),
(12, 'm'),
(13, 'l'),
(14, ' xl'),
(15, 'xxl'),
(16, '3xl'),
(17, '4xl'),
(18, '1l'),
(19, '5l'),
(20, '26l'),
(21, '30l'),
(22, '80l'),
(23, '90l');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int NOT NULL,
  `products_id` int NOT NULL,
  `size_id` int NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `products_id`, `size_id`, `quantity`) VALUES
(1, 1, 1, 12),
(2, 2, 1, 22),
(3, 2, 2, 12),
(4, 3, 2, 2),
(7, 5, 4, 12),
(8, 5, 5, 3),
(9, 6, 11, 5),
(10, 6, 13, 7),
(11, 7, 12, 10),
(12, 8, 1, 10),
(13, 8, 2, 6),
(14, 9, 3, 5),
(15, 10, 11, 5),
(16, 11, 13, 5),
(17, 12, 11, 12),
(18, 12, 13, 6),
(19, 13, 4, 5),
(20, 15, 12, 13),
(21, 15, 13, 44),
(22, 16, 11, 13),
(23, 17, 13, 22),
(24, 17, 14, 6),
(25, 17, 15, 8),
(26, 18, 20, 6),
(27, 20, 20, 8),
(28, 21, 21, 5),
(29, 22, 20, 2),
(30, 24, 4, 2),
(31, 24, 5, 3),
(32, 28, 4, 3),
(33, 28, 6, 5),
(34, 29, 5, 8),
(35, 29, 6, 9),
(36, 29, 3, 4),
(37, 30, 9, 2),
(38, 26, 6, 3),
(39, 26, 3, 4),
(40, 27, 4, 6),
(41, 33, 13, 5),
(42, 34, 13, 6),
(43, 33, 12, 2),
(44, 36, 11, 4),
(45, 38, 12, 6),
(46, 39, 13, 5),
(47, 40, 13, 6),
(48, 40, 14, 3),
(49, 41, 13, 6),
(50, 41, 12, 2),
(51, 44, 13, 8),
(52, 45, 12, 12);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phonenumber` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verificationcode` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emailverified` tinyint NOT NULL DEFAULT '0',
  `profile` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `phonenumber`, `address`, `password`, `verificationcode`, `emailverified`, `profile`) VALUES
(1, 'aung aung', 'aung@gmail.com', '09337336363', 'yangon', '$2y$10$D8NQUJzv9.DPpsr31amJweoLuiv0wuR3cHPY/xWx60uDbP4B8WJaS', '446631', 1, NULL),
(2, 'mg mg', 'mgmg@gmail.com', '09378337333', 'Mandalay', '$2y$10$.zHgBiZOWhwRSbSAuwGw4OTPcoovCnKNo/FF2EHRiAd/.4DruPPnG', '783265', 1, NULL),
(3, 'Su Su', 'su@gmail.com', '09833377444', 'Mandalay', '$2y$10$p8T.Q.TAapwIGjpPZ0omLO.VYLgArMTUunUn2jR7PyWPbe.r8tjpG', '472567', 1, NULL),
(7, 'Thaw Maung Oo', 'thawmaungoo281103@gmail.com', '09888844444', 'Myeik', '$2y$10$xIJq4bOANdJELlPsb8Au9uvkzu8MGM40PhIajqJHxv5vos5ahnx9q', '126261', 1, './assets/images/img/profile/Monday-25th-November-2024-1806661559.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_id` (`products_id`),
  ADD KEY `size_id` (`size_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_id` (`orders_id`),
  ADD KEY `products_id` (`products_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`crid`),
  ADD UNIQUE KEY `crnumber` (`crnumber`),
  ADD UNIQUE KEY `ccv` (`ccv`);

--
-- Indexes for table `productreview`
--
ALTER TABLE `productreview`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_id` (`products_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_id` (`products_id`),
  ADD KEY `size_id` (`size_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orderdetail`
--
ALTER TABLE `orderdetail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `crid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `productreview`
--
ALTER TABLE `productreview`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`size_id`) REFERENCES `size` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `orderdetail_ibfk_1` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderdetail_ibfk_2` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `productreview`
--
ALTER TABLE `productreview`
  ADD CONSTRAINT `productreview_ibfk_1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productreview_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`size_id`) REFERENCES `size` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
