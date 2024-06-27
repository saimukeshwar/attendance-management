-- Creating `departments` table
CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `departments`
INSERT INTO `departments` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Human Resources', 'Responsible for managing employee recruitment, training, and welfare.', '2024-05-17 01:47:34'),
(2, 'Finance', 'Responsible for managing financial resources and budgeting.', '2024-05-17 01:47:34'),
(3, 'Marketing', 'Responsible for promoting products and services to customers.', '2024-05-17 01:47:34'),
(4, 'IT', 'Responsible for managing information technology systems and infrastructure.', '2024-05-17 01:47:34');

-- Creating `employees` table
CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `department` varchar(100) NOT NULL,
  `shift` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `employees`
INSERT INTO `employees` (`id`, `username`, `firstname`, `lastname`, `gender`, `dob`, `address`, `department`, `shift`, `phone`, `email`, `password`) VALUES
(1, 'jane', 'John', 'Doe', 'male', '1990-05-15', '123 Main St, City, Country', 'IT', '', '123-456-7890', 'john.doe@example.com', '123456'),
(2, 'Jane', 'Jane', 'Smith', 'female', '1985-10-20', '456 Elm St, City, Country', 'HR', '', '987-654-3210', 'jane.smith@example.com', '123456'),
(3, 'Michael', 'Michael', 'Johnson', 'male', '1992-03-25', '789 Oak St, City, Country', 'Sales', '', '', 'michael.johnson@example.com', '123456'),
(7, 'madhukar', 'kota', 'madhukar', 'Male', '2002-08-17', 'dharmaraopet', 'Finance', '', '8978929656', 'Kotamadhukaryadav777@gmail.com', '112233');

-- Creating `employee_leave` table
CREATE TABLE `employee_leave` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `reason` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `token` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `employee_leave`
INSERT INTO `employee_leave` (`id`, `start`, `end`, `reason`, `status`, `token`) VALUES
(1, '2023-06-01', '2023-06-10', 'Vacation', 'Approved', 1),
(2, '2023-07-05', '2023-07-15', 'Medical', 'Cancelled', 2),
(3, '2024-05-18', '2024-05-19', 'me', 'Pending', 4);

-- Creating `shifts` table
CREATE TABLE `shifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shift_name` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `shifts`
INSERT INTO `shifts` (`id`, `shift_name`, `start_time`, `end_time`, `created_at`) VALUES
(1, 'Morning Shift', '08:00:00', '16:00:00', '2024-05-17 01:47:34'),
(2, 'Night Shift', '20:00:00', '04:00:00', '2024-05-17 01:47:34');

-- Creating `users` table
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `dob` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `users`
INSERT INTO `users` (`id`, `username`, `firstname`, `lastname`, `gender`, `dob`, `address`, `department`, `phone`, `email`, `password`) VALUES
(1, 'john_doe', '', '', 'Male', '0000-00-00', '', '', '', '', 'password123'),
(2, 'jane_smith', '', '', 'Male', '0000-00-00', '', '', '', '', 'securepass'),
(3, 'admin', '', '', 'Male', '0000-00-00', '', '', '', '', 'adminpassword');

-- Creating `location` table
CREATE TABLE `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table `location`
INSERT INTO `location` (`id`, `location`, `created_at`) VALUES
(1, 'Office', '2023-09-29 05:52:28'),
(2, 'Field', '2023-09-29 05:52:40'),
(3, 'Home', '2023-09-29 05:52:46');

-- Creating `attendance` table
CREATE TABLE `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employees_id` varchar(255) NOT NULL,
  `departments` varchar(255) NOT NULL,
  `shifts` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` date NOT NULL,
  `check_in` time NOT NULL,
  `in_status` varchar(255) NOT NULL,
  `check_out` time NOT NULL,
  `out_status` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `attendance`
INSERT INTO `attendance` (`id`, `employees_id`, `departments`, `shifts`, `location`, `message`, `date`, `check_in`, `in_status`, `check_out`, `out_status`, `created_at`) VALUES
(1, 'EMP-2', 'Account', '09:00:00-18:00:00', 'Office', 'Hello', '2023-09-29', '11:23:05', 'Late', '11:23:39', 'Early', '2023-09-29 05:53:39');
