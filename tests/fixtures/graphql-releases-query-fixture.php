<?php
namespace FortAwesome;

function graphql_releases_query_fixture() {
	return array(
		'latest'   => array(
			'version' => '5.4.1',
		),
		'releases' =>
		array(
			0  =>
			array(
				'date'          => '2017-12-08 00:00:00',
				'iconCount'     =>
				array(
					'free' => 899,
					'pro'  => 1278,
				),
				'srisByLicense' =>
				array(
					'free' =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-VVoO3UHXsmXwXvf1kJx2jV3b1LbOfTqKL46DdeLG8z4pImkQ4GAP9GMy+MxHMDYG',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-JT52EiskN0hkvVxJA8d2wg8W/tLxrC02M4u5+YAezNnBlY/N2yy3X51pKC1QaPkw',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-7mC9VNNEUg5vt0kVQGblkna/29L8CpTJ5fkpo0nlmTbfCoDXyuK/gPO3wx8bglOz',
						),
						3  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-JZ2w5NHrKZS6hqVAVlhUO3eHPVzjDZqOpWBZZ6opcmMwVjN7uoagKSSftrq8F0pn',
						),
						4  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-TQW9cJIp+U8M7mByg5ZKUQoIxj0ac36aOpNzqQ04HpwyrJivS38EQsKHO2rR5eit',
						),
						5  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-X1ZQAmDHBeo7eaAJwWMyyA3mva9mMK10CpRFvX8PejR0XIUjwvGDqr2TwJqwbH9S',
						),
						6  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-2CD5KZ3lSO1FK9XJ2hsLsEPy5/TBISgKIk2NSEcS03GbEnWEfhzd0x6DBIkqgPN1',
						),
						7  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-i3UPn8g8uJGiS6R/++68nHyfYAnr/lE/biTuWYbya2dONccicnZZPlAH6P8EWf28',
						),
						8  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-tqpP2rDLsdWkeBrG3Jachyp0yzl/pmhnsdV88ySUFZATuziAnHWsHRSS97l5D9jn',
						),
						9  =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-hXqI+wajk6jJu2DXwf2oqBg6q5+HqXM5yz9smX94pDjiLzH81gAuVtjter66i1Ct',
						),
						10 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-kbPfTyGdGugnvSKEBJCd6+vYipOQ6a+2np5O4Ty3sW7tgI0MpwPyAh+QwUpMujV9',
						),
						11 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-BRge2B8T+0rmvB/KszFfdQ0PDvPnhV2J80JMKrnq21Fq6tHeKFhSIrdoroXvk7eB',
						),
					),
					'pro'  =>
					array(),
				),
				'version'       => '5.0.1',
			),
			1  =>
			array(
				'date'          => '2017-12-19 00:00:00',
				'iconCount'     =>
				array(
					'free' => 904,
					'pro'  => 1277,
				),
				'srisByLicense' =>
				array(
					'free' =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-bJB2Wn8ZuuMwYA12t6nmPqVTqT64ruKTAWqdxs/Oal3vexA7RPAo3FtVU5hIil2E',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-F8vNf2eNIHep58ofQztLhhWsZXaTzzfZRqFfWmh7Cup7LqrF0HCtB6UCAIIkZZYZ',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-CTTGZltCsihOiEwOCbT7p1lhij8kYk6lapCladmNzxj4yXj/AKp6q3+CRoNN3UCG',
						),
						3  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-GtLUznQ3nMgus15JP1pAE2UH9HAQi8gjQTNfIT+Gq6zFPeeq3y+Xtxt5HUBFF0YO',
						),
						4  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-WEKepgUDOaHRK2/r+qA7W/Srd+36IIOmBm/+wm9aSz6acYC0LkyM9UJElLVNy95T',
						),
						5  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-sV6Qj6KRPF7HrXfo5NK0evVt+YbNxUuGZU2udYKDAxwxPVTuEE6lofcZJhRMK4WT',
						),
						6  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-xiGKJ+4CP2p2WkTifyjHDeZVAg1zBrnJV8LU33N7J+5BWp1biPcSpEJJY7hFiRLn',
						),
						7  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-V+scQ15NnQuKVajRBsSery7bV87d0xDAoCs4pB8ZcwW74+zzW5CkgRmIFOYw8kKX',
						),
						8  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-CxMnuVDquTXcsJnW1rAfSm4uzGr12HENF1oe+JRZm4jcQDerJ6VeA1XLvAso396r',
						),
						9  =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-ihKlq3j4PocIYMPkNra+ieEVsLuFzj4rp1yjn3jq+La7r4G9kf9COpWfOI8SGapM',
						),
						10 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-KDEuZV2OBU0Q264kBX2Idu9gYr5z/fQrtvUsKfuKGEDkDxV0GBVN/qi3QoLZPmbJ',
						),
						11 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-0nloDHslShcnKvH94Zv8nb0zPlzTFCzfZGx9YxR2ngUWs9HXXHVx1PUQw0u9/7LE',
						),
					),
					'pro'  =>
					array(),
				),
				'version'       => '5.0.2',
			),
			2  =>
			array(
				'date'          => '2018-01-08 00:00:00',
				'iconCount'     =>
				array(
					'free' => 907,
					'pro'  => 1276,
				),
				'srisByLicense' =>
				array(
					'free' =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-KFTzeUQSHjcfuC8qqdFm+laWVqpkucx/3uXo41hhKQzUEtbNnNSk8KEEBZ+2lEQy',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-J6h7hpR0mfr79Ck/ZfDrhN14FnkbkLbd+mm0yTw5spSpK08yOK/AB9IRR/Dcg8EJ',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-l2oTZy4pLseT/J6oW0mwsjKPhjpTctOfU191uVonzezZiqw9PPcz4AMKsIAeyR4P',
						),
						3  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-cDXlx+8npD3wa2ahyeSZvsi9VlRrMmJVIB1rpK7Ftyq4cppWM9d2mBhrlOqYBljt',
						),
						4  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-ioYc/tyAAvPTKdlEWH/BDO/Fn0RGAWisNzyfZNt74mHfA6UPN2tzjD6Nm4ieQfBR',
						),
						5  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-bnoXyQHIAXdkrtQTtvuajtPgmWqHQ8657dQ4vzySapygDMqzijBpEq96AwgX2u4N',
						),
						6  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-4OPaVeLgwRHdGJplmRGxGcoGYwxBAdR8Qr9z/Av7blRYPlRIPtjTygdtpQlD1HHv',
						),
						7  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-68dqWCRgViK/UsBTW5vGfntS6GdBDT5D4KWUBXTf6IkF2NFFD+X/0QNs0FZaIELt',
						),
						8  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-sBtO3o3oG61AtAKrg74kfk50JP0YHcRTwOXgTeUobbJJBgYiCcmtkh784fmHww23',
						),
						9  =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-J0ggktpCvzBHSxd/a8EBQgQDIWBtASK5rhHMvGWuR/UyjuPgX0iCAcb3OlfhvlQz',
						),
						10 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-DX1/9hggbc1yKVl40n2dNF9OzLf9ZPwZm87WzIW+FinkgjSq18PXpUxOL4I0iS1+',
						),
						11 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-kysXtDCmCTYxM55rHL+9xPu6+Inoi3ZzZHvcxkXs+iPj5nymJKlauQdXyzubyD0b',
						),
					),
					'pro'  =>
					array(),
				),
				'version'       => '5.0.3',
			),
			3  =>
			array(
				'date'          => '2018-01-10 00:00:00',
				'iconCount'     =>
				array(
					'free' => 907,
					'pro'  => 1276,
				),
				'srisByLicense' =>
				array(
					'free' =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-DmABxgPhJN5jlTwituIyzIUk6oqyzf3+XuP7q3VfcWA2unxgim7OSSZKKf0KSsnh',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-1beec9tTZuu+KrTudmvRnGpK81r78DKCAXdphCvdG+PR+n/WCczsYPqTBTvYsM7z',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-xdTUmhbcetyLRVL4PAriRajOve+/5pjOiy5sJABnhXMcRMVc9HI9s2KmOCjjDK/P',
						),
						3  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-nM5tBytXTc1HDZ/A3My2gNT2TxLk/M/5yFi0QrOxaZjBi7QpKUfA2QqT+fcSxSlg',
						),
						4  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-g2aKxiZcFezoVOq4MsjaxuBbSxSlXD/NRQ5GaPLfvCtcTLgP3fYZKKAGxCM/wMfe',
						),
						5  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-MCR8qGTbdyK+hklwz1eKgGiAjT57F5HEJMs/uHRAwZ6GI5602TyGI89FyrbUwiIc',
						),
						6  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-nVi8MaibAtVMFZb4R1zHUW/DsTJpG/YwPknbGABVOgk5s6Vhopl6XQD/pTCG/DKB',
						),
						7  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-dl3ONr32uA3YqpqKWzhXLs5k1YbKOn3dwiMbEP1S/XQMa3LPRwvJrhW7+lomL/uc',
						),
						8  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-l7FyBM+wFIWpfmy8RYkWgEu/Me6Hrz98ijLu4nP3PkGbTtTCvtHB5ktI8hLEgEG3',
						),
						9  =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-lwwoO5Gg19TptbILrLBjV28EVJ9RW3tD3cGyjCRn3OY9IuLua/YRlE47btZIXfMv',
						),
						10 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-4KkAk2UXMS9Xl3FoAAN43VJxRZ/emjElCz60xUTegPOZlbPLZGylvor2v7wQ0JNb',
						),
						11 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-yfrMPoFcXUzdvECrvYRYE7wlxouXxjRSge5x6BlPPOb38tW4n0e8EW79RGU7VY0R',
						),
					),
					'pro'  =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-1RxicL8bcQJWgpr/clvtGVG7DVFJvDX/DVsJsbjKhXtdo8r5WVZQqB9AHTNPr08A',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-sFwP5Zsnp6I4zQxUMPHvv8Bk16eEzU0YhaNbMCftDHPKDD+BR8WdXAHKL4xpipII',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-VFi8UvBDvM8muKO8ogMXi2j8vdJiu8hq1uxpX/NS8BsftBiJpheM5AuhFH1dvURx',
						),
						3  =>
						array(
							'path'  => 'css/light.css',
							'value' => 'sha384-4FGoKudkcpRXgx5UNFa5TxzaHUhnvCGFDeZKncEn9KJx/l07kcid3VbpwajrvrFW',
						),
						4  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-eyjlqgvgpHiWM0GoL4/hsTh22piTKmMTM+sfJYacddG2n9AEubqQB/w4CPJK1/1b',
						),
						5  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-TlWtvBj4TXNlpJC5Qq4aHel0R/dywVcP/6eOFC0qptQ71WWSxJCvuTajjGb1duS9',
						),
						6  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-rHay3RzsgCtbjvDmBLThu6ESXlU4Al5STjlHSpNygnbeyt04OP1uKZVXB2Zy16+T',
						),
						7  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-vV0064GQjt+TcoZxVPm/f6vyAivSNofFvOHKLWxcDl784Dzm9W4BBpoTvUG4vi5a',
						),
						8  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-/877azmwW/YhoBsPeM9dh61dNr5XGbuk24lyjPbFWyrPaZPyU2oxgOY6PE1OH4z4',
						),
						9  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-7L9/YJQEf9kLPc6sdtoVIsuBNxCVi4OmHPcszcY685IJIcB52hgYoL1OiwTawJS/',
						),
						10 =>
						array(
							'path'  => 'js/light.js',
							'value' => 'sha384-iXxa9ExuZ0Fi2N2VO/buuWuAgYIUXNtOaJiKLa40Bjt43KJpzJdhg2TBHyBVqCPh',
						),
						11 =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-YzSStfq1m16y1v5M97ViNRpiQUCVpagVVOkqlmww8otyjFkY6EXT4dShlKNuxRDu',
						),
						12 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-WJDZ/GI6pz1VoELs6i44T3f00fguksrLXIx3LXHdlaAzmOvX/mTK5j+qzHJdKejC',
						),
						13 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-8XZ16R7aSGin4NRuv6gn5xfbsvad5H8LR41g48iduwkfZEqDgXlvUjkJKgxqZUiW',
						),
					),
				),
				'version'       => '5.0.4',
			),
			4  =>
			array(
				'date'          => '2018-01-25 00:00:00',
				'iconCount'     =>
				array(
					'free' => 929,
					'pro'  => 1387,
				),
				'srisByLicense' =>
				array(
					'free' =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-VY3F8aCQDLImi4L+tPX4XjtiJwXDwwyXNbkH7SHts0Jlo85t1R15MlXVBKLNx+dj',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-rK0EPNdv8UCeRNPzX+96ARRlf9hZM+OukGceDTdbPH30DYcSI1x5QyBU7d2I2kHX',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-dbkYY2NmVwxaFrr4gq04oVh6w39ovmevsgD80Il1Od3hwpgREqyPb3XqbpaSwN4x',
						),
						3  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-HGbVnizaFNw8zW+vIol9xMwBFWdV7/k61278Zo1bnMy9dLmjv48D7rtpgYRTe5Pd',
						),
						4  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-GfC9nfESTZkjCPFbevBVig3FTd6wkjRRYMtj+qFgK8mMBvGIje2rrALgiBy6pwRL',
						),
						5  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-U2b24h7gWqOYespg+vI5yiIn4ZYlTevT0N96xkGrw7ktP1gg9XwqEslsdTLJdlGg',
						),
						6  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-0AJY8UERsBUKdWcyF3o2kisLKeIo6G4Tbd8Y6fbyw6qYmn4WBuqcvxokp8m2UzSD',
						),
						7  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-4iSpDug9fizYiQRPpPafdAh5NaF8yzNMjOvu3veWgaFm0iIo8y4vUi7f3Yyz5WP1',
						),
						8  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-rttr/ldR2uHigckjTCjMDe47ySeFVaL3Q7xUkJZir56u8Z8h/XnHJXHocgyfb25F',
						),
						9  =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-G375DXNEVfALvsggywPWDYrRxNOvXaCYt/kiq/GXmbaDW8/B0XtbC8iuLpXXm1jF',
						),
						10 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-U0ZJ7q5xbT8hEoRqj61HzpvsqNOQ8bsHY2VqSRPqGOzjHXmmV70Aw+DBC/PT00p4',
						),
						11 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-L8zntmMOcCbOxXiL5Rjn6ubB7KunZiQ8U3bb9x6FFTGDEvVEESW9n+x49jm34K3W',
						),
					),
					'pro'  =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-ldFHeX3xCFvM4uf7m0mCMIoCPVwM71jopwqLZRldf+ojynoGVSxDiphfScLukkwO',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-Ks7IvHjmJ4FIFxhK4iNrtW0rAVo1DlCYpe/nDsK8CnU+yactd38YiNE1GT018WPg',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-sATKZbJwxaEIU3unIoL1VMbIyrNNh7PlgnaiWlicWXeRA7qdnzfFzMP9AaN2wfTU',
						),
						3  =>
						array(
							'path'  => 'css/light.css',
							'value' => 'sha384-YWWfxaKIDrbFXuVQnpxASJDHmFl2K5f2vDgrcROb+rYycoqcQVdMlfu3U38boTg/',
						),
						4  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-CydLcYoDSbudHX/6hygyQD4jBMPsv91d/RwdtH1qxI79KG8kII/OzxKDwsswywA4',
						),
						5  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-uBARwTxpZ7FB08kQlCOS/dUaN3TrGGcHthrXYIhZBpdq7YtUdVDM1sAUH9NIozMl',
						),
						6  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-BptPo+4C0N+fnMTnfw7ddW/zYUJhuNEe7edve8UrMbs+fCpfDJvJcC/lpa5Nvaky',
						),
						7  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-FrB6Se1Wkxlx66xA4rPuOoOolLyQt5B1uptDmtLJSIVRJDbNkmE3QOLipnMuAbUW',
						),
						8  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-G12tjfNd/W8L4IrE5+f13LUbpzVowwhNDv+WNecvxjbaGN9bbSY7epBOqUlRqXnq',
						),
						9  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-Ln5PcCmuH8v+AF9nt+HkM2GfXjsn1CtVc0n+ciM8+oe3nwGyPCceDVva7bUjNfo0',
						),
						10 =>
						array(
							'path'  => 'js/light.js',
							'value' => 'sha384-jzS22FYPy68IBBet2IRM5aQDOXjg9X1g+drXIVonDtyqGFCtUA0YIdgHdvCCX/fD',
						),
						11 =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-M8TFIPAJNl8UIC8OP6GFcIE0SHkGN4zjwwjz+BBTz60XhNegOrZmjNtTQNKifmXX',
						),
						12 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-R/e3QvpS9m8HcN9b9l6nNo678ekTXL31kFY/XtRHSjrihDX8A2DF8HaXhdlAtzMx',
						),
						13 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-X9eLyweB0LOTEGCwMARo9+zibrXQYmBMSrhFk4ncpT/WYnPIcpTg0IgBFDgzuPwL',
						),
					),
				),
				'version'       => '5.0.6',
			),
			5  =>
			array(
				'date'          => '2018-03-01 00:00:00',
				'iconCount'     =>
				array(
					'free' => 946,
					'pro'  => 1535,
				),
				'srisByLicense' =>
				array(
					'free' =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-IiIL1/ODJBRTrDTFk/pW8j0DUI5/z9m1KYsTm/RjZTNV8RHLGZXkUDwgRRbbQ+Jh',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-q3jl8XQu1OpdLgGFvNRnPdj5VIlCvgsDQTQB6owSOHWlAurxul7f+JpUOVdAiJ5P',
						),
						3  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-A/oR8MwZKeyJS+Y0tLZ16QIyje/AmPduwrvjeH6NLiLsp4cdE4uRJl8zobWXBm4u',
						),
						4  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-v2Tw72dyUXeU3y4aM2Y0tBJQkGfplr39mxZqlTBDUZAb9BGoC40+rdFCG0m10lXk',
						),
						5  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-TGBI4yK0MJz2ga16RLBBt4xT4aoPMPmRYhfu1Kl5IJ0gsLyOBIKHEb49BtoO+lPS',
						),
						6  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ',
						),
						7  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-sCI3dTBIJuqT6AwL++zH7qL8ZdKaHpxU43dDt9SyOzimtQ9eyRhkG3B7KMl6AO19',
						),
						8  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c',
						),
						9  =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-t7yHmUlwFrLxHXNLstawVRBMeSLcXTbQ5hsd0ifzwGtN7ZF7RZ8ppM7Ldinuoiif',
						),
						10 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-+Ga2s7YBbhOD6nie0DzrZpJes+b2K1xkpKxTFFcx59QmVPaSA8c7pycsNaFwUK6l',
						),
						11 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-4CnzNxEP5RK316IYY2+W4hc05uJdfd+p9iNVeNG9Ws3Qxf5tKolysO9wu/8rloj2',
						),
					),
					'pro'  =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-OGsxOZf8qnUumoWWSmTqXMPSNI9URpNYN35fXDb5Cv5jT6OR673ah1e5q+9xKTq6',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-VRONz34zTLl4P+DLYyJ8kP8C3tB1PGtqL5p8nBAvHuoc1u32bR3RHixrjffD8Fly',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-+5VkSw5C1wIu2iUZEfX77QSYRb5fhjmEsRn8u4r9Ma8mvu/GvTag4LDSEAw7RjXl',
						),
						3  =>
						array(
							'path'  => 'css/light.css',
							'value' => 'sha384-shmfBA2CRxp88gq8NcvWbEN8KExYU4uvQUBEG36BStGZ5k91nGKE4wDvvWvuimbu',
						),
						4  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-0w6MzzKHIB9cUlfWSmSp1Pj6XqGGDseWSMz1Yppk3UOc1dhYhpFx1AuCkMBECEvC',
						),
						5  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-+iHwwKZGTdlVFbv4fsKmLkogfdKlp47zQGkSMDN3ANc8kXjyKudKvQwinI5VH+2C',
						),
						6  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-b2wDmqWyAwmI2rS5ut5UweBS1V32L/k1+2Oo7eCaHdXOS/1bFwC8AKevTI6N28LN',
						),
						7  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-816IUmmhAwCMonQiPZBO/PTgzgsjHtpb78rpsLzldhb4HZjFzBl06Z3eu4ZuwHTz',
						),
						8  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-gJijC/2qM/p3zm2wHECHX1OMLdzlu61sNp7YfmFQxo+OyT9hO1orX7MmnHhaoXQ4',
						),
						9  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-Ht3fAeBiX/rVmKVyMwONAIIt0aRoPzZgq1FzdRgR9zFo+Kcd8YDwUbFlTItfaYW4',
						),
						10 =>
						array(
							'path'  => 'js/light.js',
							'value' => 'sha384-mfSnp84URDGC1t+cg63LgVKwEs63ulRUpjNneyDZMGMAE9ZKUNZ85rMBMHucGLYP',
						),
						11 =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-SIp/+zr0hyfSVIQPkAwB/L1h4fph6T3CmU4mE7IFtGJlgwoCko0Bye/1J0sjyh4v',
						),
						12 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-jTxqWCb7UqRDQDd2Nkuh5BkHe9k+ElbFLa3NaJfid5kBK/+cVktzVRXrw0isFWxf',
						),
						13 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-w/sFNq23wbOXJOUpFyISABLXk9tA4Z8r9hl80er2mobEwgS7VXXYDANaWyrCWe3/',
						),
					),
				),
				'version'       => '5.0.8',
			),
			6  =>
			array(
				'date'          => '2018-03-27 00:00:00',
				'iconCount'     =>
				array(
					'free' => 989,
					'pro'  => 1718,
				),
				'srisByLicense' =>
				array(
					'free' =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-ATC/oZittI09GYIoscTZKDdBr/kI3lCwzw3oBMnOYCPVNJ4i7elNlCxSgLfdfFbl',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-Lyz+8VfV0lv38W729WFAmn77iH5OSroyONnUva4+gYaQTic3iI2fnUKtDSpbVf0J',
						),
						3  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-seionXF7gEANg+LFxIOw3+igh1ZAWgHpNR8SvE64G/Zgmjd918dTL55e8hOy7P4T',
						),
						4  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-29Ax2Ao1SMo9Pz5CxU1KMYy+aRLHmOu6hJKgWiViCYpz3f9egAJNwjnKGgr+BXDN',
						),
						5  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-Hl6tZnMfNiJHYyFxpmnRV8+pziARxY3X/4XWfFXldG7sdkkLv+Od2Gpc57P7C1g6',
						),
						6  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl',
						),
						7  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-qJKAzpOXfvmSjzbmsEtlYziSrpVjh5ROPNqb8UZ60myWy7rjTObnarseSKotmJIx',
						),
						8  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-2IUdwouOFWauLdwTuAyHeMMRFfeyy4vqYNjodih+28v2ReC+8j+sLF9cK339k5hY',
						),
						9  =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-BazKgf1FxrIbS1eyw7mhcLSSSD1IOsynTzzleWArWaBKoA8jItTB5QR+40+4tJT1',
						),
						10 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-P4tSluxIpPk9wNy8WSD8wJDvA8YZIkC6AQ+BfAFLXcUZIPQGu4Ifv4Kqq+i2XzrM',
						),
						11 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-9f5gaI9TkuYhi5O/inzfdOXx2nkIhDsLtXqBNmtY6/c5PoqXfd0U2DAjqQVSCXQh',
						),
					),
					'pro'  =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-L+XK540vkePe55E7PAfByfvW0XpsyYpsifTpgh/w8WvH6asVg/c2zqp0EfZfZTbF',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-+LMmZxgyldhNCY6nei3oAWJjHbpbROtVb+f5Ux/nahA+Xjm3wcNdu7zyB39Yj38S',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-31qpW3hduWGiGey9tdI9rBBxiog5pxZbPiAlD6YKIgy0P2V1meprKhvpk+xJDkMw',
						),
						3  =>
						array(
							'path'  => 'css/light.css',
							'value' => 'sha384-wD8IB6DSQidXyIWfwBrsFwTaHTQDsgzyeqzhd1jNdBZHvGSa7KRGb6Q5sMlroCyk',
						),
						4  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-hJbmKHxbgrH79UtKxubo1UTe96bOL4Xfhjaqr0csD1UMPEPbeV+446QAC+IGxY+b',
						),
						5  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-k8v16DuQ4ZFtRfpTeqTW4tcHIj5tkvUNQm1QiLs90XiToLzyFeV+yxujHjSZ2wim',
						),
						6  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-yVUvm1bVSmayKKt0YHPKotNQzlBvgNhEBbQ6U1d38bjpapXMVmE+SLXrpQ9td4Ij',
						),
						7  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-DtPgXIYsUR6lLmJK14ZNUi11aAoezQtw4ut26Zwy9/6QXHH8W3+gjrRDT+lHiiW4',
						),
						8  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-yIJb2TJeTM04vupX+3lv0Qp9j0Pnk8Qm9UPYlXr3H0ROCHNNLoacpS++HWDabbzi',
						),
						9  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-8QYlVHotqQzcAVhJny7MO9ZR0hASr6cRCpURV+EobTTAv5wftkn4i+U6UrMqoCis',
						),
						10 =>
						array(
							'path'  => 'js/light.js',
							'value' => 'sha384-06sraYAcw8BzUjsPn5z8Qi/QAA2/ZJl5GN3LGtRp7k+tZpu7kw+sRNXDDTU4RkOt',
						),
						11 =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-C6h/8oKUfY6cVuGfFSu9uGIlFkaD1u1j+ByYGFTdFbOpHOHpw39lKxqEpRgLQg6A',
						),
						12 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-nISI3wKDp2gWn9L91zXOKXZ6JPt2mteGTnaJAMfeNgAoeLKl2AQsWLH69HMmBXHa',
						),
						13 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-vuyo8HdrwozCl2DhHOJ40ytjEx9FGy0cqu8i5GHeIoSUm6MPgqCXAVoUIsudKfuE',
						),
					),
				),
				'version'       => '5.0.9',
			),
			7  =>
			array(
				'date'          => '2018-04-10 00:00:00',
				'iconCount'     =>
				array(
					'free' => 991,
					'pro'  => 1718,
				),
				'srisByLicense' =>
				array(
					'free' =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-KtmfosZaF4BaDBojD9RXBSrq5pNEO79xGiggBxf8tsX+w2dBRpVW5o0BPto2Rb2F',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-8WwquHbb2jqa7gKWSoAwbJBV2Q+/rQRss9UXL5wlvXOZfSodONmVnifo/+5xJIWX',
						),
						3  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-R7FIq3bpFaYzR4ogOiz75MKHyuVK0iHja8gmH1DHlZSq4tT/78gKAa7nl4PJD7GP',
						),
						4  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-HTDlLIcgXajNzMJv5hiW5s2fwegQng6Hi+fN6t5VAcwO/9qbg2YEANIyKBlqLsiT',
						),
						5  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-ucawWSvpdgQ67m4VQzI6qBOHIsGRoY2soJtCkkp15b6IaNCLgauWkbKR8SAuiDQ7',
						),
						6  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+',
						),
						7  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-6jhVhr5a+Z1nLr9h+fd7ocMEo847wnGFelCHddaOOACUeZNoQwFXTxh4ysXVam8u',
						),
						8  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-M2FSA4xMm1G9m4CNXM49UcDHeWcDZNucAlz1WVHxohug0Uw1K+IpUhp/Wjg0y6qG',
						),
						9  =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-JWLWlnwX0pRcCBsI3ZzOEyVDoUmngnFnbXR9VedCc3ko4R3xDG+KTMYmVciWbf4N',
						),
						10 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-Q7KAHqDd5trmfsv85beYZBsUmw0lsreFBQZfsEhzUtUn5HhpjVzwY0Aq4z8DY9sA',
						),
						11 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-RLvgmog5EsZMMDnT3uJo6ScffPHTtMbhtV8pcT8kP5UJzlVRU1SP9Hccelk3zYZc',
						),
					),
					'pro'  =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-KwxQKNj2D0XKEW5O/Y6haRH39PE/xry8SAoLbpbCMraqlX7kUP6KHOnrlrtvuJLR',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-cyAsyPMdnj21FGg6BEGfZdZ99a/opKBeFa8z5VoHPsPj+tLRYSxkRlPWnGkCJGyA',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-HE+OCjOJOPZavEcVffA6E24sIfY2RwV4JRieXa/3N5iCY8vgnTwZemElENQ8ak/K',
						),
						3  =>
						array(
							'path'  => 'css/light.css',
							'value' => 'sha384-k/d3hya1Xwx/V3yLAr7/6ibFaFIaN+xeY1eIv42A1Bn2HgfB+/YjLscji1sHLOkb',
						),
						4  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-D4yOV+i5oKU6w8CiadBDVtSim/UXmlmQfrIdRsuKT3nYhiF/Tb6YLQtyF9l0vqQF',
						),
						5  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-WjYgBJXUWNFTzFd4wNJuzUZx28GSgjzXrPO4LJrng96HFrI/nLrG1R5NET65v1yR',
						),
						6  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-S/uB02cfkgX8kd+j6f3gmw/PPTg8xSiE/w6d8dE852PzHXkGBYLrqpWFse9hInR2',
						),
						7  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-+1nLPoB0gaUktsZJP+ycZectl3GX7wP8Xf2PE/JHrb7X1u7Emm+v7wJMbAcPr8Ge',
						),
						8  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-OwdVp9K/baqiXthTvRnYzMcsTaqwG19SfDkTRc/GBIhK9eYlWVVBEvLlueA0STAP',
						),
						9  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-TxXqLyCP6HYGVtr9V1M1rQE7IMbBEZoDdOX+MFeYNbWNwopWKVQM8NyqtU2x+5t2',
						),
						10 =>
						array(
							'path'  => 'js/light.js',
							'value' => 'sha384-rv/n2A+UxOzR1qs4wrcOtJ7Ai5Hcn3QQ8tvEkOo5lCvqCD3xwpeO3KZP18JpSXr3',
						),
						11 =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-QNGmoJVI8f07j7N4+DSn4Cdob1PTBJOR6jRGwUwqSPyL2HmvWaBPXuSXOcStGo9D',
						),
						12 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-m3J/Wb6KcNkFJIpCugSSJITG80sKhEA+16UCFdq1LnpMTOCXwwpeyrE1FmyqoArv',
						),
						13 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-H+U1wWQdWbEtuQPJ4ZpMl8yWydI6xc/306L/NZkpGY8BGpeSpu39V20x03S3xcMw',
						),
					),
				),
				'version'       => '5.0.10',
			),
			8  =>
			array(
				'date'          => '2018-05-03 00:00:00',
				'iconCount'     =>
				array(
					'free' => 1043,
					'pro'  => 1748,
				),
				'srisByLicense' =>
				array(
					'free' =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-Pln/erVatVEIIVh7sfyudOXs5oajCSHg7l5e2Me02e3TklmDuKEhQ8resTIwyI+w',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-rnr8fdrJ6oj4zli02To2U/e6t1qG8dvJ8yNZZPsKHcU7wFK3MGilejY5R/cUc5kf',
						),
						3  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-RGDxJbFQcd3/Rei8rYb+3xO3YREd0abxm8WfLkYj7j4HHo5ZVuNUGVx8H8GbpFTQ',
						),
						4  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-VxweGom9fDoUf7YfLTHgO0r70LVNHP5+Oi8dcR4hbEjS8UnpRtrwTx7LpHq/MWLI',
						),
						5  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-N44Xrku5FaDiZLZ8lncIZLh+x9xiqk1r0NTlUJQ5xanSpdORyQHP4Zp2WQJ9GlpJ',
						),
						6  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-Voup2lBiiyZYkRto2XWqbzxHXwzcm4A5RfdfG6466bu5LqjwwrjXCMBQBLMWh7qR',
						),
						7  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-BPIhZF7kZGuZzBS4SP/oIqzpxWuOUtsPLUTVGpGw+EtB1wKt1hv63jb2OCroS3EX',
						),
						8  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-6AOxTjzzZLvbTJayrLOYweuPckqh0rrB4Sj+Js8Vzgr85/qm2e0DRqi+rBzyK52J',
						),
						9  =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-6XNKyHeL6pEPXURVNSKQ0lUP80a5FHqN0oFqSSS8Qviyy2u0KmCMJlQ5iLiAAPBg',
						),
						10 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-652/z7yNdGONCCBu0u5h5uF9voJhBdgruAuIDVheEaQ7O/ZC9wyyV+yZsYb32Wy7',
						),
						11 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-STc8Gazx86A+NmeBWQTqa5Ob1wGSRQZevexYiUkKdiqZhi5LSZ28XYAvgptHK5HH',
						),
					),
					'pro'  =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-HX5QvHXoIsrUAY0tE/wG8+Wt1MwvaY28d9Zciqcj6Ob7Tw99tFPo4YUXcZw9l930',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-M4owBK0KiG0Vz+G5z/8v8tBb1+w9ts66Z6xKkZEPgBwzISkrcNra4GxZcvJPyaGB',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-ZDxYpspDwfEsC0ZJDb74i/Rqjb1CnX3a69Dz9vXv4PvvlTEkgMI02TATTRNJoZ06',
						),
						3  =>
						array(
							'path'  => 'css/light.css',
							'value' => 'sha384-PWGGmWk9+xVydf1Gzso0ouaikBBKLu4nCY52q+tBUMq5iXmRhpgTuDkjbtxZ1rXT',
						),
						4  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-tYZB+BP2inzRg01pQhSlW4Tloc0ULXYGiBaf5kSB5Tb3+l84bJy+PKerqziKz3iv',
						),
						5  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-KY40QRrgoQAM9BPN+gm7JoK30M/P6QqKRCbXUS3uWbPfycyiVeEsPkGNMhcNL3DU',
						),
						6  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-ubRAMbpAKC+ULwg5mkUQLFReIXq1yeiKIcfV7cYp+rEaeINfEglYX6JOte80PCDk',
						),
						7  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-quzri7saio48xMf3ED3HiI5YaItt68Q+0J3qc9EIfk1jk3QqCJhS24l6CZpUGfEe',
						),
						8  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-QlvHmHtevrYI4s/vdiK6chTDouw2pRA5av6ZLVtENubkoCgSZz4ZaXVvplQ1FRPs',
						),
						9  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-CUrLKzrygRugRUPtEJ1u4nV4Ec6GnuDMRDGaxfoFXLI+sraWS6rqGg2Sjfs6BTet',
						),
						10 =>
						array(
							'path'  => 'js/light.js',
							'value' => 'sha384-z7YlG414oqy0TO7qY/nGfC8zd1LL8JAX3iNQ3iLybUIziHzaMYqBwUvhizEwV0Fd',
						),
						11 =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-p/qo0lifpToZ0ubNiv1WFzlmYJU+BOenvU+evARCvCqALvbpZuqmZQ207vmYD6QL',
						),
						12 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-y//1Knkpeyl2S568g2ECqUA4n3MKf+kpj1/sfjUQbR1WtBPONceBHrQVMiAqfjLH',
						),
						13 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-6+8zJP76v3EziONR2vMd32iSU3qbdicAE8KNp+NWniM6mBmvN80NlY+sbvCO+w7M',
						),
					),
				),
				'version'       => '5.0.12',
			),
			9  =>
			array(
				'date'          => '2018-05-10 00:00:00',
				'iconCount'     =>
				array(
					'free' => 1109,
					'pro'  => 1877,
				),
				'srisByLicense' =>
				array(
					'free' =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-VGCZwiSnlHXYDojsRqeMn3IVvdzTx5JEuHgqZ3bYLCLUBV8rvihHApoA1Aso2TZA',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-GVa9GOgVQgOk+TNYXu7S/InPTfSDTtBalSgkgqQ7sCik56N9ztlkoTr2f/T44oKV',
						),
						3  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-EWu6DiBz01XlR6XGsVuabDMbDN6RT8cwNoY+3tIH+6pUCfaNldJYJQfQlbEIWLyA',
						),
						4  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-Rw5qeepMFvJVEZdSo1nDQD5B6wX0m7c5Z/pLNvjkB14W6Yki1hKbSEQaX9ffUbWe',
						),
						5  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-LAtyQAMHxrIJzktG06ww5mJ0KQ+uCqQIJFjwj+ceCjUlZ2jkLwJZt1nBGw4KaFEZ',
						),
						6  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe',
						),
						7  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-G/XjSSGjG98ANkPn82CYar6ZFqo7iCeZwVZIbNWhAmvCF2l+9b5S21K4udM7TGNu',
						),
						8  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY',
						),
						9  =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-IJ3h7bJ6KqiB70L7/+fc44fl+nKF5eOFkgM9l/zZii9xs7W2aJrwIlyHZiowN+Du',
						),
						10 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ',
						),
						11 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-qqI1UsWtMEdkxgOhFCatSq+JwGYOQW+RSazfcjlyZFNGjfwT/T1iJ26+mp70qvXx',
						),
					),
					'pro'  =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-oi8o31xSQq8S0RpBcb4FaLB8LJi9AT8oIdmS1QldR8Ui7KUQjNAnDlJjp55Ba8FG',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-t3MQUMU0g3tY/0O/50ja6YVaEFYwPpOiPbrHk9p5DmYtkHJU2U1/ujNhYruOJwcj',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-LDuQaX4rOgqi4rbWCyWj3XVBlgDzuxGy/E6vWN6U7c25/eSJIwyKhy9WgZCHQWXz',
						),
						3  =>
						array(
							'path'  => 'css/light.css',
							'value' => 'sha384-d8NbeymhHpk+ydwT2rk4GxrRuC9pDL/3A6EIedSEYb+LE+KQ5QKgIWTjYwHj/NBs',
						),
						4  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-HLkkol/uuRVQDnHaAwidOxb1uCbd78FoGV/teF8vONYKRP9oPQcBZKFdi3LYDy/C',
						),
						5  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-drdlAcijFWubhOfj9OS/gy2Gs34hVhVT90FgJLzrldrLI+7E7lwBxmanEEhKTRTS',
						),
						6  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-8YpCivPy+AkMdZ0uAvEP04Gs77AN/6mS5AmZqkCwniP51zSG8rCMaH06OYuC4iXd',
						),
						7  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-d84LGg2pm9KhR4mCAs3N29GQ4OYNy+K+FBHX8WhimHpPm86c839++MDABegrZ3gn',
						),
						8  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-44Hl7UlQr9JXHFcZOp9qWHk2H1lrsAN/cG3GNgB2JqbciecuJ2/B9sjelOMttzBM',
						),
						9  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-BUkEHIKZJ0ussRY3zYfFL7R0LpqWmucr9K38zMTJWdGQywTjmzbejVSNIHuNEhug',
						),
						10 =>
						array(
							'path'  => 'js/light.js',
							'value' => 'sha384-+iGqamqASU/OvBgGwlIHH6HSEgiluzJvTqcjJy8IN9QG9aUfd0z0pKpTlH7TpU7X',
						),
						11 =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-1bAvs6o5Yb7MMzvTI3oq2qkreCQFDXb6KISLBhrHR+3sJ/mm7ZWfnQVRwScbPEmd',
						),
						12 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-CucLC75yxFXtBjA/DCHWMS14abAUhf5HmFRdHyKURqqLqi3OrLsyhCyqp83qjiOR',
						),
						13 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-LDfu/SrM7ecLU6uUcXDDIg59Va/6VIXvEDzOZEiBJCh148mMGba7k3BUFp1fo79X',
						),
					),
				),
				'version'       => '5.0.13',
			),
			10 =>
			array(
				'date'          => '2018-06-20 00:00:00',
				'iconCount'     =>
				array(
					'free' => 1264,
					'pro'  => 2068,
				),
				'srisByLicense' =>
				array(
					'free' =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-7xAnn7Zm3QC1jFjVc1A6v/toepoG3JXboQYzbM0jrPzou9OFXm/fY6Z/XiIebl/k',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-ozJwkrqb90Oa3ZNb+yKFW2lToAWYdTiF1vt8JiH5ptTGHTGcN7qdoR1F95e0kYyG',
						),
						3  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-avJt9MoJH2rB4PKRsJRHZv7yiFZn8LrnXuzvmZoD3fh1aL6aM6s0BBcnCvBe6XSD',
						),
						4  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-TbilV5Lbhlwdyc4RuIV/JhD8NR+BfMrvz4BL5QFa2we1hQu6wvREr3v6XSRfCTRp',
						),
						5  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-5aLiCANDiVeIiNfzcW+kXWzWdC6riDYfxLS6ifvejaqYOiEufCh0zVLMkW4nr8iC',
						),
						6  =>
						array(
							'path'  => 'css/v4-shims.css',
							'value' => 'sha384-epK5t6ciulYxBQbRDZyYJFVuWey/zPlkBIbv6UujFdGiIwQCeWOyv5PVp2UQXbr2',
						),
						7  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9',
						),
						8  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-ZqDZAkGUHrXxm3bvcTCmQWz4lt7QGLxzlqauKOyLwg8U0wYcYPDIIVTbZZXjbfsM',
						),
						9  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-juNb2Ils/YfoXkciRFz//Bi34FN+KKL2AN4R/COdBOMD9/sV/UsxI6++NqifNitM',
						),
						10 =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-Y+AVd32cSTAMpwehrH10RiRmA28kvu879VbHTG58mUFhd+Uxl/bkAXsgcIesWn3a',
						),
						11 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-Z7p3uC4xXkxbK7/4keZjny0hTCWPXWfXl/mJ36+pW7ffAGnXzO7P+iCZ0mZv5Zt0',
						),
						12 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-3qT9zZfeo1gcy2NmVv5dAhtOYkj91cMLXRkasOiRB/v+EU3G+LZUyk5uqZQdIPsV',
						),
					),
					'pro'  =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-87DrmpqHRiY8hPLIr7ByqhPIywuSsjuQAfMXAE0sMUpY3BM7nXjf+mLIUSvhDArs',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-C1HxUFJBptCeaMsYCbPUw8fdL2Cblu3mJZilxrfujE+7QLr8BfuzBl5rPLNM61F6',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-PnWzJku7hTqk2JREATthkLpYeVVGcBbXG5yEzk7hD2HIr/VxffIDfNSR7p7u4HUy',
						),
						3  =>
						array(
							'path'  => 'css/light.css',
							'value' => 'sha384-ANTAgj8tbw0vj4HgQ4HsB886G2pH15LXbruHPCBcUcaPAtn66UMxh8HQcb1cH141',
						),
						4  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-6kuJOVhnZHzJdVIZJcWiMZVi/JwinbqLbVxIbR73nNqXnYJDQ5TGtf+3XyASO4Am',
						),
						5  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-rvfDcG9KDoxdTesRF/nZ/sj8CdQU+hy6JbNMwxUTqpoI2LaPK8ASQk6E4bgabrox',
						),
						6  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-/h6SKuA/ysT91EgYEGm9B6Z6zlaxuvKeW/JB7FWdGwCFalafxmGzJE2a63hS1BLm',
						),
						7  =>
						array(
							'path'  => 'css/v4-shims.css',
							'value' => 'sha384-2RBBYH6GaI11IJzJ6V1eL7kXXON+epoQIt+HqpzQdBrtyT7gNwKPDxo2roxUbtW9',
						),
						8  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-E5SpgaZcbSJx0Iabb3Jr2AfTRiFnrdOw1mhO19DzzrT9L+wCpDyHUG2q07aQdO6E',
						),
						9  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-QPbiRUBnwCr8JYNjjm7CB0QP9h4MLvWUZhsChFX6dLzRkY22/nAxVYqa5nUTd6PL',
						),
						10 =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-ckjcH5WkBMAwWPjTJiy7K2LaLp37yyCVKAs3DKjhPdo0lRCDIScolBzRsuaSu+bQ',
						),
						11 =>
						array(
							'path'  => 'js/light.js',
							'value' => 'sha384-77i21WTcIcnSPKxwR794RLUQitpNqm6K3Fxsjx8hgoc3ZZbPJu5orgvU/7xS3EFq',
						),
						12 =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-S21AhcbZ5SXPXH+MH7JuToqmKYXviahLaD1s9yApRbu1JDiMjPBGQIw/3PCHKUio',
						),
						13 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-q6QALO/4RSDjqnloeDcGnkB0JdK3MykIi6dUW5YD66JHE3JFf8rwtV5AQdYHdE0X',
						),
						14 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-9gfBAY6DS3wT0yuvYN1aaA1Q9R0fYQHliQWLChuYDWJJ0wQJpoNZrzlcqd4+qqny',
						),
					),
				),
				'version'       => '5.1.0',
			),
			11 =>
			array(
				'date'          => '2018-07-16 00:00:00',
				'iconCount'     =>
				array(
					'free' => 1265,
					'pro'  => 2067,
				),
				'srisByLicense' =>
				array(
					'free' =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-SYNjKRRe+vDW0KSn/LrkhG++hqCLJg9ev1jIh8CHKuEA132pgAz+WofmKAhPpTR7',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-0b7ERybvrT5RZyD80ojw6KNKz6nIAlgOKXIcJ0CV7A6Iia8yt2y1bBfLBOwoc9fQ',
						),
						3  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-QNorH84/Id/CMkUkiFb5yTU3E/qqapnCVt6k5xh1PFIJ9hJ8VfovwwH/eMLQTjGS',
						),
						4  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-S2gVFTIn1tJ/Plf+40+RRAxBCiBU5oAMFUJxTXT3vOlxtXm7MGjVj62mDpbujs4C',
						),
						5  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-EH3TEAKYd7R0QbCS4OFuYoEpaXITVg5c/gdZ/beEaAbRjMGVuVLLFjiIKOneCzGZ',
						),
						6  =>
						array(
							'path'  => 'css/v4-shims.css',
							'value' => 'sha384-LCsPWAjCFLDeFHB5Y0SBIOqgC5othK8pIZiJAdbJDiN10B2HXEm1mFNHtED8cViz',
						),
						7  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-BtvRZcyfv4r0x/phJt9Y9HhnN5ur1Z+kZbKVgzVBAlQZX4jvAuImlIz+bG7TS00a',
						),
						8  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-0inRy4HkP0hJ038ZyfQ4vLl+F4POKbqnaUB6ewmU4dWP0ki8Q27A0VFiVRIpscvL',
						),
						9  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-NY6PHjYLP2f+gL3uaVfqUZImmw71ArL9+Roi9o+I4+RBqArA2CfW1sJ1wkABFfPe',
						),
						10 =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-sAzYCvbTTKFOxT4VHu+ZjHRMXjvfjT6TAqOng28g4jba88Peg5+hkoVIqQKGjmj1',
						),
						11 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-GXi56ipjsBwAe6v5X4xSrVNXGOmpdJYZEEh/0/GqJ3JTHsfDsF8v0YQvZCJYAiGu',
						),
						12 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-T69Lzd4bE7W8/vVrxvfsx45/AAKf6QmKEg5zSl0v9aZwo/pTKseq81mxdpARTQpx',
						),
					),
					'pro'  =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-xyMU7RufUdPGVOZRrc2z2nRWVWBONzqa0NFctWglHmt5q5ukL22+lvHAqhqsIm3h',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-E5dVkWQIVhVPtBz/KK2TS7EM9l1+5XiWFPX7l3+5ayHPwDguGsHqof3GQbk55AS3',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-bHoj6f1b1CQ6zapOREeYBO/JnDjeV1fLuKn3KHnbqAAnkLva11KY3m8YyKPVXYLF',
						),
						3  =>
						array(
							'path'  => 'css/light.css',
							'value' => 'sha384-EGKQAl6ZrGi/zGxZ4ykVhc/A3tFVeBiLnneETILtcxQnZpo7ejmb4BkNa3zSgo4K',
						),
						4  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-AKIrAHbICIQF+NEqtykrcdzMjExDiKLa9hOyUVsr4PlHtktH7xaD10vO98UnPjuE',
						),
						5  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-Ux3tEr1RmnxCht2XbPkWWBuotwMVXKOe0PkWN/nmiD5CSV6Tyjl+Kr0J0iX1yd0q',
						),
						6  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-++BmJ9x4V05AhCNnLr/RjPTY4BAFuhZsESUqH5hiwZspBvy7F+DRGvSH8tGHw9P/',
						),
						7  =>
						array(
							'path'  => 'css/v4-shims.css',
							'value' => 'sha384-TUicmScQcYANFcc4OQKEX6V1Zek9o9t+dwW/2tZoXmSigBk9JqfHxZZFlSo+0oRl',
						),
						8  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-cHcg4nvWPIGArJhEgL2F5e09Cn1GyPQpNYKbPatFCpDefCbezZjPA3PhLozKTZnv',
						),
						9  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-KCMfKsP/3VgeibBQRMu4bT+9041Hi2v9PIz9FLOPJBEvxCBklc4o7tRwwQu4FWsT',
						),
						10 =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-EWJRWU7LQt+ri8YtDjTr8adATyP7y8DwlpE8zruoUC4nHNjtWZMU+iPYK+tFaV3U',
						),
						11 =>
						array(
							'path'  => 'js/light.js',
							'value' => 'sha384-0rp6k6cJIuLV1ORowDSSKr4VbEqb664PQUWdBvhJyt6IfkshVb0r6UlOkX6yVdaI',
						),
						12 =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-Mw6yr+W+X+ckaAUbsPUb2BcU3Af9aSjmPMIlMr2iplN0VQIpscDWy/VwY5w0sz9w',
						),
						13 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-PyvJtlnGBA/R+hfVbHbnzfeT8G/iTORqPhR5WKGTQXlfmLe5bV+d64NECHG4sIMa',
						),
						14 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-rJQjFeDWQReL3KmIeV81jB594CgKx/MmXyAgiuu88Jo253P+PSMgWzivZQtR6N6J',
						),
					),
				),
				'version'       => '5.1.1',
			),
			12 =>
			array(
				'date'          => '2018-07-23 00:00:00',
				'iconCount'     =>
				array(
					'free' => 1295,
					'pro'  => 2357,
				),
				'srisByLicense' =>
				array(
					'free' =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-nT8r1Kzllf71iZl81CdFzObMsaLOhqBU1JD2+XoAALbdtWaXDOlWOZTR4v1ktjPE',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-HbmWTHay9psM8qyzEKPc8odH4DsOuzdejtnr+OFtDmOcIVnhgReQ4GZBH7uwcjf6',
						),
						3  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-zkhEzh7td0PG30vxQk1D9liRKeizzot4eqkJ8gB3/I+mZ1rjgQk+BSt2F6rT2c+I',
						),
						4  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-wnAC7ln+XN0UKdcPvJvtqIH3jOjs9pnKnq9qX68ImXvOGz2JuFoEiCjT8jyZQX2z',
						),
						5  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-jKeGgxY7zPT61fNXg6OMRDu8vsxOPRLMlgAIUHo1KVag4lyu5B03KsDLYOTMM4ld',
						),
						6  =>
						array(
							'path'  => 'css/v4-shims.css',
							'value' => 'sha384-W14o25dsDf2S/y9FS68rJKUyCoBGkLwr8owWTSTTHj4LOoHdrgSxw1cmNQMULiRb',
						),
						7  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-4oV5EgaV02iISL2ban6c/RmotsABqE4yZxZLcYMAdG7FAPsyHYAPpywE9PJo+Khy',
						),
						8  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-4BRtleJgTYsMKIVuV1Z7lNE29r4MxwKR7u88TWG2GaXsmSljIykt/YDbmKndKGID',
						),
						9  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-QcnrgQuRmocjIBY6ByWMmDvUg3HO4MSdVjY7ynJwZfvTDhVPPQOUI9TRzc6/7ZO1',
						),
						10 =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-YdSTwqfKxyP06Jj3UzTeumv8M+Pme60+KND4oF+5r5VeUCvdkw7NhSzFYWbe00ba',
						),
						11 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-YmNA3b9AQuWW8KZguYfqJa/YhKNTwGVD5pQc1cN0ZAVRudFFtR17HR7rooNcVXe4',
						),
						12 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-rn4uxZDX7xwNq5bkqSbpSQ3s4tK9evZrXAO1Gv9WTZK4p1+NFsJvOQmkos19ebn2',
						),
					),
					'pro'  =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-TXfwrfuHVznxCssTxWoPZjhcss/hp38gEOH8UPZG/JcXonvBQ6SlsIF49wUzsGno',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-Ei2oxwH0wpwmp7KPdhYnajC5fWDdMENOjDw9OfzWvcFcOGn0Egy+L5AAculaqBbD',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-4eP+1rYQmuI3hxrmyE+GT/EIiNbF4R85ciN3jMpmIh+bU5Hz2IU7AdcVe+JS+AJz',
						),
						3  =>
						array(
							'path'  => 'css/light.css',
							'value' => 'sha384-pcDR01P1wNxsYZiEYdROCAYhU2u8VHOctLrYRonRFtkf/TGEQFWt0rqFbPGWlyn4',
						),
						4  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-g3XsWx0Sqi7JIjLKVnwUxEvqrxTMQPIf3PN+vTdWY2AhduP/rnj0rw89v0nbD4Ro',
						),
						5  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-B/E/KxBX31kY/5sew+X4c8e6ErosbqOOsA3t4k6VVmx8Hrz//v0tEUtXmUVx9X6Q',
						),
						6  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-O6mvz45yC1vfdu/EgUxAoSGrP+sFtepMtj7eOQIW1G3WT9Sj5djActZC0hd/F42D',
						),
						7  =>
						array(
							'path'  => 'css/v4-shims.css',
							'value' => 'sha384-2QRS8Mv2zxkE2FAZ5/vfIJ7i0j+oF15LolHAhqFp9Tm4fQ2FEOzgPj4w/mWOTdnC',
						),
						8  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-yBZ34R8uZDBb7pIwm+whKmsCiRDZXCW1vPPn/3Gz0xm4E95frfRNrOmAUfGbSGqN',
						),
						9  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-eg9wHuvEPj6+GlGomBRaMHLF0QfCnjdASWDKd84DMeM9phhyDaPFou/nHJBt0bz+',
						),
						10 =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-FQUuiJxt9F0hPc9IP3M5ndmqK53iBCGcy4ZSx8QirhYOIs8l7x+e1/zdswyZEigi',
						),
						11 =>
						array(
							'path'  => 'js/light.js',
							'value' => 'sha384-glAz6mCeiwAe/kHHHG/OvhrjA4+AH55ZfH8fwYp48YCY61POwUmOrH/oYOaF2Ujy',
						),
						12 =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-8hKZY21U4J3r9N0GFl+24YnDkbRhs8y/nXT6BaZ+sOJDNmz+1DhFawE9UYL37XzB',
						),
						13 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-1j3ph9Rf+Aaz6rrizz6cdFxU9ZbUyvkbiwQ5+T/BY4I5mk37vUpTA8S9ZZOlfdWu',
						),
						14 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-aoMjEUBUPf5GpXx1WJUeTZ/gBmGqQB1u8uUc2J5LW2xnQtJKkGulESZ+rkoj182s',
						),
					),
				),
				'version'       => '5.2.0',
			),
			13 =>
			array(
				'date'          => '2018-08-28 00:00:00',
				'iconCount'     =>
				array(
					'free' => 1341,
					'pro'  => 2637,
				),
				'srisByLicense' =>
				array(
					'free' =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-rf1bqOAj3+pw6NqYrtaE1/4Se2NBwkIfeYbsFdtiR6TQz0acWiwJbv1IM/Nt/ite',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-1rquJLNOM3ijoueaaeS5m+McXPJCGdr5HcA03/VHXxcp2kX2sUrQDmFc3jR5i/C7',
						),
						3  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-ZlNfXjxAqKFWCwMwQFGhmMh3i89dWDnaFU2/VZg9CvsMGA7hXHQsPIqS+JIAmgEq',
						),
						4  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-VGP9aw4WtGH/uPAOseYxZ+Vz/vaTb1ehm1bwx92Fm8dTrE+3boLfF1SpAtB1z7HW',
						),
						5  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-4K9ulTwOtsXr+7hczR7fImKfUZY5THwqvfxwPx1VUCEOt4qssi2Vm+kHY7NJQPoy',
						),
						6  =>
						array(
							'path'  => 'css/v4-shims.css',
							'value' => 'sha384-lmquXrF9qn7mMo6iRQ662vN44vTTVUBpcdtDFWPxD9uFPqC/aMn6pcQrTTupiv1A',
						),
						7  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-kW+oWsYx3YpxvjtZjFXqazFpA7UP/MbiY4jvs+RWZo2+N94PFZ36T6TFkc9O3qoB',
						),
						8  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-2vdvXGQdnt+ze3ylY5ESeZ9TOxwxlOsldUzQBwtjvRpen1FwDT767SqyVbYrltjb',
						),
						9  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-2OfHGv4zQZxcNK+oL8TR9pA+ADXtUODqGpIRy1zOgioC4X3+2vbOAp5Qv7uHM4Z8',
						),
						10 =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-sqmLTIuB+bQgkyOcdJ/hAvXl51Z7qqdK/lcH/rt6sdvDKFincQWI+fVgcDZM6NMz',
						),
						11 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-GJiigN/ef2B3HMj0haY+eMmG4EIIrhWgGJ2Rv0IaWnNdWdbWPr1sRLkGz7xfjOFw',
						),
						12 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-DtdEw3/pBQuSag11V3is/UZMjGkGMLDRBgk1UVAOvH6cYoqKjBmCEhePm13skjRV',
						),
					),
					'pro'  =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-9ralMzdK1QYsk4yBY680hmsb4/hJ98xK3w0TIaJ3ll4POWpWUYaA2bRjGGujGT8w',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-AOiME8p6xSUbTO/93cbYmpOihKrqxrLjvkT2lOpIov+udKmjXXXFLfpKeqwTjNTC',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-Yz2UJoJEWBkb0TBzOd2kozX5/G4+z5WzWMMZz1Np2vwnFjF5FypnmBUBPH2gUa1F',
						),
						3  =>
						array(
							'path'  => 'css/light.css',
							'value' => 'sha384-9QuzjQIM/Un6pY9bKVJGLW8PauASO8Mf9y3QcsHhfZSXNyXGoXt/POh3VLeiv4mw',
						),
						4  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-pofSFWh/aTwxUvfNhg+LRpOXIFViguTD++4CNlmwgXOrQZj1EOJewBT+DmUVeyJN',
						),
						5  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-wJu5pIbEyJzi+kRgVKVQkPNKI104yNC+IAyK7XXEVGgPGe+LTEERIkpSZbc/wrOx',
						),
						6  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-Hmg9TonawJaGH8ayFFnEBwvkx61BYLPAOV7b/YDGQEVIs1jh9pWQigAavMuD+Vc/',
						),
						7  =>
						array(
							'path'  => 'css/v4-shims.css',
							'value' => 'sha384-1YFoQoO5Em1oxLErpWpJuswiqPFVHl8HLDUaLjJGJH8+Nra/Y1D6uOZkEgfH5OZf',
						),
						8  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-eAVkiER0fL/ySiqS7dXu8TLpoR8d9KRzIYtG0Tz7pi24qgQIIupp0fn2XA1H90fP',
						),
						9  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-am5AyalpQCEfbKe6FYiGZc2vX080nrcueZmrbkljxLdQDJ5q5Vu9QDROD/QefEp1',
						),
						10 =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-u3o36ga3mMU6/lK/zdiER4h7pPtAK7wBuN0DrZPH22v01RZL8bKZkULIjxcx2/X/',
						),
						11 =>
						array(
							'path'  => 'js/light.js',
							'value' => 'sha384-2R0W5LA7dXp3ze/WhvjXlUcDaHRhtGlKYxN9QMhGDdjmj2EI1bub5ysSwofJwGfI',
						),
						12 =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-EbI+OvKb7noKOfu8MSi/vCbi0KWlM61MjHDmRk4/vwJkPsMIRcJggYLDGWv7VeYY',
						),
						13 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-U4vTrZsQ4ooEtzL162EZfTtCiJNTXOwGDBzV91//DI5L/h48ibzHBiHJmPLpx2hO',
						),
						14 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-8e1r0+5VTqCqkg/9vG+cnipytzBkEh9fpESgVwBZAizMkWRfiaTkdhgdnhLGwuPd',
						),
					),
				),
				'version'       => '5.3.1',
			),
			14 =>
			array(
				'date'          => '2018-10-10 00:00:00',
				'iconCount'     =>
				array(
					'free' => 1388,
					'pro'  => 2969,
				),
				'srisByLicense' =>
				array(
					'free' =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-Px1uYmw7+bCkOsNAiAV5nxGKJ0Ixn5nChyW8lCK1Li1ic9nbO5pC/iXaq27X5ENt',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-BzCy2fixOYd0HObpx3GMefNqdbA7Qjcc91RgYeDjrHTIEXqiF00jKvgQG0+zY/7I',
						),
						3  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-4e3mPOi7K1/4SAx8aMeZqaZ1Pm4l73ZnRRquHFWzPh2Pa4PMAgZm8/WNh6ydcygU',
						),
						4  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-osqezT+30O6N/vsMqwW8Ch6wKlMofqueuia2H7fePy42uC05rm1G+BUPSd2iBSJL',
						),
						5  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-2MWWLQq91kFwloAny7gkgoeV33bD/cE3A9ZbB2rCN/YAAR/VEHVoDq6vRJJYTaxM',
						),
						6  =>
						array(
							'path'  => 'css/v4-shims.css',
							'value' => 'sha384-YIDcSvDDaIskj/WDlWwjrNdK194YAGWc1CScdo2tXl3IQVS1zS07xQaoAFlXCf1P',
						),
						7  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-L469/ELG4Bg9sDQbl0hvjMq8pOcqFgkSpwhwnslzvVVGpDjYJ6wJJyYjvG3u8XW7',
						),
						8  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-lc/yFuYW3B0EW9B2QSpod2KeBxq6/ZizGwAW6mRLUe3kKUVlSBfDIVZKwKIz/DBg',
						),
						9  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-ISRc+776vRkDOTSbmnyoZFmwHy7hw2UR3KJpb4YtcfOyqUqhLGou8j5YmYnvQQJ4',
						),
						10 =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-SQqzt64aAzh3UJ9XghcA//GE8+NxAIRcuCrrekyDokXP6Bbt/FYAFlV6VSPrZKwH',
						),
						11 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-agDKwSYPuGlC0wD14lKXXwb94jlUkbkoSugquwmKRKWv/nDXe1kApDS/gqUlRQmZ',
						),
						12 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-/s2EnwEz7C3ziRundAGzeOAoGYffu84oY4SOHjhI/2Wqk3Z0usUm9bjdduzhZ9+z',
						),
					),
					'pro'  =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-POYwD7xcktv3gUeZO5s/9nUbRJG/WOmV6jfEGikMJu77LGYO8Rfs2X7URG822aum',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-rmUpvtaCngUop5CYz7WL1LnqkMweXskxP+1AXmkuMSbImsUuy82bUYS4A8Syd3Pf',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-PPeKwWhk5XZBVVq089DuhGmjaEVB1r+jdmx6jZrqzlef8ojhZXG+E/D6SP7uO1dk',
						),
						3  =>
						array(
							'path'  => 'css/light.css',
							'value' => 'sha384-DZAoxBcs4G15aUXLX4vKbO53ye8L8AB/zg07HOVhIMVclhx8rdWye0AJSQl51ehV',
						),
						4  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-xKPOvJDwdb/n5w2kh6cxds98Ae2d5N63xkIydEdoYeA2bxIKUmmyU9lZ9j58mLYS',
						),
						5  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-oT4lQmwnKx98HRnFgaGvgCdjtKOjep9CjfMdAOPtJU8Vy6NY3X34GfqL0H43ydJn',
						),
						6  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-j2EtHJUHBAZF9vkmX0TSA/QqYMf0Npp9P2leJGZFDbLHbcI62HH8w7FRcUMNf8Q2',
						),
						7  =>
						array(
							'path'  => 'css/v4-shims.css',
							'value' => 'sha384-aaXKvb/d7l2hTm3ZDWCy5v4ct5zXIslt+70K4xalZPLu3ifrkYcG61m4u+DIQGEk',
						),
						8  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-0+tugznPwCEvPiypW+OwmFjAQvRKlgI0ZZZW3nofNlLMmbYXbmNvfX/9up9XQSRs',
						),
						9  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-ShBqjf9lFG58e2NmhnbVlhAOPCWdzkPbBmAEcQ37Liu3TwOYxIizS7J1P3rRLJHm',
						),
						10 =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-8vKKeD0uIV/HXM5ym3RGB4O7rZ43fCdpiXqP047w7sEE3igcK0Y1U9ApEArcRBDJ',
						),
						11 =>
						array(
							'path'  => 'js/light.js',
							'value' => 'sha384-jlaccvPpizUbHU/8pYAsDEwhhBae8MUcYqHHsKkjFcFsEp3Y6LrVXh0GA84aAkTg',
						),
						12 =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-MB7Bz/7e8sBWnZgblSLUfFOOi+V1PIkRG/Ex1NMeu0CovaXCzHyCMwAwOF+FAo1s',
						),
						13 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-KlTWIsOnBg7LJobQmLsv5fQ1qbx73K+o8/xhoUDoIba13SxF4bT5W2WgV3d8mZIw',
						),
						14 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-e+EZ4XUeGXVd0FDmP/mFu7FFe+qVX738ayOS2AErNIPSLz5oZ3OgVa9zEyCds3HP',
						),
					),
				),
				'version'       => '5.4.1',
			),
			15 =>
			array(
				'date'          => '2021-11-22 00:00:00',
				'iconCount'     =>
				array(
					'free' => 1734,
					'pro'  => 12995,
				),
				'srisByLicense' =>
				array(
					'free' =>
					array(
						0  =>
						array(
							'path'  => 'css/all.css',
							'value' => 'sha384-5e2ESR8Ycmos6g3gAKr1Jvwye8sW4U1u/cAKulfVJnkakCcMqhOudbtPnvJ+nbv7',
						),
						1  =>
						array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-Lzg1sLP4sLS8KyVySlmRH4QzbOnIzlp/h2MYRTDkxMPKwaD+zxathmN655nRjRSG',
						),
						2  =>
						array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-RAtjHVFRUZs4Tif4stxk4r1UN31mhO2m2ii67jtwlyWDXls6IDZ6/N2bHxt3bA48'
						),
						3  =>
						array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-TvfVCWnd24+5zZ+qmyScSguhYpT7YtOajZ0b4IVLn3+T3dFYzXkgu/EE/Nrf2km5'
						),
						4  =>
						array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-4veAyGk1Tas2qyx7CD/29iLDa8aarX6vdaWWVPD7K/m8FdvH9ae9yFNbWOxmP1hZ'
						),
						5  =>
						array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-MLxC4sgXwbw5k1vFBDb68XNAF7UdJ7e1ibhu+ySJnAakTpweYCcq7jCcQpd5nJjU'
						),
						6  =>
						array(
							'path'  => 'css/v4-shims.css',
							'value' => 'sha384-zCIuCI9fw3QOcUPL5/7JfB3Qw6sjEimma+57eLWmHPHyVgqGmX5XLwGi3Ak5fLzQ'
						),
						7  =>
						array(
							'path'  => 'css/v4-font-face.css',
							'value' => 'sha384-LJQ43yQLnfgXK8pn645vHWEmSJrVqisZaieRPj7NGV7cCzlL/B67BDv8gMRBS53i'
						),
						8  =>
						array(
							'path'  => 'css/v5-font-face.css',
							'value' => 'sha384-W7b35mq2oJvzl9StEqMDWhapHEgwLh3/iohOpz2RopU0+3/eOmb8eubYCz0OwUcj'
						),
						9  =>
						array(
							'path'  => 'js/all.js',
							'value' => 'sha384-6e7nA5mhBVXnMIAtGPETl10C7oipDhu2IN/lyxyjAJG+KzNtRLqrqFJN5wJ+6/qU'
						),
						10  =>
						array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-zY1eKUaz/NWcOf6xnU5eePxV3anVtTTAlu33RytBcT9jGz8dstwzZbVpp2l609NT'
						),
						11  =>
						array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-W1qlouWJA+8MQIORaSCnwNHhaPuAMwQGosDEwU/g4kkawDb4WwLy3ZWVpa/KtRXb'
						),
						12 =>
						array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-Axuj5+DJ+mQA38QqwpWCujH6bCefx3brdTdN+ffhy6oxdqSvs1evxn4iX828SSe6'
						),
						13 =>
						array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-9d1SM0Z1PczSHlc0bwe5j/n1kjp14H06SgMcxbmNkp6ZSQa6CqneEHKQkfVGPcR7'
						),
						14 =>
						array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-ZkRpffzN60bZU7hfI/zFR3Nv603593UFKpz6QAm3FUAUqGa60uzGmuEGLB5BZNsY'
						),
						15 =>
						array(
							'path'  => 'js/conflict-detection.js',
							'value' => 'sha384-rN+BHnX2WMsUD7VYL6PykWIyqG6SyEu6IdhgM42fLyWqC7JlY2k76ufmZvMFU43a'
						)
					),
				),
				'version'       => '6.0.0-beta3',
			),
		),
	);
}
