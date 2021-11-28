<?php

	$bookList = [
		[
			'id' => '2',
			'isbn' => '000002',
			'name' => 'The GALE ENCYCLOPIA of DIETS',
			'categoryName' => 'Funny',
			'categoryId' => '1',
			'cover' => 'http://book-cafe.sitetastingmyanmar.com/api/book/covers/2.jpg',
			'rentCount' => '25',
			'starCount' => '15',
			'status' => 'in_rent',
			'uploadDate' => [
				'date' => '2020-08-03',
				'since' => '3 days ago'
			],
			'isAvailable' => '1'
		],
		[
			'id' => '3',
			'isbn' => '000003',
			'name' => 'THE RULE OF WORK',
			'categoryName' => 'Funny',
			'categoryId' => '1',
			'cover' => 'http://book-cafe.sitetastingmyanmar.com/api/book/covers/3.jpg',
			'rentCount' => '25',
			'starCount' => '15',
			'status' => 'in_rent',
			'uploadDate' => [
				'date' => '2020-08-03',
				'since' => '3 days ago'
			],
			'isAvailable' => '1'
		],
	];

	echo json_encode($bookList);

?>