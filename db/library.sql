-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2024 at 02:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `lib_admins`
--

CREATE TABLE `lib_admins` (
  `adm_id` int(11) NOT NULL COMMENT 'รหัสผู้ดูแล',
  `adm_fname` varchar(50) NOT NULL COMMENT 'ชื่อ',
  `adm_lname` varchar(50) NOT NULL COMMENT 'นามสกุล',
  `adm_staff_id` varchar(20) NOT NULL COMMENT 'รหัสเจ้าหน้าที่',
  `adm_password` varchar(255) NOT NULL COMMENT 'รหัสผ่าน',
  `adm_super_admin` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = มีสิทธิ์สูงสุด 0 = ไม่มี',
  `adm_profile` varchar(50) DEFAULT NULL COMMENT 'รูปผู้ใช้',
  `adm_time_create` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วัน เวลาสร้าง',
  `adm_time_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วัน เวลาแก้ไข'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ข้อมูลผู้ดูแลระบบ';

--
-- Dumping data for table `lib_admins`
--

INSERT INTO `lib_admins` (`adm_id`, `adm_fname`, `adm_lname`, `adm_staff_id`, `adm_password`, `adm_super_admin`, `adm_profile`, `adm_time_create`, `adm_time_update`) VALUES
(10, 'super', 'admin', '0000000000000', '$2y$10$pi.oqz3ilvhDSdTXw..TVeJl/pPebinGISVzkAMcFmzDyd.iHuJSW', 1, '', '2024-10-02 15:06:25', '2024-10-15 07:11:41'),
(12, 'ผู้ดูแลระบบ', 'ทดสอบ', '1111111111111', '$2y$10$wRCkuNGy2Cm0v0jqMB6CgejJsM5V1uZkNHhArUKhZur7UQ1TxKq5i', 0, NULL, '2024-10-26 08:33:34', '2024-10-26 08:33:34'),
(13, 'Dum', 'Deee', '3333333333333', '$2y$10$oJOYOem8/VYCljE86DXfzubbjY2HE/Cz4vz/fAs0SZP1p3kvA5JXW', 0, NULL, '2024-10-26 08:44:40', '2024-10-26 08:44:40');

-- --------------------------------------------------------

--
-- Table structure for table `lib_books`
--

CREATE TABLE `lib_books` (
  `bk_id` int(11) NOT NULL COMMENT 'รหัสรายการ',
  `bk_name` varchar(100) NOT NULL COMMENT 'ชื่อหนังสือ',
  `bk_quantity` int(11) NOT NULL COMMENT 'จำนวน',
  `bk_student_loan_period` int(11) NOT NULL COMMENT 'วันยืมสูงสุดของนักเรียน',
  `bk_teacher_loan_period` int(11) NOT NULL COMMENT 'วันยืมสูงสุดของครู',
  `bk_detail` text NOT NULL COMMENT 'รายละเอียด',
  `bk_publisher` varchar(100) DEFAULT NULL COMMENT 'สำนักพิมพ์',
  `bk_author` varchar(100) DEFAULT NULL COMMENT 'ผู้แต่ง',
  `bt_id` int(11) DEFAULT NULL COMMENT 'ประเภทหนังสือ',
  `bk_show` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'สถานะ 1 = แสดง 0 = ไม่แสดง',
  `bk_img` varchar(100) DEFAULT NULL COMMENT 'รูปสินค้า',
  `bk_time_create` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วัน เวลาสร้าง',
  `bk_time_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วัน เวลาแก้ไข'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ข้อมูลหนังสือ';

--
-- Dumping data for table `lib_books`
--

INSERT INTO `lib_books` (`bk_id`, `bk_name`, `bk_quantity`, `bk_student_loan_period`, `bk_teacher_loan_period`, `bk_detail`, `bk_publisher`, `bk_author`, `bt_id`, `bk_show`, `bk_img`, `bk_time_create`, `bk_time_update`) VALUES
(4, 'ธี่หยด...สิ้นเสียงครวญคลั่ง', 5, 6, 7, 'ภาคต่ออันสมบูรณ์ของเรื่องผีที่คนไทยพูดถึงเยอะที่สุดในเวลานี้! ', 'แพรวสำนักพิมพ์', 'กฤตานนท์', 5, 1, 'img_671cb06952c9e.jpg', '2024-10-10 10:45:07', '2024-10-26 09:22:14'),
(5, 'ราชันหนังสยอง เล่ม 4 (จบ)', 5, 7, 14, '  STORY รินโดถูกให้เล่น \"เกมมรณะ\"อย่างสนุกสนานเพื่อช่วยมนุษย์ขวานที่ถูกจับ เขาได้ใช้ความรู้เรื่องหนังที่เหนือคนธรรมตากับการตัดสินใจอันเฉียบขาดเป็นอาวุธแต่ก็ถูกคิเนมะต่างๆทำร้าย!? ยิ่งไปกว่านั้น ชายผู้นั้นที่มีพลังเหนือล้ำก็ปรากฏตัว!?เรื่องราวของคนบ้าหนังสยองขวัญสุดขั้วอย่างหาที่เปรียบไม่ได้กับปีศาจที่มีหนึ่งเตียวได้มาถึงฉากอวสานแล้ว!!', 'สยามอินเตอร์คอมิกส์/Siam Inter Comics', 'Oohira Kouta', 3, 1, 'img_671cb1f600718.jpg', '2024-10-17 14:04:18', '2024-10-26 09:10:14'),
(6, 'สลัดรวมมิตรคนเพี้ยนหลุดโลก เล่ม 11', 5, 7, 14, '  \"สาวน้อยเวทมนตร์\" นั่นคือ \"อาชีพ\" ที่ไม่ว่าใครต่างก็เฝ้าฟันถึงบริษัทแมจิลูมียร์ตั้งเข้าให้คนในวงการเกระบบ \"อลิสซิสเต็ม\" ไปใช้คานะกับโคชิกายะจึงไปกำจัดสัตว์ประหลาดประเภทใหม่ที่สถาบันวิจัยเวทเพื่อสร้างผลงานทว่าผู้อำนวยการสำนักงานพลังเวทซึ่งเป็นคุณพ่อของโคชิกายะกับซีซีมิ ศาสตราจารย์มหาวิทยาลัยซึ่งสังกัดสหพันธ์เวทกลับเรียกบริษัทอาสต์มาพื่อข้ดขวางการก่าจัดนี้!?และนั่นทำให้ซิเกะโมโตะเข้ามาป็นโอเปอเรเตอร์ชั่วคราว..!?การ์ตูนแอคชั่นสาวน้อยเวทมนตร์คนทำงานเล่ม 6 มาแล้ว!!', 'รักพิมพ์ พับลิชชิ่ง/luckpim', 'Yomi Hirasaka', 3, 1, 'img_671cb17c9a480.jpg', '2024-10-21 06:15:45', '2024-10-26 09:08:12'),
(7, 'จิตวิทยาสายดาร์ก', 15, 7, 14, 'Dr. Hiro  เคยเป็นนักขายที่ล้มเหลว  ขายอะไรก็ไม่มีใครซื้อแต่แล้ววันหนึ่งขณะกำลังดูข่าว  เขาก็นึกขึ้นได้ว่า“ในโลกเรามีลัทธิที่ขายของไม่น่าเชื่อถือได้ในราคาแพงลิ่วแถมยังทำให้สาวกยอมทุ่มบริจาคทรัพย์สินจนหมดตัวแล้วทำไมผมถึงขายไม่ออกล่ะ?”เขาจึงเริ่มศึกษาเทคนิคเหล่านั้นอย่างจริงจังอ่านหนังสือทุกเล่มเกี่ยวกับการล้างสมองที่มีในท้องตลาดแล้วเอาไปปรับใช้จนกลายเป็นนักขายระดับท็อปของญี่ปุ่นนั่นคือที่มาของ  “จิตวิทยาสายดาร์ก”พบกับเทคนิคทางจิตวิทยาที่ช่วยให้คุณใช้คำพูดควบคุมจิตใจคนทำให้พวกเขาคล้อยตามและทำอย่างที่คุณต้องการโดยไม่รู้ตัว', 'วีเลิร์น (WeLearn)', 'Dr.Hiro', 7, 1, 'img_671cad5c8bb7d.jpg', '2024-10-21 06:30:32', '2024-10-26 08:50:36'),
(8, 'SAKAMOTO DAYS วันสบายๆ ฉบับนักฆ่า', 7, 7, 14, '  การแข่งตกปลาระหว่างชินและนางโมะณ จุดตั้งแคมป์ของครอบครัวชาคาโมโตะ!?การเดินตะลอนกินราเมนของชิชิบะและโอชาราติการทำงานแบบริโมตเวิร์กของคาชิมะ ฯลฯเรื่องราวส์ปินออฟที่หาอ่านได้เฉพาะในฉบับนิยายเท่านั้น!!อีกทั้งยังมีภาพประกอบที่วาดขึ้นไหม่ห้ามพลาดด้วยประการทั้งปวง!!', 'รักพิมพ์ พับลิชชิ่ง/luckpim', 'YUTO SUZUKI', 3, 1, 'img_671cb01ceb67b.jpg', '2024-10-21 06:30:42', '2024-10-26 09:02:20'),
(9, 'สมองสั่งซื้อ', 8, 7, 14, ' ในจังหวะที่จ่ายเงินซื้อสินค้าในชีวิตประจำวัน คุณอาจไม่เคยรู้เลยว่าเสี้ยววินาทีที่ดูเหมือนเป็นการตัดสินใจชั่ววูบนั้น แท้จริงแล้วเกิดขึ้นจากกระบวนการอันซับซ้อนภายในสมองของคุณเอง\r\nหนังสือ BUY BY BRAIN ของนายแพทย์อุเทน บุญอรณะ จะพาคุณเข้าสู่โลกอันซับซ้อนของการตลาดยุคใหม่ที่เชื่อมโยงกับการทำงานของสมองของเรา ด้วยเนื้อหาที่มีผลการวิจัยในห้องทดลองโดยใช้เครื่องมืออย่าง fMRI, EEG, fNRI, Eye Tracking มารองรับ โลกขององค์ความรู้ที่เรียกกันว่า นิวโรมาร์เก็ตติ้ง (Neuromarketing) ', 'อมรินทร์ How to', 'นายแพทย์อุเทน บุญอรณะ', 7, 1, 'img_671cb118704a7.jpg', '2024-10-21 06:31:00', '2024-10-26 09:06:32'),
(10, 'ปริศนา Sudoku พิชิตสมองเสื่อม Vol.2', 5, 7, 14, '  การเล่นซูโดกุเป็นประจำ ช่วยเสริมสร้างการเชื่อมโยงระหว่างเซลล์ประสาทในสมอง ทำให้สมองของคุณทำงานได้อย่างมีประสิทธิภาพมากขึ้น การเล่นซูโดกุไม่เพียงแค่สนุก แต่ยังเป็นการลงทุนเพื่อสุขภาพสมองของคุณในระยะยาว ขนาดเล่มกระทัดรัด พกพาง่าย เล่นได้ทุกที่', 'สแนปเอ็กซ์', 'กองบรรณาธิการ', 6, 1, 'img_671cb0ab2b692.jpg', '2024-10-21 06:31:12', '2024-10-26 09:05:23'),
(11, 'Mission Economy : คู่มือออกแบบนโยบายเศรษฐกิจฉบับกล้าฝัน จากภารกิจสำรวจดวงจันทร์ สู่ปฏิบัติการพลิกโฉม', 10, 7, 14, '   ให้เกิดขึ้นได้จริงและทุกคนเข้าถึงได้ข้อเสนอของมัซซูกาโตในการรับมือภารกิจแห่งอนาคต สั่นสะเทือนแนวคิดดั้งเดิมทางเศรษฐศาสตร์และธุรกิจ อาทิ\r\n\r\n รัฐไม่ใช่ปีศาจร้ายที่จำเป็น แต่เล่นบทนักสร้างสรรค์ที่ทรงพลังได้ โดยไม่ตั้งรับรอแก้ปัญหาความล้มเหลวของตลาดเท่านั้นหากต้องร่วมสร้างตลาดใหม่และกำหนดทิศทางของตลาดด้วย\r\n รัฐไม่เพียงทำหน้าที่สร้างความเท่าเทียมในสนามแข่งขัน แต่ต้องปรับยกสนามแข่งขันไปสู่ทิศทางใหม่ที่ควรจะเป็น\r\n การว่าจ้างหน่วยงานภายนอก ไม่สำคัญเท่าการยกระดับศักยภาพของหน่วยงานภายใน\r\n การตัดสินใจทางเศรษฐกิจไม่ใช่แค่การวิเคราะห์ต้นทุน-ผลประโยชน์ แต่หัวใจสำคัญคือผลต่อขยายที่เป็นพลวัต (dynamicspillovers) ต่างหาก\r\n    นี่คือภารกิจกล้าฝันที่ต้องอาศัยการประสานพลังทุกภาคส่วน ไม่ว่าคุณจะเป็นนักเศรษฐศาสตร์ นักนโยบาย นักธุรกิจ คนทำงานการเมืองหรือประชาชน หนังสือเล่มนี้จะมอบความรู้ใหม่และแรงบันดาลใจในการเดินทางสู่อนาคต เพื่อส่งมอบเศรษฐกิจที่ดี มีพลวัต มีคุณค่า ยั่งยืน เป็นธรรมและตอบโจทย์เป้าหมายสาธารณะเพื่อประโยชน์ของทุกคนถ้าวันนั้น การพิชิตดวงจันทร์คือภารกิจใหญ่ แล้ววันนี้ อะไรคือ Mission Economy ที่ต้องปักธงและมุ่งมั่นไปให้ถึง?\r\n   หนังสือเข้ารอบสุดท้ายรางวัล Porchlight Business Book Awards หมวด Big Ideas &amp; New Perspectives', 'บุ๊คสเคป/BOOKSCAPE', 'Mariana Mazzucato', 6, 1, 'img_671caf17cd2b1.jpg', '2024-10-21 06:31:38', '2024-10-26 08:57:59'),
(12, 'สูตรลับตำรับดันเจียน เล่ม  1', 15, 7, 14, '  สุดยอดการ์ตูนอาหารที่จะสะท้านทุกตำรา!! เชลล์ยังไม่ชิม แม่ช้อยยังไม่รำ!! แต่เอล์ฟสาวของเรานั้นยืนยันความอร่อย!! แมนเดรกนั้นอร่อยดี มีประโยชน์ ทั้งสไลม์ ทั้งมิมิก บาซิลิสก์และมังกร จับมาย่างไฟอ่อน ปรุงให้ร้อนเสร็จพร้อมกิน!! บาซิลิสก์ มอนสเตอร์ดุร้าย >> จับมาปรุง >> เสร็จแล้วจ้า!!', 'DEXPRESS Publishing', 'Ryoko Kui', 3, 1, 'img_671cadc2ee59d.jpg', '2024-10-21 06:31:50', '2024-10-26 08:52:18'),
(13, 'ร้านขายยาปริศนารับแก้ปัญหาหัวใจ', 6, 7, 14, '  ในเขตที่กำลังจะพัฒนาใหม่เขตหนึ่งของกรุงโซลซึ่งเต็มไปด้วยบ้านเก่าที่พังทลาย มีร้านขายยาน่าสงสัยร้านหนึ่งซึ่งถูกปรับปรุงใหม่จนสวยงาม ร้านขายยานี้พูดแต่เรื่องที่ไม่น่าเชื่อเกี่ยวกับการขายความรักหรือการเติมเต็มความรัก ผู้ชายอ้วนและน่าเกลียดที่อยู่ในภาพวาดของเฟอร์นันโด โบเตโร แต่งงานกับภรรยาที่เป็นเภสัชกรสาวแสนสวยและใช้ชีวิตอยู่ด้วยกัน ดูเหมือนว่ายาจะมีความลับอะไรบางอย่าง\r\nร้านขายยานี้แตกต่างจากร้านอื่น ๆ เพราะมีทั้งป้ายชื่อว่า “ร้านยารัก” มีทั้งเสียงดนตรี กลิ่นหอมของชาสมุนไพร มีเก้าอี้นวมที่ให้คำปรึกษา และเหนือสิ่งอื่นใดคือยาวิเศษของความรักซึ่งเรียกว่าการตกหลุมรัก สถานที่แห่งนี้ที่แค่มองก็รู้สึกสบายใจขึ้น คนที่เจ็บปวดแต่ละคนจะมารวมตัวกัน สุดท้ายแล้วร้านขายยาที่ขายความรักจะเยียวยาจิตใจของคนที่มีบาดแผลได้หรือไม่', 'Piccolo', 'อีซ็อนย็อง', 5, 1, 'img_671cb2ab77621.jpg', '2024-10-21 06:32:00', '2024-10-26 09:22:26'),
(14, 'inancial Literacy and Money Skills ปลดหนี้ เลิกจน บริหารเงินให้มั่งคั่ง คุณก็ทำได้ ถ้าตั้งใจและจัดกา', 5, 7, 14, '    \'โดยส่วนใหญ่แล้วเวลาที่เราพูดเรื่องการบริหารเงิน หลายคนอาจจะรู้สึกว่าเป็นเรื่องยาก มีแต่ตัวเลขและไม่รู้ว่าจะต้องเริ่มอย่างไร หนังสือเล่มนี้จึงสรุปออกมาเป็นแนวคิดและไอเดียที่จะทำให้ทุกคนสามารถเริ่มต้นด้วยตัวเอง ว่าเราจะเก็บเงินอย่างไร สร้างเป้าหมายตามระยะเวลาที่มีได้อย่างไร จะทำอย่างไรที่ได้ผลตอบแทนอย่างเหมาะสม รวมถึงจะสร้างวินัยการลงทุนได้อย่างไรเสมือนกับแผนที่นำทาง ที่จะทำจะให้เรารู้วิธีการเริ่มบริหารเงินด้วยตัวเองอย่างไม่ยาก เริ่มได้ตั้งแต่การเงินติดลบ แก้ไขจัดการหนี้สิน เปลี่ยนสถานะเป็นคนไร้หนี้ และต่อยอดไปจนถึงการมีเงินออมและงอกเงยด้วยแนวทางในการลงทุนแบบต่างๆ\"   ', 'อินโฟเพรส/Infopress', 'กวิน สุวรรณตระกูล', 6, 1, 'img_671cb24b39f93.jpg', '2024-10-22 03:21:20', '2024-10-26 09:11:39'),
(15, 'จอมมารนักส่องกับไอดอลผู้กล้า เล่ม 5', 8, 7, 14, '  ทั้งที่เอลลี่รู้สึกถึงหัวใจที่เปี่ยมรักซึ่งตัวเองมีให้มาโอแล้วแต่การที่เขามองเธอเป็นเพียงแค่ไอดอลก็ทำให้ความมุ่งมั่นที่จะเป็นผู้กล้าต่อไปหวั่นไหวเรย์นอลส์เห็นภาพที่กลัดกลุ้มของเธอจึงได้ยอมรับการลาวงการของเธอและยุติกิจกรรมอวยเพราะมีใจให้กัน จึงสวนทางกันสุดท้ายบทสรุปของทั้งสองจะเป็นเช่นไร...!?เรื่องของจอมมารที่ไม่อาจละสายตาจากผู้กล้าได้กับผู้กล้าที่น่าเทิดทูนอย่างที่สุดได้มาถึงบทสรุปสุดน่าประทับใจตรงนี้แล้ว!!', 'สยามอินเตอร์คอมิกส์/Siam Inter Comics', 'FUKUSHIMA Masayasu', 3, 1, 'img_671cae4d073f8.jpg', '2024-10-22 03:48:28', '2024-10-26 08:54:37'),
(16, 'พลิกฟ้า ฝ่าวิกฤต การบินไทย', 5, 7, 14, '  ผมตั้งใจให้ Pocket Book เล่มนี้ เป็นบันทึกเรื่องราวที่ผมมีส่วนร่วมในประวัติศาลตร์ของลายการบินแห่งชาติของไทยในช่วงที่ต้องบินผาวิกฤตแบบพลิกฟ้าพลิกวิกฤตสุดๆ ตลอดช่วงเข้าแผนฟื้นฟูฯท่านจะเข้าใจความรู้สึกเวลาที่เราจน ไม่มีเงิน มองไม่เห็นแสงสว่างปลายอุโมงค์ การเอาตัวรอดในยามวิกฤตการเปลี่ยนวิกฤตเป็นโอการใหม่ การมี Plan B C Dการขอมเสียอวัยวะเพื่อรักษาชีวิต ก้าวข้ามความขัดแย้งโดยขีดประโยชน์ส่วนรวมและให้ธุรกิจเดินไปข้างหน้าได้ตามแผนฟื้นฟูฯนับว่าเป็น \"ที่สุด\" ในชีวิตนั้นปลายของผมวันนี้ผมและทีมงานการบินไทยทุกคนอยากบอกว่า...หากฟ้ายังมีสีฟ้าอยู่ การบินไทยจะบินนำธงชาติไทยขึ้นสู่ห้องฟ้า เป็นความภาคภูมิใจของคนไทยตลอดไปครับ', 'มติชน/matichon', 'ชาญศิลป์ ตรีนุชกร', 6, 1, 'img_671caf6bc21cc.jpg', '2024-10-22 03:48:50', '2024-10-26 08:59:23'),
(17, 'มุมมองนักอ่านพระเจ้า เล่ม 18', 5, 7, 14, 'ภารกิจของ <คิมดกจาคอมพานี>\r\n\r\nคือขัดขวางไม่ให้มหาสงครามเทพและปีศาจมีผลตัดสินชี้ขาด\r\n\r\nแม้การยืดเยื้อจะทำให้ ‘แต้มโกลาหล’ ยิ่งเพิ่มมากขึ้น\r\n\r\nแต่ก็เป็นการกดดันให้สองผู้นำของฝ่ายดีและฝ่ายร้ายยุติสงครามได้อย่างดี\r\n\r\nถ้าไม่อยากให้ #‘วินาศ’ กันไปหมดทั้งโลก\r\n\r\nทว่า...\r\n\r\n \r\n\r\n[เขตพื้นที่สงครามดังกล่าวมีการตัดสินฝ่ายที่ได้รับชัยชนะแล้ว]\r\n\r\n[ทำการมอบบทลงโทษเสียชีวิตให้แก่ผู้เข้าร่วมที่ปราชัยในเขตพื้นที่สงคราม]\r\n\r\n \r\n\r\nมีสมาชิกกลุ่มที่ทำภารกิจไม่สำเร็จ!\r\n\r\nจะใช่ฮันซูยองที่ต้องต้านทัพกลุ่มดาวฝ่ายดีที่นำโดย <เอเดน>\r\n\r\nหรือเป็นจองฮีวอนกับอีฮยอนซอง ที่เผชิญหน้าเหล่าราชาปีศาจทั้งหลายกัน', 'Levon', 'sing N song', 5, 1, 'img_671caeae7b589.jpg', '2024-10-22 03:49:07', '2024-10-26 08:56:14');

-- --------------------------------------------------------

--
-- Table structure for table `lib_books_borrow`
--

CREATE TABLE `lib_books_borrow` (
  `br_id` int(11) NOT NULL COMMENT 'รหัสรายการ',
  `usr_id` int(11) NOT NULL COMMENT 'รหัสผู้ใช้',
  `bk_id` int(11) NOT NULL COMMENT 'รหัสหนังสือ',
  `br_amount` int(11) NOT NULL DEFAULT 1 COMMENT 'จำนวน',
  `br_status` enum('borrow','return') NOT NULL DEFAULT 'borrow' COMMENT 'สถานะ',
  `br_borrow_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วัน เวลา ยืม',
  `br_return_date` timestamp NULL DEFAULT NULL COMMENT 'วัน เวลา คืน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ข้อมูลยืม-คืนหนังสือ';

--
-- Dumping data for table `lib_books_borrow`
--

INSERT INTO `lib_books_borrow` (`br_id`, `usr_id`, `bk_id`, `br_amount`, `br_status`, `br_borrow_date`, `br_return_date`) VALUES
(24, 8, 17, 1, 'return', '2024-04-01 01:19:20', '2024-10-26 01:29:08'),
(25, 8, 7, 1, 'return', '2024-10-26 02:12:31', '2024-10-26 02:12:40'),
(26, 8, 4, 1, 'return', '2024-08-20 07:41:03', '2024-07-09 07:41:54'),
(27, 8, 4, 1, 'return', '2024-10-26 08:17:48', '2024-10-26 08:17:59'),
(28, 9, 13, 1, 'return', '2024-10-26 08:43:22', '2024-10-26 09:22:26');

-- --------------------------------------------------------

--
-- Table structure for table `lib_books_types`
--

CREATE TABLE `lib_books_types` (
  `bt_id` int(11) NOT NULL COMMENT 'รหัสประเภท',
  `bt_name` varchar(100) NOT NULL COMMENT 'ชื่อประเภท',
  `bt_time_create` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วัน เวลาสร้าง',
  `bt_time_update` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp() COMMENT 'วัน เวลาแก้ไข'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ประเภทหนังสือ';

--
-- Dumping data for table `lib_books_types`
--

INSERT INTO `lib_books_types` (`bt_id`, `bt_name`, `bt_time_create`, `bt_time_update`) VALUES
(3, 'การ์ตูน', '2024-10-03 13:31:54', '2024-10-26 08:48:17'),
(5, 'นิยาย', '2024-10-18 11:31:36', '2024-10-26 08:48:24'),
(6, 'ความรู้', '2024-10-26 08:48:31', NULL),
(7, 'จิตวิทยา พัฒนาตนเอง', '2024-10-26 08:49:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lib_users`
--

CREATE TABLE `lib_users` (
  `usr_id` int(11) NOT NULL COMMENT 'รหัสผู้ใช้',
  `usr_fname` varchar(50) NOT NULL COMMENT 'ชื่อ',
  `usr_lname` varchar(50) NOT NULL COMMENT 'นามสกุล',
  `usr_username` varchar(50) NOT NULL COMMENT 'ชื่อผู้ใช้',
  `usr_password` varchar(255) NOT NULL COMMENT 'รหัสผ่าน',
  `usr_type` enum('Student','Teacher') NOT NULL COMMENT 'ประเภทผู้ใช้',
  `usr_profile` varchar(100) NOT NULL COMMENT 'รุปผู้ใช้',
  `usr_time_create` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วัน เวลา สร้าง',
  `usr_time_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วัน เวลา แก้ไข'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ข้อมูลผู้ใช้';

--
-- Dumping data for table `lib_users`
--

INSERT INTO `lib_users` (`usr_id`, `usr_fname`, `usr_lname`, `usr_username`, `usr_password`, `usr_type`, `usr_profile`, `usr_time_create`, `usr_time_update`) VALUES
(8, 'adisak', 'kkmy', 'adisak1', '$2y$10$zPUlDUab2c5GF5wHdJ2F9OX6fnnqHgUtEHxZh1Su3GB4MoRckCzdi', 'Student', 'img_671cab0848b99.png', '2024-10-03 12:41:59', '2024-10-26 08:41:55'),
(9, 'ดวงใจ', 'ใจดี', 'dungjai', '$2y$10$.VoWbPGwiymRB6dQCmDj4.zZ.DFvddQoq7IytrCB8Cd.HVwIDfwou', 'Teacher', '', '2024-10-08 13:58:17', '2024-10-26 08:43:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lib_admins`
--
ALTER TABLE `lib_admins`
  ADD PRIMARY KEY (`adm_id`),
  ADD UNIQUE KEY `adm_admin_id` (`adm_staff_id`);

--
-- Indexes for table `lib_books`
--
ALTER TABLE `lib_books`
  ADD PRIMARY KEY (`bk_id`),
  ADD KEY `bt_id` (`bt_id`);

--
-- Indexes for table `lib_books_borrow`
--
ALTER TABLE `lib_books_borrow`
  ADD PRIMARY KEY (`br_id`),
  ADD KEY `usr_id` (`usr_id`),
  ADD KEY `bk_id` (`bk_id`);

--
-- Indexes for table `lib_books_types`
--
ALTER TABLE `lib_books_types`
  ADD PRIMARY KEY (`bt_id`);

--
-- Indexes for table `lib_users`
--
ALTER TABLE `lib_users`
  ADD PRIMARY KEY (`usr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lib_admins`
--
ALTER TABLE `lib_admins`
  MODIFY `adm_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสผู้ดูแล', AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `lib_books`
--
ALTER TABLE `lib_books`
  MODIFY `bk_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสรายการ', AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `lib_books_borrow`
--
ALTER TABLE `lib_books_borrow`
  MODIFY `br_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสรายการ', AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `lib_books_types`
--
ALTER TABLE `lib_books_types`
  MODIFY `bt_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสประเภท', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lib_users`
--
ALTER TABLE `lib_users`
  MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสผู้ใช้', AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lib_books`
--
ALTER TABLE `lib_books`
  ADD CONSTRAINT `lib_books_ibfk_1` FOREIGN KEY (`bt_id`) REFERENCES `lib_books_types` (`bt_id`) ON DELETE SET NULL;

--
-- Constraints for table `lib_books_borrow`
--
ALTER TABLE `lib_books_borrow`
  ADD CONSTRAINT `lib_books_borrow_ibfk_1` FOREIGN KEY (`usr_id`) REFERENCES `lib_users` (`usr_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lib_books_borrow_ibfk_2` FOREIGN KEY (`bk_id`) REFERENCES `lib_books` (`bk_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
