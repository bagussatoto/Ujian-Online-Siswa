-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2019 at 05:10 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prio_ta`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(3) NOT NULL,
  `username` varchar(64) DEFAULT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `alamat` text,
  `no_telp` char(13) DEFAULT NULL,
  `email` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `nama`, `alamat`, `no_telp`, `email`) VALUES
(1, 'admin', 'Super Admin', 'Jogja', '08123456789', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `grup_soal`
--

CREATE TABLE `grup_soal` (
  `id_grup_soal` int(11) NOT NULL,
  `nama_grup_soal` varchar(30) DEFAULT NULL,
  `id_pelajaran` int(11) DEFAULT NULL,
  `metode_acak` enum('LCG','SQL RANDOM') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grup_soal`
--

INSERT INTO `grup_soal` (`id_grup_soal`, `nama_grup_soal`, `id_pelajaran`, `metode_acak`) VALUES
(1, 'Ujian Akhir Semester (UAS)', 3, NULL),
(2, 'Ujian Tengah Semester (UTS)', 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `nip` char(20) NOT NULL,
  `username` char(64) DEFAULT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `alamat` text,
  `tempat_lahir` varchar(20) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `agama` enum('Islam','Hindu','Budha','Kristen Protestan','Katolik','Kong Hu Cu') DEFAULT NULL,
  `no_telp` char(13) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `gambar` varchar(100) DEFAULT NULL,
  `jk` enum('L','P') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`nip`, `username`, `nama`, `alamat`, `tempat_lahir`, `tgl_lahir`, `agama`, `no_telp`, `email`, `gambar`, `jk`) VALUES
('1985033020190428', '1985033020190428', 'Guru Satu', 'Jogja', 'Jogja', '2019-05-01', 'Islam', '08123456789', 'gurusatu@gmail.com', 'Default-avatar.jpg', 'L'),
('1985033020190429', '1985033020190429', 'Guru Kepala Lab', 'jogja', 'jogja', '2019-05-01', 'Islam', '08123456789', 'gurukepalalab@gmail.com', 'Default-avatar1.jpg', 'L');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_ujian`
--

CREATE TABLE `hasil_ujian` (
  `id_hasil_ujian` int(11) NOT NULL,
  `nis` char(20) DEFAULT NULL,
  `id_grup_soal` int(11) DEFAULT NULL,
  `nilai` char(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jawaban`
--

CREATE TABLE `jawaban` (
  `jawaban_id` int(10) NOT NULL,
  `soal_id` int(10) NOT NULL,
  `nis` char(20) DEFAULT NULL,
  `jawaban_soal` enum('a','b','c','d') DEFAULT NULL,
  `keterangan` enum('benar','salah') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(20) DEFAULT NULL,
  `blok` enum('Y','N') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `blok`) VALUES
