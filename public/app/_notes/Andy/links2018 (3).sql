-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2018 at 03:04 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `links2018`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `primary_key` int(11) NOT NULL,
  `mime` varchar(255) NOT NULL,
  `extension` varchar(100) NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `path` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `type`, `primary_key`, `mime`, `extension`, `size`, `description`, `path`, `user_id`, `created`, `modified`) VALUES
(1, 'post', 0, 'image/jpeg', '.jpg', '190.48', '10', 'sb-admin/js/assets/uploads/10.jpg', 1, '2015-12-24 23:43:29', '2015-12-24 23:43:29'),
(2, 'post', 0, 'image/jpeg', '.jpg', '305.92', '6', 'sb-admin/js/assets/uploads/6.jpg', 1, '2015-12-24 23:48:00', '2015-12-24 23:48:00'),
(3, 'post', 0, 'image/jpeg', '.jpg', '340.45', '9', 'sb-admin/js/assets/uploads/9.jpg', 1, '2015-12-24 23:48:29', '2015-12-24 23:48:29'),
(4, 'post', 0, 'image/jpeg', '.jpg', '190.48', '10', 'sb-admin/js/assets/uploads/10.jpg', 1, '2015-12-24 23:48:45', '2015-12-24 23:48:45'),
(5, 'post', 0, 'image/jpeg', '.jpg', '467.65', 'hero', 'sb-admin/js/assets/uploads/hero.jpg', 1, '2015-12-24 23:49:10', '2015-12-24 23:49:10'),
(6, 'post', 0, 'image/jpeg', '.jpg', '552.86', 'blur', 'sb-admin/js/assets/uploads/blur.jpg', 1, '2015-12-24 23:49:42', '2015-12-24 23:49:42'),
(7, 'post', 0, 'image/jpeg', '.jpg', '305.92', '6', 'sb-admin/js/assets/uploads/6.jpg', 1, '2015-12-24 23:55:13', '2015-12-24 23:55:13'),
(8, 'post', 0, 'image/jpeg', '.jpg', '186.94', '8', 'sb-admin/js/assets/uploads/8.jpg', 1, '2015-12-24 23:57:38', '2015-12-24 23:57:38'),
(9, 'post', 0, 'image/jpeg', '.jpg', '552.86', 'blur', 'sb-admin/js/assets/uploads/blur.jpg', 1, '2015-12-24 23:57:50', '2015-12-24 23:57:50'),
(10, 'post', 0, 'image/jpeg', '.jpg', '186.94', '8', 'sb-admin/js/assets/uploads/8.jpg', 1, '2015-12-24 23:57:56', '2015-12-24 23:57:56'),
(11, 'post', 0, 'image/jpeg', '.jpg', '190.48', '10', 'sb-admin/js/assets/uploads/10.jpg', 1, '2015-12-24 23:58:33', '2015-12-24 23:58:33'),
(12, 'post', 0, 'image/jpeg', '.jpg', '340.45', '9', 'sb-admin/js/assets/uploads/9.jpg', 1, '2015-12-24 23:58:58', '2015-12-24 23:58:58'),
(13, 'post', 0, 'image/jpeg', '.jpg', '305.92', '6', 'sb-admin/js/assets/uploads/6.jpg', 1, '2015-12-25 00:00:54', '2015-12-25 00:00:54'),
(14, 'post', 0, 'image/jpeg', '.jpg', '209.27', '7', 'sb-admin/js/assets/uploads/7.jpg', 1, '2015-12-25 00:02:24', '2015-12-25 00:02:24'),
(15, 'post', 0, 'image/jpeg', '.jpg', '209.27', '7', 'sb-admin/js/assets/uploads/7.jpg', 9, '2015-12-26 02:35:57', '2015-12-26 02:35:57'),
(16, 'post', 0, 'image/jpeg', '.jpg', '268.98', '5', 'sb-admin/js/assets/uploads/5.jpg', 9, '2015-12-26 02:37:39', '2015-12-26 02:37:39'),
(17, 'post', 0, 'image/jpeg', '.jpg', '238.62', '3', 'sb-admin/js/assets/uploads/3.jpg', 9, '2015-12-26 02:40:10', '2015-12-26 02:40:10'),
(18, 'post', 0, 'image/jpeg', '.jpg', '161.11', 'leaf', 'sb-admin/js/assets/uploads/leaf.jpg', 1, '2015-12-27 01:31:27', '2015-12-27 01:31:27'),
(19, 'post', 0, 'image/png', '.png', '0.96', 'header_bg', 'sb-admin/js/assets/uploads/header_bg.png', 1, '2015-12-27 01:31:59', '2015-12-27 01:31:59'),
(20, 'post', 0, 'image/jpeg', '.jpg', '32.27', 'bridge', 'sb-admin/js/assets/uploads/bridge.jpg', 1, '2015-12-27 01:32:12', '2015-12-27 01:32:12'),
(21, 'post', 0, 'image/jpeg', '.jpg', '826.11', 'Desert', 'sb-admin/js/assets/uploads/Desert.jpg', 1, '2018-09-04 02:37:36', '2018-09-04 02:37:36');

