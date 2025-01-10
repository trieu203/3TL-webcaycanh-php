-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 08, 2025 lúc 02:10 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webbancayphp`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitethoadon`
--

CREATE TABLE `chitethoadon` (
  `machitiet` int(11) NOT NULL,
  `mahoadon` int(11) NOT NULL,
  `macaycanh` int(11) NOT NULL,
  `soluong` int(11) NOT NULL,
  `tongtien` int(11) NOT NULL,
  `trangthai` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `magiohang` int(11) NOT NULL,
  `macaycanh` int(11) NOT NULL,
  `soluongthem` int(11) NOT NULL,
  `maphien` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `giohang`
--

INSERT INTO `giohang` (`magiohang`, `macaycanh`, `soluongthem`, `maphien`) VALUES
(1, 3, 7, '8efs8rubktsjh3r8pbr9e4gun3'),
(5, 4, 1, 'r6oqfkv81p3j81amudnls2k9p6');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadon`
--

CREATE TABLE `hoadon` (
  `mahoadon` int(11) NOT NULL,
  `ngayxuat` date NOT NULL,
  `tendangnhap` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaicay`
--

CREATE TABLE `loaicay` (
  `maloai` int(11) NOT NULL,
  `tenloai` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loaicay`
--

INSERT INTO `loaicay` (`maloai`, `tenloai`) VALUES
(1, 'Cây để bàn'),
(2, 'Cây phong thủy'),
(3, 'Cây bonsai'),
(4, 'Cây ngoài trời'),
(5, 'Cây treo tường');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

CREATE TABLE `nguoidung` (
  `tendangnhap` char(20) NOT NULL,
  `matkhau` text NOT NULL,
  `hoten` varchar(50) NOT NULL,
  `dienthoai` int(10) NOT NULL,
  `diachi` varchar(30) NOT NULL,
  `anhdaidien` text NOT NULL,
  `quyentruycap` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`tendangnhap`, `matkhau`, `hoten`, `dienthoai`, `diachi`, `anhdaidien`, `quyentruycap`) VALUES
('khoa123', '698d51a19d8a121ce581499d7b701668', 'Thượng Văn Anh Khoa', 12342222, 'Trà Vinh', '677e6f0137a66.jpg', 0),
('khoaadmin', '698d51a19d8a121ce581499d7b701668', '', 0, '', '', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `macaycanh` int(11) NOT NULL,
  `tencay` varchar(30) NOT NULL,
  `hinhanh` text NOT NULL,
  `mota` varchar(1000) NOT NULL,
  `gia` int(11) NOT NULL,
  `maloai` int(11) NOT NULL,
  `soluongsanpham` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`macaycanh`, `tencay`, `hinhanh`, `mota`, `gia`, `maloai`, `soluongsanpham`) VALUES
(3, 'Cây Lưỡi Hổ', 'images/sanpham/cayluoiho.jpg', 'Là một loại cây phong thủy phổ biến ở Việt Nam', 52000, 2, 20),
(4, 'Cây Kim Tiền', 'images/sanpham/cay-kim-tien-chau-ly-men-su.jpg', 'Cây kim tiền còn được gọi là cây kim phát tài, cây phát tài, kim tiền phát lộc có nguồn gốc từ Châu Phi.', 100000, 1, 10),
(5, 'Cây phát tài', 'images/sanpham/cay_phat_tai.jpg', 'Cây phát tài (hay còn gọi là phát lộc, tên khoa học: Dracaena spp.) là một loại cây cảnh thuộc họ Măng tây (Asparagaceae), nổi tiếng với ý nghĩa phong thủy mang lại tài lộc, may mắn và thịnh vượng cho gia chủ.', 50000, 1, 5),
(6, 'Cây xương rồng', 'images/sanpham/cay_xuong_rong.jpg', 'Cây xương rồng là một loại cây thuộc họ Cactaceae, nổi tiếng với khả năng chịu hạn tốt, hình dáng độc đáo và vẻ đẹp hoang dã, mạnh mẽ.', 45000, 1, 7),
(7, 'Cây sen đá', 'images/sanpham/cay_sen_da.jpg', 'Cây sen đá (tên khoa học: Echeveria spp.) là một loại cây mọng nước thuộc họ Crassulaceae, được yêu thích nhờ vẻ đẹp tinh tế, hình dáng nhỏ nhắn, dễ chăm sóc và mang ý nghĩa phong thủy tích cực.', 75000, 1, 8),
(8, 'Cây ngọc bích', 'images/sanpham/cay_ngoc_bich.jpg', 'Cây ngọc bích hay còn được gọi là cây sen đá ngọc bích, cây phỉ thúy, có tên khoa học là Crassula ovata. Là loại cây có nguồn gốc từ Nam Phi, cây ngọc bích tượng trưng cho tiền tài, sự may mắn và tài lộc.', 100000, 2, 3),
(9, 'Cây thiết mộc lan', 'images/sanpham/cay_thiet_moc_lan.jpg', 'Cây thiết mộc lan được đánh giá là đem lại nhiều sinh khí, may mắn và thịnh vượng cho gia chủ, nhất là khi cây nở hoa là dấu hiệu tiền tài đang đến với bạn.', 35000, 2, 5),
(10, 'Cây trầu bà', 'images/sanpham/cay_trau_ba.jpg', 'Trồng cây trầu bà trong nhà sẽ mang tới tài lộc và giúp bạn thuận lợi hơn về đường con cái. Nếu trồng cây trầu bà trong văn phòng, chúng sẽ giúp sự nghiệp của bạn suôn sẻ, ít trắc trở và ngày càng thăng tiến hơn.', 95000, 2, 5),
(11, 'Cây vạn niên thanh', 'images/sanpham/cay_van_nien_thanh.jpg', 'Vạn niên thanh là một trong số ít loại cây đem lại sự may mắn, thịnh vượng cho gia chủ. Vì vậy, loai cây này được dùng để làm quà biếu vào mỗi dịp đặc biệt như năm mới, báo hỷ, mừng tuổi… với mong ước cầu cho gia chủ được may mắn, sung túc.', 125000, 2, 4),
(12, 'Bonsai sanh', 'images/sanpham/bonsai_xanh.jpg', 'Bonsai sanh (tên khoa học: Ficus microcarpa) là một loại cây cảnh truyền thống được yêu thích trong nghệ thuật bonsai. Với vẻ đẹp cổ kính, dáng thế phong phú và sức sống mãnh liệt, cây sanh không chỉ là biểu tượng của sự trường tồn, bền bỉ mà còn mang giá trị thẩm mỹ và phong thủy cao.', 130000, 3, 2),
(13, 'Bonsai tung', 'images/sanpham/bonsai_tung.jpg', 'Bonsai tùng là loại cây cảnh thuộc họ Cupressaceae, phổ biến trong nghệ thuật bonsai nhờ vẻ đẹp cổ kính, hình dáng uy nghi và ý nghĩa phong thủy sâu sắc. Cây bonsai tùng không chỉ là biểu tượng của sự trường thọ, sức sống mạnh mẽ mà còn thể hiện sự cao quý và tinh thần kiên định.', 150000, 3, 5),
(14, 'bonsai bồ đề', 'images/sanpham/bonsai_bo_de.jpg', 'Cây bồ đề bonsai vốn là vật phẩm trang trí quen thuộc của nhiều gia chủ. Không chỉ bởi gắn liền với Phật Pháp mà còn bởi dáng đứng của cây uy nghiêm, tuyệt mỹ.', 500000, 3, 5),
(15, 'Cây dây leo', 'images/sanpham/cay_day_leo.jpg', 'Dây leo là bất kỳ loại thực vật nào có thói quen sinh trưởng như thân cây kéo dài hoặc leo bám vào một vật thể, dạng thân leo hoặc thân bò.', 45000, 5, 6),
(16, 'Cây đuôi công', 'images/sanpham/cay_duoi_cong.jpg', 'Trong phong thủy, cây đuôi công được xem là một loại cây hút tài lộc, may mắn, tượng trưng cho sự tròn đầy và thịnh vượng của gia chủ.', 450000, 5, 7),
(17, 'Cây bàng Singapore', 'images/sanpham/cay_bang_singapore.jpg', 'Cây bàng Singapore với thân cây mọc thẳng đứng, mọc vươn lên phía trước thể hiện sự cần cù, chịu khó, luôn phấn đấu trong mọi hoàn cảnh, vượt qua được sóng gió dù trong bất kì hoàn cảnh nào.', 230000, 5, 6),
(18, 'Cây hoa giấy', 'images/sanpham/cay_hoa_giay.jpg', 'Đặc điểm hình dáng của cây hoa giấy như đã phân tích ở trên là cây dạng leo, có nhiều cành nên trông rất xum xuê chính vì vậy mà trong phong thủy, loại cây này tượng trưng cho sự đủ đầy, chở che, hạnh phúc vẹn tròn.', 340000, 4, 6),
(19, 'Cây dừa cảnh', 'images/sanpham/cay_dua_canh.jpg', 'Cây dừa cảnh ngoài khả năng ngăn bụi, cung cấp oxi và tạo thêm mảng xanh trong nhà, trong văn phòng hoặc công ty, chúng còn mang ý nghĩa về mặt phong thủy.', 250000, 4, 6),
(20, 'Cây cau cảnh', 'images/sanpham/cay_cau_canh.jpg', 'Không chỉ đẹp, việc trồng cây cảnh trong nhà còn là một xu thế, nó có rất nhiều tác dụng trong việc lọc không khí, tái tạo môi trường sinh thái tự nhiên là điều kiện sống của con người.', 450000, 4, 9);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitethoadon`
--
ALTER TABLE `chitethoadon`
  ADD PRIMARY KEY (`machitiet`),
  ADD KEY `macaycanh` (`macaycanh`),
  ADD KEY `mahoadon` (`mahoadon`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`magiohang`),
  ADD KEY `macaycanh` (`macaycanh`);

--
-- Chỉ mục cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`mahoadon`),
  ADD KEY `tendangnhap` (`tendangnhap`);

--
-- Chỉ mục cho bảng `loaicay`
--
ALTER TABLE `loaicay`
  ADD PRIMARY KEY (`maloai`);

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`tendangnhap`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`macaycanh`),
  ADD KEY `maloai` (`maloai`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chitethoadon`
--
ALTER TABLE `chitethoadon`
  MODIFY `machitiet` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `giohang`
--
ALTER TABLE `giohang`
  MODIFY `magiohang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `mahoadon` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `loaicay`
--
ALTER TABLE `loaicay`
  MODIFY `maloai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `macaycanh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitethoadon`
--
ALTER TABLE `chitethoadon`
  ADD CONSTRAINT `chitethoadon_ibfk_1` FOREIGN KEY (`macaycanh`) REFERENCES `sanpham` (`macaycanh`),
  ADD CONSTRAINT `chitethoadon_ibfk_2` FOREIGN KEY (`mahoadon`) REFERENCES `hoadon` (`mahoadon`);

--
-- Các ràng buộc cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `giohang_ibfk_1` FOREIGN KEY (`macaycanh`) REFERENCES `sanpham` (`macaycanh`);

--
-- Các ràng buộc cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`tendangnhap`) REFERENCES `nguoidung` (`tendangnhap`);

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`maloai`) REFERENCES `loaicay` (`maloai`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
