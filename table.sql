CREATE TABLE `data_dtks` (
    `id` int(11) NOT NULL auto_increment,
    `provinsi` TEXT DEFAULT NULL,
    `kabupaten` TEXT DEFAULT NULL,
    `kecamatan` TEXT DEFAULT NULL,
    `desa_kelurahan` TEXT DEFAULT NULL,
    `prop_capil` VARCHAR(30) DEFAULT NULL,
    `kab_capil` VARCHAR(30) DEFAULT NULL,
    `id_kec` VARCHAR(30) DEFAULT NULL,
    `id_desa` VARCHAR(30) DEFAULT NULL,
    `ATENSI` TEXT DEFAULT NULL,
    `Alamat` TEXT DEFAULT NULL,
    `BLT` TEXT DEFAULT NULL,
    `BLT_BBM` TEXT DEFAULT NULL,
    `BNPT_PPKM` TEXT DEFAULT NULL,
    `BPNT` TEXT DEFAULT NULL,
    `BST` TEXT DEFAULT NULL,
    `FIRST_SK` TEXT DEFAULT NULL,
    `NIK` TEXT DEFAULT NULL,
    `NOKK` TEXT DEFAULT NULL,
    `Nama` TEXT DEFAULT NULL,
    `PBI` TEXT DEFAULT NULL,
    `PENA` TEXT DEFAULT NULL,
    `PERMAKANAN` TEXT DEFAULT NULL,
    `PKH` TEXT DEFAULT NULL,
    `RUTILAHU` TEXT DEFAULT NULL,
    `SEMBAKO_ADAPTIF` TEXT DEFAULT NULL,
    `YAPI` TEXT DEFAULT NULL,
    `aktorLabel` TEXT DEFAULT NULL,
    `checkBtnHamil` TEXT DEFAULT NULL,
    `checkBtnVerifMeninggal` TEXT DEFAULT NULL,
    `counter` TEXT DEFAULT NULL,
    `deleted_label` TEXT DEFAULT NULL,
    `idsemesta` TEXT DEFAULT NULL,
    `isAktifHamil` TEXT DEFAULT NULL,
    `is_btn_dapodik` TEXT DEFAULT NULL,
    `is_btn_hidupkan` TEXT DEFAULT NULL,
    `is_btn_padankan` TEXT DEFAULT NULL,
    `is_nonaktif` TEXT DEFAULT NULL,
    `keterangan_disabilitas` TEXT DEFAULT NULL,
    `keterangan_meninggal` TEXT DEFAULT NULL,
    `masih_hidup_label` TEXT DEFAULT NULL,
    `padankan_at` TEXT DEFAULT NULL,
    `periode_blt` TEXT DEFAULT NULL,
    `periode_blt_bbm` TEXT DEFAULT NULL,
    `periode_bpnt` TEXT DEFAULT NULL,
    `periode_bpnt_ppkm` TEXT DEFAULT NULL,
    `periode_bst` TEXT DEFAULT NULL,
    `periode_pbi` TEXT DEFAULT NULL,
    `periode_pena` TEXT DEFAULT NULL,
    `periode_permakanan` TEXT DEFAULT NULL,
    `periode_pkh` TEXT DEFAULT NULL,
    `periode_rutilahu` TEXT DEFAULT NULL,
    `periode_sembako_adaptif` TEXT DEFAULT NULL,
    `periode_yapi` TEXT DEFAULT NULL,
    `verifyid` TEXT DEFAULT NULL,
    `active` tinyint(4) DEFAULT NULL,
    `update_at` datetime NOT NULL,
    PRIMARY KEY  (id),
    INDEX(`id_desa`)
);