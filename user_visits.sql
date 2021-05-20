
CREATE TABLE IF NOT EXISTS `user_visits` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `view_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `page_url` varchar(255) NOT NULL,
  `views_count` int(11) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `user_visits`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `user_visits` (`id`, `ip_address`, `user_agent`, `view_date`, `page_url`, `views_count`) VALUES
(1, '130.180.212.151', 'Mozilla/5.0 (Windows NT 6.1; rv:88.0) Gecko/20100101 Firefox/88.0', '2021-05-20 08:16:22', 'https://site.com/index1.html', 2),
(2, '130.180.212.151', 'Mozilla/5.0 (Windows NT 6.1; rv:88.0) Gecko/20100101 Firefox/88.0', '2021-05-20 08:18:55', 'https://site.com/index2.html', 4);