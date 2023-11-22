-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2023 at 09:33 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forum_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message_subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `user_id`, `message_subject`, `message`, `timestamp`) VALUES
(1, 2, 'Website Feedback', 'I found the website very user-friendly and informative. Great job on the design and content!', '2023-11-09 10:27:15'),
(2, 3, 'Website Improvement Suggestions', 'While the website is good, there\'s room for improvement in the navigation menu. Consider adding more categories.', '2023-11-09 10:27:16'),
(6, 7, 'Website Accessibility', 'I found the website to be accessible and inclusive. It\'s important for users with disabilities.', '2023-11-09 10:27:16'),
(7, 2, 'Website Features', 'I like the interactive features on the website, such as the search function and user profiles.', '2023-11-09 10:27:16'),
(9, 4, 'Website Performance', 'The website\'s performance is excellent, and I appreciate the quick loading times for pages and images.', '2023-11-09 10:27:16'),
(11, 6, 'Website User Experience Feedback', 'I wanted to share my thoughts on the website user experience. Overall, it\'s quite user-friendly, and I appreciate the effort put into making the site accessible and easy to navigate. However, I did notice that the login process could be simplified, and it would be great to have a more prominent search bar on the homepage. Keep up the good work, and I\'m looking forward to seeing further enhancements in the future!', '2023-11-09 10:33:44');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`module_id`, `module_name`, `description`) VALUES
(1, 'Introduction to Computer Science', 'An introductory course covering the fundamentals of computer science.'),
(2, 'Calculus I', 'A foundational course in calculus for science and engineering students.'),
(3, 'History of Art', 'Exploration of art history from ancient civilizations to the modern era.'),
(5, 'Organic Chemistry', 'In-depth study of organic chemistry compounds and reactions.'),
(6, 'Data Structures and Algorithms', 'Advanced study of data structures and algorithm design.'),
(7, 'Linear Algebra', 'A mathematical course covering linear algebra and its applications.'),
(8, 'Introduction to Machine Learning', 'An introductory course on machine learning techniques.'),
(13, 'Digital Marketing Strategies', 'Explore effective digital marketing strategies, including social media marketing, SEO, and content marketing. Learn to create and implement successful digital campaigns.'),
(14, 'Machine Learning Fundamentals', 'Introduction to machine learning concepts, algorithms, and applications. Explore supervised and unsupervised learning techniques.'),
(15, 'Graphic Design Basics', 'Learn the fundamentals of graphic design, including principles of design, color theory, and practical design applications.'),
(16, 'Personal Finance Management', 'Essential skills for managing personal finances, covering budgeting, saving, investing, and financial planning for the future.'),
(17, 'Business Ethics and Sustainability', 'Explore ethical decision-making in business and strategies for sustainable business practices. Understand the impact of ethical choices on corporate social responsibility.'),
(18, 'Mobile App Development', 'Introduction to mobile app development for iOS and Android platforms. Learn the basics of app design, development, and deployment.'),
(19, 'Health and Wellness', 'Focus on maintaining a healthy lifestyle. Topics include nutrition, fitness, mental health, and strategies for overall well-being.'),
(20, 'Creative Writing Workshop', 'Explore the art of creative writing, covering various genres and writing techniques. Develop your storytelling skills and creativity.'),
(22, 'Cybersecurity Fundamentals', 'Introduction to cybersecurity concepts, including network security, encryption, and best practices for protecting digital information.'),
(23, 'Photography Essentials', 'Learn the basics of photography, including camera settings, composition, and post-processing techniques. Develop your skills in capturing compelling images.');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `title`, `content`, `user_id`, `module_id`, `timestamp`, `image_url`) VALUES
(1, 'How can I improve my coding skills?', 'I want to become a better programmer. Any tips on improving my coding skills?', 2, 1, '2023-11-21 09:07:13', ''),
(2, 'Recommend a good book on history', 'I\'m looking for a comprehensive history book. Any recommendations?', 2, 3, '2023-11-09 10:15:31', NULL),
(3, 'Best practices for data analysis?', 'What are some best practices for conducting data analysis in a research project?', 3, 2, '2023-11-09 10:15:31', NULL),
(4, 'Travel recommendations for Europe', 'I\'m planning a trip to Europe. Any travel recommendations and tips?', 3, 5, '2023-11-09 10:15:31', NULL),
(5, 'How to manage stress during exams?', 'Exams are approaching, and I\'m feeling stressed. Any strategies to manage stress effectively?', 4, 6, '2023-11-09 10:15:31', NULL),
(6, 'Recommendations for learning a new language', 'I want to learn a new language. Any good language learning resources?', 4, 8, '2023-11-09 10:15:31', NULL),
(7, 'Career advice for recent graduates', 'Any career advice for recent graduates entering the job market?', 5, 7, '2023-11-09 10:15:31', NULL),
(9, 'Favorite science fiction novels', 'What are some of your favorite science fiction novels? I\'m looking for recommendations.', 6, 3, '2023-11-09 10:15:31', NULL),
(10, 'Healthy meal prep ideas', 'I need some healthy meal prep ideas for the week. Any suggestions?', 6, 2, '2023-11-09 10:15:32', NULL),
(11, 'Home gardening tips for beginners', 'I\'m a beginner in gardening. Any tips for starting a home garden?', 7, 5, '2023-11-09 10:15:32', NULL),
(12, 'Best practices for time management', 'How can I improve my time management skills and be more productive?', 7, 1, '2023-11-09 10:15:32', NULL),
(13, 'Effective study techniques for mathematics', 'I\'m struggling with math. What are some effective study techniques for improving math skills?', 2, 2, '2023-11-09 10:16:18', NULL),
(14, 'Recommendations for learning a musical instrument', 'I want to learn a musical instrument. Any recommendations for beginners?', 2, 8, '2023-11-09 10:16:18', NULL),
(15, 'Remote work productivity tips', 'As a remote worker, what productivity tips can help me stay focused?', 3, 1, '2023-11-09 10:16:18', NULL),
(16, 'Healthy recipes for a vegetarian diet', 'Looking for healthy and delicious vegetarian recipes. Any suggestions?', 3, 2, '2023-11-09 10:16:18', NULL),
(17, 'Balancing work and personal life', 'Struggling to balance work and personal life. Any advice on achieving a better work-life balance?', 4, 1, '2023-11-09 10:16:18', NULL),
(18, 'Best practices for project management', 'What are the best practices for managing projects effectively?', 4, 7, '2023-11-09 10:16:19', NULL),
(19, 'Traveling on a budget', 'Tips for traveling on a budget without compromising on the experience?', 5, 5, '2023-11-09 10:16:19', NULL),
(20, 'Stress relief techniques for students', 'College can be stressful. What are some stress relief techniques for students?', 5, 6, '2023-11-09 10:16:19', NULL),
(21, 'Career paths in the technology industry', 'What are some promising career paths in the tech industry?', 6, 1, '2023-11-09 10:16:19', NULL),
(22, 'Favorite outdoor activities for summer', 'Looking for outdoor activity ideas for the summer season. What\'s your favorite?', 6, 5, '2023-11-09 10:16:19', NULL),
(23, 'Effective leadership strategies', 'I want to improve my leadership skills. Any effective leadership strategies to recommend?', 7, 7, '2023-11-09 10:16:19', NULL),
(24, 'Recommendations for good podcasts', 'Looking for engaging podcasts on various topics. Any recommendations?', 7, 3, '2023-11-09 10:16:19', NULL),
(25, 'How to prepare for a job interview?', 'I have a job interview coming up. What are some tips for successful interview preparation?', 2, 7, '2023-11-09 10:17:20', NULL),
(26, 'Favorite historical figures', 'Who are your favorite historical figures, and why?', 2, 3, '2023-11-09 10:17:21', NULL),
(27, 'Balancing academics and extracurricular activities', 'How can I effectively balance my academics with extracurricular commitments?', 3, 6, '2023-11-09 10:17:21', NULL),
(28, 'Healthy habits for a busy lifestyle', 'What are some healthy habits to maintain with a busy schedule?', 3, 2, '2023-11-09 10:17:21', NULL),
(29, 'Improving communication skills', 'Any recommendations for improving communication skills in both personal and professional contexts?', 4, 7, '2023-11-09 10:17:21', NULL),
(30, 'Favorite travel destinations', 'Share your favorite travel destinations and experiences!', 4, 5, '2023-11-09 10:17:21', NULL),
(31, 'What is the fundamental concept of computer science?', 'Provide a concise definition of the core concept that forms the foundation of computer science.', 2, 1, '2023-11-14 18:10:22', NULL),
(32, 'Why is algorithm design crucial in computer science?', 'Discuss the importance of designing efficient algorithms in the field of computer science.', 3, 1, '2023-11-14 18:10:22', NULL),
(33, 'Explain the role of data structures in computer science.', 'How do data structures contribute to the organization and manipulation of data in computer science?', 4, 1, '2023-11-14 18:10:22', NULL),
(34, 'What are the key components of a computer system?', 'Identify and describe the essential components that make up a computer system.', 5, 1, '2023-11-14 18:10:23', NULL),
(35, 'Discuss the evolution of programming languages.', 'Explore the history and evolution of programming languages in the context of computer science.', 6, 1, '2023-11-14 18:10:23', NULL),
(36, 'How does computer science contribute to other disciplines?', 'Examine the interdisciplinary nature of computer science and its impact on other fields.', 7, 1, '2023-11-14 18:10:23', NULL),
(37, 'Explain the concept of abstraction in computer science.', 'Define and elaborate on the role of abstraction in simplifying complex systems in computer science.', 2, 1, '2023-11-14 18:10:23', NULL),
(38, 'What is the significance of binary code in computing?', 'Discuss why binary code is fundamental to the representation and processing of information in computers.', 3, 1, '2023-11-14 18:10:23', NULL),
(39, 'Explore the concept of artificial intelligence in computer science.', 'Discuss the principles and applications of artificial intelligence within the realm of computer science.', 4, 1, '2023-11-14 18:10:23', NULL),
(40, 'How do computer networks facilitate communication?', 'Examine the role of computer networks in enabling communication between devices and systems.', 5, 1, '2023-11-14 18:10:23', NULL),
(41, 'Discuss the ethical considerations in computer science.', 'Explore the ethical challenges and responsibilities associated with advancements in computer science.', 6, 1, '2023-11-14 18:10:23', NULL),
(42, 'What is the impact of computer science on everyday life?', 'Examine how computer science innovations influence and shape various aspects of our daily lives.', 7, 1, '2023-11-14 18:10:23', NULL),
(43, 'Discuss the role of computer science in problem-solving.', 'How does computer science provide systematic approaches to solving complex problems?', 2, 1, '2023-11-14 18:10:23', NULL),
(44, 'Explore the concept of cybersecurity in computer science.', 'Examine the principles and practices of cybersecurity to safeguard computer systems and data.', 3, 1, '2023-11-14 18:10:23', NULL),
(45, 'How does computer science contribute to the development of software applications?', 'Discuss the process and methodologies involved in developing software applications.', 4, 1, '2023-11-14 18:10:23', NULL),
(47, 'DSA', 'Idk Mo', 2, 6, '2023-11-15 05:27:57', '');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `reply_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `reply_content` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`reply_id`, `user_id`, `question_id`, `reply_content`, `timestamp`) VALUES
(1, 2, 1, 'You can improve your coding skills by practicing regularly, working on projects, and seeking feedback from experienced developers.', '2023-11-09 10:18:48'),
(2, 3, 3, 'When conducting data analysis, make sure to clean and preprocess your data, choose the right statistical tools, and visualize your results for better understanding.', '2023-11-09 10:18:48'),
(3, 4, 6, 'For time management, consider using techniques like the Pomodoro method and making to-do lists. Prioritize tasks based on importance and deadlines.', '2023-11-09 10:18:49'),
(4, 5, 11, 'Effective leadership involves clear communication, setting a good example, and empowering your team members to excel in their roles.', '2023-11-09 10:18:49'),
(5, 6, 13, 'To improve your math skills, practice regularly, seek help when needed, and don\'t be afraid to make mistakes. Math is about problem-solving.', '2023-11-09 10:18:49'),
(6, 7, 15, 'Balancing work and personal life is crucial for mental well-being. Set boundaries and prioritize self-care to maintain balance.', '2023-11-09 10:18:49'),
(7, 2, 19, 'To travel on a budget, plan your trip in advance, look for deals, and consider budget-friendly accommodations and transportation.', '2023-11-09 10:18:49'),
(8, 3, 25, 'Job interview preparation involves researching the company, practicing common interview questions, and presenting yourself confidently.', '2023-11-09 10:18:49'),
(9, 4, 27, 'Balancing academics and extracurricular activities requires effective time management and setting priorities based on your goals.', '2023-11-09 10:18:49'),
(10, 5, 29, 'Improving communication skills involves active listening, clear articulation, and understanding non-verbal cues.', '2023-11-09 10:18:49'),
(11, 6, 14, 'I recommend reading \"A People\'s History of the United States\" for an insightful perspective on American history.', '2023-11-09 10:19:39'),
(12, 7, 16, 'For healthy recipes, consider making dishes with quinoa, tofu, and a variety of fresh vegetables. It\'s both nutritious and delicious.', '2023-11-09 10:19:39'),
(13, 2, 17, 'Balancing work and personal life can be challenging. Try time blocking to allocate specific time for work and personal activities.', '2023-11-09 10:19:39'),
(14, 3, 21, 'Career paths in the technology industry include software development, data science, cybersecurity, and more. Choose based on your interests.', '2023-11-09 10:19:39'),
(15, 4, 23, 'Effective leadership strategies include setting a vision, leading by example, and empowering your team to achieve their goals.', '2023-11-09 10:19:39'),
(16, 5, 25, 'Preparing for a job interview involves researching the company, rehearsing your answers, and having questions ready to ask the interviewer.', '2023-11-09 10:19:39'),
(17, 6, 27, 'Balancing academics and extracurricular activities can be challenging. Use a calendar to plan your schedule and prioritize tasks.', '2023-11-09 10:19:39'),
(18, 7, 29, 'Effective communication in the workplace involves active listening, clear communication, and resolving conflicts professionally.', '2023-11-09 10:19:39'),
(19, 2, 12, 'For podcasts, consider listening to \"Radiolab\" and \"The Joe Rogan Experience\" for a diverse range of topics and engaging conversations.', '2023-11-09 10:19:39'),
(20, 3, 18, 'Project management best practices include setting clear goals, establishing a project plan, and communicating effectively with the team.', '2023-11-09 10:19:39'),
(22, 5, 19, 'Traveling on a budget can be fun. Consider backpacking, staying in hostels, and using public transportation to save money.', '2023-11-09 10:21:23'),
(23, 6, 26, 'For learning a musical instrument, start with a teacher or online lessons, and practice regularly to build your skills.', '2023-11-09 10:21:24'),
(24, 7, 24, 'There are numerous great history podcasts. Consider \"Hardcore History\" and \"Revolutions\" for in-depth historical narratives.', '2023-11-09 10:21:24'),
(25, 2, 28, 'To maintain a healthy lifestyle with a busy schedule, plan meals, exercise, and get enough sleep for physical and mental health.', '2023-11-09 10:21:24'),
(26, 3, 30, 'Improving communication skills is essential for professional and personal growth. Practice effective listening and assertive communication.', '2023-11-09 10:21:24'),
(27, 4, 15, 'Remote work productivity can be enhanced by creating a dedicated workspace, setting a schedule, and taking regular breaks.', '2023-11-09 10:21:24'),
(28, 5, 7, 'Recommendations for history books depend on the specific era or region of interest. Could you provide more details for a tailored recommendation?', '2023-11-09 10:21:24'),
(29, 6, 22, 'Favorite outdoor activities for the summer include hiking, camping, biking, and spending time at the beach or in nature.', '2023-11-09 10:21:24'),
(30, 7, 4, 'For stress relief during exams, practice relaxation techniques like deep breathing, meditation, and get adequate sleep.', '2023-11-09 10:21:24'),
(31, 2, 2, 'A highly recommended history book is \"Guns, Germs, and Steel\" by Jared Diamond. It offers a unique perspective on human history.', '2023-11-09 10:22:02'),
(32, 3, 10, 'One of the best ways to learn a new language is to immerse yourself in it by practicing with native speakers and using language learning apps.', '2023-11-09 10:22:02'),
(33, 4, 23, 'Effective leadership also involves setting clear expectations, providing feedback, and fostering a positive work environment.', '2023-11-09 10:22:02'),
(34, 5, 17, 'To balance work and personal life, consider using time management techniques like the Eisenhower Matrix to prioritize tasks.', '2023-11-09 10:22:02'),
(35, 6, 12, 'For podcasts, try \"How I Built This\" for inspiring stories of entrepreneurs and \"TED Talks\" for a wide range of thought-provoking topics.', '2023-11-09 10:22:02'),
(36, 7, 30, 'Stress relief during exams is crucial. Consider exercise, healthy eating, and mindfulness techniques to stay calm and focused.', '2023-11-09 10:22:02'),
(37, 2, 9, 'Balancing academics and extracurricular activities is easier when you set specific goals and prioritize what\'s most important to you.', '2023-11-09 10:22:02'),
(38, 3, 26, 'Learning a musical instrument is a rewarding journey. Consistent practice and patience are key to mastering any instrument.', '2023-11-09 10:22:02'),
(39, 4, 4, 'There are various techniques to relieve stress during exams, such as deep breathing exercises and effective time management.', '2023-11-09 10:22:03'),
(40, 5, 14, 'One of the great history books to read is \"Sapiens: A Brief History of Humankind\" by Yuval Noah Harari. It provides a fascinating overview of human history.', '2023-11-09 10:22:03'),
(41, 6, 7, 'For history podcasts, consider \"Revolutions\" by Mike Duncan, which delves into various historical revolutions and their impact.', '2023-11-09 10:23:13'),
(42, 7, 1, 'Improving your coding skills involves practicing coding challenges, working on real projects, and seeking help from coding communities.', '2023-11-09 10:23:13'),
(43, 2, 3, 'When conducting data analysis, make sure to clean your data, use the right statistical tools, and document your findings thoroughly.', '2023-11-09 10:23:13'),
(44, 3, 6, 'For effective time management, try using time blocking and to-do lists. Prioritize tasks and allocate specific time for focused work.', '2023-11-09 10:23:13'),
(45, 4, 11, 'Effective leadership involves clear communication, inspiring your team, and fostering a collaborative and inclusive work environment.', '2023-11-09 10:23:13'),
(46, 5, 13, 'To improve your math skills, practice regularly, ask questions, and seek additional resources like online tutorials and courses.', '2023-11-09 10:23:13'),
(47, 6, 16, 'Healthy meal prep ideas include cooking in batches, incorporating lean proteins, and using a variety of colorful vegetables.', '2023-11-09 10:23:13'),
(48, 7, 20, 'Stress relief techniques for students include mindfulness meditation, physical exercise, and maintaining a healthy sleep schedule.', '2023-11-09 10:23:13'),
(49, 2, 27, 'Balancing academics and extracurricular activities requires effective time management and setting clear goals.', '2023-11-09 10:23:13'),
(50, 3, 28, 'For maintaining a healthy lifestyle with a busy schedule, consider meal prepping and incorporating regular physical activity.', '2023-11-09 10:23:13'),
(51, 4, 2, 'For history books, \"A Short History of Nearly Everything\" by Bill Bryson offers a fascinating journey through the history of science.', '2023-11-09 10:23:13'),
(53, 6, 9, 'To balance academics and extracurricular activities, set clear priorities, create a schedule, and maintain a strong support system.', '2023-11-09 10:23:14'),
(54, 7, 10, 'Learning a musical instrument requires patience and practice. Regular lessons and consistent practice will lead to progress.', '2023-11-09 10:23:14'),
(55, 2, 21, 'Career paths in the technology industry can lead to positions in software development, data analysis, cybersecurity, and more.', '2023-11-09 10:23:14'),
(59, 2, 31, 'To enhance your coding skills, practice regularly on coding platforms like LeetCode or HackerRank. Challenge yourself with diverse problems and learn from the solutions.', '2023-11-14 19:37:31'),
(60, 3, 31, 'Consider working on real-world projects to apply your coding knowledge. This hands-on experience will help you develop practical skills and problem-solving abilities.', '2023-11-14 19:37:31'),
(61, 4, 31, 'Read and analyze code written by experienced programmers. Understanding different coding styles and approaches will broaden your perspective and improve your coding proficiency.', '2023-11-14 19:37:31'),
(62, 5, 31, 'Join coding communities and engage in discussions. Collaborating with other programmers exposes you to different techniques and best practices, accelerating your learning.', '2023-11-14 19:37:31'),
(63, 6, 31, 'Focus on one programming language initially. Mastering the fundamentals will make it easier to pick up additional languages and frameworks in the future.', '2023-11-14 19:37:31'),
(64, 7, 31, 'Don\'t shy away from debugging. Understanding and fixing errors is a crucial part of coding. Embrace challenges, and learn from your mistakes.', '2023-11-14 19:37:31'),
(65, 2, 31, 'Explore online tutorials and courses. Platforms like Coursera and Udacity offer in-depth courses on various programming topics, helping you build a strong foundation.', '2023-11-14 19:37:31'),
(66, 3, 31, 'Attend coding meetups or virtual events. Networking with other programmers can provide valuable insights, and you might discover new techniques or tools.', '2023-11-14 19:37:31'),
(67, 4, 31, 'Set specific goals for your coding journey. Whether it\'s building a web application or contributing to an open-source project, having clear objectives will keep you motivated.', '2023-11-14 19:37:31'),
(68, 5, 31, 'Stay curious and never stop learning. Follow industry trends, read programming blogs, and explore new technologies to stay updated and continually improve your skills.', '2023-11-14 19:37:31'),
(69, 2, 1, 'To enhance your coding skills, practice regularly on coding platforms like LeetCode or HackerRank. Challenge yourself with diverse problems and learn from the solutions.', '2023-11-14 19:39:48'),
(70, 3, 1, 'Consider working on real-world projects to apply your coding knowledge. This hands-on experience will help you develop practical skills and problem-solving abilities.', '2023-11-14 19:39:48'),
(71, 4, 1, 'Read and analyze code written by experienced programmers. Understanding different coding styles and approaches will broaden your perspective and improve your coding proficiency.', '2023-11-14 19:39:49'),
(72, 5, 1, 'Join coding communities and engage in discussions. Collaborating with other programmers exposes you to different techniques and best practices, accelerating your learning.', '2023-11-14 19:39:49'),
(73, 6, 1, 'Focus on one programming language initially. Mastering the fundamentals will make it easier to pick up additional languages and frameworks in the future.', '2023-11-14 19:39:49'),
(74, 7, 1, 'Don\'t shy away from debugging. Understanding and fixing errors is a crucial part of coding. Embrace challenges, and learn from your mistakes.', '2023-11-14 19:39:49'),
(75, 2, 1, 'Explore online tutorials and courses. Platforms like Coursera and Udacity offer in-depth courses on various programming topics, helping you build a strong foundation.', '2023-11-14 19:39:49'),
(76, 3, 1, 'Attend coding meetups or virtual events. Networking with other programmers can provide valuable insights, and you might discover new techniques or tools.', '2023-11-14 19:39:49'),
(77, 4, 1, 'Set specific goals for your coding journey. Whether it\'s building a web application or contributing to an open-source project, having clear objectives will keep you motivated.', '2023-11-14 19:39:49'),
(78, 5, 1, 'Stay curious and never stop learning. Follow industry trends, read programming blogs, and explore new technologies to stay updated and continually improve your skills.', '2023-11-14 19:39:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `about` text DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `about`, `email`, `password`, `profile_picture`, `role`) VALUES
(1, 'root', 'i have power', 'ptmaiphuong91@gmail.com', '$2y$10$1nNtwZi1hvNI.GViZWLAfOsL0kzNw1gMSeoSyxQ/5/dl2mlQir0F2', '../img/profile_img/849b9193dc318671773fc3979ae576aa.jpg', 'admin'),
(2, 'baola', '123', 'pp3946p@gre.ac.uk', '$2y$10$u2GqWCgU11C4FSgqO7F4xu0aCqWbHmNLrehKCz6sXZV1JcJ7cKJGK', '../img/profile_img/default_profile_img.png', 'user'),
(3, 'lo', NULL, 'lo@ne.c', '$2y$10$0EhU8W88K8GCyO0A4XEib.jeUYEBXYrwBvJWyxvDvf/sR2KdBkgzG', '../img/profile_img/default_profile_img.png', 'user'),
(4, 'wek', '', 'wek@gmail.com', '$2y$10$thfzijOVp8w8huE1vqs29uRofh45k.kkYI46/ejmCcmfWI7U8ANly', '../img/profile_img/default_profile_img.png', 'user'),
(5, 'lamp', NULL, 'lamp@gmail.cpm', '$2y$10$PoI6jr9A1jlKySVCqncUm.dohhodmyuikG5.SYurWU4wa273o4tFy', '../img/profile_img/default_profile_img.png', 'user'),
(6, 'khoa1661', NULL, 'khoa1661@gmail.cpm', '$2y$10$M1EOCklgKnjIDlwEJjvLm.Q3hcbE8Lt5XpxRHU6GlueGB1xx5qm4W', '../img/profile_img/default_profile_img.png', 'user'),
(7, 'nh4t', NULL, 'nh4t@gmail.cpm', '$2y$10$i4b6lzjq3QM2tdkpfv.fluXgtPgf9dluVXc0GOtTSnKKccNyTl1YS', '../img/profile_img/default_profile_img.png', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `messages_ibfk_1` (`user_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `questions_ibfk_2` (`module_id`),
  ADD KEY `questions_ibfk_1` (`user_id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `replies_ibfk_2` (`question_id`),
  ADD KEY `replies_ibfk_1` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`) ON DELETE CASCADE;

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `replies_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
