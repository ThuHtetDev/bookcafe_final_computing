<?php

	echo json_encode([
		'id' => '1',
		'isbn' => '000001',
		'cover' => [
			[
				'path' => 'http://book-cafe.sitetastingmyanmar.com/api/book/covers/1.jpg',
				'preview' => 'http://book-cafe.sitetastingmyanmar.com/api/book/covers/1.jpg',
				'name' => 'Front Cover'
			],
			[
				'path' => 'http://book-cafe.sitetastingmyanmar.com/api/book/covers/2.jpg',
				'preview' => 'http://book-cafe.sitetastingmyanmar.com/api/book/covers/2.jpg',
				'name' => 'Back Cover'
			],
			[
				'path' => 'http://book-cafe.sitetastingmyanmar.com/api/book/covers/3.jpg',
				'preview' => 'http://book-cafe.sitetastingmyanmar.com/api/book/covers/3.jpg',
				'name' => 'Others'
			],
		],
		'name' => 'About PHP',
		'description' =>
		  'The PHP development team announces the immediate availability of PHP 7.4.8. This is a security release impacting the official Windows builds of PHP. For windows users running an official build, this release contains a patched version of libcurl addressing CVE-2020-8169. For all other consumers of PHP, this is a bug fix release. All PHP 7.4 users are encouraged to upgrade to this version.',
		'categoryName' => 'Funny',
		'categoryId' => '1',
		'rentCount' => '25',
		'starCount' => '15',
		'status' => 'in_queue',
		'isInRent' => '1',
		'isOwner' => '1',
		'isRentBook' => '1',
		'isAvailable' => '1'

	]);

?>