(1, 'Kelas IX', 'N'),
(2, 'Kelas VIII', 'N'),
(3, 'Kelas VII', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `pbm`
--

CREATE TABLE `pbm` (
  `id_pbm` int(11) NOT NULL,
  `tahun_ajaran` char(9) DEFAULT NULL,
  `id_pelajaran` int(11) DEFAULT NULL,
  `nip` char(20) DEFAULT NULL,
  `nis` char(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pbm`
--

INSERT INTO `pbm` (`id_pbm`, `tahun_ajaran`, `id_pelajaran`, `nip`, `nis`) VALUES
(3, '2019/2020', 3, '1985033020190428', '111235020000120001');

-- --------------------------------------------------------

--
-- Table structure for table `pelajaran`
--

CREATE TABLE `pelajaran` (
  `id_pelajaran` int(11) NOT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `nama_pelajaran` varchar(20) DEFAULT NULL,
  `blok` enum('Y','N') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelajaran`
--

INSERT INTO `pelajaran` (`id_pelajaran`, `id_kelas`, `nama_pelajaran`, `blok`) VALUES
(3, 1, 'Bahasa Indonesia', 'N'),
(4, 1, 'Matematika', 'N'),
(5, 1, 'Bahasa Inggris', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nis` char(20) NOT NULL,
  `username` char(64) DEFAULT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `alamat` text,
  `tempat_lahir` varchar(20) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `jk` enum('L','P') DEFAULT NULL,
  `agama` enum('Islam','Hindu','Budha','Kristen Protestan','Katolik','Kong Hu Cu') DEFAULT NULL,
  `no_telp` char(13) DEFAULT NULL,
  `email` varchar(20) DEFAULT NULL,
  `gambar` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nis`, `username`, `nama`, `alamat`, `tempat_lahir`, `tgl_lahir`, `jk`, `agama`, `no_telp`, `email`, `gambar`) VALUES
('111235020000120001', '111235020000120001', 'Siswa Satu', 'jogja', 'Jogja', '2019-05-01', 'L', 'Islam', '08123456789', 'siswasatu@gmail.com', 'Default-avatar.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `soal`
--

CREATE TABLE `soal` (
  `id_soal` int(11) NOT NULL,
  `id_grup_soal` int(11) DEFAULT NULL,
  `soal` text,
  `gambar` varchar(50) DEFAULT NULL,
  `a` text,
  `b` text,
  `c` text,
  `d` text,
  `jawaban` enum('A','B','C','D') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `soal`
--

INSERT INTO `soal` (`id_soal`, `id_grup_soal`, `soal`, `gambar`, `a`, `b`, `c`, `d`, `jawaban`) VALUES
(1, 1, 'Perekonomian di dunia terus merosot yang disebabkan resesi di Eropa yang berkepanjangan. Hal ini membawa dampak yang sangat besar bagi perajin di Indonesia karena produknya tidak dapat diekspor bahkan gagal ekspor. Untuk mempertahankan kelangsungan hidup keluarga dan karyawannya banyak perajin kita yang beralih usaha lain.\r\nMakna tersurat paragraf di atas adalah ….', NULL, 'Perekonomian Indonesia merosot sehingga berdampak di perekonomian dunia.', 'Dampak kemerosoton perekonomian dunia, perajin Indonesia beralih usaha lain.', 'Kegagalan mengekspor produk karena perajin tidak mampu bersaing untuk menghasilkan produk unggulan.', ' Eropa menjadi penyebab Indonesia tidak bisa ekspor produk.', 'B'),
(2, 1, 'Dewasa ini kita tidak asing lagi mendengar kata internet. Penggunaan internet berkembang dengan pesat. Sekarang masyarakat dapat dengan mudah mengakses internet di warnet atau melalui laptop dengan modem ataupun wireless-connected bahkan lewat HP. Jumlah pengguna interenet pun akan terus bertaambah.\r\nArti istilah pesat dalam paragraf tersebut adalah ….', NULL, 'Banyak', 'Lambat', 'Cepat', ' Kuat', 'C'),
(3, 1, 'Hidup bermasyarakat perlu saling menghargai. Salah satu bentuk penghargaan adalah pemberian pujian. Membiasakan memberikan pujian berarti belajar hidup saling menghargai. Hal itu akan membuat hidup ini semakin terasa indah.\r\nMakna tersurat paragraf di atas adalah ….', NULL, 'Bentuk penghargaan tidak hanya pemberian pujian tetapi bisa juga dengan   pemberian hadiah.', ' Hidup dengan memberi akan terasa sangat indah.', 'Hidup dalam keanekaragaman harus saling menghargai.', 'Pemberian pujian merupakan salah satu bentuk penghargaan dalam hidup bermasyarakat.', 'D'),
(4, 1, 'Berdasarkan hasil penelitian, satu pohon jika dikonversi ke rupiah bisa menghasilkan oksigen senilai Rp 1.174.000,00 per hari. Tentu pohon-pohon yang ditebang secara asal-asalan akan mempengaruhi ekosistem yang ada. Jika keseimbangan alam terganggu, dampaknya akan sangat dirasakan oleh manusia. Padahal fungsi pohon itu sendiri untuk menyerap air dan menyediakan oksigen secara gratis. Bayangkan saja apabila kila harus membeli oksigen untuk bernafas, berapa biaya yang kita keluarkan?\r\n\r\nArti istilah dikonversi dalam paragraf tersebut adalah ….', NULL, 'Dibentuk', 'Ditukar', 'Digunakan', 'Dihasilkan', 'B'),
(5, 1, 'Bacalah kutipan cerpen berikut!\r\n“Mamaaaaa!!!!” teriak Sasa.\r\n“Ada apa, Sasa? Kok teriak-teriak begitu kayak di hutan saja,” tanya mama.\r\n“Ini nih, Ma. Lihat!! Masak bajunya gak muat, mana besok harus datang ke pesta ulang tahun Reno.”\r\n“Ya sudah, pakai yang lain saja atau mau pakai punya mama?” kata mama sambil tersenyum.\r\nSasa hanya bisa mengernyitkan dahinya dan mendengus kesal.\r\nMakna tersurat dari kutipan cerpen di atas adalah ….', NULL, 'Sasa kesal karena diejek oleh mamanya.', ' Sasa tidak memiliki baju untuk ke pesta ulang tahun Reno.', 'Mama memilihkan baju untuk Sasa.', 'Sasa sedang mempersiapkan baju yang akan dipakai saat pesta ulang tahun Reno.', 'B'),
(6, 1, 'Bacalah kutipan cerpen berikut!\r\nAku bersyukur kepada Tuhan karena dia telah berubah. Aku pun memaafkannya, meskipun sampai saat ini aku belum bertemu dia lagi. Aku berharap suatu hari nanti kami akan menjalin persahabatan lagi.\r\nPenggalan cerpen di atas merupakan bagian ….', NULL, 'Krisis', 'Resolusi', 'Orientasi', 'Komplikasi', 'B'),
(7, 1, 'Bacalah kutipan fabel berikut!\r\nMatahari mulai tenggelam, anak katak yang nakal itu tidak juga pulang. Ibu katak sangat khawatir. Ia kemudian mencari anak katak. Ternyata anak katak masih asyik bermain dengan teman-temannya. Ibu katak mengajak anaknya pulang. Dengan berat hati, katak menyudahi dan mengikuti ibunya pulang.\r\nKata ‘matahari yang mulai tenggelam” tersebut mengandung makna ….', NULL, 'Hari hampir sore', 'Hari hampir pagi', 'Hari hampir malam', 'Hari hampir siang', 'C'),
(8, 1, 'Cermatilah petunjuk pembuatan cilok khas Bandung!\r\n  Tepung terigu, garam, gula, merica dicampur dengan air panas sampai basahnya merata (jangan terlalu cair).\r\n    Setelah kalis, siapkan air untuk merebus yang sudah diberi garam dan sedikit minyak.\r\n    Setelah menunggu sampai agak dingin masukkan tepung kanji, daun bawang lalu uleni.\r\n    Jika telah mengkilat, angkat lalu tiriskan.\r\n    Bentuk adonan menjadi bulatan dan masukkan pada air yang mendidih.\r\n    Terakhir untuk membuat bumbu kacang, blender semua bumbu kacang lalu didihkan sampai kental.', NULL, '(1) – (3) – (2) – (5) – (4) – (6)', '(1) – (2) – (3) – (4) – (5) – (6)', '(1) – (2) – (5) – (3) – (4) – (6)', '(1) – (3) – (5) – (3) – (4) – (6)', 'A'),
(9, 1, 'Bacalah teks berikut!\r\nPenduduk desa binaan PKK provinsi mulai membajak sawah. Mereka akan menanam padi karena musim hujan sudah hadir.\r\nPenggunaan kata yang tidak tepat pada paragraf di atas adalah ….', NULL, 'Binaan', 'Membajak', 'Musim', 'Hadir', 'D'),
(10, 1, 'Kedelai termasuk bahan pangan yang dapat dibuat segala makanan seperti tahu, tempe, dan tauco.\r\nPenggunaan kata yang tidak tepat pada paragraf di atas adalah ….', NULL, 'Bahan', 'Pangan', 'Dibuat', 'Segala', 'D'),
(11, 1, 'Hitam, hitam sekali penghidupan perempuan bangsa kita di masa silam, lebih hitam, lebih kelam, dari malam yang gelap! Perempuan bukan manusia seperti laki-laki yang mempunyai pikiran dan pemandangan sendiri, yang mempunyai hidup sendiri. Perempuan hanya hamba sahaya, perempuan hanya budak yang harus bekerja dan melahirkan anak bagi laki-laki, dengan tiada memiliki hak. Setinggi-tingginya ia menjadi perhiasan, menjadi permainan, yang dimulia-muliakan selagi disukai, tetapi dibuang dan ditukar, apabila telah kabur cahayanya, telah hilang sarinya. Sebagaimana pepatah menyatakan habis manis sepah dibuang.\r\nKalimat yang dicetak miring dalam paragraf tersebut menggunakan majas yang sama dengan kalimat ...', NULL, 'Tidak, saya tidak mau lagi bertemu dengan dia, tidak juga sekarang dan nanti.', 'Anak, cucu, ayah, ibu, nenek, kakek sampai bebuyutan hadir dalam pesta upacara adat itu.', 'Bapak-bapak, Ibu-ibu, serta Saudara-saudara saya minta kita harus tetap bersatu padu.', ' Pangkat, jabatan, uang itu bagiku tidak ada artinya selain cinta yang sejati.', 'D'),
(12, 1, 'Kata-kata si pegawai itu memberondong cepat bagai peluru yang mendesing memerahkan daun telinga laki-laki kurus itu. Biji mata laki-laki itu melotot berputar-putar cepat seolah-olah ...\r\nMajas yang tepat untuk melengkapi teks tersebut adalah ...', NULL, ' hendak menatap anaknya dengan kasih sayang', 'mati memalingkan pemandangan bagiku', 'mati melihat seseorang dengan jelas', 'hendak melompat keluar dari kedua matanya', 'D'),
(13, 1, 'Walaupun tiap hari berpeluh keringat, tak sedikit pun Fahri mengeluh. Semangatnya keras bagaikan baja.\r\nKalimat kedua pada paragraf di atas mengandung majas ...', NULL, 'Metafora ', 'Asosiasi      ', 'Personifikasi', 'Metonimia', 'B'),
(14, 1, 'Nita: Fik, kamu mengerti tidak akibat orang yang suka mengonsumsi narkoba.\r\nIfik: Tahu kak. Kan sudah diajarkan dan dijelaskan panjang lebar oleh dokter sekolah kami.\r\nNita: Tetapi, mengapa kamu tidak melarang teman kamu si Kiki.\r\nIfik: Kakak Nita saja yang memberitahukan karena kalau saya, tidak mau menurut.\r\nNita: Ya, kamu jangan mencontoh dia ya. Kalau sudah tertangkap, menyesal juga tidak ada gunanya. Ibarat peribahasa ......', NULL, 'Bergantung di akar lapuk', 'Nasi sudah menjadi bubur', 'Menangguk di air keruh', 'Berumah di tepi pantai', 'B'),
(15, 1, 'Seseorang yang suka mengabaikan atau menunda-nunda pekerjaannya padahal waktu yang tersedia cukup banyak. Tetapi, setelah diketahui manfaat dan keuntungan dari pekerjaan tersebut, barulah dia memulai mengerjakannya. Namun waktu, pengerjaannya tinggal sedikit.\r\n', NULL, 'Mulutmu harimaumu yang akan menerkam kepalamu', 'Hari pagi dibuang-buang, hari petang dikejar-kejar', 'Hilang tak tentu rimbanya, mati tak tentu kuburnya', 'Ikut hati mati, ikut rasa binasa, ikut mata buta', 'B'),
(16, 1, 'Pengelola tempat wisata Curug Bersih memperkirakan ada sekitar 15 ribu pengunjung yang mendatangi tempat wisata ini pada masa liburan anak sekolah tahun ini. Perkiraan ini dianggap tidak berlebihan karena membludaknya jumlah pengunjung yang datang pada musim liburan tahun lalu. Untuk menambah daya tarik pengunjung, pengelola akan menyiapkan beberapa macam hiburan, seperti pentas musik dan pertunjukan – pertunjukan seni lainnya. ', NULL, 'Pentas musik di tempat wisata Curug Bersih', 'Membludaknya jumlah pengunjung di tempat wisata ini', 'Perkiraan jumlah pengunjung tempat wisata Curug Bersih tahun ini', 'Pengelola menyiapkan beberapa hiburan untuk menambah daya tarik tempat wisata ini ', 'C'),
(17, 1, 'Menjelang berbuka puas jalanan menjadi sangat macet (1). Hal ini dikarenakan membludaknya jumlah para pengendara kendaraan bermotor (2). Kebanyakan dari mereka adalah para pemuda yang sedang ngabuburit atau menunggu berbuka puasa (3). Mereka menunggu waktu berbuka puasa dengan berkumpul bersama teman atau berbuka bersama (4). Sayangnya, hal ini malah menambah kemacetan jalan raya (5).', NULL, '4', '3', '2', '1', 'D'),
(18, 1, 'Pemerintah akan memantau harga – harga kebutuhan bahan pokok di pasaran pada saat menjelang dan selama bulan ramadhan. Hal ini dilakukan untuk mencegah tindakan – tindakan nakal para pedagang yang menjual dengan harga yang sangat tinggi. Jika harga bahan pokok di pasaran melonjak, maka pemerintah akan bertindak dengan melakukan operasi pasar.\r\n\r\nKalimat kritik yang tepat pada isi paragraf di atas adalah ?', NULL, 'Pemerintah seharusnya memantau harga barang pokok tidak hanya selama bulan Ramadhan', 'Pemerintah harus menurunkan harga bahan pokok selama bulan ramadhan', 'Pemerintah seharusnya menindak para pedagang yang berlaku curang', 'Pemerintah harus mengadakan operasi pasar salama bulan Ramadhan', 'A'),
(19, 1, 'Berita 1\r\n\r\nKematian Angeline membuat masyarakat Indonesia geram. Bagaimana tidak ? Gadis kecil yang dikabarkan meninggal ini, ternyata dinyatakan meninggal terkubur di halaman rumahnya sendiri. Ironisnya, kematian Angeline ini disebabkan oleh orang terdekatnya sendiri. Semasa hidupnya, Angeline tidak mendapatkan perhatian oleh ibu angkatnya. Bahkan dia diperlakukan seperti pembantu.\r\n\r\nBerita 2\r\n\r\nPolisi akhirnya menetapkan seorang dosen yang diduga menelantarkan keempat anaknya. Menurut penyelidik, anak – anaknya dibiarkan tinggal di tempat yang tidak layak huni. Bahkan, salah satu anaknya tidak diperbolehkan masuk ke rumah, sehingga dia harus tidur di pos ronda. Setelah dilakukan penyelidikan lebih lanjut. Ternyata, tersangka juga merupakan seorang pecandu narkoba.\r\n\r\n Kesamaan isi yang disampaikan pada teks kutipan berita di atas adalah ?', NULL, 'Kekerasan anak disebabkan oleh orang tua kandung', 'Kasus penelantaran anak', 'Kasus pembunuhan anak', 'Kasus penyalahgunaan narkoba', 'B'),
(20, 1, 'Berita 1\r\n\r\nKematian Angeline membuat masyarakat Indonesia geram. Bagaimana tidak ? Gadis kecil yang dikabarkan meninggal ini, ternyata dinyatakan meninggal terkubur di halaman rumahnya sendiri. Ironisnya, kematian Angeline ini disebabkan oleh orang terdekatnya sendiri. Semasa hidupnya, Angeline tidak mendapatkan perhatian oleh ibu angkatnya. Bahkan dia diperlakukan seperti pembantu.\r\n\r\nBerita 2\r\n\r\nPolisi akhirnya menetapkan seorang dosen yang diduga menelantarkan keempat anaknya. Menurut penyelidik, anak – anaknya dibiarkan tinggal di tempat yang tidak layak huni. Bahkan, salah satu anaknya tidak diperbolehkan masuk ke rumah, sehingga dia harus tidur di pos ronda. Setelah dilakukan penyelidikan lebih lanjut. Ternyata, tersangka juga merupakan seorang pecandu narkoba.\r\n Perbedaan urutan penyampaian informasi di atas adalah ?', NULL, 'Teks 1 Siapa, Apa, mengapa ; Teks 2 Siapa, mengapa, apa', 'Teks 1 Apa, Kenapa,  Bagaimana ; Teks 2 Siapa, Apa, kenapa', 'Teks 1 Kenapa, Apa, bagaimana ; Teks 2 Siapa, Kenapa, Apa', 'Teks 1 Bagaimana, Apa, Kenapa ; Teks 2 Apa, Siapa, Kenapa', 'B'),
(21, 1, '(1) Kebocoran pembangkit listrik di Jepang merupakan kecelakaan nuklir yang terparah di muka bumi ini. (2) Musibah ini menyebabkan sepuluh ribu jiwa terpapar oleh radiasi nuklir yang sangat berbahaya. (3) Nuklir memang bisa digunakan sebagai sumber energi. (4) Namun, penggunaan ini tidak efektif karena memiliki resiko yang sangat besar. (5) Diperkirakan, radiasi ini akan terus berada di daerah itu selama puluhan tahun ke depan. \r\n\r\nKalimat yang merupakan fakta adalah ?', NULL, '1 dan 2', '2 dan 3', ' 2 dan 4', '3 dan 5', 'B'),
(22, 1, '(1) Cuaca di Bandar Lampung tidak bersahabat selama beberapa hari ke depan. (2) Hal ini bisa dilihat dari data yang dikeluarkan oleh pihak BMKG yang menyatakan bahwa hujan akan terus turun pada bulan ini. (3) Keadaan ini sungguh membuat susah orang – orang. (4) Di musim penghujan ini mereka harus menghadapi beberapa macam masalah. (5) Padahal, Jika tidak hujan, orang – orang pasti sangat senang.\r\nKalimat yang merupakan opini adalah ?', NULL, ' 1 dan 3', ' 2 dan 4', '4 dan 5', '3 dan 5', 'D'),
(23, 1, 'Memo\r\n\r\nKepada : Manager keuangan\r\nDari : General manager\r\n\r\n………………. yang akan dipakai dalam rapat dengan para dewan direksi, pada tanggal 22 Juni 2015. \r\n\r\nGeneral Manger\r\n        ttd\r\nAria Nugraha\r\n\r\nKalimat yang tepat untuk mengisi bagian yang kosong di atas adalah ?', NULL, 'Segera siapkan laporan keuangan', 'Tolong siapkan undangan rapat', 'Saya membutuhkan laporan keuangan. Oleh karena itu, berikan kepada saya sebagai bahan', 'Saya ingin membuat acara rapat dengan dewan direksi. Oleh karena itu, buatkan undangan', 'A'),
(24, 1, '1. Tidak lupa, Budi merapikan tempat tidurnya.\r\n2. Kemudian, dia pergi ke sekolah\r\n3. Budi bangun pagi jam 6\r\n4. Setelah itu, dia mandi dan memakai seragam\r\n5. Lalu, dia sarapan pagi bersama kedua orang tuanya.\r\n\r\nKalimat – kalimat di atas akan menjadi sebuah paragraf yang padu, jika disesuaikan dengan urutan ?', NULL, '1, 2, 3, 5, 4', ' 3, 1, 4, 5, 2', ' 2, 3, 1, 4, 5', '4, 5, 3, 2, 1', 'B'),
(25, 1, 'Judul buku : Mari berbahasa yang baik dan benar\r\nPenulis : Aryo Nugroho\r\nPenerbit : Gramidia\r\nTahun : 2015\r\nTempat : Jakarta', NULL, 'Nugroho, Aryo. 2015. Mari Berbahasa yang Baik dan Benar. Jakarta: Gramidia', 'Aryo, Nugroho.  2015. Mari Berbahasa yang Baik dan Benar. Jakarta: Gramidia', 'Nugroho, Aryo. Mari Berbahasa yang Baik dan Benar. Jakarta: Gramidia. 2015', 'Aryo, Nugroho. Mari Berbahasa yang Baik dan Benar. Jakarta. 2015: Gramidia.', 'A'),
(26, 1, 'Di bawah ini merupakan ciri – ciri pantun, kecuali …', NULL, 'Terdiri dari bait genap', '1 Bait terdiri dari sampiran dan isi', ' Memiliki sajak', 'Terdiri dari bait ganjil', 'D'),
(27, 1, 'Buah manggis kulitnya tipis \r\n………………………………………….\r\nMakin kupandang dikau semakin manis\r\nMembuat hati ini jatuh menggila\r\n\r\nLarik yang tepat untuk melengkapi pantun di atas adalah ?', NULL, 'Diiris dengan batang peria', 'beli di pasar bukan di warung', 'Buah mangga buah cempeda', 'Jatuh tepat di atas kepala', 'D'),
(28, 1, 'Andi duduk termenung sendiri di atas sebuah bangku taman. Sekali – sekali dia berdiri dan melihat sekitar. “Dia janji untuk menemuiku jam 8. Sedangkan, sekarang sudah jam 9. Apakah dia lupa dengan janjinya sendiri,” Gerutu Andi.\r\n\r\nLatar suasana yang tepat pada penggalan cerpen di atas adalah ?', NULL, 'Kesal', 'Gelisah', ' Senang', ' Khawatir', 'A'),
(29, 1, 'Ibu : Kenapa kamu tidak mengerjakan tugas yang ibu berikan kemarin ?\r\nAni : Maafkan Ani Bu, Ani kelelahan setelah pulang dari latihan drama di sekolah.\r\nIbu : . . . \r\nAni : Ani janji Ani akan mengerjakannya di awal waktu.\r\n\r\nKalimat yang tepat untuk melengkapi penggalan percakapan di atas adalah ?', NULL, ' Kamu tidak bertanggung jawab!', ' Lain kali kamu harus bisa membagi waktumu!', 'Jangan latihan drama lagi!', 'Teruskan usahamu!', 'B'),
(30, 1, '“Jika kamu, aku tunjuk sebagai ketua kelompok kita, apa yang akan kamu lakukan dengan kewenangan tersebut?” Budi menunduk,”Saya sungguh tidak berani memikirkan hal tersebut.” \r\nKarakter Budi yang sesuai dengan penggalan cerita di atas adalah ?', NULL, 'Pemberani', 'Pintar', 'Penakut', 'Jujur', 'C'),
(31, 1, ' Berikut ini adalah ciri – ciri novel, kecuali ?', NULL, 'Memiliki nilai - nilai', 'Memiliki karakter', 'Memiliki latar, setting dan plot', 'Memiliki satu konflik', 'D'),
(32, 1, 'Setiap hari Pak Raden bekerja dengan keras. Tidak peduli siang dan malam, Dia dengan tekun menggerakkan tubuh – tubuhnya yang renta. Selain pekerja keras dan tekun, Pak Raden juga terkenal akan kejujurannya.\r\n\r\nPenokohan dalam kutipan novel di atas disampaikan dengan cara ?', NULL, 'Langsung', 'Tidak langsung', 'Tersirat', 'Lingkungan tokoh', 'A'),
(33, 1, 'Manakah diantara karya tulis berikut ini yang merupakan macam – macam prosa lama ?', NULL, 'Hikayat, talibun, legenda, mitos', 'Pantun, puisi, fabel, legenda, cerpen', 'Pantun, puisi, Legenda, esaay', 'Hikayat, talibun, mitos, novel', 'A'),
(34, 1, 'Hatta dan Drajad adalah dua pribadi dengan latar belakang  yang berbeda. Hatta adalah praktisi, sedangkan Drajad adalah intelektual. Hatta kompromistis, Drajad kritis. Dengan demikian, cara penuangan nilai-nilai idealisme mereka kadang-kadang berbeda.\r\n\r\nGagasan utama paragraf tersebut adalah ....', NULL, ' perbedaan pribadi Hatta dan Drajad', 'latar belakang kepribadian Hatta', 'latar belakang kepribadian Drajad', 'nilai-nilai idealisme Hatta dan Drajat', 'A'),
(35, 1, '(1)   Berbagai pihak mulai sibuk menyongsong Ujian Nasional SMP 2010. (2) Salah satunya adalah kesibukan Direktorat Pembinaan SMP menyelenggarakan kegiatan Pendalaman Materi UN bagi Tim Pengembang Kurikulum. (3) Dinas Pendidikan di daerah-daerah juga sibuk melakukan sosialisasi ke satuan pendidikan tentang pelaksanaan UN yang akan dilaksanakan akhir Maret . (4) Begitu juga, sekolah-sekolah mulai giat mengadakan kegiatan belajar tambahan untuk siswa kelas IX.\r\n\r\nKalimat utama paragraf tersebut ditandai dengan nomor ....', NULL, '1', '2', '3', '4', 'A'),
(36, 1, 'Akibat terlambatnya pasokan BBM dari Pertamina, kerepotan masyarakat seputar bahan bakar terus berlangsung. Kelangkaan premium dan pertamax di stasiun pengisian bahan bakar untuk umum (SPBU) sejak sebulan lalu kian meluas. Tidak hanya di Surakarta dan sekitarnya, kondisi itu kian meluas ke beberapa wilayah di Tanah Air. Sejauh pemantauan penulis, solar pun mulai menghilang. Pengumuman “Premium Habis” atau “Bensin Habis” banyak dijumpai di sejumlah SPBU. Akibatnya, terjadi antrean kendaraan yang ingin mengisi bahan bakar.\r\n\r\nKritik yang tepat terhadap pihak Pertamina sesuai dengan teks berita di atas adalah...', NULL, 'Sebaiknya Pertamina menjaga komitmennya untuk menjamin kelancaran pasokan BBM sehingga tidak meresahkan warga.', 'Dalam urusan distribusi, keterlambatan pasokan merupakan hal yang sudah biasa karena kondisi cuaca yang tidak mendukung.', 'Masyarakat sebaiknya bisa memaklumi terlambatnya pasokan BBM dan tetap bersabar serta tidak menyalahkan Pertamina.', ' Sebagai badan usaha milik negara, Pertamina harus bertanggung jawab terhadap kekacauan dalam pasokan bahan bakar minyak (BBM).', 'A'),
(37, 1, 'Teks Berita 1     Teks Berita 2 \r\nAS menambah 30 ribu tentara tambahan ke Afghanistan dengan misi mengakhiri kekerasan Taliban dan Alqaidah. Misi pasukan tambahan ini berlangsung selama 1,5 tahun dan setelah itu akan ditarik kembali. Meskipun demikian, banyak pihak meragukan penambahan pasukan ini bisa menghentikan perlawanan Taliban dan Alqaidah.     Konflik berkepanjangan antara pasukan Taliban dan Alqaidah di satu pihak melawan pasukan AS terus berlanjut. Pasukan AS terus memburu milisi yang diduga lari ke Yaman. Puluhan ribu pasukan terus ditambah dan dikerahkan. Namun, banyak pihak tidak yakin penambahan jumlah pasukan AS akan mampu memadamkan perlawanan Taliban dan Alqaidah. \r\n  Kesamaan informasi kedua teks tersebut adalah ... ', NULL, 'Amerika Serikat mengirim 30 ribu pasukan tambahan ke Afghanistan.', ' Misi pasukan Amerika Serikat akan menjalankan tugas selama 1,5 tahun.', 'Pasukan Amerika Serikat terus memburu milisi yang diduga lari ke Yaman.', ' Banyak pihak meragukan kemampuan Amerika Serikat menghentikan perlawanan ', 'D'),
(38, 1, 'Senin (16/1) tadi pagi bus penumpang dari Medan – Banda Aceh masuk paret di wilayah  Saree.  Kecelakaan diduga disebabkan terlepasnya ban depan sehingga  bus menabrak pengaman jalan  dan  masuk parit. Tidak ada korban jiwa dalam peristiwa tersebut.Karena benturan bus tidak begitu kuat. Saat ditemui di lokasi kejadian, Kepala Organda Cabang Banda Aceh menuturkan, penyebab pasti kecelakaan itu ada beberapa kemungkinan, antara lain faktor Bus, pemasangan ban depan, dan  faktor teknis lainnya. \r\n  Informasi yang merupakan isi teks berita tersebut adalah ... ', NULL, ' Bus penumpang Banda Aceh   mengalami kecelakaan pada hari Senin yang telah menimbulkan korban jiwa akibat ban depannya lepas.', ' Kecelakaan telah terjadi pada bus penumpang sehingga masuk parit  dan tidak menimbulkan korban jiwa di wilayah Saree.', 'Bus penumpang telah mengalami kecelakaan pada hari Senin di Sare akibat terlepasnya ban depan  dan tidak ada korban jiwa.', ' Pada hari Senin Bus penumpang dari Banda Aceh-Medan mengalami  kecelakaan di Saree akibat terlepasnya ban depan  dan tidak ada korban jiwa.', 'D'),
(39, 1, 'Berita 1     Berita 2 \r\nGempa bumi  berkekuatan 8,9 Skala Richter telah mengguncang  Banda Aceh. Peristiwa itu terjadi pada hari Minggu (26/12) pukul 08.00 WIB selama 15 menit. Berdasarkan laporan bahwa peristiwa tersebut disertai dengan gelombang tsunami yang sangat dahsyat yang telah  menimbulkan kerusakan yang sangat parah serta menelan korban jiwa sangat banyak. Kepala Badan Metrologi dan Geofisika Banda Aceh mengatakan pusat gempa pada 3,71 Lintang Selatan dan 100,74 Bujur Timur. Sumber gempa berada pada kedalaman 146 kilometer Barat daya, Banda Aceh.     Minggu (26/12) pagi Banda Aceh diguncang gempa. Gempa bumi yang berkekuatan 8.9 Skala Richter mengguncang Banda Aceh. Informasi yang diterima telah terjadi kerusakan dan korban jiwa akibat terjangan gelombang tsunami yang  meluluhlantakkan wilayah pesisir  Banda Aceh. Sumber gempa berada pada kedalaman 146 kilometer barat daya,  pada pada 3,71 Lintang Selatan dan 100,74 Bujur Timur Banda Aceh.  Pernyataan ini disampaikan oleh Kepala Badan Metrologi dan Geofisika Banda Aceh. \r\n  \r\nPerbedaan penyajian kedua teks berita tersebut adalah ...   ', NULL, 'Apa-kapan-bagaimana-di mana-siapa     Kapan-apa-bagaimana-siapa-di mana ', 'Apa-kapan-siapa-bagaimana- di mana     di mana-kapan-apa-bagaimana-siapa ', 'Apa-kapan-bagaimana-siapa- di mana     Kapan-apa-bagaimana-di mana-siapa ', 'Apa-bagaimana-kapan-siapa- di mana     Kapan-di mana-apa-bagaimana-siapa ', 'C'),
(40, 1, '(1) Setiap kali musim hujan, kota Banda Aceh selalu banjir.( 2) Banjir yang terjadi merusak 100 rumah. (3) Seandainya masyarakat kota tidak membuang sampah sembarangan, hal ini tidak akan terjadi. (4) Sebenarnya anjuran tidak membuang sampah sembarangan ini sudah lama didengung-dengungkan pemerintah kota Banda Aceh tetapi tampaknya berlalu begitu saja. \r\n  Kalimat yang berisi pendapat dalam paragraf tersebut ditandai dengan nomor .... ', NULL, '(1) dan (3)  ', ' (2) dan (3)', '(1) dan (4) ', '(3) dan (4)', 'D'),
(41, 1, 'Peristiwa besar tidak pernah berhenti di negeri kita. Gempa di Sumatera Barat berganti dengan kasus Bank Century. Kehebohan tentang bank yang konon melibatkan  pejabat teras negeri ini masih bergulir, disusul pula dengan kasus Prita Mulyasari. Lalu, bangsa kita dirundung duka. K.H. Abdurrahman Wahid  atau Gus Dur meninggalkan kita ketika bangsa ini dikepung beragam persoalan yang pelik. Oleh karena itu, sudah saatnya kita merenung dan kembali pada ajaran-Nya. \r\nSimpulan paragraf tersebut yang tepat adalah ... ', NULL, 'Bangsa kita tidak pernah berhenti dari persoalan besar sehingga kita perlu merenung dan kembali pada ajaran-Nya.', 'Berbagai peristiwa besar mewarnai kehidupan bangsa kita seperti gempa, kasus bank, kasus Prita Mulyasari hingga wafatnya Gus Dur.', 'Berbagai peristiwa duka menimpa bangsa kita, kini saatnya kita merenung dan kembali pada ajaran-Nya.', 'Peristiwa duka tidak pernah berhenti menimpa bangsa kita, dari gempa hingga Gus Dur wafat. ', 'A'),
(42, 1, 'Bacalah kutipan tajuk berikut dengan saksama kemudian kerjakan soal nomor 45 s.d. 50! \r\nSatu lagi budaya Indonesia yang dicuri Malaysia yaitu tari pendet. Tari pendet yang sangat dicintai masyarakat Bali telah digunakan negeri jiran itu untuk promosi pariwisatanya. Manuver ini menambah panjang daftar pencaplokan budaya Indonesia. Sebelumnya, negeri serumpun itu mengakui lagu “Rasa Sayange”, batik, musik angklung, dan reog Ponorogo sebagai budayanya. Kita marah dan menuntut Malaysia menyampaikan permohonan maaf serta menarik kembali iklan itu. \r\nKetika kasus tari pendet ramai dipersoalkan Indonesia, seorang produser iklan pariwisata Malaysia dengan enteng menjawab,\"Tidak ada salahnya kami mempromosikan tarian Indonesia. Karena tema yang kami angkat adalah The Truly Asia.\" Akan tetapi, si produser itu lupa bahwa triknya terlalu mudah dibaca. Penjelasan tentang tari pendet berasal dari Indonesia tidak ada di bawah iklan. \r\nKita sebagai bangsa besar dengan kekayaan budaya tiada tara boleh saja kesal dan marah, tetapi itu semua tidak menyelesaikan masalah. Besok atau lusa, hanya soal waktu, Malaysia akan mengklaim lagi budaya Indonesia sebagai budayanya. Jika Indonesia ribut, mereka tinggal melayangkan permohonan maaf. Yang penting, citra sebagai The Trully Asia sudah terbentuk. \r\nIndonesia harus menyikapi pengakuan tari pendet oleh Malaysia dengan serius, sistematis, dan komprehensif. Pariwisata harus dikelola dengan lebih gencar, memanfaatkan semua sumber daya yang dimiliki, terutama kekayaan budaya. Tiada guna kita berang terhadap ulah si Trully Asia tanpa langkah nyata untuk membangun martabat bangsa. \r\n\r\nGagasan utama tajuk tersebut adalah .... ', NULL, 'Indonesia kurang  serius  dalam menyikapi pendakuan Malaysia terhadap tari pendet. ', 'Malaysia mendaku lagu Rasa Sayange, batik, musik  angklung, dan reog Ponorogo', 'Keributan Indonesia ketika Malaysia dengan enteng meminta maaf kepada Indonesia', 'Kita adalah bangsa yang besar dengan kekayaan yang tiada tara boleh marah', 'A'),
(43, 1, 'Tajuk atau tajuk rencana adalah tulisan opini dari redaktur suatu surat kabar. \r\nGagasan utama tajuk merupakan inti persoalan yang dikemukakan oleh penulis dalam sebuah tajuk. Untuk mengenali gagasan utama sebuah tajuk kita harus tahu gagasan-gagasan pada setiap paragraf yang dikemukakan penulis. \r\nCiri-ciri gagasan utama tajuk adalah: \r\n1.    Persoalan yang paling umum dari sebuah tajuk\r\n2.    Menjadi rincian persoalan dalam setiap paragraf\r\n3.    Kata kuncinya sering muncul\r\n  \r\nPada tajuk di atas kita akan menemukan rincian gagasan: \r\n•    Tari pendet khas Indonesia dicuri Malaysia (paragraf I).\r\n•    Tari pendet ramai dipersoalkan di Indonesia (paragraf II).\r\n•    Kesal dan marah tidak dapat menyelesaikan masalah (paragraf III)\r\n•    Indonesia harus menyikapi pengakuan tari pendet oleh Malaysia dengan serius, sistematis, dan komprehensif (paragraf IV)\r\n  Kata kunci dalam tajuk tersebut adalah tari pendet. Paragraf keempat merupakan sikap yang harus diambil oleh Indonesia terhadap persoalan yang diutarakan pada paragraf I,II, dan III. Oleh karena itu,  dapat disimpulkan bahwa gagasan yang paling umum dari keempat paragraf tersebut adalah pilihan A, sedangkan pilihan B,C, dan D  merupakan salah satu gagasan rincian paragraf yang lingkupnya sempit. \r\n  \r\nLetak kalimat fakta pada tajuk tersebut adalah .... ', NULL, ' paragraf pertama kalimat kedua ', 'paragraf kedua kalimat kedua ', ' paragraf ketiga kalimat kedua', 'paragraf keempat kalimat kedua', 'A'),
(44, 1, 'Penulis pada tajuk tersebut berpihak  pada.... ', NULL, 'rakyat Indonesia ', ' negeri jiran Malaysia ', 'masyarakat Bali', ' produser iklan', 'C'),
(45, 1, 'Simpulan isi tajuk tersebut adalah... ', NULL, 'Malaysia telah membuat marah rakyat Indonesia karena telah beberapa kali mencuri budaya Indonesia.', 'Indonesia hanya bisa ribut ketika Malaysia dengan enteng meminta maaf melalui surat kepada Indonesia.', ' Sebagai bangsa yang besar dengan kekayaan yang tiada tara, tidak boleh kesal dan marah terhadap bangsa Malaysia.', 'Pengakuan Malaysia terhadap tari pendet  perlu disikapi Indonesia secara serius, sistematis, dan komprehensif.', 'D'),
(46, 1, 'Grafik Perolehan Nilai Rata-rata Bermain Drama di Kelas IX.A SMP Merah Putih \r\nSimpulan isi grafik tersebut adalah ... ', NULL, 'Perolehan nilai rata-rata siswa kelas IX.A dalam bermain drama  tampak sangat bervariasi.', 'Kenaikan perolehan nilai rata-rata dalam penghayatan dan pelafalan dalam bermain drama di kelas IX.A untuk setiap siklus adalah sama.', ' Perolehan nilai rata-rata kemampuan siswa kelas IX.A berekspresi saat bermain drama sangat menggembirakan. ', 'Perolehan nilai rata-rata siswa kelas IX.A dalam bermain drama mengalami kemajuan setiap siklus.', 'D'),
(47, 1, 'Petugas pengelola pariwisata Taman Seroja memprediksikan terdapat sekitar 27 ribu pelancong yang datang ke tempat ini pada saat liburan akhir semester di tahun ini. Prediksi ini tentu saja tidak berlebihan karena berkaca pada jumlah pelancong yang datang pada saat musim liburan di tahun lalu. Dalam rangka menambah minat dan daya tarik pelancong, petugas pengelola akan mempersiapkan beberapa item hiburan baru speerti misalnya wahana air, pertunjukan musik, sulap, dan masih banyak lagi.\r\n\r\nGagasan utama pada paragraf di atas ialah …', NULL, 'Adanya tambahan wahana air di tempat wisata taman seroja', 'Prediksi peningkatan jumlah pelancong pariwisata taman seroja di tahun ini', 'Taman seroja adalah tempat wisata terbaik di Indonesia', 'Beberapa wahana baru taman seroja akan menarik minat para pelancong', 'B'),
(48, 1, 'Kalimat tanya berikut ini yang jawabannya terdapat pada paragraf di atas ialah …', NULL, ' Dari mana sajakah asal pelancong yang mengunjungi wisata taman seroja?', 'Berapa jumlah nomonal pelancong yang telah diprediksikan oleh pengelola wisata taman seroja?', 'Diantara beberapa wahana yang tersedia, bentuk hiburan jenis apa yang paling diminati oleh pelancong wisata taman seroja?', ' Siapa sajakah tokoh nasional yang hadir dalam peresmian wisata taman seroja?', 'B'),
(49, 1, 'Berita tentang peristiwa kematian Sofia, seorang gadis kecil berusia 7 tahun tak ayal membuat masyarakat Indonesia geram. Gadis kecil lucu tersebut tewas di tangan ibu angkatnya sendiri dan dikubur di halaman belakang rumah, tepat di bawah kandang kelinci peliharaan keluarga. Sofia memang hanyalah anak angkat dari keluarga Stefanus. Ia kerapkali diperlakukan layaknya seorang budak di rumah tersebut. …\r\n\r\n3. Berita tersebut berisikan tentang …', NULL, 'kasus penganiayaan orang tua kandung terhadap anak', 'kekerasan orang tua oleh anak kandung', 'peristiwa pembunuhan seorang anak oleh ibu angkatnya sendiri', ' perlakuan layaknya budak oleh ibu angkat', 'C'),
(50, 1, '(1)Cuaca di kota Padang sampai pada beberapa hari ke depan sangatlah tidak bersahabat. (2) hal tersebut berdasarkan pada data yang dirilis oleh BMKG yang menyatakan bahwa kota tersebut akan terus diguyur hujan pada bulan Februari. (3) Kondisi tersebut cukup menyulitkan warga masyarakat. (4) mengingat hujan yang seringkali berlangsung selama berhari-hari, wali kota Padang menghimbau agar warganya sedia jaz hujan untuk menghadapi aktivitas di bulan ini. (5) Wali kota menambahkan bahwa hujan jangan sampai menghambat produktivitas warga.\r\n\r\n5. Kalimat fakta ditunjukkan pada kalimat no …', NULL, '1', '2', '3', '4', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` char(64) NOT NULL,
  `password` char(32) DEFAULT NULL,
  `level` enum('admin','guru','siswa','guru_kep_lab') DEFAULT NULL,
  `blok` enum('Y','N') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `level`, `blok`) VALUES
('111235020000120001', 'bcd724d15cde8c47650fda962968f102', 'siswa', 'N'),
('1985033020190428', '77e69c137812518e359196bb2f5e9bb9', 'guru', 'N'),
('1985033020190429', '77e69c137812518e359196bb2f5e9bb9', 'guru_kep_lab', 'N'),
('admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'N');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `grup_soal`
--
ALTER TABLE `grup_soal`
  ADD PRIMARY KEY (`id_grup_soal`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`nip`);

--
-- Indexes for table `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  ADD PRIMARY KEY (`id_hasil_ujian`),
  ADD KEY `id_proses_ujian` (`nis`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `pbm`
--
ALTER TABLE `pbm`
  ADD PRIMARY KEY (`id_pbm`);

--
-- Indexes for table `pelajaran`
--
ALTER TABLE `pelajaran`
  ADD PRIMARY KEY (`id_pelajaran`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`);

--
-- Indexes for table `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id_soal`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`(32));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `grup_soal`
--
ALTER TABLE `grup_soal`
  MODIFY `id_grup_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pbm`
--
ALTER TABLE `pbm`
  MODIFY `id_pbm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pelajaran`
--
ALTER TABLE `pelajaran`
  MODIFY `id_pelajaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `soal`
--
ALTER TABLE `soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
