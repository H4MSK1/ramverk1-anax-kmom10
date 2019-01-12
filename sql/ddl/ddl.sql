SET NAMES utf8;
SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `body` text NOT NULL,
  `points` float DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of comments
-- ----------------------------
INSERT INTO `comments` VALUES ('1', '1', '1', 'This is a comment #1', '-4', '2019-01-12 15:28:33', '2019-01-12 15:37:34');
INSERT INTO `comments` VALUES ('2', '1', '1', 'This is a comment #2', '-1', '2019-01-12 15:28:39', '2019-01-12 15:35:32');
INSERT INTO `comments` VALUES ('3', '2', '1', 'Helloooo', '1', '2019-01-12 15:33:47', '2019-01-12 15:35:39');
INSERT INTO `comments` VALUES ('4', '2', '7', 'This was the perfect solution, thank you!', '0', '2019-01-12 15:59:31', '2019-01-12 15:59:31');
INSERT INTO `comments` VALUES ('5', '1', '7', 'Make sure you mark the answer as accepted :)', '0', '2019-01-12 16:00:00', '2019-01-12 16:00:00');

-- ----------------------------
-- Table structure for posts
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text NOT NULL,
  `is_question` enum('0','1') DEFAULT '0',
  `accepted_answer` int(11) DEFAULT '0',
  `answer_for_post` int(11) DEFAULT NULL,
  `points` float DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of posts
-- ----------------------------
INSERT INTO `posts` VALUES ('1', '1', 'Why is it faster to process a sorted array than an unsorted array?', 'Here is a piece of C++ code that seems very peculiar. For some strange reason, sorting the data miraculously makes the code almost six times faster.\r\n\r\n```\r\n#include &lt;algorithm&gt;\r\n#include &lt;ctime&gt;\r\n#include &lt;iostream&gt;\r\n\r\nint main()\r\n{\r\n    // Generate data\r\n    const unsigned arraySize = 32768;\r\n    int data[arraySize];\r\n\r\n    for (unsigned c = 0; c &lt; arraySize; ++c)\r\n        data[c] = std::rand() % 256;\r\n\r\n    // !!! With this, the next loop runs faster\r\n    std::sort(data, data + arraySize);\r\n\r\n    // Test\r\n    clock_t start = clock();\r\n    long long sum = 0;\r\n\r\n    for (unsigned i = 0; i &lt; 100000; ++i)\r\n    {\r\n        // Primary loop\r\n        for (unsigned c = 0; c &lt; arraySize; ++c)\r\n        {\r\n            if (data[c] &gt;= 128)\r\n                sum += data[c];\r\n        }\r\n    }\r\n\r\n    double elapsedTime = static_cast&lt;double&gt;(clock() - start) / CLOCKS_PER_SEC;\r\n\r\n    std::cout &lt;&lt; elapsedTime &lt;&lt; std::endl;\r\n    std::cout &lt;&lt; &quot;sum = &quot; &lt;&lt; sum &lt;&lt; std::endl;\r\n}\r\n```', '1', '0', null, '3', '2019-01-12 15:25:37', '2019-01-12 15:37:19');
INSERT INTO `posts` VALUES ('2', '1', null, 'This is an answer #1', '0', '0', '1', '0', '2019-01-12 15:28:58', '2019-01-12 15:28:58');
INSERT INTO `posts` VALUES ('3', '1', null, 'This is an answer #2', '0', '0', '1', '0', '2019-01-12 15:29:02', '2019-01-12 15:29:02');
INSERT INTO `posts` VALUES ('4', '1', null, 'This is an answer #3', '0', '0', '1', '0', '2019-01-12 15:29:05', '2019-01-12 15:29:05');
INSERT INTO `posts` VALUES ('5', '2', null, 'Helloooo', '0', '0', '1', '0', '2019-01-12 15:33:38', '2019-01-12 15:33:38');
INSERT INTO `posts` VALUES ('6', '2', 'How do I undo the most recent commits in Git?', 'I accidentally committed the wrong files to Git, but I haven\'t pushed the commit to the server yet.\r\n\r\nHow can I undo those commits from the local repository?', '1', '7', null, '0', '2019-01-12 15:49:49', '2019-01-12 16:00:22');
INSERT INTO `posts` VALUES ('7', '1', null, '####Undo a commit and redo\r\n\r\n```\r\n$ git commit -m \"Something terribly misguided\"             # (1)\r\n$ git reset HEAD~                                          # (2)\r\n<< edit files as necessary >>                              # (3)\r\n$ git add ...                                              # (4)\r\n$ git commit -c ORIG_HEAD                                  # (5)\r\n```\r\n\r\n 1. This is what you want to undo\r\n 2. This leaves your working tree (the state of your files on disk) unchanged but undoes the commit and leaves the changes you committed unstaged (so they\'ll appear as \"Changes not staged for commit\" in git status, and you\'ll need to add them again before committing). If you only want to add more changes to the previous commit, or change the commit message1, you could use git reset --soft HEAD~ instead, which is like git reset HEAD~ (where HEAD~ is the same as HEAD~1) but leaves your existing changes staged.\r\n 3. Make corrections to working tree files.\r\n 4. ```git add``` anything that you want to include in your new commit.\r\n 5. Commit the changes, reusing the old commit message. ```reset``` copied the old head to ```.git/ORIG_HEAD```; ```commit``` with ```-c ORIG_HEAD``` will open an editor, which initially contains the log message from the old commit and allows you to edit it. If you do not need to edit the message, you could use the ```-C``` option.\r\n\r\nIf the code is already pushed to your server and you have permissions to overwrite history (rebase) then:\r\n```\r\ngit push origin master --force\r\n```\r\n', '0', '0', '6', '0', '2019-01-12 15:55:06', '2019-01-12 15:55:06');

