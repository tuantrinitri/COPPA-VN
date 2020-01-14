<?php
/**
 * LIST PERMISSIONS FOR ROLES
 * DANH SÁCH CÁC CHỨC NĂNG ĐỂ PHÂN QUYỀN
 */
return [
	'user' => [
		'name' => 'Tài khoản',
		'user.list' => [
			'title' => 'Xem',
			'description' => 'Xem danh sách tài khoản'
		],
		'user.add' => [
			'title' => 'Thêm',
			'description' => 'Thêm tài khoản mới'
		],
		'user.edit' => [
			'title' => 'Sửa',
			'description' => 'Cập nhật thông tin, cấp lại mật khẩu,...'
		],
		'user.delete' => [
			'title' => 'Xóa',
			'description' => 'Xóa vĩnh viễn tài khoản'
		]
	],
	'post' => [
		'name' => 'Bài viết',
		'post.list' => [
			'title' => 'Xem',
			'description' => 'Xem danh sách bài viết <br>(Quản trị viên, Ban biên tập: tất cả; Cộng tác viên: những bài viết của chính mình)'
		],
		'post.add' => [
			'title' => 'Thêm',
			'description' => 'Thêm, gửi bài viết mới'
		],
		'post.edit' => [
			'title' => 'Sửa',
			'description' => 'Chỉnh sửa, cập nhật thông tin bài viết'
		],
		'post.delete' => [
			'title' => 'Xóa',
			'description' => 'Xóa vĩnh viễn bài viết'
		],
		'post.approve' => [
			'title' => 'Duyệt bài',
			'description' => 'Chỉ dành cho Quản trị viên và Ban biên tập',
			'only' => [1,2]
		]
	]
];