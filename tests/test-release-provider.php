<?php
namespace FortAwesome;

/**
 * Tests the release provider.
 *
 * @noinspection PhpIncludeInspection
 */

require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome-release-provider.php';
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';

use \InvalidArgumentException;

/**
 * Class ReleaseProviderTest
 *
 * @group api
 *
 * The backupStaticAttributes option seems to be necessary in order to make the handler mocking work consistently.
 * To see what happens without it, disconnect networking (so the client can't get out to the real API URL and MUST
 * rely on this mock handler), and then run this test case. It will fail some times.
 * This is probably because we're messing with singletons here.
 *
 * TODO: Considering refactoring or re-implementing to avoid this if it becomes a problem. But maybe it's not a problem.
 *
 * WARNING: if you disable this attribute and see the tests still passing, it's probably because it's hitting the
 * real API server instead of using the MockHandler, which we don't want to do. So just make sure you understand
 * what you're doing before disabling this and make sure that the test suite still passes offline (and thus does
 * not require hitting the real API server).
 *
 * UPDATE: December 5, 2018 removed the backupStaticAttributes annotation when adding runTestsInSeparateProcesses
 * and "preserveGlobalState disabled" because we're suddenly having failures in Travis CI (but not in the local
 * development environment). The failures are all from this test case:
 *  "Exception: Serialization of 'Closure' is not allowed"
 *
 * PHP cannot serialize anonymous functions:
 * https://github.com/sebastianbergmann/phpunit/issues/2739
 *
 * And when tests are run with process isolation, apparently serialization of globals between parent and child
 * processes is part of the magic.
 *
 * See also: https://phpunit.de/manual/6.5/en/appendixes.annotations.html#appendixes.annotations.preserveGlobalState
 * (Though this doc is for phpunit 6.5, and we're using 5.x right now).
 *
 * So we must be doing that. Don't know why this only started failing on CI today. But we're going to try and insist
 * on this test case running in separate processes all the time and configure it so that it hopefully runs the same
 * in both local developpment and CI.
 *
 * @preserveGlobalState disabled
 * @runTestsInSeparateProcesses
 */
class ReleaseProviderTest extends \WP_UnitTestCase {
	// Known at the time of capturing the "releases_api" vcr fixture on Oct 18, 2018.
	protected $known_versions_sorted_desc = [
		'5.4.1',
		'5.3.1',
		'5.2.0',
		'5.1.1',
		'5.1.0',
		'5.0.13',
		'5.0.12',
		'5.0.10',
		'5.0.9',
		'5.0.8',
		'5.0.6',
		'5.0.4',
		'5.0.3',
		'5.0.2',
		'5.0.1',
	];

	public function setUp() {
		reset_db();
	}

	public function test_can_load_and_instantiate() {
		$obj = fa_release_provider();
		$this->assertFalse( is_null( $obj ) );
	}