-- ----------------------------
-- Table structure for post_tags
-- ----------------------------
DROP TABLE IF EXISTS `post_tags`;
CREATE TABLE `post_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of post_tags
-- ----------------------------
INSERT INTO `post_tags` VALUES ('1', '1', '1');
INSERT INTO `post_tags` VALUES ('2', '2', '1');
INSERT INTO `post_tags` VALUES ('3', '3', '1');
INSERT INTO `post_tags` VALUES ('4', '4', '1');
INSERT INTO `post_tags` VALUES ('5', '5', '6');
INSERT INTO `post_tags` VALUES ('6', '6', '6');
INSERT INTO `post_tags` VALUES ('7', '7', '6');
INSERT INTO `post_tags` VALUES ('8', '8', '6');

-- ----------------------------
-- Table structure for tags
-- ----------------------------
DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) NOT NULL,
  `body` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tags
-- ----------------------------
INSERT INTO `tags` VALUES ('1', 'java', 'No description yet.');
INSERT INTO `tags` VALUES ('2', 'c++', 'No description yet.');
INSERT INTO `tags` VALUES ('3', 'performance', 'No description yet.');
INSERT INTO `tags` VALUES ('4', 'optimization', 'No description yet.');
INSERT INTO `tags` VALUES ('5', 'git', 'No description yet.');
INSERT INTO `tags` VALUES ('6', 'git-commit', 'No description yet.');
INSERT INTO `tags` VALUES ('7', 'git-reset', 'No description yet.');
INSERT INTO `tags` VALUES ('8', 'git-revert', 'No description yet.');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gravatar` varchar(255) DEFAULT NULL,
  `about` text,
  `points` float DEFAULT '0',
  `votes` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'moau17', '$2y$10$eCdRUq0pFs28UqRfiUcZw.Ch0EseR3A4Utp0pEe.JRV8lbZt7Tyzy', 'alburhan97@gmail.com', '4c7eba13696e44b82bed306f71462593', 'Hey, I\'m *moau17* and this is my page.', '3', '0', '2019-01-09 19:20:39', '2019-01-12 16:00:00');
INSERT INTO `users` VALUES ('2', 'admin', '$2y$10$r7KBOiv1CW5swhZD76G9n.vTumjIEgVxV2QRJOvTrwxIniR5..YRq', 'alburhan97@gmail.com', '4c7eba13696e44b82bed306f71462593', 'Hey, I\'m *Admin* and this is my page.', '6', '6', '2019-01-12 15:31:21', '2019-01-12 15:59:31');