-- --------------------------------------------------------

--
-- Table structure for table `assets_posts`
--

CREATE TABLE `assets_posts` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `status`) VALUES
(1, 'Web Programming', 'web-programming', 1),
(2, 'Web Design', 'web-design', 1),
(3, 'Network  & Security', 'network-security', 0),
(4, 'Search Engine Optimation (SEO)', 'search-engine-optimation-seo', 1),
(11, 'New Post New Post', 'new-post-new-post', 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `body` text,
  `type` varchar(100) NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `published_at` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `body`, `type`, `featured_image`, `status`, `published_at`, `user_id`, `created`, `modified`) VALUES
(1, 'Justice Department Sets Sights on Wall Street Executives', 'justice-department-sets-sights-on-wall-street-executives', '<p>Evelio said... Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p> <p> Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. <br></p><p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p> <p> Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. <br></p><br><br><img src=\"/ci-blog/assets/uploads/7.jpg\"><br>', 'post', 'assets/uploads/blur.jpg', 1, '2015-12-30', 1, '2015-12-25 01:29:57', '2018-08-31 01:54:54'),
(2, 'Uis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla ', 'uis-aute-irure-dolor-in-reprehenderit-in-voluptate-velit-esse-cillum-dolore-eu-fugiat-nulla', '<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p> <p> Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. <br></p><br><img src=\"/product/ci-blog/assets/uploads/8.jpg\" height=\"388\" width=\"749\"><br><br><p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p> <p> Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. <br></p><p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p> <p> Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. </p><br>', 'post', 'assets/uploads/blur.jpg', 1, '2015-12-17', 1, '2015-12-25 02:11:57', '2015-12-26 02:22:06'),
(3, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit', 'lorem-ipsum-dolor-sit-amet-consectetur-adipisicing-elit', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. <br><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. <br><br><img src=\"/product/ci-blog/assets/uploads/3.jpg\" height=\"512\" width=\"805\"><br><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. <br><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. <br><br>', 'post', 'assets/uploads/3.jpg', 1, '2015-12-26', 9, '2015-12-26 02:42:38', '2015-12-26 16:37:03'),
(6, 'About Us', 'about-us', '<img src=\"/product/ci-blog/assets/uploads/3.jpg\"><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus. Phasellus pharetra nulla ac diam. Quisque semper justo at risus. Donec venenatis, turpis vel hendrerit interdum, dui ligula ultricies purus, sed posuere libero dui id orci. Nam congue, pede vitae dapibus aliquet, elit magna vulputate arcu, vel tempus metus leo non est. Etiam sit amet lectus quis est congue mollis. Phasellus congue lacus eget neque. Phasellus ornare, ante vitae consectetuer consequat, purus sapien ultricies dolor, et mollis pede metus eget nisi. Praesent sodales velit quis augue.<br><br><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus. Phasellus pharetra nulla ac diam. Quisque semper justo at risus. Donec venenatis, turpis vel hendrerit interdum, dui ligula ultricies purus, sed posuere libero dui id orci. Nam congue, pede vitae dapibus aliquet, elit magna vulputate arcu, vel tempus metus leo non est. Etiam sit amet lectus quis est congue mollis. Phasellus congue lacus eget neque. Phasellus ornare, ante vitae consectetuer consequat, purus sapien ultricies dolor, et mollis pede metus eget nisi. Praesent sodales velit quis augue. <br><br><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus. Phasellus pharetra nulla ac diam. Quisque semper justo at risus. Donec venenatis, turpis vel hendrerit interdum, dui ligula ultricies purus, sed posuere libero dui id orci. Nam congue, pede vitae dapibus aliquet, elit magna vulputate arcu, vel tempus metus leo non est. Etiam sit amet lectus quis est congue mollis. Phasellus congue lacus eget neque. Phasellus ornare, ante vitae consectetuer consequat, purus sapien ultricies dolor, et mollis pede metus eget nisi. Praesent sodales velit quis augue. <br><br>', 'page', '', 1, '2015-12-26', 1, '2015-12-26 19:08:39', '2015-12-27 01:44:35'),
(7, 'My Post', 'my-post', '<p id=\"yui_3_18_0_3_1536009839261_6141\">It’s widely known Google has some of the best software engineers on the planet. Last July, one of them — a Google engineer who works in the company’s Sunnyvale offices — decided to put his skills to the test. Er, against his employer.</p> <p>David Tomaschik found a software vulnerability that allowed him to hack open doors on campus that you were supposed to need an RFID keycard for. He hacked up some code, sent it across the company’s network, and quickly saw the light on the door to his office turn from red to green.</p><p><img src=\"/links/sb-admin/js/assets/uploads/6.jpg\"><br></p><!--?php echo !empty($post[\'body\']) ? addslashes($post[\'body\']) :\'\';?-->', 'post', '', 0, '2018-09-03', 1, '2018-09-02 19:23:37', '2018-09-04 02:01:35');