	protected static function build_success_response() {
		return array(
			'response' => array(
				'code'    => 200,
				'message' => 'OK',
			),
			'body'     => '{"jsonapi":{"version":"1.0"},"data":[{"type":"releases","links":{"self":"/api/releases/"},"id":"","attributes":{"version":"5.0.1","sri":{"pro":{},"free":{"js/v4-shims.js":"sha384-BRge2B8T+0rmvB/KszFfdQ0PDvPnhV2J80JMKrnq21Fq6tHeKFhSIrdoroXvk7eB","js/solid.js":"sha384-kbPfTyGdGugnvSKEBJCd6+vYipOQ6a+2np5O4Ty3sW7tgI0MpwPyAh+QwUpMujV9","js/regular.js":"sha384-hXqI+wajk6jJu2DXwf2oqBg6q5+HqXM5yz9smX94pDjiLzH81gAuVtjter66i1Ct","js/fontawesome.js":"sha384-tqpP2rDLsdWkeBrG3Jachyp0yzl/pmhnsdV88ySUFZATuziAnHWsHRSS97l5D9jn","js/brands.js":"sha384-i3UPn8g8uJGiS6R/++68nHyfYAnr/lE/biTuWYbya2dONccicnZZPlAH6P8EWf28","js/all.js":"sha384-2CD5KZ3lSO1FK9XJ2hsLsEPy5/TBISgKIk2NSEcS03GbEnWEfhzd0x6DBIkqgPN1","css/svg-with-js.css":"sha384-X1ZQAmDHBeo7eaAJwWMyyA3mva9mMK10CpRFvX8PejR0XIUjwvGDqr2TwJqwbH9S","css/solid.css":"sha384-TQW9cJIp+U8M7mByg5ZKUQoIxj0ac36aOpNzqQ04HpwyrJivS38EQsKHO2rR5eit","css/regular.css":"sha384-JZ2w5NHrKZS6hqVAVlhUO3eHPVzjDZqOpWBZZ6opcmMwVjN7uoagKSSftrq8F0pn","css/fontawesome.css":"sha384-7mC9VNNEUg5vt0kVQGblkna/29L8CpTJ5fkpo0nlmTbfCoDXyuK/gPO3wx8bglOz","css/brands.css":"sha384-JT52EiskN0hkvVxJA8d2wg8W/tLxrC02M4u5+YAezNnBlY/N2yy3X51pKC1QaPkw","css/all.css":"sha384-VVoO3UHXsmXwXvf1kJx2jV3b1LbOfTqKL46DdeLG8z4pImkQ4GAP9GMy+MxHMDYG"}},"is-latest":false,"icon-count":{"pro":1278,"free":899},"download":{"separates_web_desktop":false},"date":"2017-12-08T00:00:00"}},{"type":"releases","links":{"self":"/api/releases/"},"id":"","attributes":{"version":"5.0.2","sri":{"pro":{},"free":{"js/v4-shims.js":"sha384-0nloDHslShcnKvH94Zv8nb0zPlzTFCzfZGx9YxR2ngUWs9HXXHVx1PUQw0u9/7LE","js/solid.js":"sha384-KDEuZV2OBU0Q264kBX2Idu9gYr5z/fQrtvUsKfuKGEDkDxV0GBVN/qi3QoLZPmbJ","js/regular.js":"sha384-ihKlq3j4PocIYMPkNra+ieEVsLuFzj4rp1yjn3jq+La7r4G9kf9COpWfOI8SGapM","js/fontawesome.js":"sha384-CxMnuVDquTXcsJnW1rAfSm4uzGr12HENF1oe+JRZm4jcQDerJ6VeA1XLvAso396r","js/brands.js":"sha384-V+scQ15NnQuKVajRBsSery7bV87d0xDAoCs4pB8ZcwW74+zzW5CkgRmIFOYw8kKX","js/all.js":"sha384-xiGKJ+4CP2p2WkTifyjHDeZVAg1zBrnJV8LU33N7J+5BWp1biPcSpEJJY7hFiRLn","css/svg-with-js.css":"sha384-sV6Qj6KRPF7HrXfo5NK0evVt+YbNxUuGZU2udYKDAxwxPVTuEE6lofcZJhRMK4WT","css/solid.css":"sha384-WEKepgUDOaHRK2/r+qA7W/Srd+36IIOmBm/+wm9aSz6acYC0LkyM9UJElLVNy95T","css/regular.css":"sha384-GtLUznQ3nMgus15JP1pAE2UH9HAQi8gjQTNfIT+Gq6zFPeeq3y+Xtxt5HUBFF0YO","css/fontawesome.css":"sha384-CTTGZltCsihOiEwOCbT7p1lhij8kYk6lapCladmNzxj4yXj/AKp6q3+CRoNN3UCG","css/brands.css":"sha384-F8vNf2eNIHep58ofQztLhhWsZXaTzzfZRqFfWmh7Cup7LqrF0HCtB6UCAIIkZZYZ","css/all.css":"sha384-bJB2Wn8ZuuMwYA12t6nmPqVTqT64ruKTAWqdxs/Oal3vexA7RPAo3FtVU5hIil2E"}},"is-latest":false,"icon-count":{"pro":1277,"free":904},"download":{"separates_web_desktop":false},"date":"2017-12-19T00:00:00"}},{"type":"releases","links":{"self":"/api/releases/"},"id":"","attributes":{"version":"5.0.3","sri":{"pro":{},"free":{"js/v4-shims.js":"sha384-kysXtDCmCTYxM55rHL+9xPu6+Inoi3ZzZHvcxkXs+iPj5nymJKlauQdXyzubyD0b","js/solid.js":"sha384-DX1/9hggbc1yKVl40n2dNF9OzLf9ZPwZm87WzIW+FinkgjSq18PXpUxOL4I0iS1+","js/regular.js":"sha384-J0ggktpCvzBHSxd/a8EBQgQDIWBtASK5rhHMvGWuR/UyjuPgX0iCAcb3OlfhvlQz","js/fontawesome.js":"sha384-sBtO3o3oG61AtAKrg74kfk50JP0YHcRTwOXgTeUobbJJBgYiCcmtkh784fmHww23","js/brands.js":"sha384-68dqWCRgViK/UsBTW5vGfntS6GdBDT5D4KWUBXTf6IkF2NFFD+X/0QNs0FZaIELt","js/all.js":"sha384-4OPaVeLgwRHdGJplmRGxGcoGYwxBAdR8Qr9z/Av7blRYPlRIPtjTygdtpQlD1HHv","css/svg-with-js.css":"sha384-bnoXyQHIAXdkrtQTtvuajtPgmWqHQ8657dQ4vzySapygDMqzijBpEq96AwgX2u4N","css/solid.css":"sha384-ioYc/tyAAvPTKdlEWH/BDO/Fn0RGAWisNzyfZNt74mHfA6UPN2tzjD6Nm4ieQfBR","css/regular.css":"sha384-cDXlx+8npD3wa2ahyeSZvsi9VlRrMmJVIB1rpK7Ftyq4cppWM9d2mBhrlOqYBljt","css/fontawesome.css":"sha384-l2oTZy4pLseT/J6oW0mwsjKPhjpTctOfU191uVonzezZiqw9PPcz4AMKsIAeyR4P","css/brands.css":"sha384-J6h7hpR0mfr79Ck/ZfDrhN14FnkbkLbd+mm0yTw5spSpK08yOK/AB9IRR/Dcg8EJ","css/all.css":"sha384-KFTzeUQSHjcfuC8qqdFm+laWVqpkucx/3uXo41hhKQzUEtbNnNSk8KEEBZ+2lEQy"}},"is-latest":false,"icon-count":{"pro":1276,"free":907},"download":{"separates_web_desktop":false},"date":"2018-01-08T00:00:00"}},{"type":"releases","links":{"self":"/api/releases/"},"id":"","attributes":{"version":"5.0.4","sri":{"pro":{"js/v4-shims.js":"sha384-8XZ16R7aSGin4NRuv6gn5xfbsvad5H8LR41g48iduwkfZEqDgXlvUjkJKgxqZUiW","js/solid.js":"sha384-WJDZ/GI6pz1VoELs6i44T3f00fguksrLXIx3LXHdlaAzmOvX/mTK5j+qzHJdKejC","js/regular.js":"sha384-YzSStfq1m16y1v5M97ViNRpiQUCVpagVVOkqlmww8otyjFkY6EXT4dShlKNuxRDu","js/light.js":"sha384-iXxa9ExuZ0Fi2N2VO/buuWuAgYIUXNtOaJiKLa40Bjt43KJpzJdhg2TBHyBVqCPh","js/fontawesome.js":"sha384-7L9/YJQEf9kLPc6sdtoVIsuBNxCVi4OmHPcszcY685IJIcB52hgYoL1OiwTawJS/","js/brands.js":"sha384-/877azmwW/YhoBsPeM9dh61dNr5XGbuk24lyjPbFWyrPaZPyU2oxgOY6PE1OH4z4","js/all.js":"sha384-vV0064GQjt+TcoZxVPm/f6vyAivSNofFvOHKLWxcDl784Dzm9W4BBpoTvUG4vi5a","css/svg-with-js.css":"sha384-rHay3RzsgCtbjvDmBLThu6ESXlU4Al5STjlHSpNygnbeyt04OP1uKZVXB2Zy16+T","css/solid.css":"sha384-TlWtvBj4TXNlpJC5Qq4aHel0R/dywVcP/6eOFC0qptQ71WWSxJCvuTajjGb1duS9","css/regular.css":"sha384-eyjlqgvgpHiWM0GoL4/hsTh22piTKmMTM+sfJYacddG2n9AEubqQB/w4CPJK1/1b","css/light.css":"sha384-4FGoKudkcpRXgx5UNFa5TxzaHUhnvCGFDeZKncEn9KJx/l07kcid3VbpwajrvrFW","css/fontawesome.css":"sha384-VFi8UvBDvM8muKO8ogMXi2j8vdJiu8hq1uxpX/NS8BsftBiJpheM5AuhFH1dvURx","css/brands.css":"sha384-sFwP5Zsnp6I4zQxUMPHvv8Bk16eEzU0YhaNbMCftDHPKDD+BR8WdXAHKL4xpipII","css/all.css":"sha384-1RxicL8bcQJWgpr/clvtGVG7DVFJvDX/DVsJsbjKhXtdo8r5WVZQqB9AHTNPr08A"},"free":{"js/v4-shims.js":"sha384-yfrMPoFcXUzdvECrvYRYE7wlxouXxjRSge5x6BlPPOb38tW4n0e8EW79RGU7VY0R","js/solid.js":"sha384-4KkAk2UXMS9Xl3FoAAN43VJxRZ/emjElCz60xUTegPOZlbPLZGylvor2v7wQ0JNb","js/regular.js":"sha384-lwwoO5Gg19TptbILrLBjV28EVJ9RW3tD3cGyjCRn3OY9IuLua/YRlE47btZIXfMv","js/fontawesome.js":"sha384-l7FyBM+wFIWpfmy8RYkWgEu/Me6Hrz98ijLu4nP3PkGbTtTCvtHB5ktI8hLEgEG3","js/brands.js":"sha384-dl3ONr32uA3YqpqKWzhXLs5k1YbKOn3dwiMbEP1S/XQMa3LPRwvJrhW7+lomL/uc","js/all.js":"sha384-nVi8MaibAtVMFZb4R1zHUW/DsTJpG/YwPknbGABVOgk5s6Vhopl6XQD/pTCG/DKB","css/svg-with-js.css":"sha384-MCR8qGTbdyK+hklwz1eKgGiAjT57F5HEJMs/uHRAwZ6GI5602TyGI89FyrbUwiIc","css/solid.css":"sha384-g2aKxiZcFezoVOq4MsjaxuBbSxSlXD/NRQ5GaPLfvCtcTLgP3fYZKKAGxCM/wMfe","css/regular.css":"sha384-nM5tBytXTc1HDZ/A3My2gNT2TxLk/M/5yFi0QrOxaZjBi7QpKUfA2QqT+fcSxSlg","css/fontawesome.css":"sha384-xdTUmhbcetyLRVL4PAriRajOve+/5pjOiy5sJABnhXMcRMVc9HI9s2KmOCjjDK/P","css/brands.css":"sha384-1beec9tTZuu+KrTudmvRnGpK81r78DKCAXdphCvdG+PR+n/WCczsYPqTBTvYsM7z","css/all.css":"sha384-DmABxgPhJN5jlTwituIyzIUk6oqyzf3+XuP7q3VfcWA2unxgim7OSSZKKf0KSsnh"}},"is-latest":false,"icon-count":{"pro":1276,"free":907},"download":{"separates_web_desktop":false},"date":"2018-01-10T00:00:00"}},{"type":"releases","links":{"self":"/api/releases/"},"id":"","attributes":{"version":"5.0.6","sri":{"pro":{"js/v4-shims.js":"sha384-X9eLyweB0LOTEGCwMARo9+zibrXQYmBMSrhFk4ncpT/WYnPIcpTg0IgBFDgzuPwL","js/solid.js":"sha384-R/e3QvpS9m8HcN9b9l6nNo678ekTXL31kFY/XtRHSjrihDX8A2DF8HaXhdlAtzMx","js/regular.js":"sha384-M8TFIPAJNl8UIC8OP6GFcIE0SHkGN4zjwwjz+BBTz60XhNegOrZmjNtTQNKifmXX","js/light.js":"sha384-jzS22FYPy68IBBet2IRM5aQDOXjg9X1g+drXIVonDtyqGFCtUA0YIdgHdvCCX/fD","js/fontawesome.js":"sha384-Ln5PcCmuH8v+AF9nt+HkM2GfXjsn1CtVc0n+ciM8+oe3nwGyPCceDVva7bUjNfo0","js/brands.js":"sha384-G12tjfNd/W8L4IrE5+f13LUbpzVowwhNDv+WNecvxjbaGN9bbSY7epBOqUlRqXnq","js/all.js":"sha384-FrB6Se1Wkxlx66xA4rPuOoOolLyQt5B1uptDmtLJSIVRJDbNkmE3QOLipnMuAbUW","css/svg-with-js.css":"sha384-BptPo+4C0N+fnMTnfw7ddW/zYUJhuNEe7edve8UrMbs+fCpfDJvJcC/lpa5Nvaky","css/solid.css":"sha384-uBARwTxpZ7FB08kQlCOS/dUaN3TrGGcHthrXYIhZBpdq7YtUdVDM1sAUH9NIozMl","css/regular.css":"sha384-CydLcYoDSbudHX/6hygyQD4jBMPsv91d/RwdtH1qxI79KG8kII/OzxKDwsswywA4","css/light.css":"sha384-YWWfxaKIDrbFXuVQnpxASJDHmFl2K5f2vDgrcROb+rYycoqcQVdMlfu3U38boTg/","css/fontawesome.css":"sha384-sATKZbJwxaEIU3unIoL1VMbIyrNNh7PlgnaiWlicWXeRA7qdnzfFzMP9AaN2wfTU","css/brands.css":"sha384-Ks7IvHjmJ4FIFxhK4iNrtW0rAVo1DlCYpe/nDsK8CnU+yactd38YiNE1GT018WPg","css/all.css":"sha384-ldFHeX3xCFvM4uf7m0mCMIoCPVwM71jopwqLZRldf+ojynoGVSxDiphfScLukkwO"},"free":{"js/v4-shims.js":"sha384-L8zntmMOcCbOxXiL5Rjn6ubB7KunZiQ8U3bb9x6FFTGDEvVEESW9n+x49jm34K3W","js/solid.js":"sha384-U0ZJ7q5xbT8hEoRqj61HzpvsqNOQ8bsHY2VqSRPqGOzjHXmmV70Aw+DBC/PT00p4","js/regular.js":"sha384-G375DXNEVfALvsggywPWDYrRxNOvXaCYt/kiq/GXmbaDW8/B0XtbC8iuLpXXm1jF","js/fontawesome.js":"sha384-rttr/ldR2uHigckjTCjMDe47ySeFVaL3Q7xUkJZir56u8Z8h/XnHJXHocgyfb25F","js/brands.js":"sha384-4iSpDug9fizYiQRPpPafdAh5NaF8yzNMjOvu3veWgaFm0iIo8y4vUi7f3Yyz5WP1","js/all.js":"sha384-0AJY8UERsBUKdWcyF3o2kisLKeIo6G4Tbd8Y6fbyw6qYmn4WBuqcvxokp8m2UzSD","css/svg-with-js.css":"sha384-U2b24h7gWqOYespg+vI5yiIn4ZYlTevT0N96xkGrw7ktP1gg9XwqEslsdTLJdlGg","css/solid.css":"sha384-GfC9nfESTZkjCPFbevBVig3FTd6wkjRRYMtj+qFgK8mMBvGIje2rrALgiBy6pwRL","css/regular.css":"sha384-HGbVnizaFNw8zW+vIol9xMwBFWdV7/k61278Zo1bnMy9dLmjv48D7rtpgYRTe5Pd","css/fontawesome.css":"sha384-dbkYY2NmVwxaFrr4gq04oVh6w39ovmevsgD80Il1Od3hwpgREqyPb3XqbpaSwN4x","css/brands.css":"sha384-rK0EPNdv8UCeRNPzX+96ARRlf9hZM+OukGceDTdbPH30DYcSI1x5QyBU7d2I2kHX","css/all.css":"sha384-VY3F8aCQDLImi4L+tPX4XjtiJwXDwwyXNbkH7SHts0Jlo85t1R15MlXVBKLNx+dj"}},"is-latest":false,"icon-count":{"pro":1387,"free":929},"download":{"separates_web_desktop":false},"date":"2018-01-25T00:00:00"}},{"type":"releases","links":{"self":"/api/releases/"},"id":"","attributes":{"version":"5.0.8","sri":{"pro":{"js/v4-shims.js":"sha384-w/sFNq23wbOXJOUpFyISABLXk9tA4Z8r9hl80er2mobEwgS7VXXYDANaWyrCWe3/","js/solid.js":"sha384-jTxqWCb7UqRDQDd2Nkuh5BkHe9k+ElbFLa3NaJfid5kBK/+cVktzVRXrw0isFWxf","js/regular.js":"sha384-SIp/+zr0hyfSVIQPkAwB/L1h4fph6T3CmU4mE7IFtGJlgwoCko0Bye/1J0sjyh4v","js/light.js":"sha384-mfSnp84URDGC1t+cg63LgVKwEs63ulRUpjNneyDZMGMAE9ZKUNZ85rMBMHucGLYP","js/fontawesome.js":"sha384-Ht3fAeBiX/rVmKVyMwONAIIt0aRoPzZgq1FzdRgR9zFo+Kcd8YDwUbFlTItfaYW4","js/brands.js":"sha384-gJijC/2qM/p3zm2wHECHX1OMLdzlu61sNp7YfmFQxo+OyT9hO1orX7MmnHhaoXQ4","js/all.js":"sha384-816IUmmhAwCMonQiPZBO/PTgzgsjHtpb78rpsLzldhb4HZjFzBl06Z3eu4ZuwHTz","css/svg-with-js.css":"sha384-b2wDmqWyAwmI2rS5ut5UweBS1V32L/k1+2Oo7eCaHdXOS/1bFwC8AKevTI6N28LN","css/solid.css":"sha384-+iHwwKZGTdlVFbv4fsKmLkogfdKlp47zQGkSMDN3ANc8kXjyKudKvQwinI5VH+2C","css/regular.css":"sha384-0w6MzzKHIB9cUlfWSmSp1Pj6XqGGDseWSMz1Yppk3UOc1dhYhpFx1AuCkMBECEvC","css/light.css":"sha384-shmfBA2CRxp88gq8NcvWbEN8KExYU4uvQUBEG36BStGZ5k91nGKE4wDvvWvuimbu","css/fontawesome.css":"sha384-+5VkSw5C1wIu2iUZEfX77QSYRb5fhjmEsRn8u4r9Ma8mvu/GvTag4LDSEAw7RjXl","css/brands.css":"sha384-VRONz34zTLl4P+DLYyJ8kP8C3tB1PGtqL5p8nBAvHuoc1u32bR3RHixrjffD8Fly","css/all.css":"sha384-OGsxOZf8qnUumoWWSmTqXMPSNI9URpNYN35fXDb5Cv5jT6OR673ah1e5q+9xKTq6"},"free":{"js/v4-shims.js":"sha384-4CnzNxEP5RK316IYY2+W4hc05uJdfd+p9iNVeNG9Ws3Qxf5tKolysO9wu/8rloj2","js/solid.js":"sha384-+Ga2s7YBbhOD6nie0DzrZpJes+b2K1xkpKxTFFcx59QmVPaSA8c7pycsNaFwUK6l","js/regular.js":"sha384-t7yHmUlwFrLxHXNLstawVRBMeSLcXTbQ5hsd0ifzwGtN7ZF7RZ8ppM7Ldinuoiif","js/fontawesome.js":"sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c","js/brands.js":"sha384-sCI3dTBIJuqT6AwL++zH7qL8ZdKaHpxU43dDt9SyOzimtQ9eyRhkG3B7KMl6AO19","js/all.js":"sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ","css/svg-with-js.css":"sha384-TGBI4yK0MJz2ga16RLBBt4xT4aoPMPmRYhfu1Kl5IJ0gsLyOBIKHEb49BtoO+lPS","css/solid.css":"sha384-v2Tw72dyUXeU3y4aM2Y0tBJQkGfplr39mxZqlTBDUZAb9BGoC40+rdFCG0m10lXk","css/regular.css":"sha384-A/oR8MwZKeyJS+Y0tLZ16QIyje/AmPduwrvjeH6NLiLsp4cdE4uRJl8zobWXBm4u","css/fontawesome.css":"sha384-q3jl8XQu1OpdLgGFvNRnPdj5VIlCvgsDQTQB6owSOHWlAurxul7f+JpUOVdAiJ5P","css/brands.css":"sha384-IiIL1/ODJBRTrDTFk/pW8j0DUI5/z9m1KYsTm/RjZTNV8RHLGZXkUDwgRRbbQ+Jh","css/all.css":"sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S"}},"is-latest":false,"icon-count":{"pro":1535,"free":946},"download":{"separates_web_desktop":false},"date":"2018-03-01T00:00:00"}},{"type":"releases","links":{"self":"/api/releases/"},"id":"","attributes":{"version":"5.0.9","sri":{"pro":{"js/v4-shims.js":"sha384-vuyo8HdrwozCl2DhHOJ40ytjEx9FGy0cqu8i5GHeIoSUm6MPgqCXAVoUIsudKfuE","js/solid.js":"sha384-nISI3wKDp2gWn9L91zXOKXZ6JPt2mteGTnaJAMfeNgAoeLKl2AQsWLH69HMmBXHa","js/regular.js":"sha384-C6h/8oKUfY6cVuGfFSu9uGIlFkaD1u1j+ByYGFTdFbOpHOHpw39lKxqEpRgLQg6A","js/light.js":"sha384-06sraYAcw8BzUjsPn5z8Qi/QAA2/ZJl5GN3LGtRp7k+tZpu7kw+sRNXDDTU4RkOt","js/fontawesome.js":"sha384-8QYlVHotqQzcAVhJny7MO9ZR0hASr6cRCpURV+EobTTAv5wftkn4i+U6UrMqoCis","js/brands.js":"sha384-yIJb2TJeTM04vupX+3lv0Qp9j0Pnk8Qm9UPYlXr3H0ROCHNNLoacpS++HWDabbzi","js/all.js":"sha384-DtPgXIYsUR6lLmJK14ZNUi11aAoezQtw4ut26Zwy9/6QXHH8W3+gjrRDT+lHiiW4","css/svg-with-js.css":"sha384-yVUvm1bVSmayKKt0YHPKotNQzlBvgNhEBbQ6U1d38bjpapXMVmE+SLXrpQ9td4Ij","css/solid.css":"sha384-k8v16DuQ4ZFtRfpTeqTW4tcHIj5tkvUNQm1QiLs90XiToLzyFeV+yxujHjSZ2wim","css/regular.css":"sha384-hJbmKHxbgrH79UtKxubo1UTe96bOL4Xfhjaqr0csD1UMPEPbeV+446QAC+IGxY+b","css/light.css":"sha384-wD8IB6DSQidXyIWfwBrsFwTaHTQDsgzyeqzhd1jNdBZHvGSa7KRGb6Q5sMlroCyk","css/fontawesome.css":"sha384-31qpW3hduWGiGey9tdI9rBBxiog5pxZbPiAlD6YKIgy0P2V1meprKhvpk+xJDkMw","css/brands.css":"sha384-+LMmZxgyldhNCY6nei3oAWJjHbpbROtVb+f5Ux/nahA+Xjm3wcNdu7zyB39Yj38S","css/all.css":"sha384-L+XK540vkePe55E7PAfByfvW0XpsyYpsifTpgh/w8WvH6asVg/c2zqp0EfZfZTbF"},"free":{"js/v4-shims.js":"sha384-9f5gaI9TkuYhi5O/inzfdOXx2nkIhDsLtXqBNmtY6/c5PoqXfd0U2DAjqQVSCXQh","js/solid.js":"sha384-P4tSluxIpPk9wNy8WSD8wJDvA8YZIkC6AQ+BfAFLXcUZIPQGu4Ifv4Kqq+i2XzrM","js/regular.js":"sha384-BazKgf1FxrIbS1eyw7mhcLSSSD1IOsynTzzleWArWaBKoA8jItTB5QR+40+4tJT1","js/fontawesome.js":"sha384-2IUdwouOFWauLdwTuAyHeMMRFfeyy4vqYNjodih+28v2ReC+8j+sLF9cK339k5hY","js/brands.js":"sha384-qJKAzpOXfvmSjzbmsEtlYziSrpVjh5ROPNqb8UZ60myWy7rjTObnarseSKotmJIx","js/all.js":"sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl","css/svg-with-js.css":"sha384-Hl6tZnMfNiJHYyFxpmnRV8+pziARxY3X/4XWfFXldG7sdkkLv+Od2Gpc57P7C1g6","css/solid.css":"sha384-29Ax2Ao1SMo9Pz5CxU1KMYy+aRLHmOu6hJKgWiViCYpz3f9egAJNwjnKGgr+BXDN","css/regular.css":"sha384-seionXF7gEANg+LFxIOw3+igh1ZAWgHpNR8SvE64G/Zgmjd918dTL55e8hOy7P4T","css/fontawesome.css":"sha384-Lyz+8VfV0lv38W729WFAmn77iH5OSroyONnUva4+gYaQTic3iI2fnUKtDSpbVf0J","css/brands.css":"sha384-ATC/oZittI09GYIoscTZKDdBr/kI3lCwzw3oBMnOYCPVNJ4i7elNlCxSgLfdfFbl","css/all.css":"sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1"}},"is-latest":false,"icon-count":{"pro":1718,"free":989},"download":{"separates_web_desktop":false},"date":"2018-03-27T00:00:00"}},{"type":"releases","links":{"self":"/api/releases/"},"id":"","attributes":{"version":"5.0.10","sri":{"pro":{"js/v4-shims.js":"sha384-H+U1wWQdWbEtuQPJ4ZpMl8yWydI6xc/306L/NZkpGY8BGpeSpu39V20x03S3xcMw","js/solid.js":"sha384-m3J/Wb6KcNkFJIpCugSSJITG80sKhEA+16UCFdq1LnpMTOCXwwpeyrE1FmyqoArv","js/regular.js":"sha384-QNGmoJVI8f07j7N4+DSn4Cdob1PTBJOR6jRGwUwqSPyL2HmvWaBPXuSXOcStGo9D","js/light.js":"sha384-rv/n2A+UxOzR1qs4wrcOtJ7Ai5Hcn3QQ8tvEkOo5lCvqCD3xwpeO3KZP18JpSXr3","js/fontawesome.js":"sha384-TxXqLyCP6HYGVtr9V1M1rQE7IMbBEZoDdOX+MFeYNbWNwopWKVQM8NyqtU2x+5t2","js/brands.js":"sha384-OwdVp9K/baqiXthTvRnYzMcsTaqwG19SfDkTRc/GBIhK9eYlWVVBEvLlueA0STAP","js/all.js":"sha384-+1nLPoB0gaUktsZJP+ycZectl3GX7wP8Xf2PE/JHrb7X1u7Emm+v7wJMbAcPr8Ge","css/svg-with-js.css":"sha384-S/uB02cfkgX8kd+j6f3gmw/PPTg8xSiE/w6d8dE852PzHXkGBYLrqpWFse9hInR2","css/solid.css":"sha384-WjYgBJXUWNFTzFd4wNJuzUZx28GSgjzXrPO4LJrng96HFrI/nLrG1R5NET65v1yR","css/regular.css":"sha384-D4yOV+i5oKU6w8CiadBDVtSim/UXmlmQfrIdRsuKT3nYhiF/Tb6YLQtyF9l0vqQF","css/light.css":"sha384-k/d3hya1Xwx/V3yLAr7/6ibFaFIaN+xeY1eIv42A1Bn2HgfB+/YjLscji1sHLOkb","css/fontawesome.css":"sha384-HE+OCjOJOPZavEcVffA6E24sIfY2RwV4JRieXa/3N5iCY8vgnTwZemElENQ8ak/K","css/brands.css":"sha384-cyAsyPMdnj21FGg6BEGfZdZ99a/opKBeFa8z5VoHPsPj+tLRYSxkRlPWnGkCJGyA","css/all.css":"sha384-KwxQKNj2D0XKEW5O/Y6haRH39PE/xry8SAoLbpbCMraqlX7kUP6KHOnrlrtvuJLR"},"free":{"js/v4-shims.js":"sha384-RLvgmog5EsZMMDnT3uJo6ScffPHTtMbhtV8pcT8kP5UJzlVRU1SP9Hccelk3zYZc","js/solid.js":"sha384-Q7KAHqDd5trmfsv85beYZBsUmw0lsreFBQZfsEhzUtUn5HhpjVzwY0Aq4z8DY9sA","js/regular.js":"sha384-JWLWlnwX0pRcCBsI3ZzOEyVDoUmngnFnbXR9VedCc3ko4R3xDG+KTMYmVciWbf4N","js/fontawesome.js":"sha384-M2FSA4xMm1G9m4CNXM49UcDHeWcDZNucAlz1WVHxohug0Uw1K+IpUhp/Wjg0y6qG","js/brands.js":"sha384-6jhVhr5a+Z1nLr9h+fd7ocMEo847wnGFelCHddaOOACUeZNoQwFXTxh4ysXVam8u","js/all.js":"sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+","css/svg-with-js.css":"sha384-ucawWSvpdgQ67m4VQzI6qBOHIsGRoY2soJtCkkp15b6IaNCLgauWkbKR8SAuiDQ7","css/solid.css":"sha384-HTDlLIcgXajNzMJv5hiW5s2fwegQng6Hi+fN6t5VAcwO/9qbg2YEANIyKBlqLsiT","css/regular.css":"sha384-R7FIq3bpFaYzR4ogOiz75MKHyuVK0iHja8gmH1DHlZSq4tT/78gKAa7nl4PJD7GP","css/fontawesome.css":"sha384-8WwquHbb2jqa7gKWSoAwbJBV2Q+/rQRss9UXL5wlvXOZfSodONmVnifo/+5xJIWX","css/brands.css":"sha384-KtmfosZaF4BaDBojD9RXBSrq5pNEO79xGiggBxf8tsX+w2dBRpVW5o0BPto2Rb2F","css/all.css":"sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg"}},"is-latest":false,"icon-count":{"pro":1718,"free":991},"download":{"separates_web_desktop":false},"date":"2018-04-10T00:00:00"}},{"type":"releases","links":{"self":"/api/releases/"},"id":"","attributes":{"version":"5.0.12","sri":{"pro":{"js/v4-shims.js":"sha384-6+8zJP76v3EziONR2vMd32iSU3qbdicAE8KNp+NWniM6mBmvN80NlY+sbvCO+w7M","js/solid.js":"sha384-y//1Knkpeyl2S568g2ECqUA4n3MKf+kpj1/sfjUQbR1WtBPONceBHrQVMiAqfjLH","js/regular.js":"sha384-p/qo0lifpToZ0ubNiv1WFzlmYJU+BOenvU+evARCvCqALvbpZuqmZQ207vmYD6QL","js/light.js":"sha384-z7YlG414oqy0TO7qY/nGfC8zd1LL8JAX3iNQ3iLybUIziHzaMYqBwUvhizEwV0Fd","js/fontawesome.js":"sha384-CUrLKzrygRugRUPtEJ1u4nV4Ec6GnuDMRDGaxfoFXLI+sraWS6rqGg2Sjfs6BTet","js/brands.js":"sha384-QlvHmHtevrYI4s/vdiK6chTDouw2pRA5av6ZLVtENubkoCgSZz4ZaXVvplQ1FRPs","js/all.js":"sha384-quzri7saio48xMf3ED3HiI5YaItt68Q+0J3qc9EIfk1jk3QqCJhS24l6CZpUGfEe","css/svg-with-js.css":"sha384-ubRAMbpAKC+ULwg5mkUQLFReIXq1yeiKIcfV7cYp+rEaeINfEglYX6JOte80PCDk","css/solid.css":"sha384-KY40QRrgoQAM9BPN+gm7JoK30M/P6QqKRCbXUS3uWbPfycyiVeEsPkGNMhcNL3DU","css/regular.css":"sha384-tYZB+BP2inzRg01pQhSlW4Tloc0ULXYGiBaf5kSB5Tb3+l84bJy+PKerqziKz3iv","css/light.css":"sha384-PWGGmWk9+xVydf1Gzso0ouaikBBKLu4nCY52q+tBUMq5iXmRhpgTuDkjbtxZ1rXT","css/fontawesome.css":"sha384-ZDxYpspDwfEsC0ZJDb74i/Rqjb1CnX3a69Dz9vXv4PvvlTEkgMI02TATTRNJoZ06","css/brands.css":"sha384-M4owBK0KiG0Vz+G5z/8v8tBb1+w9ts66Z6xKkZEPgBwzISkrcNra4GxZcvJPyaGB","css/all.css":"sha384-HX5QvHXoIsrUAY0tE/wG8+Wt1MwvaY28d9Zciqcj6Ob7Tw99tFPo4YUXcZw9l930"},"free":{"js/v4-shims.js":"sha384-STc8Gazx86A+NmeBWQTqa5Ob1wGSRQZevexYiUkKdiqZhi5LSZ28XYAvgptHK5HH","js/solid.js":"sha384-652/z7yNdGONCCBu0u5h5uF9voJhBdgruAuIDVheEaQ7O/ZC9wyyV+yZsYb32Wy7","js/regular.js":"sha384-6XNKyHeL6pEPXURVNSKQ0lUP80a5FHqN0oFqSSS8Qviyy2u0KmCMJlQ5iLiAAPBg","js/fontawesome.js":"sha384-6AOxTjzzZLvbTJayrLOYweuPckqh0rrB4Sj+Js8Vzgr85/qm2e0DRqi+rBzyK52J","js/brands.js":"sha384-BPIhZF7kZGuZzBS4SP/oIqzpxWuOUtsPLUTVGpGw+EtB1wKt1hv63jb2OCroS3EX","js/all.js":"sha384-Voup2lBiiyZYkRto2XWqbzxHXwzcm4A5RfdfG6466bu5LqjwwrjXCMBQBLMWh7qR","css/svg-with-js.css":"sha384-N44Xrku5FaDiZLZ8lncIZLh+x9xiqk1r0NTlUJQ5xanSpdORyQHP4Zp2WQJ9GlpJ","css/solid.css":"sha384-VxweGom9fDoUf7YfLTHgO0r70LVNHP5+Oi8dcR4hbEjS8UnpRtrwTx7LpHq/MWLI","css/regular.css":"sha384-RGDxJbFQcd3/Rei8rYb+3xO3YREd0abxm8WfLkYj7j4HHo5ZVuNUGVx8H8GbpFTQ","css/fontawesome.css":"sha384-rnr8fdrJ6oj4zli02To2U/e6t1qG8dvJ8yNZZPsKHcU7wFK3MGilejY5R/cUc5kf","css/brands.css":"sha384-Pln/erVatVEIIVh7sfyudOXs5oajCSHg7l5e2Me02e3TklmDuKEhQ8resTIwyI+w","css/all.css":"sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9"}},"is-latest":false,"icon-count":{"pro":1748,"free":1043},"download":{"separates_web_desktop":false},"date":"2018-05-03T00:00:00"}},{"type":"releases","links":{"self":"/api/releases/"},"id":"","attributes":{"version":"5.0.13","sri":{"pro":{"js/v4-shims.js":"sha384-LDfu/SrM7ecLU6uUcXDDIg59Va/6VIXvEDzOZEiBJCh148mMGba7k3BUFp1fo79X","js/solid.js":"sha384-CucLC75yxFXtBjA/DCHWMS14abAUhf5HmFRdHyKURqqLqi3OrLsyhCyqp83qjiOR","js/regular.js":"sha384-1bAvs6o5Yb7MMzvTI3oq2qkreCQFDXb6KISLBhrHR+3sJ/mm7ZWfnQVRwScbPEmd","js/light.js":"sha384-+iGqamqASU/OvBgGwlIHH6HSEgiluzJvTqcjJy8IN9QG9aUfd0z0pKpTlH7TpU7X","js/fontawesome.js":"sha384-BUkEHIKZJ0ussRY3zYfFL7R0LpqWmucr9K38zMTJWdGQywTjmzbejVSNIHuNEhug","js/brands.js":"sha384-44Hl7UlQr9JXHFcZOp9qWHk2H1lrsAN/cG3GNgB2JqbciecuJ2/B9sjelOMttzBM","js/all.js":"sha384-d84LGg2pm9KhR4mCAs3N29GQ4OYNy+K+FBHX8WhimHpPm86c839++MDABegrZ3gn","css/svg-with-js.css":"sha384-8YpCivPy+AkMdZ0uAvEP04Gs77AN/6mS5AmZqkCwniP51zSG8rCMaH06OYuC4iXd","css/solid.css":"sha384-drdlAcijFWubhOfj9OS/gy2Gs34hVhVT90FgJLzrldrLI+7E7lwBxmanEEhKTRTS","css/regular.css":"sha384-HLkkol/uuRVQDnHaAwidOxb1uCbd78FoGV/teF8vONYKRP9oPQcBZKFdi3LYDy/C","css/light.css":"sha384-d8NbeymhHpk+ydwT2rk4GxrRuC9pDL/3A6EIedSEYb+LE+KQ5QKgIWTjYwHj/NBs","css/fontawesome.css":"sha384-LDuQaX4rOgqi4rbWCyWj3XVBlgDzuxGy/E6vWN6U7c25/eSJIwyKhy9WgZCHQWXz","css/brands.css":"sha384-t3MQUMU0g3tY/0O/50ja6YVaEFYwPpOiPbrHk9p5DmYtkHJU2U1/ujNhYruOJwcj","css/all.css":"sha384-oi8o31xSQq8S0RpBcb4FaLB8LJi9AT8oIdmS1QldR8Ui7KUQjNAnDlJjp55Ba8FG"},"free":{"js/v4-shims.js":"sha384-qqI1UsWtMEdkxgOhFCatSq+JwGYOQW+RSazfcjlyZFNGjfwT/T1iJ26+mp70qvXx","js/solid.js":"sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ","js/regular.js":"sha384-IJ3h7bJ6KqiB70L7/+fc44fl+nKF5eOFkgM9l/zZii9xs7W2aJrwIlyHZiowN+Du","js/fontawesome.js":"sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY","js/brands.js":"sha384-G/XjSSGjG98ANkPn82CYar6ZFqo7iCeZwVZIbNWhAmvCF2l+9b5S21K4udM7TGNu","js/all.js":"sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe","css/svg-with-js.css":"sha384-LAtyQAMHxrIJzktG06ww5mJ0KQ+uCqQIJFjwj+ceCjUlZ2jkLwJZt1nBGw4KaFEZ","css/solid.css":"sha384-Rw5qeepMFvJVEZdSo1nDQD5B6wX0m7c5Z/pLNvjkB14W6Yki1hKbSEQaX9ffUbWe","css/regular.css":"sha384-EWu6DiBz01XlR6XGsVuabDMbDN6RT8cwNoY+3tIH+6pUCfaNldJYJQfQlbEIWLyA","css/fontawesome.css":"sha384-GVa9GOgVQgOk+TNYXu7S/InPTfSDTtBalSgkgqQ7sCik56N9ztlkoTr2f/T44oKV","css/brands.css":"sha384-VGCZwiSnlHXYDojsRqeMn3IVvdzTx5JEuHgqZ3bYLCLUBV8rvihHApoA1Aso2TZA","css/all.css":"sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"}},"is-latest":false,"icon-count":{"pro":1877,"free":1109},"download":{"separates_web_desktop":false},"date":"2018-05-10T00:00:00"}},{"type":"releases","links":{"self":"/api/releases/"},"id":"","attributes":{"version":"5.1.0","sri":{"pro":{"js/v4-shims.js":"sha384-9gfBAY6DS3wT0yuvYN1aaA1Q9R0fYQHliQWLChuYDWJJ0wQJpoNZrzlcqd4+qqny","js/solid.js":"sha384-q6QALO/4RSDjqnloeDcGnkB0JdK3MykIi6dUW5YD66JHE3JFf8rwtV5AQdYHdE0X","js/regular.js":"sha384-S21AhcbZ5SXPXH+MH7JuToqmKYXviahLaD1s9yApRbu1JDiMjPBGQIw/3PCHKUio","js/light.js":"sha384-77i21WTcIcnSPKxwR794RLUQitpNqm6K3Fxsjx8hgoc3ZZbPJu5orgvU/7xS3EFq","js/fontawesome.js":"sha384-ckjcH5WkBMAwWPjTJiy7K2LaLp37yyCVKAs3DKjhPdo0lRCDIScolBzRsuaSu+bQ","js/brands.js":"sha384-QPbiRUBnwCr8JYNjjm7CB0QP9h4MLvWUZhsChFX6dLzRkY22/nAxVYqa5nUTd6PL","js/all.js":"sha384-E5SpgaZcbSJx0Iabb3Jr2AfTRiFnrdOw1mhO19DzzrT9L+wCpDyHUG2q07aQdO6E","css/v4-shims.css":"sha384-2RBBYH6GaI11IJzJ6V1eL7kXXON+epoQIt+HqpzQdBrtyT7gNwKPDxo2roxUbtW9","css/svg-with-js.css":"sha384-/h6SKuA/ysT91EgYEGm9B6Z6zlaxuvKeW/JB7FWdGwCFalafxmGzJE2a63hS1BLm","css/solid.css":"sha384-rvfDcG9KDoxdTesRF/nZ/sj8CdQU+hy6JbNMwxUTqpoI2LaPK8ASQk6E4bgabrox","css/regular.css":"sha384-6kuJOVhnZHzJdVIZJcWiMZVi/JwinbqLbVxIbR73nNqXnYJDQ5TGtf+3XyASO4Am","css/light.css":"sha384-ANTAgj8tbw0vj4HgQ4HsB886G2pH15LXbruHPCBcUcaPAtn66UMxh8HQcb1cH141","css/fontawesome.css":"sha384-PnWzJku7hTqk2JREATthkLpYeVVGcBbXG5yEzk7hD2HIr/VxffIDfNSR7p7u4HUy","css/brands.css":"sha384-C1HxUFJBptCeaMsYCbPUw8fdL2Cblu3mJZilxrfujE+7QLr8BfuzBl5rPLNM61F6","css/all.css":"sha384-87DrmpqHRiY8hPLIr7ByqhPIywuSsjuQAfMXAE0sMUpY3BM7nXjf+mLIUSvhDArs"},"free":{"js/v4-shims.js":"sha384-3qT9zZfeo1gcy2NmVv5dAhtOYkj91cMLXRkasOiRB/v+EU3G+LZUyk5uqZQdIPsV","js/solid.js":"sha384-Z7p3uC4xXkxbK7/4keZjny0hTCWPXWfXl/mJ36+pW7ffAGnXzO7P+iCZ0mZv5Zt0","js/regular.js":"sha384-Y+AVd32cSTAMpwehrH10RiRmA28kvu879VbHTG58mUFhd+Uxl/bkAXsgcIesWn3a","js/fontawesome.js":"sha384-juNb2Ils/YfoXkciRFz//Bi34FN+KKL2AN4R/COdBOMD9/sV/UsxI6++NqifNitM","js/brands.js":"sha384-ZqDZAkGUHrXxm3bvcTCmQWz4lt7QGLxzlqauKOyLwg8U0wYcYPDIIVTbZZXjbfsM","js/all.js":"sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9","css/v4-shims.css":"sha384-epK5t6ciulYxBQbRDZyYJFVuWey/zPlkBIbv6UujFdGiIwQCeWOyv5PVp2UQXbr2","css/svg-with-js.css":"sha384-5aLiCANDiVeIiNfzcW+kXWzWdC6riDYfxLS6ifvejaqYOiEufCh0zVLMkW4nr8iC","css/solid.css":"sha384-TbilV5Lbhlwdyc4RuIV/JhD8NR+BfMrvz4BL5QFa2we1hQu6wvREr3v6XSRfCTRp","css/regular.css":"sha384-avJt9MoJH2rB4PKRsJRHZv7yiFZn8LrnXuzvmZoD3fh1aL6aM6s0BBcnCvBe6XSD","css/fontawesome.css":"sha384-ozJwkrqb90Oa3ZNb+yKFW2lToAWYdTiF1vt8JiH5ptTGHTGcN7qdoR1F95e0kYyG","css/brands.css":"sha384-7xAnn7Zm3QC1jFjVc1A6v/toepoG3JXboQYzbM0jrPzou9OFXm/fY6Z/XiIebl/k","css/all.css":"sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt"}},"is-latest":false,"icon-count":{"pro":2068,"free":1264},"download":{"separates_web_desktop":true},"date":"2018-06-20T00:00:00"}},{"type":"releases","links":{"self":"/api/releases/"},"id":"","attributes":{"version":"5.1.1","sri":{"pro":{"js/v4-shims.js":"sha384-rJQjFeDWQReL3KmIeV81jB594CgKx/MmXyAgiuu88Jo253P+PSMgWzivZQtR6N6J","js/solid.js":"sha384-PyvJtlnGBA/R+hfVbHbnzfeT8G/iTORqPhR5WKGTQXlfmLe5bV+d64NECHG4sIMa","js/regular.js":"sha384-Mw6yr+W+X+ckaAUbsPUb2BcU3Af9aSjmPMIlMr2iplN0VQIpscDWy/VwY5w0sz9w","js/light.js":"sha384-0rp6k6cJIuLV1ORowDSSKr4VbEqb664PQUWdBvhJyt6IfkshVb0r6UlOkX6yVdaI","js/fontawesome.js":"sha384-EWJRWU7LQt+ri8YtDjTr8adATyP7y8DwlpE8zruoUC4nHNjtWZMU+iPYK+tFaV3U","js/brands.js":"sha384-KCMfKsP/3VgeibBQRMu4bT+9041Hi2v9PIz9FLOPJBEvxCBklc4o7tRwwQu4FWsT","js/all.js":"sha384-cHcg4nvWPIGArJhEgL2F5e09Cn1GyPQpNYKbPatFCpDefCbezZjPA3PhLozKTZnv","css/v4-shims.css":"sha384-TUicmScQcYANFcc4OQKEX6V1Zek9o9t+dwW/2tZoXmSigBk9JqfHxZZFlSo+0oRl","css/svg-with-js.css":"sha384-++BmJ9x4V05AhCNnLr/RjPTY4BAFuhZsESUqH5hiwZspBvy7F+DRGvSH8tGHw9P/","css/solid.css":"sha384-Ux3tEr1RmnxCht2XbPkWWBuotwMVXKOe0PkWN/nmiD5CSV6Tyjl+Kr0J0iX1yd0q","css/regular.css":"sha384-AKIrAHbICIQF+NEqtykrcdzMjExDiKLa9hOyUVsr4PlHtktH7xaD10vO98UnPjuE","css/light.css":"sha384-EGKQAl6ZrGi/zGxZ4ykVhc/A3tFVeBiLnneETILtcxQnZpo7ejmb4BkNa3zSgo4K","css/fontawesome.css":"sha384-bHoj6f1b1CQ6zapOREeYBO/JnDjeV1fLuKn3KHnbqAAnkLva11KY3m8YyKPVXYLF","css/brands.css":"sha384-E5dVkWQIVhVPtBz/KK2TS7EM9l1+5XiWFPX7l3+5ayHPwDguGsHqof3GQbk55AS3","css/all.css":"sha384-xyMU7RufUdPGVOZRrc2z2nRWVWBONzqa0NFctWglHmt5q5ukL22+lvHAqhqsIm3h"},"free":{"js/v4-shims.js":"sha384-T69Lzd4bE7W8/vVrxvfsx45/AAKf6QmKEg5zSl0v9aZwo/pTKseq81mxdpARTQpx","js/solid.js":"sha384-GXi56ipjsBwAe6v5X4xSrVNXGOmpdJYZEEh/0/GqJ3JTHsfDsF8v0YQvZCJYAiGu","js/regular.js":"sha384-sAzYCvbTTKFOxT4VHu+ZjHRMXjvfjT6TAqOng28g4jba88Peg5+hkoVIqQKGjmj1","js/fontawesome.js":"sha384-NY6PHjYLP2f+gL3uaVfqUZImmw71ArL9+Roi9o+I4+RBqArA2CfW1sJ1wkABFfPe","js/brands.js":"sha384-0inRy4HkP0hJ038ZyfQ4vLl+F4POKbqnaUB6ewmU4dWP0ki8Q27A0VFiVRIpscvL","js/all.js":"sha384-BtvRZcyfv4r0x/phJt9Y9HhnN5ur1Z+kZbKVgzVBAlQZX4jvAuImlIz+bG7TS00a","css/v4-shims.css":"sha384-LCsPWAjCFLDeFHB5Y0SBIOqgC5othK8pIZiJAdbJDiN10B2HXEm1mFNHtED8cViz","css/svg-with-js.css":"sha384-EH3TEAKYd7R0QbCS4OFuYoEpaXITVg5c/gdZ/beEaAbRjMGVuVLLFjiIKOneCzGZ","css/solid.css":"sha384-S2gVFTIn1tJ/Plf+40+RRAxBCiBU5oAMFUJxTXT3vOlxtXm7MGjVj62mDpbujs4C","css/regular.css":"sha384-QNorH84/Id/CMkUkiFb5yTU3E/qqapnCVt6k5xh1PFIJ9hJ8VfovwwH/eMLQTjGS","css/fontawesome.css":"sha384-0b7ERybvrT5RZyD80ojw6KNKz6nIAlgOKXIcJ0CV7A6Iia8yt2y1bBfLBOwoc9fQ","css/brands.css":"sha384-SYNjKRRe+vDW0KSn/LrkhG++hqCLJg9ev1jIh8CHKuEA132pgAz+WofmKAhPpTR7","css/all.css":"sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ"}},"is-latest":false,"icon-count":{"pro":2067,"free":1265},"download":{"separates_web_desktop":true},"date":"2018-07-16T00:00:00"}},{"type":"releases","links":{"self":"/api/releases/"},"id":"","attributes":{"version":"5.2.0","sri":{"pro":{"js/v4-shims.js":"sha384-aoMjEUBUPf5GpXx1WJUeTZ/gBmGqQB1u8uUc2J5LW2xnQtJKkGulESZ+rkoj182s","js/solid.js":"sha384-1j3ph9Rf+Aaz6rrizz6cdFxU9ZbUyvkbiwQ5+T/BY4I5mk37vUpTA8S9ZZOlfdWu","js/regular.js":"sha384-8hKZY21U4J3r9N0GFl+24YnDkbRhs8y/nXT6BaZ+sOJDNmz+1DhFawE9UYL37XzB","js/light.js":"sha384-glAz6mCeiwAe/kHHHG/OvhrjA4+AH55ZfH8fwYp48YCY61POwUmOrH/oYOaF2Ujy","js/fontawesome.js":"sha384-FQUuiJxt9F0hPc9IP3M5ndmqK53iBCGcy4ZSx8QirhYOIs8l7x+e1/zdswyZEigi","js/brands.js":"sha384-eg9wHuvEPj6+GlGomBRaMHLF0QfCnjdASWDKd84DMeM9phhyDaPFou/nHJBt0bz+","js/all.js":"sha384-yBZ34R8uZDBb7pIwm+whKmsCiRDZXCW1vPPn/3Gz0xm4E95frfRNrOmAUfGbSGqN","css/v4-shims.css":"sha384-2QRS8Mv2zxkE2FAZ5/vfIJ7i0j+oF15LolHAhqFp9Tm4fQ2FEOzgPj4w/mWOTdnC","css/svg-with-js.css":"sha384-O6mvz45yC1vfdu/EgUxAoSGrP+sFtepMtj7eOQIW1G3WT9Sj5djActZC0hd/F42D","css/solid.css":"sha384-B/E/KxBX31kY/5sew+X4c8e6ErosbqOOsA3t4k6VVmx8Hrz//v0tEUtXmUVx9X6Q","css/regular.css":"sha384-g3XsWx0Sqi7JIjLKVnwUxEvqrxTMQPIf3PN+vTdWY2AhduP/rnj0rw89v0nbD4Ro","css/light.css":"sha384-pcDR01P1wNxsYZiEYdROCAYhU2u8VHOctLrYRonRFtkf/TGEQFWt0rqFbPGWlyn4","css/fontawesome.css":"sha384-4eP+1rYQmuI3hxrmyE+GT/EIiNbF4R85ciN3jMpmIh+bU5Hz2IU7AdcVe+JS+AJz","css/brands.css":"sha384-Ei2oxwH0wpwmp7KPdhYnajC5fWDdMENOjDw9OfzWvcFcOGn0Egy+L5AAculaqBbD","css/all.css":"sha384-TXfwrfuHVznxCssTxWoPZjhcss/hp38gEOH8UPZG/JcXonvBQ6SlsIF49wUzsGno"},"free":{"js/v4-shims.js":"sha384-rn4uxZDX7xwNq5bkqSbpSQ3s4tK9evZrXAO1Gv9WTZK4p1+NFsJvOQmkos19ebn2","js/solid.js":"sha384-YmNA3b9AQuWW8KZguYfqJa/YhKNTwGVD5pQc1cN0ZAVRudFFtR17HR7rooNcVXe4","js/regular.js":"sha384-YdSTwqfKxyP06Jj3UzTeumv8M+Pme60+KND4oF+5r5VeUCvdkw7NhSzFYWbe00ba","js/fontawesome.js":"sha384-QcnrgQuRmocjIBY6ByWMmDvUg3HO4MSdVjY7ynJwZfvTDhVPPQOUI9TRzc6/7ZO1","js/brands.js":"sha384-4BRtleJgTYsMKIVuV1Z7lNE29r4MxwKR7u88TWG2GaXsmSljIykt/YDbmKndKGID","js/all.js":"sha384-4oV5EgaV02iISL2ban6c/RmotsABqE4yZxZLcYMAdG7FAPsyHYAPpywE9PJo+Khy","css/v4-shims.css":"sha384-W14o25dsDf2S/y9FS68rJKUyCoBGkLwr8owWTSTTHj4LOoHdrgSxw1cmNQMULiRb","css/svg-with-js.css":"sha384-jKeGgxY7zPT61fNXg6OMRDu8vsxOPRLMlgAIUHo1KVag4lyu5B03KsDLYOTMM4ld","css/solid.css":"sha384-wnAC7ln+XN0UKdcPvJvtqIH3jOjs9pnKnq9qX68ImXvOGz2JuFoEiCjT8jyZQX2z","css/regular.css":"sha384-zkhEzh7td0PG30vxQk1D9liRKeizzot4eqkJ8gB3/I+mZ1rjgQk+BSt2F6rT2c+I","css/fontawesome.css":"sha384-HbmWTHay9psM8qyzEKPc8odH4DsOuzdejtnr+OFtDmOcIVnhgReQ4GZBH7uwcjf6","css/brands.css":"sha384-nT8r1Kzllf71iZl81CdFzObMsaLOhqBU1JD2+XoAALbdtWaXDOlWOZTR4v1ktjPE","css/all.css":"sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ"}},"is-latest":false,"icon-count":{"pro":2357,"free":1295},"download":{"separates_web_desktop":true},"date":"2018-07-23T00:00:00"}},{"type":"releases","links":{"self":"/api/releases/"},"id":"","attributes":{"version":"5.3.1","sri":{"pro":{"js/v4-shims.js":"sha384-8e1r0+5VTqCqkg/9vG+cnipytzBkEh9fpESgVwBZAizMkWRfiaTkdhgdnhLGwuPd","js/solid.js":"sha384-U4vTrZsQ4ooEtzL162EZfTtCiJNTXOwGDBzV91//DI5L/h48ibzHBiHJmPLpx2hO","js/regular.js":"sha384-EbI+OvKb7noKOfu8MSi/vCbi0KWlM61MjHDmRk4/vwJkPsMIRcJggYLDGWv7VeYY","js/light.js":"sha384-2R0W5LA7dXp3ze/WhvjXlUcDaHRhtGlKYxN9QMhGDdjmj2EI1bub5ysSwofJwGfI","js/fontawesome.js":"sha384-u3o36ga3mMU6/lK/zdiER4h7pPtAK7wBuN0DrZPH22v01RZL8bKZkULIjxcx2/X/","js/brands.js":"sha384-am5AyalpQCEfbKe6FYiGZc2vX080nrcueZmrbkljxLdQDJ5q5Vu9QDROD/QefEp1","js/all.js":"sha384-eAVkiER0fL/ySiqS7dXu8TLpoR8d9KRzIYtG0Tz7pi24qgQIIupp0fn2XA1H90fP","css/v4-shims.css":"sha384-1YFoQoO5Em1oxLErpWpJuswiqPFVHl8HLDUaLjJGJH8+Nra/Y1D6uOZkEgfH5OZf","css/svg-with-js.css":"sha384-Hmg9TonawJaGH8ayFFnEBwvkx61BYLPAOV7b/YDGQEVIs1jh9pWQigAavMuD+Vc/","css/solid.css":"sha384-wJu5pIbEyJzi+kRgVKVQkPNKI104yNC+IAyK7XXEVGgPGe+LTEERIkpSZbc/wrOx","css/regular.css":"sha384-pofSFWh/aTwxUvfNhg+LRpOXIFViguTD++4CNlmwgXOrQZj1EOJewBT+DmUVeyJN","css/light.css":"sha384-9QuzjQIM/Un6pY9bKVJGLW8PauASO8Mf9y3QcsHhfZSXNyXGoXt/POh3VLeiv4mw","css/fontawesome.css":"sha384-Yz2UJoJEWBkb0TBzOd2kozX5/G4+z5WzWMMZz1Np2vwnFjF5FypnmBUBPH2gUa1F","css/brands.css":"sha384-AOiME8p6xSUbTO/93cbYmpOihKrqxrLjvkT2lOpIov+udKmjXXXFLfpKeqwTjNTC","css/all.css":"sha384-9ralMzdK1QYsk4yBY680hmsb4/hJ98xK3w0TIaJ3ll4POWpWUYaA2bRjGGujGT8w"},"free":{"js/v4-shims.js":"sha384-DtdEw3/pBQuSag11V3is/UZMjGkGMLDRBgk1UVAOvH6cYoqKjBmCEhePm13skjRV","js/solid.js":"sha384-GJiigN/ef2B3HMj0haY+eMmG4EIIrhWgGJ2Rv0IaWnNdWdbWPr1sRLkGz7xfjOFw","js/regular.js":"sha384-sqmLTIuB+bQgkyOcdJ/hAvXl51Z7qqdK/lcH/rt6sdvDKFincQWI+fVgcDZM6NMz","js/fontawesome.js":"sha384-2OfHGv4zQZxcNK+oL8TR9pA+ADXtUODqGpIRy1zOgioC4X3+2vbOAp5Qv7uHM4Z8","js/brands.js":"sha384-2vdvXGQdnt+ze3ylY5ESeZ9TOxwxlOsldUzQBwtjvRpen1FwDT767SqyVbYrltjb","js/all.js":"sha384-kW+oWsYx3YpxvjtZjFXqazFpA7UP/MbiY4jvs+RWZo2+N94PFZ36T6TFkc9O3qoB","css/v4-shims.css":"sha384-lmquXrF9qn7mMo6iRQ662vN44vTTVUBpcdtDFWPxD9uFPqC/aMn6pcQrTTupiv1A","css/svg-with-js.css":"sha384-4K9ulTwOtsXr+7hczR7fImKfUZY5THwqvfxwPx1VUCEOt4qssi2Vm+kHY7NJQPoy","css/solid.css":"sha384-VGP9aw4WtGH/uPAOseYxZ+Vz/vaTb1ehm1bwx92Fm8dTrE+3boLfF1SpAtB1z7HW","css/regular.css":"sha384-ZlNfXjxAqKFWCwMwQFGhmMh3i89dWDnaFU2/VZg9CvsMGA7hXHQsPIqS+JIAmgEq","css/fontawesome.css":"sha384-1rquJLNOM3ijoueaaeS5m+McXPJCGdr5HcA03/VHXxcp2kX2sUrQDmFc3jR5i/C7","css/brands.css":"sha384-rf1bqOAj3+pw6NqYrtaE1/4Se2NBwkIfeYbsFdtiR6TQz0acWiwJbv1IM/Nt/ite","css/all.css":"sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"}},"is-latest":false,"icon-count":{"pro":2637,"free":1341},"download":{"separates_web_desktop":true},"date":"2018-08-28T00:00:00"}},{"type":"releases","links":{"self":"/api/releases/"},"id":"","attributes":{"version":"5.4.1","sri":{"pro":{"js/v4-shims.js":"sha384-e+EZ4XUeGXVd0FDmP/mFu7FFe+qVX738ayOS2AErNIPSLz5oZ3OgVa9zEyCds3HP","js/solid.js":"sha384-KlTWIsOnBg7LJobQmLsv5fQ1qbx73K+o8/xhoUDoIba13SxF4bT5W2WgV3d8mZIw","js/regular.js":"sha384-MB7Bz/7e8sBWnZgblSLUfFOOi+V1PIkRG/Ex1NMeu0CovaXCzHyCMwAwOF+FAo1s","js/light.js":"sha384-jlaccvPpizUbHU/8pYAsDEwhhBae8MUcYqHHsKkjFcFsEp3Y6LrVXh0GA84aAkTg","js/fontawesome.js":"sha384-8vKKeD0uIV/HXM5ym3RGB4O7rZ43fCdpiXqP047w7sEE3igcK0Y1U9ApEArcRBDJ","js/brands.js":"sha384-ShBqjf9lFG58e2NmhnbVlhAOPCWdzkPbBmAEcQ37Liu3TwOYxIizS7J1P3rRLJHm","js/all.js":"sha384-0+tugznPwCEvPiypW+OwmFjAQvRKlgI0ZZZW3nofNlLMmbYXbmNvfX/9up9XQSRs","css/v4-shims.css":"sha384-aaXKvb/d7l2hTm3ZDWCy5v4ct5zXIslt+70K4xalZPLu3ifrkYcG61m4u+DIQGEk","css/svg-with-js.css":"sha384-j2EtHJUHBAZF9vkmX0TSA/QqYMf0Npp9P2leJGZFDbLHbcI62HH8w7FRcUMNf8Q2","css/solid.css":"sha384-oT4lQmwnKx98HRnFgaGvgCdjtKOjep9CjfMdAOPtJU8Vy6NY3X34GfqL0H43ydJn","css/regular.css":"sha384-xKPOvJDwdb/n5w2kh6cxds98Ae2d5N63xkIydEdoYeA2bxIKUmmyU9lZ9j58mLYS","css/light.css":"sha384-DZAoxBcs4G15aUXLX4vKbO53ye8L8AB/zg07HOVhIMVclhx8rdWye0AJSQl51ehV","css/fontawesome.css":"sha384-PPeKwWhk5XZBVVq089DuhGmjaEVB1r+jdmx6jZrqzlef8ojhZXG+E/D6SP7uO1dk","css/brands.css":"sha384-rmUpvtaCngUop5CYz7WL1LnqkMweXskxP+1AXmkuMSbImsUuy82bUYS4A8Syd3Pf","css/all.css":"sha384-POYwD7xcktv3gUeZO5s/9nUbRJG/WOmV6jfEGikMJu77LGYO8Rfs2X7URG822aum"},"free":{"js/v4-shims.js":"sha384-/s2EnwEz7C3ziRundAGzeOAoGYffu84oY4SOHjhI/2Wqk3Z0usUm9bjdduzhZ9+z","js/solid.js":"sha384-agDKwSYPuGlC0wD14lKXXwb94jlUkbkoSugquwmKRKWv/nDXe1kApDS/gqUlRQmZ","js/regular.js":"sha384-SQqzt64aAzh3UJ9XghcA//GE8+NxAIRcuCrrekyDokXP6Bbt/FYAFlV6VSPrZKwH","js/fontawesome.js":"sha384-ISRc+776vRkDOTSbmnyoZFmwHy7hw2UR3KJpb4YtcfOyqUqhLGou8j5YmYnvQQJ4","js/brands.js":"sha384-lc/yFuYW3B0EW9B2QSpod2KeBxq6/ZizGwAW6mRLUe3kKUVlSBfDIVZKwKIz/DBg","js/all.js":"sha384-L469/ELG4Bg9sDQbl0hvjMq8pOcqFgkSpwhwnslzvVVGpDjYJ6wJJyYjvG3u8XW7","css/v4-shims.css":"sha384-YIDcSvDDaIskj/WDlWwjrNdK194YAGWc1CScdo2tXl3IQVS1zS07xQaoAFlXCf1P","css/svg-with-js.css":"sha384-2MWWLQq91kFwloAny7gkgoeV33bD/cE3A9ZbB2rCN/YAAR/VEHVoDq6vRJJYTaxM","css/solid.css":"sha384-osqezT+30O6N/vsMqwW8Ch6wKlMofqueuia2H7fePy42uC05rm1G+BUPSd2iBSJL","css/regular.css":"sha384-4e3mPOi7K1/4SAx8aMeZqaZ1Pm4l73ZnRRquHFWzPh2Pa4PMAgZm8/WNh6ydcygU","css/fontawesome.css":"sha384-BzCy2fixOYd0HObpx3GMefNqdbA7Qjcc91RgYeDjrHTIEXqiF00jKvgQG0+zY/7I","css/brands.css":"sha384-Px1uYmw7+bCkOsNAiAV5nxGKJ0Ixn5nChyW8lCK1Li1ic9nbO5pC/iXaq27X5ENt","css/all.css":"sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz"}},"is-latest":true,"icon-count":{"pro":2969,"free":1388},"download":{"separates_web_desktop":true},"date":"2018-10-10T00:00:00"}}]}',
		);
	}

