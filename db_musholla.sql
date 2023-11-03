-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2022 at 04:17 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_musholla`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_artikel`
--

CREATE TABLE `tbl_artikel` (
  `id_artikel` int(11) NOT NULL,
  `id_kategoriartikel` int(11) NOT NULL,
  `slug_artikel` varchar(100) NOT NULL,
  `judul_artikel` varchar(70) NOT NULL,
  `isi_artikel` text NOT NULL,
  `penulis` varchar(35) NOT NULL,
  `img_artikel` varchar(60) NOT NULL,
  `status_artikel` int(1) NOT NULL,
  `hits` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_artikel`
--

INSERT INTO `tbl_artikel` (`id_artikel`, `id_kategoriartikel`, `slug_artikel`, `judul_artikel`, `isi_artikel`, `penulis`, `img_artikel`, `status_artikel`, `hits`, `created_at`, `updated_at`) VALUES
(6, 1, 'test-artikel', 'test artikel', '<p>fdafdsafdfadfadasdfafdsa</p>', 'saya sendiri', '1619428090_59ee47ef33b848736182.jpg', 0, 4, '2021-04-26 04:08:10', '2021-05-23 19:59:21'),
(7, 2, 'seputar-fiqih', 'seputar fiqih', '<figure class=\"image\"><img src=\"http://localhost:8080/img/artikel/1619429488_2f3c611de468db85a0dc.jfif\"></figure><h2>&nbsp;</h2><h2><strong>Ini belajar membuat artikel menggunakan ckeditor 5 di codeigniter 4 dengan ajax</strong></h2>', 'donny', '1619429547_ec7fd544b4130a383cb0.jpg', 0, 0, '2021-04-26 04:32:27', '2021-04-26 04:32:27'),
(8, 5, 'adzan-berkumandang-di-sembilan-masjid-london-borough', 'Adzan Berkumandang di Sembilan Masjid London Borough', '<p>REPUBLIKA.CO.ID, LONDON -- Otoritas Waltham Forest, London Borough telah menyetujui adzan dikumandangkan secara publik dari sembilan masjid di wilayahnya. Hal tersebut dilakukan agar Muslim setempat beribadah di rumah mengingat adanya larangan sholat berjamaah di masjid.<br>&nbsp;</p><p>Perizinan adzan yang menjadi pertama kalinya di wilayah itu terjadi sejak (4/5), dan akan terus berlanjut selama bulan puasa dan sholat jumat ke depannya. \"Itu (adzan) hanya terjadi di Whitechapel di masjid London Timur dan telah terjadi selama bertahun-tahun, tetapi di sisi London ini tidak pernah, dan di wilayah ini secara khusus, tidak pernah,” ujar Afran Abrahim yang meminta perizinan di Waltham Forest seperti dilansir Metro, Rabu (6/5).</p><p>Abrahim (35 tahun) tak menampik, Ramadhan ini menjadi Ramadhan yang paling berbeda dari biasanya. Terlebih, ketika mayoritas orang tak berkunjung ke masjid dan berdoa.</p><p>\"Ini adalah sesuatu yang tidak ingin saya alami lagi, tetapi kita harus beradaptasi,” kata dia.</p><p>Dia menegaskan, dengan adanya adzan di masjid-masjid di wilayahnya akan membuat situasi menjadi lebih baik. Sehingga, kata dia, para orang tua dan rekan di sekitarnya bisa langsung melakukan sholat ketika masjid mengumandangkan adzan.</p><p>\"Itu telah menjadi pokok pembicaraan yang cukup bagus yang memecah hambatan,\" katanya.</p><p>Dia menambahkan, pada umumnya komunitas Muslim kerap kali dibebani persoalan yang berat, tak terkecuali di wilayahnya. Namun demikian, dengan adanya perizinan tersebut diharapkan adanya respons baik yang bermunculan.</p><p>Terpisah, Wakil Sekretaris Jenderal Asosiasi Islam Waltham Forest, Irfan Akhar mengatakan, biasanya Muslim setempat terbiasa melakukan ibadah dan buka puasa bersama di masjid selama Ramadhan. Namun, berbeda dengan tahun ini terkait adanya penyebaran wabah Covid-19.</p><p>“Semoga mereka yang dekat dengan masjid akan mendengar panggilan sholat dan menemukan sedikit hiburan. Tolong semua orang tinggal di rumah dan tetap aman,\" ujar dia.</p><p>Dia menegaskan, sebagai bentuk penghubung antar-Muslim di tahun ini, Dewan Masjid Waltham Forest telah meminta adzan di beberapa masjid di wilayahnya untuk menyesuaikan dengan kondisi. Utamanya, mengingatkan jamaah waktu sholat dan melakukannya di rumah.</p><p>“Dewan mempertimbangkan permintaan itu seperti halnya dengan kelompok agama atau agama yang ingin beribadah secara bertanggung jawab selama masa sulit ini,” ujar dia.</p><p>&nbsp;</p><p>Sumber: https://republika.co.id/berita/q9wf8k366/adzan-berkumandang-di-sembilan-masjid-di-london-borough</p>', 'admin', '1620632663_b435eaf5460427a65e4e.jpg', 1, 15, '2021-05-10 14:44:23', '2021-05-16 11:38:43'),
(9, 5, 'act-salurkan-bantuan-tunai-untuk-korban-luka-di-gaza', 'ACT Salurkan Bantuan Tunai untuk Korban Luka di Gaza', '<p>REPUBLIKA.CO.ID, JAKARTA--Aksi Cepat Tanggap (ACT) bergerak membantu warga Gaza korban serangan zionis Israel. ACT telah mengunjungi sejumlah<a href=\"https://republika.co.id/tag/rumah-sakit\"> rumah sakit </a>di Gaza untuk memberi bantuan tunai kepada korban luka sehingga para korban bisa membeli obat-obatan untuk memulihkan kondisi mereka atau keluarganya.</p><p>\"Saat ini banyak warga di Gaza yang menjadi korban serangan Israel, tidak memiliki uang sama sekali untuk membeli obat-obatan, karena semua harta yang mereka miliki juga telah hilang saat rumahnya hancur. Sehingga bantuan tunai ini tentunya sangat tepat diberikan untuk mereka,\" ujar Said Mukaffiy dari tim Global Humanity Response ACT, dalam keterangan pers yang diterima, Ahad (23/5).</p><p>Salah satu pasien di rumah sakit adalah Suzy Eshkuntana dan ayahnya, Riad Ashkantna. Anak dan ayah ini sempat menyentuh hati masyarakat dunia lewat foto evakuasi Suzy dari reruntuhan rumahnya di gedung Abu Al-Auf, di Jalan Al-Wehda, Gaza, yang hancur dibom pesawat tempur Israel.</p><p>Suzy saat ini hanya hidup bersama ayahnya. Ibu dan saudara laki-laki Suzy, meninggal dalam serangan tersebut. Dalam foto dan video yang beredar, Suzy nampak terus menangisi kepergian ibu dan saudaranya. Sementara tangis sang ayah juga pecah saat memeluk tubuh anak laki-lakinya yang telah dibalut kafan.</p><p>Sambil terus menangis, Riad meminta kepada warga yang mengurus jenazah anaknya, agar dapat melihat wajah anaknya tersebut untuk terakhir kalinya. Saat kafan di bagian wajah dibuka, tangis Riad pun semakin tak terbendung.</p><p>Beberapa kali Riad mendekap wajahnya ke wajah jenazah anaknya, seolah masih tidak percaya anaknya telah meninggal. Saat ini, kondisi Suzy dan Riad sungguh memprihatinkan. Mereka hanya dapat mengandalkan bantuan dari pihak luar untuk bertahan hidup. Semua harta benda mereka telah hancur bersamaan runtuhnya rumah mereka.</p><p>\"Bantuan dari<a href=\"https://republika.co.id/tag/para-dermawan\"> para dermawan </a>melalui<a href=\"https://republika.co.id/tag/act\"> ACT </a>ini, kami ikhtiarkan untuk terus dapat kami berikan kepada warga<a href=\"https://republika.co.id/tag/palestina\"> Palestina </a>korban agresi Israel, seperti Suzy dan ayahnya. Agar beban hidup mereka setidaknya dapat semakin berkurang di hari-hari berikutnya,\" kata Said.</p>', 'admin', '1621774096_504000688d1c27560456.jpeg', 1, 1, '2021-05-23 19:48:16', '2021-05-26 21:10:04'),
(10, 5, 'israel-harus-dibawa-ke-mahkamah-pidana-internasional', 'Israel Harus Dibawa ke Mahkamah Pidana Internasional', '<p><strong>REPUBLIKA.CO.ID, CARACAS - </strong>Kejahatan Israel di Jalur Gaza harus dibawa ke Pengadilan Kriminal Internasional atau International Criminal Court (ICC), kata Duta Besar<a href=\"https://republika.co.id/tag/palestina\"> Palestina </a>untuk Venezuela Fadi Alzaben, pada hari Jumat.</p><p>“Israel tidak dapat menikmati impunitas seperti sekarang. Mereka harus membayar kejahatan mereka dan harus diadili di ICC,” kata dia.</p><p>Komentarnya muncul sebagai tanggapan atas pengeboman Israel baru-baru ini di Gaza yang berlangsung selama 11 hari. Pernyataan Alzaben dilansir pada sebuah acara untuk memberikan solidaritas dengan rakyat Palestina di Guarenas, sebuah kota yang berbatasan dengan ibu kota Venezuela, Caracas.</p><p>Dia mengatakan bahwa lebih dari 75 anak dan wanita Palestina terbunuh akibat serangan Israel baru-baru ini. “Lebih dari 75 anak dan wanita Palestina telah meninggal. Mereka menyerang infrastruktur Jalur Gaza, juga masjid suci Al Aqsa, ”ujarnya.</p><p>Acara ini diselenggarakan oleh Wali Kota Guarena, Luis Figueroa, yang menegaskan kembali komitmen pemerintah federal Venezuela untuk Palestina. Figueroa mengatakan kotanya akan segera meresmikan sebuah alun-alun untuk menghormati perjuangan rakyat Palestina.</p><p>sumber : https://www.aa.com.tr/id/dunia/israel-harus-dibawa-ke-mahkamah-pidana-internasional/2250723</p>', 'admin', '1621774542_4f075afa3e9c2e8a1d5c.jpg', 1, 14, '2021-05-23 19:55:42', '2021-05-26 22:30:35'),
(11, 5, 'uea-siap-fasilitasi-upaya-perdamaian-israel-palestina', 'UEA Siap Fasilitasi Upaya Perdamaian Israel Palestina', '<p>REPUBLIKA.CO.ID, ABU DHABI -- Putra Mahkota Uni Emirat Arab (UEA) Sheikh Mohammed bin Zayed al-Nahyan mengatakan, negaranya siap memfasilitasi upaya perdamaian Israel dan Palestina. UEA diketahui telah melakukan normalisasi diplomatik dengan Tel Aviv tahun lalu.<br><br>“(UEA) siap bekerja dengan semua pihak untuk mempertahankan gencatan senjata (di Jalur Gaza) dan mencari jalan baru untuk mengurangi eskalasi serta mencapai perdamaian,” kata Sheikh Mohammed pada Ahad (23/5), dilaporkan <i>Emirates News Agency</i> (WAM).&nbsp;<br><br>Namun dia menyebut, untuk membuka jalan baru menuju perdamaian, diperlukan upaya tambahan. “Terutama oleh para pemimpin Israel dan Palestina” ujarnya.<br><br>Pada Agustus 2020, UEA dan Bahrain menandatangani perjanjian damai dengan Israel. Perjanjian damai tersebut dikenal dengan nama Abraham Accords. Pemerintahan mantan presiden Amerika Serikat (AS) Donald Trump berperan besar dalam memediasi serta menjembatani ketiga pihak terkait.&nbsp;<br><br>Dalam perjanjian normalisasi itu, Bahrain dan UEA setuju membuka penerbangan langsung dari dan ke Israel. Para pihak pun sepakat membuka kedutaan besar di negara masing-masing. Normalisasi Israel dengan Bahrain dan UEA merupakan pukulan besar bagi perjuangan kemerdekaan Palestina.<br><br>Palestina, yang selama ini selalu mendapat dukungan penuh dari negara Arab, memandang kesepakatan normalisasi sebagai sebuah tusukan dari belakang. Selain Bahrain dan UEA, pemerintahan Trump membantu Israel mencapai kesepakatan serupa dengan Sudan dan Maroko.</p>', 'admin', '1621851614_0165468235d28b3e6f91.jpg', 1, 6, '2021-05-24 17:20:14', '2021-07-28 10:47:14'),
(12, 1, 'mengapa-harus-peduli-palestina', 'Mengapa Harus Peduli Palestina', '<p>Pasca penyerangan secara brutal yang dilakukan oleh aparat Israel terhadap umat Islam yang sedang melaksanakan shalat tarawih dan I’tikaf di beberapa kawasan masjid di Palestina, muncul kecaman terhadap tindakan aparat Israel dari berbagai masyarakat di seluruh dunia. Termasuk di Indonesia. Banyak masyarakat yang menunjukkan sikap solidaritasnya kepada warga Palestina.</p><p>Mayoritas sikap itu ditunjukkan melalui media sosial dengan cara membuat unggahan tentang keadaan mencekam yang terjadi di Palestina disertai dengan pesan dan doa untuk mereka. Ada pula yang mendonasikan uang dan membagikan informasi donasinya lewat media sosial. Sikap tersebut tentu saja merupakan sikap positif sebagai bentuk kepedulian terhadap warga Palestina meskipun tidak saling kenal. Tetapi mengapa kita dan orang-orang harus peduli terhadap Palestina? Bukankah di masing-masing negara kita banyak juga orang yang membutuhkan kepedulian kita?</p><p><strong>Menolak Segala Bentuk Penjajahan</strong></p><p>Seperti yang tertuang dalam Pembukaan UUD 1945 yang berbunyi, <i>“…sesungguhnya kemerdekaan itu ialah hak segala bangsa, dan oleh sebab itu, maka penjajahan di atas dunia harus dihapuskan, karena tidak sesuai dengan peri kemanusiaan dan peri keadilan.” </i>Jadi sebenarnya tidak hanya soal penjajahan di Palestina, tetapi bentuk penjajahan di negara manapun dan terhadap bangsa manapun adalah kewajiban kita untuk berpihak atau bersuara membela kemerdekaan suatu bangsa.</p><p><strong>Negeri Para Nabi</strong></p><p>Dalam sejarah Islam, tercatat ada beberapa Nabi yang tumbuh dan banyak menghabiskan waktu di Palestina atau pada zaman itu disebut dengan tanah Syam. Mulai dari kelahiran hingga berdakwah sampai ke Palestina. Di antaranya adalah Nabi Ibrahim, Nabi Muhammad, Nabi Yusuf, Nabi Yaqub, Nabi Luth, Nabi Sulaiman, Nabi Ishaq, Nabi Musa, Nabi Isa, Nabi Dawud. Maka dengan sejarah besar tersebut wajar saja jika tanah Palestina harus dibela dan dilindungi dari tangan-tangan kotor penjajah Israel yang tidak hanya mengusir warga Palestina tetapi juga banyak merusak situs-situs bersejarah.</p><p><strong>Kiblat Pertama Umat Islam</strong></p><p>Perlu kita ketahui bahwasannya Ka’bah bukanlah satu-satunya kiblat yang menjadi arah umat Islam shalat. Sebelum Ka’bah, kiblat pertama umat Islam adalah Baitul Maqdis atau Masjid Al Aqsha. Hingga akhirnya pada tahun kedua Hijriah turunlah wahyu dari Allah kepada Nabi Muhammad untuk memindahkan arah shalat atau kiblat ke Ka’bah. Sebagaimana dalam firman Allah,</p><p>قَدْ نَرٰى تَقَلُّبَ وَجْهِكَ فِى السَّمَاۤءِۚ فَلَنُوَلِّيَنَّكَ قِبْلَةً تَرْضٰىهَا ۖ فَوَلِّ وَجْهَكَ شَطْرَ الْمَسْجِدِ الْحَرَامِ ۗ وَحَيْثُ مَا كُنْتُمْ فَوَلُّوْا وُجُوْهَكُمْ شَطْرَهٗ ۗ وَاِنَّ الَّذِيْنَ اُوْتُوا الْكِتٰبَ لَيَعْلَمُوْنَ اَنَّهُ الْحَقُّ مِنْ رَّبِّهِمْ ۗ وَمَا اللّٰهُ بِغَافِلٍ عَمَّا يَعْمَلُوْنَ</p><p><i>“Kami melihat wajahmu (Muhammad) sering menengadah ke langit, maka akan Kami palingkan engkau ke kiblat yang engkau senangi. Maka hadapkanlah wajahmu ke arah Masjidil Haram. Dan di mana saja engkau berada, hadapkanlah wajahmu ke arah itu. Dan sesungguhnya orang-orang yang diberi Kitab (Taurat dan Injil) tahu, bahawa (pemindahan kiblat) itu adalah kebenaran dari Tuhan mereka. Dan Allah tidak lengah terhadap apa yang mereka kerjakan.”</i> (QS. Al-Baqarah: 144)</p><p>Hal-hal di atas hanyalah sebagian dari beberapa alasan lain. Maka seseorang tidak boleh beranggapan buruk terhadap orang lain yang menunjukkan sikap peduli terhadap negara bangsa lain, termasuk Palestina dalam hal ini. Karena biasanya orang yang menunjukkan sikap solidaritas atau peduli dengan Palestina atau bangsa lain, ia juga pasti akan peduli terlebih dahulu dengan bangsanya sendiri atau lingkungan sekitar. <strong>(Wahid)</strong></p><p>Sumber : https://www.daaruttauhiid.org/mengapa-harus-peduli-palestina/</p>', 'admin', '1622285095_d38705de5f3946c7483e.jpg', 1, 14, '2021-05-29 17:44:55', '2021-07-27 20:33:52'),
(13, 1, 'shaum-syawal-dan-hutang-shaum-ramadhan', 'Shaum Syawal dan Hutang Shaum Ramadhan', '<p>DAARUTTAUHIID.ORG, &nbsp; &nbsp;JAKARTA -- Nabi <i>Shallallahu ‘alayhi wassallam </i>bersabda,</p><h3>قال صلى اللهُ عليه وسلام من صَامَ رَمَضَانَ ثُمَّ أَتْبَعَهُ سِتًّا من شَوَّالٍ كان كَصِيَامِ الدَّهْرِ رَوَاهُ مُسْلِمٌ</h3><p><i>“Barangsiapa yang telah melaksanakan puasa Ramadhan, kemudian dia mengikutkannya dengan berpuasa selama 6 (enam) hari pada bulan Syawal, maka dia (mendapatkan pahala) sebagaimana orang yang berpuasa selama satu tahun.”</i> (HR. Muslim no. 1164).</p><p>Ketika memasuki bulan Syawal mayoritas umat Islam biasanya akan melaksanakan puasa lagi, yaitu puasa Syawal. Karena puasa Syawal memiliki keutamaan yang sangat besar, yaitu mendapatkan pahala seperti berpuasa selama satu tahun penuh. Tetapi bagaimana dengan orang yang memiliki hutang puasa ramadhan karena mungkin ketika di bulan Ramadhan sempat sakit atau bepergian jauh yang membuat dirinya tidak memungkinkan jika harus berpuasa dan bagi wanita karena sedang haid. Apakah ia harus membayar terlebih dahulu hutang puasa ramadhannya, atau ia melaksanakan puasa Syawal terlebih dahulu?</p><p><strong>Mengqadha Terlebih Dahulu</strong></p><p>Mengenai pertanyaan tersebut ada dua pandangan ulama yang berbeda. Yang pertama adalah pendapat Ulama yang <i>Mutasyaddid </i>(pendapat yang sangat ketat). Pendapat ini menyampaikan bahwa dahulukan mengqada’ atau membayar hutang puasa ramadhan, baru melaksanakan puasa Syawal. Alasannya adalah puasa ramadhan merupakan puasa yang hukumnya wajib, sedangkan puasa Syawal hukumnya sunnah, dan kedudukan hukum wajib berada di atas kedudukan hukum sunnah. Maka jika seseorang melaksanakan perkara yang wajib akan mendapatkan pahala, dan jika meninggalkannya akan mendapat dosa. Hal ini sejalan dengan Firman Allah,</p><h3>اَيَّامًا مَّعْدُوْدٰتٍۗ فَمَنْ كَانَ مِنْكُمْ مَّرِيْضًا اَوْ عَلٰى سَفَرٍ فَعِدَّةٌ مِّنْ اَيَّامٍ اُخَرَ ۗ وَعَلَى الَّذِيْنَ يُطِيْقُوْنَهٗ فِدْيَةٌ طَعَامُ مِسْكِيْنٍۗ&nbsp; فَمَنْ تَطَوَّعَ خَيْرًا فَهُوَ خَيْرٌ لَّهٗ ۗ وَاَنْ تَصُوْمُوْا خَيْرٌ لَّكُمْ اِنْ كُنْتُمْ تَعْلَمُوْنَ&nbsp;</h3><p><i>“(Yaitu) beberapa hari tertentu. Maka barangsiapa di antara kamu sakit atau dalam perjalanan (lalu tidak berpuasa), maka (wajib mengganti) sebanyak hari (yang dia tidak berpuasa itu) pada hari-hari yang lain. Dan bagi orang yang berat menjalankannya, wajib membayar fidyah, yaitu memberi makan seorang miskin. Tetapi barangsiapa dengan kerelaan hati mengerjakan kebajikan, maka itu lebih baik baginya, dan puasamu itu lebih baik bagimu jika kamu mengetahui.”</i> (QS. Al-Baqarah: 184)</p><p>Ulama berpendapat bagi yang memiliki hutang puasa harus segera dibayar setelah Ramadhan. Karena makna surat diatas فَعِدَّةٌ adalah segera, bukan ditunda.</p><p><strong>Shaum Syawal</strong></p><p>Pendapat selanjutnya adalah dari ulama yang memiliki pendapat <i>Mutasahiliin </i>(pendapat yang agak longgar). Pendapat ini menyampaikan bahwa diperbolehkan seseorang untuk mendahulukan puasa Syawal. Dasar hukum pendapat ini sama dengan pendapat diatas yaitu dalam Al-Qur’an surat Al-Baqarah ayat&nbsp; seratus delapan puluh empat. Makna اُخَرَ dalam ayat diatas artinya adalah <i>pada hari-hari yang lain</i> yang memiliki makna tidak terbatas, atau bisa kapan pun. Bahkan Sayyidah ‘Aisyah pernah mengqada’ puasa ramadhannya di bulan Sya’ban ketika hendak memasuki bulan Ramadhan.</p><p>Maka kita diperbolehkan untuk menggunakan pendapat yang mana saja karena kedua-duanya memiliki dasar hukum yang jelas. Dan yang terpenting adalah kita mampu mempertimbangkan pilihan yang akan kita jalani karena kedua-duanya adalah baik dan memiliki prioritas masing-masing. Seperti pendapat yang pertama memiliki prioritas waktu, karena ajal tidak ada yang tahu maka lebih baik dahulukan yang wajib. Sedangkan pendapat yang kedua berpendapat boleh mendahulukan Sya’ban karena mungkin hutang puasa yang dimiliki oleh seseorang sangat banyak sehingga jika mendahulukan mengqadha khawatir tidak akan sampai waktunya melaksanakan puasa Syawal.* <strong>(Wahid)</strong></p><p><strong>*</strong><i>sumber kajian Ust. Adi Hidayat</i></p>', 'admin', '1622285711_e7a926f7845055c4e91a.jpg', 1, 366, '2021-05-29 17:55:11', '2021-06-05 19:26:52'),
(15, 1, 'metode-dakwah-yang-efektif-di-era-milenial-dan-digital', 'Metode Dakwah yang Efektif di Era Milenial dan Digital', '<p>ISTIQLAL.OR.ID, JAKARTA -- &nbsp;Di era milenial dan digital ini, terdapat sarana dan metode dalam dakwah agar lebih efektif disampaikan kepada khalayak.</p><p>Dalam mengoptimalkannya, setidaknya ada 5 kiat yang bisa kita lakukan saat berdakwah di era milenial dan digital saat ini, agar bisa mencapai keridaan Allah, diantaranya sebagai berikut.</p><p><strong>1. Optimalkan Semua Potensi dalam Berdakwah</strong></p><p>Rasulullah SAW&nbsp; bersabda: \"Sesungguhnya&nbsp; Allah mewajibkan Ihsan (sempurna) dalam segala hal.\" (HR Muslim)</p><p>Artinya dalam konteks dakwah adalah harus benar-benar menguasai konten yg akan disampaikan, jangan hanya sekedar copas (<i>copy-paste</i>) dari media tanpa pemahaman yang mendalam tentang masalah atau isu yang akan disampaikan.</p><p><strong>2. Lakukan Studi Banding dari Banyak Sumber</strong></p><p>Ibroh dari Kisah Nabi Musa AS dan Nabi Khidir AS dalam Al Gur\'an (QS. Al Kahfi/ 18 : 60-82).</p><p>Pendakwah di era digital hendaklah sering melakukan riset dari berbagai sumber, karena pendengar kita adalah majemuk, dan berasal dari berbagai latar belakang dan berbagai tingkat pendidikan yang berbeda-beda.</p><p>Dakwah yang minim riset dan berkesan kacamata kuda, akan menimbulkan berbagai reaksi yang tidak diinginkan dari pihak lain yang bersebrangan pemahamannya.</p><p>Kita tidak perlu menyenangkan semua orang karena hal itu mustahil, tapi hendaknya kita mengetahui berbagai sudut padang agar konten yang kita sampaikan bisa mewakili berbagai mustami\' (pendengar) yang berbeda latar belakang.</p><p><strong>3. Hati-hati dengan Kepentingan Kelompok atau Golongan</strong></p><p>Allah berfirman pada Qs. Al Maidah: 8, artinya sebagai berikut.</p><p>\"Hai orang-orang yang beriman hendaklah kalian menjadi orang-orang yabg selalu menegakkan (kebenaran) karena Allah &amp; menjadi saksi dengan adil. Dan janganlah sekali-kali kebencian kalian terhadap suatu kaum, mendorong kalian untuk berlaku tidak adil. Berlaku adillah, karena adil itu lebih dekat kepada takwa. Dan bertakwalah kepada Allah, sesungguhnya Allah Maha Mengetahui apa yang kalian kerjakan.\" (QS. Al Ma\'idah /5:8)</p><p>Jauhi sikap ta\'ashub (fanatik), baik dengan pemikiran, aliran, kelompok ataupun pendapat pribadi.</p><p>Selalulah ber-husnuzhan dan berusaha merangkul semua pihak, termasuk yang berbeda pandangan dengan kita. Sebab dakwah yang santun dan inklusif akan lebih diterima oleh hati nurani, dibandingkan dakwah yang eksklusif dan penuh dengan caci-maki dan fanatisme kelompok.</p><p><strong>4. Perlunya Kerja Tim (</strong><i><strong>Teamwork</strong></i><strong>)</strong></p><p>Allah berfirman pada Qs. Al Anfal: 73, artinya sebagai berikut.</p><p>\"Dan orang-orang yang kafir, sebagian mereka melindungi sebagian yang lain. Jika kamu tidak melaksanakan apa yang telah diperintahkan Allah (saling melindungi), niscaya akan terjadi kekacauan di bumi dan kerusakan yang besar.\" (QS. Al-Anfal Ayat 73).</p><p>Dalam dakwah di era digital, maka kita perlu mengoptimalkan kerja tim (<i>teamwork</i>), bukan <i>single fighter </i>atau <i>one man show</i> yang akan merepotkan dan menyulitkan kita sendiri, baik saat mencari tema, melakukan riset maupun memperkaya sumber-sumber data kita.</p><p><strong>5. Hindari Kepentingan Sesaat dalam Berdakwah</strong></p><p>Allah berfirman pada Qs. Al Baqarah: 200, artinya sebagai berikut.</p><p>\"Maka di antara manusia ada yang berdoa, \'Ya Tuhan kami, berilah kami (kebaikan) di dunia,\' dan di akhirat dia tidak memperoleh bagian apa pun.\" (Qs. Al Bagarah, 2:200)</p><p>Hal yang paling menggoda pada dakwah di era digital adalah godaan dunia.</p><p>Hal itu bisa tergambar dalam bentuk popularitas, yang sering mengakibatkan seorang Da\'i menjadi tokoh selebritis yang menghalalkan segala cara demi meningkatnya followers atau subscribernya, dibanding membawa misi Sayyidina Muhammad SAW dalam berdakwah.</p><p>Belum lagi jika jumlah penggemar sudah banyak, maka godaan jabatan pun sudah datang menunggu. Baik dari Politisi, Pejabat atau berbagai kelompok kepentingan yang merayu sang Da\'i untuk memanfaatkan followers atau subscribernya untuk kepentingan-kepentingan sesaat.</p><p>Lalu godaan keuntungan materi yg juga menanti dalam diri dengan bentuk yg lain, yaitu rayuan berupa penetapan tarif, baik oleh pribadi, maupun dengan alasan pihak manajemen.</p><p>Demikian beberapa hal yang perlu kita perhatikan dlm Dakwah di Era Milenial dan Digital ini semoga bermanfaat buat kita semua. (NF)</p>', 'admin', '1622286489_9d41d13477d4d8f8012d.jpg', 1, 47, '2021-05-29 18:08:09', '2022-07-26 14:18:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bank`
--

CREATE TABLE `tbl_bank` (
  `id_bank` int(11) NOT NULL,
  `kode_bank` varchar(35) NOT NULL,
  `nama_bank` varchar(55) NOT NULL,
  `no_rekening` varchar(25) NOT NULL,
  `cabang` varchar(35) NOT NULL,
  `nama_rekening` varchar(55) NOT NULL,
  `logo_bank` varchar(55) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_bank`
--

INSERT INTO `tbl_bank` (`id_bank`, `kode_bank`, `nama_bank`, `no_rekening`, `cabang`, `nama_rekening`, `logo_bank`, `created_at`, `updated_at`) VALUES
(1, '147', 'Bank Muamalat', '123456789', 'cabang bogor', 'yayasan al jannah', '1621407772_bfe0da839aef6645c9fc.png', '2021-05-19 12:00:45', '2021-05-19 14:02:52'),
(2, '536', 'bank BCA syariah', '987654321', 'cabang bogor', 'yayasan al jannah', '1621407889_e69d30e96128f045fc06.png', '2021-05-19 12:04:25', '2021-05-19 14:04:49'),
(4, '451', 'bank syariah indonesia', '432434234324', 'fatmawati', 'yayasan al jannah', '1621410489_446749633f27ddfb5112.png', '2021-05-19 14:48:09', '2021-05-19 15:12:45');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_budget`
--

CREATE TABLE `tbl_budget` (
  `id_budget` int(11) NOT NULL,
  `id_subkategoridonasi` int(11) NOT NULL,
  `jumlah_budget` varchar(18) NOT NULL,
  `tgl_target` date NOT NULL,
  `img_budget` varchar(55) NOT NULL,
  `proposal` varchar(60) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_budget`
--

INSERT INTO `tbl_budget` (`id_budget`, `id_subkategoridonasi`, `jumlah_budget`, `tgl_target`, `img_budget`, `proposal`, `created_at`, `updated_at`) VALUES
(7, 7, '100000000', '2021-12-31', '1621856103_9f9686de79df6df7a8bd.jpeg', '1621856103_af7d49faa7ff7b1b410d.pdf', '2021-05-24 18:35:03', '2021-05-24 18:35:03'),
(8, 8, '250000000', '2021-12-22', '1621864272_bae6abe42df1bc06ca9f.jpg', '1621864272_b7cc2193aabb7ebd6b8d.pdf', '2021-05-24 20:51:12', '2021-05-24 20:51:12'),
(9, 9, '300000000', '2022-03-15', '1621864354_c6fb4c7fd70166a3688a.jpg', '1621864354_486af4dd39c651ea4a6b.pdf', '2021-05-24 20:52:34', '2021-05-24 20:52:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_donasi`
--

CREATE TABLE `tbl_donasi` (
  `id_donasi` int(11) NOT NULL,
  `id_kategoridonasi` int(11) NOT NULL,
  `id_subkategoridonasi` int(11) NOT NULL,
  `kode_donasi` varchar(55) NOT NULL,
  `id_bank` int(11) NOT NULL,
  `jumlah_donasi` varchar(16) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_donasi`
--

INSERT INTO `tbl_donasi` (`id_donasi`, `id_kategoridonasi`, `id_subkategoridonasi`, `kode_donasi`, `id_bank`, `jumlah_donasi`, `created_at`, `updated_at`) VALUES
(25, 1, 3, '20210521154324', 4, '1000000', '2021-05-21 15:47:59', '2021-05-21 15:47:59'),
(26, 14, 7, '20210522230816', 2, '5000000', '2021-05-22 23:08:53', '2021-05-22 23:08:53'),
(27, 14, 7, '20210524190938', 1, '50000', '2021-05-24 19:10:01', '2021-05-24 19:10:01'),
(28, 14, 7, '20210524204802', 4, '1000000', '2021-05-24 20:48:34', '2021-05-24 20:48:34'),
(29, 1, 10, '20210605202349', 2, '50000', '2021-06-05 20:25:08', '2021-06-05 20:25:08'),
(30, 14, 8, '20210727195501', 4, '5000000', '2021-07-27 19:55:46', '2021-07-27 19:55:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_donatur`
--

CREATE TABLE `tbl_donatur` (
  `id_donatur` int(11) NOT NULL,
  `id_donasi` int(11) NOT NULL,
  `nama_donatur` varchar(55) NOT NULL,
  `email_donatur` varchar(55) NOT NULL,
  `hp_donatur` varchar(16) NOT NULL,
  `alamat_donatur` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_donatur`
--

INSERT INTO `tbl_donatur` (`id_donatur`, `id_donasi`, `nama_donatur`, `email_donatur`, `hp_donatur`, `alamat_donatur`, `created_at`, `updated_at`) VALUES
(22, 25, 'donny', 'doni@gmail.com', '85775284300', 'depok', '2021-05-21 15:48:00', '2021-05-21 15:48:00'),
(23, 26, 'rezza', 'rezza@gmail.com', '85775284300', 'bogor', '2021-05-22 23:08:53', '2021-05-22 23:08:53'),
(24, 27, 'fauzi', 'fauzi@gmail.com', '85775284300', 'jakarta', '2021-05-24 19:10:01', '2021-05-24 19:10:01'),
(25, 28, 'boy', 'boy@gmail.com', '8997403156', 'jakarta utara', '2021-05-24 20:48:34', '2021-05-24 20:48:34'),
(26, 29, 'mya', 'a@gmail.com', '8997403156', 'bebas', '2021-06-05 20:25:08', '2021-06-05 20:25:08'),
(27, 30, 'rahasia', 'r@gmail.com', '81234567890', 'rahasia', '2021-07-27 19:55:46', '2021-07-27 19:55:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kajian`
--

CREATE TABLE `tbl_kajian` (
  `id_kajian` int(11) NOT NULL,
  `id_kategoriartikel` int(11) NOT NULL,
  `tema_kajian` varchar(55) NOT NULL,
  `slug_kajian` varchar(60) NOT NULL,
  `tgl_kajian` datetime NOT NULL,
  `pengisi_kajian` varchar(55) NOT NULL,
  `img_kajian` varchar(55) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_kajian`
--

INSERT INTO `tbl_kajian` (`id_kajian`, `id_kategoriartikel`, `tema_kajian`, `slug_kajian`, `tgl_kajian`, `pengisi_kajian`, `img_kajian`, `created_at`, `updated_at`) VALUES
(1, 1, 'tafakur alam', 'tafakur-alam', '2021-05-08 00:00:00', 'kita sendiri', '1620193582_6177976ce5625983525a.jpg', '2021-05-05 00:46:22', '2021-05-05 00:59:43'),
(3, 1, 'peta perjalanan', 'peta-perjalanan', '2021-05-29 00:00:00', 'ustadz nain dzulkarnain', '1620527456_9ab9aca1ef296ed73137.jpg', '2021-05-09 09:30:56', '2021-05-09 09:30:56'),
(4, 1, 'meneladani perjuangan para pahlawan di dalam islam', 'meneladani-perjuangan-para-pahlawan-di-dalam-islam', '2021-06-10 00:00:00', 'ustadz adi hidayat, Lc, MA', '1620527504_ff1d732325c2a26cce79.jpg', '2021-05-09 09:31:44', '2021-05-09 09:31:44'),
(5, 2, 'aqidah pondasi utama dalam beragama', 'aqidah-pondasi-utama-dalam-beragama', '2021-06-08 00:00:00', 'ust. H. Arief Nashirudding, S. Ag', '1620527631_002a6554872ead77a165.jpg', '2021-05-09 09:33:51', '2021-05-09 09:33:51'),
(6, 3, '5 jurus mahir membaca kitab gundul metode syamil', '5-jurus-mahir-membaca-kitab-gundul-metode-syamil', '2021-07-07 00:00:00', 'ust. lukman abdillah, s. pd. i', '1620527744_87aea14b0ae5b2906426.jpg', '2021-05-09 09:35:44', '2021-05-09 09:36:39');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kategoriartikel`
--

CREATE TABLE `tbl_kategoriartikel` (
  `id_kategoriartikel` int(11) NOT NULL,
  `slug_kategoriartikel` varchar(55) NOT NULL,
  `nama_kategoriartikel` varchar(35) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_kategoriartikel`
--

INSERT INTO `tbl_kategoriartikel` (`id_kategoriartikel`, `slug_kategoriartikel`, `nama_kategoriartikel`, `created_at`, `updated_at`) VALUES
(1, 'umum', 'umum', '2021-04-24 02:38:27', '2021-04-24 02:38:27'),
(2, 'fiqih', 'fiqih', '2021-04-24 02:38:38', '2021-04-24 02:38:38'),
(3, 'tafsir', 'tafsir', '2021-04-24 02:38:54', '2021-04-24 02:38:54'),
(5, 'berita', 'berita', '2021-05-10 14:19:00', '2021-05-10 14:19:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kategoridonasi`
--

CREATE TABLE `tbl_kategoridonasi` (
  `id_kategoridonasi` int(11) NOT NULL,
  `nama_kategoridonasi` varchar(35) NOT NULL,
  `slug_kategoridonasi` varchar(55) NOT NULL,
  `jenis_kategoridonasi` int(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_kategoridonasi`
--

INSERT INTO `tbl_kategoridonasi` (`id_kategoridonasi`, `nama_kategoridonasi`, `slug_kategoridonasi`, `jenis_kategoridonasi`, `created_at`, `updated_at`) VALUES
(1, 'infaq / sedekah', 'infaq-sedekah', 1, '2021-04-18 03:35:21', '2021-05-20 17:20:19'),
(2, 'zakat', 'zakat', 1, '2021-04-18 03:35:41', '2021-05-20 17:20:26'),
(13, 'kotak amal', 'kotak-amal', 0, '2021-04-28 05:06:32', '2021-05-20 16:26:55'),
(14, 'wakaf', 'wakaf', 1, '2021-04-29 09:03:01', '2021-05-20 17:19:24');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kategorikeluar`
--

CREATE TABLE `tbl_kategorikeluar` (
  `id_kategorikeluar` int(11) NOT NULL,
  `slug_kategorikeluar` varchar(55) NOT NULL,
  `nama_kategorikeluar` varchar(55) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_kategorikeluar`
--

INSERT INTO `tbl_kategorikeluar` (`id_kategorikeluar`, `slug_kategorikeluar`, `nama_kategorikeluar`, `created_at`, `updated_at`) VALUES
(1, 'biaya-operasional', 'biaya operasional', '2021-05-02 00:15:15', '2021-05-02 00:15:15'),
(2, 'biaya-renovasi', 'biaya renovasi', '2021-05-02 00:20:18', '2021-05-02 00:28:00'),
(3, 'biaya-perawatan', 'biaya perawatan', '2021-05-02 00:24:51', '2021-05-02 00:24:51');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_komentar`
--

CREATE TABLE `tbl_komentar` (
  `id_komentar` int(11) NOT NULL,
  `id_artikel` int(11) NOT NULL,
  `nama` varchar(55) NOT NULL,
  `email` varchar(55) NOT NULL,
  `komentar` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_komentar`
--

INSERT INTO `tbl_komentar` (`id_komentar`, `id_artikel`, `nama`, `email`, `komentar`, `created_at`, `updated_at`) VALUES
(3, 13, 'donny', 'donny@gmail.com', 'sangat bermanfaat', '2021-05-30 20:56:17', '2021-05-30 20:56:17'),
(4, 13, 'rezza', 'rezza@gmail.com', 'artikel yang bermanfaat', '2021-05-30 20:57:48', '2021-05-30 20:57:48'),
(5, 13, 'fauzi', 'fauzi@gmail.com', 'kereeen bangeettt', '2021-05-30 21:59:04', '2021-05-30 21:59:04'),
(6, 13, 'alih', 'alih@gmail.com', 'baguussssss', '2021-05-30 22:00:09', '2021-05-30 22:00:09'),
(12, 15, 'mya', 'mya@gmail.com', 'komentari foto ust. felix siaw', '2021-06-05 18:47:58', '2021-06-05 18:47:58'),
(13, 15, 'azmy', 'azmy@gmail.com', 'ksfjkasdjfk;adsjkfajs', '2021-06-05 18:48:14', '2021-06-05 18:48:14'),
(14, 12, 'azzam', 'azzam@gmail.com', 'first dapet apa nih', '2021-07-27 20:46:26', '2021-07-27 20:46:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_konfirmasidonasi`
--

CREATE TABLE `tbl_konfirmasidonasi` (
  `id_konfirmasidonasi` int(11) NOT NULL,
  `id_donasi` int(11) NOT NULL,
  `id_donatur` int(11) NOT NULL,
  `tgl_donasi` date NOT NULL,
  `bukti_donasi` varchar(55) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_konfirmasidonasi`
--

INSERT INTO `tbl_konfirmasidonasi` (`id_konfirmasidonasi`, `id_donasi`, `id_donatur`, `tgl_donasi`, `bukti_donasi`, `created_at`, `updated_at`) VALUES
(20, 25, 22, '2021-05-22', '1621697951_b43d3fcf34e077bb4be4.jpg', '2021-05-21 15:48:00', '2021-05-22 22:39:11'),
(21, 26, 23, '0000-00-00', '', '2021-05-22 23:08:53', '2021-05-22 23:08:53'),
(22, 27, 24, '2021-05-24', '1621863766_b629c45e51f7fe8c4df8.jpg', '2021-05-24 19:10:01', '2021-05-24 20:42:46'),
(23, 28, 25, '2021-05-24', '1621864164_c1e51d7163269b163fb3.jpg', '2021-05-24 20:48:34', '2021-05-24 20:49:24'),
(24, 29, 26, '0000-00-00', '', '2021-06-05 20:25:08', '2021-06-05 20:25:08'),
(25, 30, 27, '2021-07-27', '1627390690_98830ab4a66c38f11fbb.jpg', '2021-07-27 19:55:46', '2021-07-27 19:58:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_materi`
--

CREATE TABLE `tbl_materi` (
  `id_materi` int(11) NOT NULL,
  `judul_materi` varchar(55) NOT NULL,
  `slug_materi` varchar(60) NOT NULL,
  `hits` int(11) NOT NULL,
  `pemateri` varchar(35) NOT NULL,
  `file_materi` varchar(60) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_materi`
--

INSERT INTO `tbl_materi` (`id_materi`, `judul_materi`, `slug_materi`, `hits`, `pemateri`, `file_materi`, `created_at`, `updated_at`) VALUES
(3, 'belajar materi', 'belajar-materi', 11, 'saya sendiri', '1620467651_50c046092a9371534b24.pdf', '2021-05-08 16:54:11', '2021-05-16 00:10:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengeluaran`
--

CREATE TABLE `tbl_pengeluaran` (
  `id_pengeluaran` int(11) NOT NULL,
  `id_kategorikeluar` int(11) NOT NULL,
  `id_subkategorikeluar` int(11) NOT NULL,
  `jumlah_keluar` varchar(16) NOT NULL,
  `tgl_keluar` date NOT NULL,
  `bukti_keluar` varchar(55) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pesan`
--

CREATE TABLE `tbl_pesan` (
  `id_pesan` int(11) NOT NULL,
  `nama` varchar(55) NOT NULL,
  `email` varchar(55) NOT NULL,
  `subject` varchar(55) NOT NULL,
  `pesan` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_pesan`
--

INSERT INTO `tbl_pesan` (`id_pesan`, `nama`, `email`, `subject`, `pesan`, `created_at`, `updated_at`) VALUES
(3, 'azzam', 'admin@example.com', 'keritik saran', 'fdfdsfdadfdsfds dfdsfjdafda;f af;djakjdfkajfkas fadsjfklajdsk', '2021-05-12 11:48:37', '2021-05-12 11:48:37'),
(4, 'donny', 'admin@admin.com', 'keritik saran', 'dfsadfafasfa', '2021-05-12 11:49:22', '2021-05-12 11:49:22'),
(5, 'fadsfa', 'admin@baitijannaty.id', 'fdada', 'dfadsfada', '2021-05-12 11:50:44', '2021-05-12 11:50:44'),
(6, 'nama siswa', 'admin@example.com', 'keritik saran', 'fsdfafdafafa', '2021-05-12 12:20:20', '2021-05-12 12:20:20'),
(7, 'fdafsafas', 'admin@admin.com', 'dfadsfasdfas', 'dfadsfadfasdfs f dsfdasfdafd s', '2021-05-12 12:27:41', '2021-05-12 12:27:41'),
(8, 'fafdads', 'admin@example.com', 'dfasa', 'dfadfaafdas', '2021-05-12 12:42:41', '2021-05-12 12:42:41'),
(9, 'donny', 'donny@gmail.com', 'pesan', 'semakin bagus aja nih', '2021-05-30 20:47:29', '2021-05-30 20:47:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reply`
--

CREATE TABLE `tbl_reply` (
  `id_reply` int(11) NOT NULL,
  `id_komentar` int(11) NOT NULL,
  `nama` varchar(55) NOT NULL,
  `email` varchar(55) NOT NULL,
  `komentar` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_reply`
--

INSERT INTO `tbl_reply` (`id_reply`, `id_komentar`, `nama`, `email`, `komentar`, `created_at`, `updated_at`) VALUES
(3, 3, 'siti', 'siti@gmail.com', 'ini cuma membalas komentar donny', '2021-05-30 23:05:23', '2021-05-30 23:05:23'),
(4, 3, 'azzam', 'azzam@gmail.com', 'ini bales donny lagi', '2021-05-31 00:01:38', '2021-05-31 00:01:38'),
(5, 6, 'donny', 'donny@gmail.com', 'ini bales alih', '2021-05-31 00:09:17', '2021-05-31 00:09:17'),
(6, 12, 'biya', 'biya@gmail.com', 'ini bales komentar mya', '2021-06-05 19:26:31', '2021-06-05 19:26:31'),
(7, 14, 'admin', 'admin@admin.com', 'dapet pertamax', '2021-07-27 20:46:52', '2021-07-27 20:46:52'),
(8, 14, 'azzam', 'azzam@gmail.com', 'lumayan hehehe', '2021-07-27 20:47:23', '2021-07-27 20:47:23'),
(9, 13, 'mya', 'mya@mya.com', 'ini membalas komentar azmy', '2022-07-26 14:01:29', '2022-07-26 14:01:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setting`
--

CREATE TABLE `tbl_setting` (
  `id_setting` int(11) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `about_me` text NOT NULL,
  `address` varchar(255) NOT NULL,
  `maps` text NOT NULL,
  `email` varchar(55) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `icon` varchar(55) NOT NULL,
  `images` varchar(55) NOT NULL,
  `visi` text NOT NULL,
  `misi` text NOT NULL,
  `fb` varchar(25) NOT NULL,
  `ig` varchar(25) NOT NULL,
  `tw` varchar(25) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_setting`
--

INSERT INTO `tbl_setting` (`id_setting`, `nama`, `about_me`, `address`, `maps`, `email`, `phone`, `icon`, `images`, `visi`, `misi`, `fb`, `ig`, `tw`, `created_at`, `updated_at`) VALUES
(1, 'al jannah', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 'perumahan baitijannaty kemang bogor', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d991.0686815573803!2d106.7292256651999!3d-6.486852875755845!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c34638ef13ab%3A0x8f125cf2f1bd4c60!2sPerumahan%20baiti%20Jannaty%202%20Kemang%20parung!5e0!3m2!1sid!2sid!4v1622296856977!5m2!1sid!2sid\" width=\"100%\" height=\"450\" style=\"border:0;\" allowfullscreen=\"true\" loading=\"lazy\"></iframe>', 'admin@aljannah.id', '8997403156', '1619526793_fee40b616b94d1075400.png', '1619526793_1bfdc70e029f7dfdb73b.jpg', '<p>Terwujudnya lembaga pemberdayaan umat yang menyuarakan moderasi Islam yang berwawasan&nbsp; ke-indonesia-an dan global</p>', '<ol><li>Meningkatkan kualitas pelayanan Ibadah yang sesuai syariah berhaluan ahlus sunah wal jama’ah</li><li>Meningkatkan sumber daya umat melalui pendidikan dan pelatihan yang berbasis ke-Indonesiaan dan global</li><li>Menerapkan pengelolaan masjid yang modern dan wawasan lingkungan</li><li>Meningkatkan kesejahteraan masyarakat dan menumbuhkan kepedulian sosial</li><li>Menyelenggarakan manajemen masjid yang modern, akuntabel, amanah, dan Profesional (MANTAP).</li></ol>', 'musholla_aljannah', 'musholla_aljannah', 'musholla_aljannah', '2021-04-27 07:33:13', '2021-06-12 23:17:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subkategoridonasi`
--

CREATE TABLE `tbl_subkategoridonasi` (
  `id_subkategoridonasi` int(11) NOT NULL,
  `id_kategoridonasi` int(11) NOT NULL,
  `nama_subkategoridonasi` varchar(55) NOT NULL,
  `slug_subkategoridonasi` varchar(55) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_subkategoridonasi`
--

INSERT INTO `tbl_subkategoridonasi` (`id_subkategoridonasi`, `id_kategoridonasi`, `nama_subkategoridonasi`, `slug_subkategoridonasi`, `created_at`, `updated_at`) VALUES
(1, 2, 'zakat fitrah', 'zakat-fitrah', '2021-04-29 08:47:54', '2021-04-29 08:47:54'),
(2, 2, 'zakat maal', 'zakat-maal', '2021-04-29 08:49:07', '2021-04-29 08:49:07'),
(3, 1, 'berbagi buka puasa', 'berbagi-buka-puasa', '2021-04-29 09:00:27', '2021-04-29 09:00:27'),
(4, 13, 'kotak amal jumat', 'kotak-amal-jumat', '2021-04-29 09:00:43', '2021-04-29 09:00:43'),
(5, 13, 'kotak amal utama', 'kotak-amal-utama', '2021-04-29 09:01:11', '2021-04-29 09:01:11'),
(6, 1, 'keluarga tangguh', 'keluarga-tangguh', '2021-04-29 09:01:57', '2021-04-29 09:01:57'),
(7, 14, 'perluasan lahan masjid', 'perluasan-lahan-masjid', '2021-04-29 09:06:13', '2021-04-29 09:06:13'),
(8, 14, 'kendaraan dakwah', 'kendaraan-dakwah', '2021-04-29 09:06:56', '2021-04-29 09:06:56'),
(9, 14, 'mobil ambulance', 'mobil-ambulance', '2021-04-29 09:07:08', '2021-04-29 09:07:08'),
(10, 1, 'donasi aja', 'donasi-aja', '2021-05-02 01:19:53', '2021-05-02 01:21:36');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subkategorikeluar`
--

CREATE TABLE `tbl_subkategorikeluar` (
  `id_subkategorikeluar` int(11) NOT NULL,
  `id_kategorikeluar` int(11) NOT NULL,
  `nama_subkategorikeluar` varchar(55) NOT NULL,
  `slug_subkategorikeluar` varchar(55) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_subkategorikeluar`
--

INSERT INTO `tbl_subkategorikeluar` (`id_subkategorikeluar`, `id_kategorikeluar`, `nama_subkategorikeluar`, `slug_subkategorikeluar`, `created_at`, `updated_at`) VALUES
(1, 1, 'gaji marbot', 'gaji-marbot', '2021-05-02 00:37:20', '2021-05-02 00:59:03'),
(2, 2, 'tempat wudhu', 'tempat-wudhu', '2021-05-02 00:37:51', '2021-05-02 00:59:17'),
(3, 3, 'karpet sajadah', 'karpet-sajadah', '2021-05-02 00:56:17', '2021-05-02 00:59:49');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(35) NOT NULL,
  `username` varchar(35) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level_user` varchar(15) NOT NULL,
  `status_user` int(1) NOT NULL,
  `picture` varchar(55) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `nama_user`, `username`, `password`, `level_user`, `status_user`, `picture`, `created_at`, `updated_at`) VALUES
(1, 'donny rezza', 'admin@admin.com', '$2y$10$TKJD5aqIUo5l9GMABNVdWuqGNHX1DpTw8/bMEF3uQ6e44/GsGexWu', 'administrator', 1, '1623507932_947060c82f3fc185b04d.svg', '2021-04-09 16:10:36', '2021-06-12 21:25:32'),
(4, 'donny rezza', 'user@user.com', '$2y$10$5tsjfSdSmjAf0.cYHY3QFeCA.EIC8q4czRVnkAwwUd7EviR8wFJ9e', 'user', 0, '1619540156_a3c404ea87b7b1036847.jpg', '2021-04-24 02:09:18', '2021-04-27 11:15:56'),
(6, 'user', 'user@admin.com', '$2y$10$YrZoeZFLqBxNwv6n7EqqQugRkeG8dGnNddY0fr2xWXsIfBgHVGZL6', 'user', 1, 'default.jpg', '2021-10-08 11:06:59', '2021-10-08 11:08:02');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_video`
--

CREATE TABLE `tbl_video` (
  `id_video` int(11) NOT NULL,
  `id_kategoriartikel` int(11) NOT NULL,
  `judul_video` varchar(55) NOT NULL,
  `slug_video` varchar(60) NOT NULL,
  `hits` int(11) NOT NULL,
  `link_video` varchar(25) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_video`
--

INSERT INTO `tbl_video` (`id_video`, `id_kategoriartikel`, `judul_video`, `slug_video`, `hits`, `link_video`, `created_at`, `updated_at`) VALUES
(3, 2, 'orang-orang yang dikabulkan do\'a nya', 'orang-orang-yang-dikabulkan-doa-nya', 0, 'YzV3GBb_1IM', '2021-05-15 17:41:08', '2021-05-15 17:41:08'),
(4, 1, 'antara sholat dan pertolongan allah', 'antara-sholat-dan-pertolongan-allah', 0, 'r_dItIKV_So', '2021-05-15 17:41:47', '2021-05-15 17:41:47'),
(5, 5, 'obat segala penyakit (as syifa)', 'obat-segala-penyakit-as-syifa', 0, '8K70aTXJzPQ', '2021-05-15 17:43:03', '2021-05-15 17:43:03'),
(6, 1, 'dahsyatnya ramadhan', 'dahsyatnya-ramadhan', 0, '3j0fdWnLwc4', '2021-05-15 17:53:48', '2021-05-15 17:53:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_artikel`
--
ALTER TABLE `tbl_artikel`
  ADD PRIMARY KEY (`id_artikel`);

--
-- Indexes for table `tbl_bank`
--
ALTER TABLE `tbl_bank`
  ADD PRIMARY KEY (`id_bank`);

--
-- Indexes for table `tbl_budget`
--
ALTER TABLE `tbl_budget`
  ADD PRIMARY KEY (`id_budget`);

--
-- Indexes for table `tbl_donasi`
--
ALTER TABLE `tbl_donasi`
  ADD PRIMARY KEY (`id_donasi`),
  ADD KEY `id_kategoridonasi` (`id_kategoridonasi`),
  ADD KEY `id_subkategoridonasi` (`id_subkategoridonasi`);

--
-- Indexes for table `tbl_donatur`
--
ALTER TABLE `tbl_donatur`
  ADD PRIMARY KEY (`id_donatur`),
  ADD KEY `id_donasi` (`id_donasi`);

--
-- Indexes for table `tbl_kajian`
--
ALTER TABLE `tbl_kajian`
  ADD PRIMARY KEY (`id_kajian`);

--
-- Indexes for table `tbl_kategoriartikel`
--
ALTER TABLE `tbl_kategoriartikel`
  ADD PRIMARY KEY (`id_kategoriartikel`);

--
-- Indexes for table `tbl_kategoridonasi`
--
ALTER TABLE `tbl_kategoridonasi`
  ADD PRIMARY KEY (`id_kategoridonasi`);

--
-- Indexes for table `tbl_kategorikeluar`
--
ALTER TABLE `tbl_kategorikeluar`
  ADD PRIMARY KEY (`id_kategorikeluar`);

--
-- Indexes for table `tbl_komentar`
--
ALTER TABLE `tbl_komentar`
  ADD PRIMARY KEY (`id_komentar`);

--
-- Indexes for table `tbl_konfirmasidonasi`
--
ALTER TABLE `tbl_konfirmasidonasi`
  ADD PRIMARY KEY (`id_konfirmasidonasi`),
  ADD KEY `id_donasi` (`id_donasi`);

--
-- Indexes for table `tbl_materi`
--
ALTER TABLE `tbl_materi`
  ADD PRIMARY KEY (`id_materi`);

--
-- Indexes for table `tbl_pengeluaran`
--
ALTER TABLE `tbl_pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`);

--
-- Indexes for table `tbl_pesan`
--
ALTER TABLE `tbl_pesan`
  ADD PRIMARY KEY (`id_pesan`);

--
-- Indexes for table `tbl_reply`
--
ALTER TABLE `tbl_reply`
  ADD PRIMARY KEY (`id_reply`);

--
-- Indexes for table `tbl_setting`
--
ALTER TABLE `tbl_setting`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indexes for table `tbl_subkategoridonasi`
--
ALTER TABLE `tbl_subkategoridonasi`
  ADD PRIMARY KEY (`id_subkategoridonasi`);

--
-- Indexes for table `tbl_subkategorikeluar`
--
ALTER TABLE `tbl_subkategorikeluar`
  ADD PRIMARY KEY (`id_subkategorikeluar`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `tbl_video`
--
ALTER TABLE `tbl_video`
  ADD PRIMARY KEY (`id_video`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_artikel`
--
ALTER TABLE `tbl_artikel`
  MODIFY `id_artikel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_bank`
--
ALTER TABLE `tbl_bank`
  MODIFY `id_bank` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_budget`
--
ALTER TABLE `tbl_budget`
  MODIFY `id_budget` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_donasi`
--
ALTER TABLE `tbl_donasi`
  MODIFY `id_donasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_donatur`
--
ALTER TABLE `tbl_donatur`
  MODIFY `id_donatur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_kajian`
--
ALTER TABLE `tbl_kajian`
  MODIFY `id_kajian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_kategoriartikel`
--
ALTER TABLE `tbl_kategoriartikel`
  MODIFY `id_kategoriartikel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_kategoridonasi`
--
ALTER TABLE `tbl_kategoridonasi`
  MODIFY `id_kategoridonasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_kategorikeluar`
--
ALTER TABLE `tbl_kategorikeluar`
  MODIFY `id_kategorikeluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_komentar`
--
ALTER TABLE `tbl_komentar`
  MODIFY `id_komentar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_konfirmasidonasi`
--
ALTER TABLE `tbl_konfirmasidonasi`
  MODIFY `id_konfirmasidonasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_materi`
--
ALTER TABLE `tbl_materi`
  MODIFY `id_materi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_pengeluaran`
--
ALTER TABLE `tbl_pengeluaran`
  MODIFY `id_pengeluaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_pesan`
--
ALTER TABLE `tbl_pesan`
  MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_reply`
--
ALTER TABLE `tbl_reply`
  MODIFY `id_reply` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_setting`
--
ALTER TABLE `tbl_setting`
  MODIFY `id_setting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_subkategoridonasi`
--
ALTER TABLE `tbl_subkategoridonasi`
  MODIFY `id_subkategoridonasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_subkategorikeluar`
--
ALTER TABLE `tbl_subkategorikeluar`
  MODIFY `id_subkategorikeluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_video`
--
ALTER TABLE `tbl_video`
  MODIFY `id_video` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_donatur`
--
ALTER TABLE `tbl_donatur`
  ADD CONSTRAINT `tbl_donatur_ibfk_1` FOREIGN KEY (`id_donasi`) REFERENCES `tbl_donasi` (`id_donasi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_konfirmasidonasi`
--
ALTER TABLE `tbl_konfirmasidonasi`
  ADD CONSTRAINT `tbl_konfirmasidonasi_ibfk_1` FOREIGN KEY (`id_donasi`) REFERENCES `tbl_donasi` (`id_donasi`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