-- --------------------------------------------------------

--
-- Table structure for table `posts_categories`
--

CREATE TABLE `posts_categories` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts_categories`
--

INSERT INTO `posts_categories` (`id`, `post_id`, `category_id`) VALUES
(6, 1, 4),
(7, 2, 3),
(10, 3, 1),
(15, 3, 3),
(17, 7, 11),
(18, 7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `posts_tags`
--

CREATE TABLE `posts_tags` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts_tags`
--

INSERT INTO `posts_tags` (`id`, `post_id`, `tag_id`) VALUES
(5, 3, 1),
(6, 3, 6),
(7, 3, 7),
(8, 1, 7),
(9, 1, 5),
(10, 7, 7),
(11, 7, 6),
(12, 7, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assets_posts`
--
ALTER TABLE `assets_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_assets_posts_posts1` (`post_id`),
  ADD KEY `fk_assets_posts_assets1` (`asset_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts_categories`
--
ALTER TABLE `posts_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_posts_categories_categories1` (`category_id`),
  ADD KEY `fk_posts_categories_posts1` (`post_id`);

--
-- Indexes for table `posts_tags`
--
ALTER TABLE `posts_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_posts_tags_tags1` (`tag_id`),
  ADD KEY `fk_posts_tags_posts1` (`post_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `assets_posts`
--
ALTER TABLE `assets_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `posts_categories`
--
ALTER TABLE `posts_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `posts_tags`
--
ALTER TABLE `posts_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `assets_posts`
--
ALTER TABLE `assets_posts`
  ADD CONSTRAINT `fk_assets_posts_assets1` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_assets_posts_posts1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `posts_categories`
--
ALTER TABLE `posts_categories`
  ADD CONSTRAINT `fk_posts_categories_categories1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_posts_categories_posts1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `posts_tags`
--
ALTER TABLE `posts_tags`
  ADD CONSTRAINT `fk_posts_tags_posts1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_posts_tags_tags1` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
