DROP TABLE IF EXISTS `produk`;
DROP TABLE IF EXISTS `user`;

CREATE TABLE `produk` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nama_produk` varchar(255) NULL,
    `harga_produk` varchar(255) NULL,
    `link_produk` varchar(255) NULL,
    `dekripsi_produk` varchar(255) NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `user` (
    `username` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `role` varchar(255) NOT NULL,
    `token` varchar(255) NOT NULL
);

INSERT INTO `user` ( `username`, `password`, `role`, `token`)
    VALUES ('admin', 'rahasiaBanget', 'admin', 'ABCDEFGHIJKLMN');