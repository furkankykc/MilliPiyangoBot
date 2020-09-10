CREATE TABLE `loto_data` (
  `id` int(11) NOT NULL,
  `result` text NOT NULL,
  `type` varchar(1) NOT NULL COMMENT 'Milli Piyango, Sayısal Loto, Şans Topu, On Numara, Süper Loto: 1,2,3,4,5',
  `date` date NOT NULL,
  `created` datetime NOT NULL,
  `state` tinyint(4) NOT NULL DEFAULT 1,
  `hits` int(7) NOT NULL DEFAULT 0,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 ROW_FORMAT = COMPACT;
INSERT INTO `loto_data` (
    `id`,
    `result`,
    `type`,
    `date`,
    `created`,
    `state`,
    `hits`,
    `title`,
    `alias`
  )
VALUES (
    3658,
    '{\"success\":true,\"data\":{\"oid\":\"3zhhtxjp5riqu400\",\"hafta\":1171,\"buyukIkramiyeKazananIl\":\"\",\"cekilisTarihi\":\"01/12/2018\",\"cekilisTuru\":\"SAYISAL_LOTO\",\"rakamlar\":\"17#32#20#47#06#31\",\"rakamlarNumaraSirasi\":\"06 - 17 - 20 - 31 - 32 - 47\",\"devretti\":true,\"devirSayisi\":2,\"bilenKisiler\":[{\"oid\":\"3zxhzgjp5riqu003\",\"kisiBasinaDusenIkramiye\":11.15,\"kisiSayisi\":136470,\"tur\":\"$3_BILEN\"},{\"oid\":\"3zxhzgjp5riqu002\",\"kisiBasinaDusenIkramiye\":75.95,\"kisiSayisi\":7133,\"tur\":\"$4_BILEN\"},{\"oid\":\"3zxhzgjp5riqu001\",\"kisiBasinaDusenIkramiye\":4850.45,\"kisiSayisi\":148,\"tur\":\"$5_BILEN\"},{\"oid\":\"3zxhzgjp5riqu000\",\"kisiBasinaDusenIkramiye\":2621741.0300000003,\"kisiSayisi\":0,\"tur\":\"$6_BILEN\"}],\"buyukIkrKazananIlIlceler\":[],\"kibrisHasilati\":50317.5,\"devirTutari\":917091.3,\"kolonSayisi\":7835994,\"kdv\":1785306.13,\"toplamHasilat\":1.1753991E7,\"hasilat\":9968684.87,\"sov\":996868.49,\"ikramiyeEH\":8971816.379999999,\"buyukIkramiye\":1704645.11,\"haftayaDevredenTutar\":2621741.03}}',
    '2',
    '2018-12-01',
    '2018-12-01 21:35:01',
    1,
    103,
    '2018-12-01',
    'sayisal-loto-sayisal-loto-2018-12-01'
  ),
  (
    3647,
    '{\"cekilisAdi\":\"19/11/2018 BİLET KONTROL ŞUBE MÜDÜRLÜĞÜ\",\"cekilisTarihi\":\"20181119\",\"haneSayisi\":6,\"sonuclar\":[{\"haneSayisi\":6,\"tip\":\"$6_RAKAM\",\"ikramiye\":2500000,\"numaralar\":[\"121220\"]},{\"haneSayisi\":6,\"tip\":\"$6_RAKAM\",\"ikramiye\":200000,\"numaralar\":[\"146966\"]},{\"haneSayisi\":6,\"tip\":\"$6_RAKAM\",\"ikramiye\":20000,\"numaralar\":[\"495334\"]},{\"haneSayisi\":6,\"tip\":\"$6_RAKAM\",\"ikramiye\":10000,\"numaralar\":[\"424831\",\"184038\"]},{\"haneSayisi\":6,\"tip\":\"$6_RAKAM\",\"ikramiye\":5000,\"numaralar\":[\"135409\",\"451609\",\"258089\"]},{\"haneSayisi\":5,\"tip\":\"SON_BES_RAKAM\",\"ikramiye\":400,\"numaralar\":[\"42806\",\"85241\",\"96845\",\"15933\",\"91595\",\"06123\",\"05787\",\"29668\",\"44286\",\"60907\"]},{\"haneSayisi\":4,\"tip\":\"SON_DORT_RAKAM\",\"ikramiye\":200,\"numaralar\":[\"8551\",\"0296\",\"7619\",\"0321\",\"8775\",\"8975\",\"0505\",\"6296\",\"6794\",\"6394\"]},{\"haneSayisi\":3,\"tip\":\"SON_UC_RAKAM\",\"ikramiye\":100,\"numaralar\":[\"032\",\"579\",\"363\",\"163\",\"213\",\"605\",\"167\",\"222\",\"397\",\"894\"]},{\"haneSayisi\":2,\"tip\":\"SON_IKI_RAKAM\",\"ikramiye\":48,\"numaralar\":[\"07\",\"24\",\"37\",\"63\",\"54\",\"57\",\"51\",\"46\"]},{\"haneSayisi\":1,\"tip\":\"AMORTI\",\"ikramiye\":24,\"numaralar\":[\"0\",\"5\"]},{\"haneSayisi\":0,\"tip\":\"TESELLI\",\"ikramiye\":2500,\"numaralar\":[\"121320\",\"121221\",\"121290\",\"121120\",\"124220\",\"121280\",\"101220\",\"121720\",\"121820\",\"171220\",\"021220\",\"121620\",\"121210\",\"121225\",\"121420\",\"191220\",\"121240\",\"125220\",\"120220\",\"121920\",\"421220\",\"321220\",\"141220\",\"123220\",\"121260\",\"121226\",\"181220\",\"129220\",\"121270\",\"121229\",\"127220\",\"111220\",\"121250\",\"121200\",\"126220\",\"122220\",\"221220\",\"121224\",\"121230\",\"131220\",\"121222\",\"121223\",\"121020\",\"121520\",\"121227\",\"128220\",\"121228\",\"161220\",\"151220\"]}],\"buyukIkrKazananIlIlceler\":[{\"il\":\"106\",\"ilView\":\"SAYISAL SİSTEM (ANKARA)\",\"ilce\":\"106\",\"ilceView\":\" \"}]}',
    '1',
    '2018-11-19',
    '2018-11-19 22:00:00',
    1,
    144,
    '2018-11-19',
    'milli-piyango-2018-11-19'
  ),
  (
    3645,
    '{\"success\":true,\"data\":{\"oid\":\"3z3f7ijoiwge4300\",\"hafta\":578,\"buyukIkramiyeKazananIl\":\"\",\"cekilisTarihi\":\"15/11/2018\",\"cekilisTuru\":\"SUPER_LOTO\",\"rakamlar\":\"48#37#34#31#39#50\",\"rakamlarNumaraSirasi\":\"31 - 34 - 37 - 39 - 48 - 50\",\"devretti\":false,\"devirSayisi\":0,\"bilenKisiler\":[{\"oid\":\"3zu6q4joiwge3y03\",\"kisiBasinaDusenIkramiye\":17.25,\"kisiSayisi\":63885,\"tur\":\"$3_BILEN\"},{\"oid\":\"3zu6q4joiwge3y02\",\"kisiBasinaDusenIkramiye\":218.2,\"kisiSayisi\":2926,\"tur\":\"$4_BILEN\"},{\"oid\":\"3zu6q4joiwge3y01\",\"kisiBasinaDusenIkramiye\":10429.15,\"kisiSayisi\":57,\"tur\":\"$5_BILEN\"},{\"oid\":\"3zu6q4joiwge3y00\",\"kisiBasinaDusenIkramiye\":5381907.55,\"kisiSayisi\":1,\"tur\":\"$6_BILEN\"}],\"buyukIkrKazananIlIlceler\":[{\"il\":\"34\",\"ilView\":\"İSTANBUL\",\"ilce\":\"03427\",\"ilceView\":\"BAĞCILAR\"}],\"kibrisHasilati\":48384,\"devirTutari\":3471507.64,\"kolonSayisi\":5561746,\"kdv\":1689423.25,\"toplamHasilat\":1.1123492E7,\"hasilat\":9434068.75,\"sov\":943406.88,\"ikramiyeEH\":8490661.87,\"buyukIkramiye\":1910398.92,\"haftayaDevredenTutar\":0.02}}',
    '5',
    '2018-11-15',
    '2018-11-15 22:11:18',
    1,
    148,
    '2018-11-15',
    'super-loto-2018-11-15'
  );