	protected static function build_500_response() {
		return array(
			'response' => array(
				'code'    => 500,
				'message' => 'Internal Server Error',
			),
			'body'     => '',
		);
	}

	protected static function build_403_response() {
		return array(
			'response' => array(
				'code'    => 403,
				'message' => 'Forbidden',
			),
			'body'     => '',
		);
	}

	protected function create_release_provider_with_mocked_response( $response ) {
		return mock_singleton_method(
			$this,
			FontAwesome_Release_Provider::class,
			'get',
			function( $method ) use ( $response ) {
				$method->willReturn(
					$response
				);
			}
		);
	}

	public function test_versions_no_releases_exception() {
		/**
		 * When the GET for releases does not return successfully and we have no version metadata available,
		 * we expect an exception to be thrown.
		 */

		$mock_response = self::build_500_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$this->expectException( FontAwesome_NoReleasesException::class );
		$farp->versions();
		// END: Since this tests an exception, make sure there are no assertions after this point, because
		// they don't seem to get a chance to run once this expected exception is handled.
	}

	public function test_client_failure_500() {
		$mock_response = self::build_500_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		// phpcs:disable Generic.CodeAnalysis.EmptyStatement.DetectedCatch
		try {
			// We need to run this for its side effects, but we don't want to be hijacked by the exception
			// it throws, because we need to assert something about the state *after* it's thrown.
			$farp->versions();
		} catch ( FontAwesome_NoReleasesException $e ) {
			// noop.
		}
		// phpcs:enable Generic.CodeAnalysis.EmptyStatement.DetectedCatch

		$this->assertEquals( 500, $farp->get_status()['code'] );
	}

