INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `avatar`, `dia_chi`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Bình Trần', 'binhcoder02@gmail.com', NULL, '$2y$10$PJ.r48wvbtZZ6znhgnbX7uM5d3biNu.zPmoQ14PQvoHUvHvXUHDvC', 'avatar.jpg', NULL, NULL, NULL, '2023-03-16 16:48:27', '2023-03-16 16:48:27');

INSERT INTO `trang_thai` (`id`, `ten_trang_thai`, `created_at`, `updated_at`) VALUES
(1, 'Private', NULL, NULL),
(2, 'Pending', NULL, NULL),
(3, 'Public', NULL, NULL);

INSERT INTO `nha_cung_cap` (`id`, `ma_ncc`, `ten_ncc`, `id_trang_thai`, `dia_chi`, `sdt`, `mo_ta`, `created_at`, `updated_at`) VALUES
(1, 'B01', 'Bình', 3, 'Sông Công', 356627865, 'dad\n', '2023-03-17 18:26:38', '2023-03-17 18:26:38');

INSERT INTO `loai_hang` (`id`, `ten_loai_hang`, `id_trang_thai`, `mo_ta`, `created_at`, `updated_at`) VALUES
(6, 'Cà phê', 3, 'das\n', '2023-03-17 20:33:47', '2023-03-17 20:33:47');

INSERT INTO `hang_hoa` (`id`, `ma_hang_hoa`, `ten_hang_hoa`, `mo_ta`, `id_loai_hang`, `don_vi_tinh`, `barcode`, `img`, `created_at`, `updated_at`) VALUES
(2, 'MT01', 'Mì tôm hảo hảo', 'dá\n', 6, 'Gói', 'fsdghjb', '1679085747.jpg', '2023-03-17 20:42:27', '2023-03-17 20:42:27'),
(3, '2', 'fsdfs', 'fds\n', 6, 'df', 'dasada', '1679085817.jpg', '2023-03-17 20:43:37', '2023-03-17 20:43:37'),
(4, 'aaaa', 'yjghjg', 'hfg\n', 6, 'jgjg', 'jgjg', 'hanghoa.jpg', '2023-03-17 20:46:00', '2023-03-17 20:46:00'),
(5, 'dasda', 'das', 'da\n', 6, 'adasdasd', 'dada', 'hanghoa.jpg', '2023-03-17 20:47:20', '2023-03-17 20:47:20'),
(6, 'fgbcvbcvbc', 'bcbcvbcvb', 'bcb\n', 6, 'cbcvbc', 'bcbcb', 'hanghoa.jpg', '2023-03-17 20:50:03', '2023-03-17 20:50:03'),
(7, 'jngnvbn', 'vbnvbnvbn', 'vbn\n', 6, 'vbnbnvvbn', 'nbvbnvbn', 'hanghoa.jpg', '2023-03-17 20:51:16', '2023-03-17 20:51:16');

INSERT INTO `phieu_nhap` (`id`, `ma_phieu_nhap`, `id_user`, `ma_ncc`, `ngay_nhap`, `mo_ta`, `created_at`, `updated_at`) VALUES
(2, 'PN000001', 1, 'B01', '2023-03-03', 'Loại hàng này chưa có mô tả cụ thể!', '2023-03-17 21:00:52', '2023-03-17 21:00:52');

INSERT INTO `chi_tiet_hang_hoa` (`id`, `ma_phieu_nhap`, `ma_ncc`, `ma_hang_hoa`, `so_luong`, `so_luong_goc`, `trang_thai`, `gia_nhap`, `ngay_san_xuat`, `tg_bao_quan`, `created_at`, `updated_at`) VALUES
(2, 'PN000001', 'MT01', 'B01', 321, 321, 3, 312, '2023-03-23', 31, '2023-03-17 21:00:52', '2023-03-17 21:00:52');