	public function test_client_failure_403() {
		$mock_response = self::build_403_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		// phpcs:disable Generic.CodeAnalysis.EmptyStatement.DetectedCatch
		try {
			// We need to run this for its side effects, but we don't want to be hijacked by the exception
			// it throws, because we need to assert something about the state *after* it's thrown.
			$farp->versions();
		} catch ( FontAwesome_NoReleasesException $e ) {
			// noop.
		}
		// phpcs:enable Generic.CodeAnalysis.EmptyStatement.DetectedCatch

		$this->assertEquals( 403, $farp->get_status()['code'] );
	}

	public function test_versions() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$versions = $farp->versions();
		$this->assertCount( count( $this->known_versions_sorted_desc ), $versions );
		$this->assertArraySubset( $this->known_versions_sorted_desc, $versions );
	}

	public function test_5_0_all_free_shimless() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$resource_collection = $farp->get_resource_collection(
			'5.0.13', // version.
			'all', // style_opt.
			[
				'use_pro'  => false,
				'use_svg'  => false,
				'use_shim' => false,
			]
		);

		$this->assertFalse( is_null( $resource_collection ) );
		$this->assertCount( 1, $resource_collection );
		$this->assertEquals( 'https://use.fontawesome.com/releases/v5.0.13/css/all.css', $resource_collection[0]->source() );
		$this->assertEquals( 'sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp', $resource_collection[0]->integrity_key() );
	}

	public function test_5_0_all_webfont_pro_shimless() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$resource_collection = $farp->get_resource_collection(
			'5.0.13', // version.
			'all', // style_opt.
			[
				'use_pro'  => true,
				'use_svg'  => false,
				'use_shim' => false,
			]
		);

		$this->assertFalse( is_null( $resource_collection ) );
		$this->assertCount( 1, $resource_collection );
		$this->assertEquals( 'https://pro.fontawesome.com/releases/v5.0.13/css/all.css', $resource_collection[0]->source() );
		$this->assertEquals( 'sha384-oi8o31xSQq8S0RpBcb4FaLB8LJi9AT8oIdmS1QldR8Ui7KUQjNAnDlJjp55Ba8FG', $resource_collection[0]->integrity_key() );
	}

	/**
	 * There was no webfont shim in 5.0.x. So this should throw an exception.
	 */
	public function test_5_0_webfont_shim_exception() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$this->expectException( FontAwesome_ConfigurationException::class );

		$farp->get_resource_collection(
			'5.0.13', // version.
			'all', // style_opt.
			[
				'use_pro'  => true,
				'use_svg'  => false,
				'use_shim' => true,
			]
		);
	}

	public function test_5_1_all_webfont_pro_shimless() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$resource_collection = $farp->get_resource_collection(
			'5.1.0', // version.
			'all', // style_opt.
			[
				'use_pro'  => true,
				'use_svg'  => false,
				'use_shim' => false,
			]
		);

		$this->assertFalse( is_null( $resource_collection ) );
		$this->assertCount( 1, $resource_collection );
		$this->assertEquals( 'https://pro.fontawesome.com/releases/v5.1.0/css/all.css', $resource_collection[0]->source() );
		$this->assertEquals( 'sha384-87DrmpqHRiY8hPLIr7ByqhPIywuSsjuQAfMXAE0sMUpY3BM7nXjf+mLIUSvhDArs', $resource_collection[0]->integrity_key() );
	}

	// TODO: when 5.1.1 is released, add a test to make sure there is a v4-shims.css integrity key.
	public function test_5_1_0_missing_webfont_free_shim_integrity() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$resource_collection = $farp->get_resource_collection(
			'5.1.0', // version.
			'all', // style_opt.
			[
				'use_pro'  => false,
				'use_svg'  => false,
				'use_shim' => true,
			]
		);

		$this->assertFalse( is_null( $resource_collection ) );
		$this->assertCount( 2, $resource_collection );
		$this->assertEquals( 'https://use.fontawesome.com/releases/v5.1.0/css/all.css', $resource_collection[0]->source() );
		$this->assertEquals( 'sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt', $resource_collection[0]->integrity_key() );
		$this->assertEquals( 'https://use.fontawesome.com/releases/v5.1.0/css/v4-shims.css', $resource_collection[1]->source() );
	}

	public function test_5_0_all_svg_pro_shim() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$resource_collection = $farp->get_resource_collection(
			'5.0.13', // version.
			'all', // style_opt.
			[
				'use_pro'  => true,
				'use_svg'  => true,
				'use_shim' => true,
			]
		);

		$this->assertFalse( is_null( $resource_collection ) );
		$this->assertCount( 2, $resource_collection );
		$this->assertEquals( 'https://pro.fontawesome.com/releases/v5.0.13/js/all.js', $resource_collection[0]->source() );
		$this->assertEquals( 'sha384-d84LGg2pm9KhR4mCAs3N29GQ4OYNy+K+FBHX8WhimHpPm86c839++MDABegrZ3gn', $resource_collection[0]->integrity_key() );
		$this->assertEquals( 'https://pro.fontawesome.com/releases/v5.0.13/js/v4-shims.js', $resource_collection[1]->source() );
		$this->assertEquals( 'sha384-LDfu/SrM7ecLU6uUcXDDIg59Va/6VIXvEDzOZEiBJCh148mMGba7k3BUFp1fo79X', $resource_collection[1]->integrity_key() );
	}

	public function test_5_0_solid_brands_svg_free_shim() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$resource_collection = $farp->get_resource_collection(
			'5.0.13', // version.
			[ 'solid', 'brands' ], // style_opt.
			[
				'use_pro'  => false,
				'use_svg'  => true,
				'use_shim' => true,
			]
		);

		$this->assertFalse( is_null( $resource_collection ) );
		$this->assertCount( 4, $resource_collection );
		$resources = array();
		foreach ( $resource_collection as $resource ) {
			$matches = [];
			$this->assertTrue( boolval( preg_match( '/\/(brands|solid|fontawesome|v4-shims)\.js/', $resource->source(), $matches ) ) );
			$resources[ $matches[1] ] = $resource;
		}
		$this->assertCount( 4, $resources );
		$this->assertArrayHasKey( 'fontawesome', $resources );
		$this->assertArrayHasKey( 'brands', $resources );
		$this->assertArrayHasKey( 'solid', $resources );
		$this->assertArrayHasKey( 'v4-shims', $resources );

		// The fontawesome main library will appear first in order.
		$this->assertEquals( 'https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js', $resource_collection[0]->source() );
		$this->assertEquals( 'sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY', $resource_collection[0]->integrity_key() );

		// The style resources will appear in the middle, in any order.
		foreach ( [ 1, 2 ] as $resource_index ) {
			switch ( $resource_collection[ $resource_index ] ) {
				case $resources['brands']:
					$this->assertEquals(
						'https://use.fontawesome.com/releases/v5.0.13/js/brands.js',
						$resource_collection[ $resource_index ]->source()
					);
					$this->assertEquals(
						'sha384-G/XjSSGjG98ANkPn82CYar6ZFqo7iCeZwVZIbNWhAmvCF2l+9b5S21K4udM7TGNu',
						$resource_collection[ $resource_index ]->integrity_key()
					);
					break;
				case $resources['solid']:
					$this->assertEquals(
						'https://use.fontawesome.com/releases/v5.0.13/js/solid.js',
						$resource_collection[ $resource_index ]->source()
					);
					$this->assertEquals(
						'sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ',
						$resource_collection[ $resource_index ]->integrity_key()
					);
					break;
				default:
					throw new InvalidArgumentException( 'Unexpected resource in collection' );
			}
		}

		// The shim will appear last in order.
		$this->assertEquals( 'https://use.fontawesome.com/releases/v5.0.13/js/v4-shims.js', $resource_collection[3]->source() );
		$this->assertEquals( 'sha384-qqI1UsWtMEdkxgOhFCatSq+JwGYOQW+RSazfcjlyZFNGjfwT/T1iJ26+mp70qvXx', $resource_collection[3]->integrity_key() );
	}

	public function test_5_1_solid_webfont_free_shim() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$resource_collection = $farp->get_resource_collection(
			'5.1.0', // version.
			[ 'solid' ], // style_opt, only a single style.
			[
				'use_pro'  => false,
				'use_svg'  => false,
				'use_shim' => true, // expect a warning but no error since webfont had no shim in 5.0.x.
			]
		);

		$this->assertFalse( is_null( $resource_collection ) );
		$this->assertCount( 3, $resource_collection );
		$resources = array();
		foreach ( $resource_collection as $resource ) {
			$matches = [];
			$this->assertTrue( boolval( preg_match( '/\/(brands|solid|fontawesome|v4-shims)\.css/', $resource->source(), $matches ) ) );
			$resources[ $matches[1] ] = $resource;
		}
		$this->assertCount( 3, $resources );
		$this->assertArrayHasKey( 'fontawesome', $resources );
		$this->assertArrayHasKey( 'solid', $resources );
		$this->assertArrayHasKey( 'v4-shims', $resources );

		// The fontawesome main library will appear first in order.
		$this->assertEquals( 'https://use.fontawesome.com/releases/v5.1.0/css/fontawesome.css', $resource_collection[0]->source() );
		$this->assertEquals( 'sha384-ozJwkrqb90Oa3ZNb+yKFW2lToAWYdTiF1vt8JiH5ptTGHTGcN7qdoR1F95e0kYyG', $resource_collection[0]->integrity_key() );

		// The solid style in the middle.
		$this->assertEquals(
			'https://use.fontawesome.com/releases/v5.1.0/css/solid.css',
			$resource_collection[1]->source()
		);
		$this->assertEquals(
			'sha384-TbilV5Lbhlwdyc4RuIV/JhD8NR+BfMrvz4BL5QFa2we1hQu6wvREr3v6XSRfCTRp',
			$resource_collection[1]->integrity_key()
		);

		// The shim last.
		$this->assertEquals( 'https://use.fontawesome.com/releases/v5.1.0/css/v4-shims.css', $resource_collection[2]->source() );
	}

	public function test_5_1_no_style_webfont_free_shim() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$this->expectException( InvalidArgumentException::class );

		$farp->get_resource_collection(
			'5.1.0', // version.
			[], // style_opt, empty.
			[
				'use_pro'  => false,
				'use_svg'  => false,
				'use_shim' => true,
			]
		);
	}

	public function test_5_1_bad_style_webfont_free_shim() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$this->expectException( InvalidArgumentException::class );

		$state = array();
		begin_error_log_capture( $state );
		$farp->get_resource_collection(
			'5.1.0', // version.
			[ 'foo', 'bar' ], // style_opt, only bad styles.
			[
				'use_pro'  => false,
				'use_svg'  => false,
				'use_shim' => true,
			]
		);
		$error_log = end_error_log_capture( $state );
		$this->assertRegExp( '/WARNING.+?unrecognized.+?foo/', $error_log );
	}

	/**
	 * Add an invalid style specifier to the $style_opt, why also providing a legitimate one.
	 * We expect success, but with a non-fatal error_log.
	 */
	public function test_5_1_solid_foo_webfont_free_no_shim() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$state = array();
		begin_error_log_capture( $state );
		$resource_collection = $farp->get_resource_collection(
			'5.1.0', // version.
			[ 'solid', 'foo' ], // style_opt.
			[
				'use_pro'  => false,
				'use_svg'  => false,
				'use_shim' => false,
			]
		);
		$error_log           = end_error_log_capture( $state );

		$this->assertFalse( is_null( $resource_collection ) );
		$this->assertCount( 2, $resource_collection );
		$resources = array();
		foreach ( $resource_collection as $resource ) {
			$matches = [];
			$this->assertTrue( boolval( preg_match( '/\/(solid|fontawesome)\.css/', $resource->source(), $matches ) ) );
			$resources[ $matches[1] ] = $resource;
		}
		$this->assertCount( 2, $resources );
		$this->assertArrayHasKey( 'fontawesome', $resources );
		$this->assertArrayHasKey( 'solid', $resources );

		// The fontawesome main library will appear first in order.
		$this->assertEquals( 'https://use.fontawesome.com/releases/v5.1.0/css/fontawesome.css', $resource_collection[0]->source() );
		$this->assertEquals( 'sha384-ozJwkrqb90Oa3ZNb+yKFW2lToAWYdTiF1vt8JiH5ptTGHTGcN7qdoR1F95e0kYyG', $resource_collection[0]->integrity_key() );

		// The solid style next.
		$this->assertEquals(
			'https://use.fontawesome.com/releases/v5.1.0/css/solid.css',
			$resource_collection[1]->source()
		);
		$this->assertEquals(
			'sha384-TbilV5Lbhlwdyc4RuIV/JhD8NR+BfMrvz4BL5QFa2we1hQu6wvREr3v6XSRfCTRp',
			$resource_collection[1]->integrity_key()
		);

		$this->assertRegExp( '/WARNING.+?unrecognized.+?foo/', $error_log );
	}

	public function test_invalid_version_exception() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$this->expectException( InvalidArgumentException::class );

		$resource_collection = $farp->get_resource_collection(
			'4.0.13', // invalid version.
			'all', // style_opt.
			[
				'use_pro'  => true,
				'use_svg'  => false,
				'use_shim' => false,
			]
		);

		// END: since we're testing an exception, code won't run after the exception-throwing statement.
	}

	public function assert_latest_and_previous_releases( $mocked_available_versions, $expected_latest, $expected_previous ) {
		$mock = mock_singleton_method(
			$this,
			FontAwesome_Release_Provider::class,
			'versions',
			function( $method ) use ( $mocked_available_versions ) {
				$method->willReturn(
					$mocked_available_versions
				);
			}
		);
		$this->assertEquals( $expected_latest, $mock->latest_minor_release() );
		$this->assertEquals( $expected_previous, $mock->previous_minor_release() );
	}

	public function test_latest_and_previous_scenarios() {
		$this->assert_latest_and_previous_releases(
			[
				'5.1.1',
				'5.1.0',
				'5.0.13',
				'5.0.11',
				'5.0.0',
			],
			'5.1.1',
			'5.0.13'
		);

		// A pre-release should not be picked as a previous minor release.
		$this->assert_latest_and_previous_releases(
			[
				'5.1.1',
				'5.1.0',
				'5.0.14-1',
				'5.0.13',
				'5.0.11',
				'5.0.0',
			],
			'5.1.1',
			'5.0.13'
		);

		// There *is* no previous in this case because 5.0.0 is the earliest and 5.0.13 is the latest.
		// So there's no minor release version before the earliest available in this set.
		$this->assert_latest_and_previous_releases(
			[
				'5.0.13',
				'5.0.11',
				'5.0.0',
			],
			'5.0.13',
			null
		);

		$this->assert_latest_and_previous_releases(
			[
				'5.2.0',
				'5.1.1',
				'5.0.13',
				'5.0.11',
				'5.0.0',
			],
			'5.2.0',
			'5.1.1'
		);

		// empty set.
		$this->assert_latest_and_previous_releases(
			[],
			null,
			null
		);
	}
}
