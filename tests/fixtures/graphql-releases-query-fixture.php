<?php
namespace FortAwesome;

function graphql_releases_query_fixture() {
	return array(
		'latest_version_5' => array(
			'version' => '5.15.4',
		),
		'latest_version_6' => array(
			'version' => '6.7.2',
		),
		'latest_version_7' => array(
			'version' => '7.0.0',
		),
		'releases'         => array(
			9  => array(
				'srisByLicense' => array(
					'free' => array(
						0  => array(
							'path'  => 'css/all.css',
							'value' => 'sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp',
						),
						1  => array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-VGCZwiSnlHXYDojsRqeMn3IVvdzTx5JEuHgqZ3bYLCLUBV8rvihHApoA1Aso2TZA',
						),
						2  => array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-GVa9GOgVQgOk+TNYXu7S/InPTfSDTtBalSgkgqQ7sCik56N9ztlkoTr2f/T44oKV',
						),
						3  => array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-EWu6DiBz01XlR6XGsVuabDMbDN6RT8cwNoY+3tIH+6pUCfaNldJYJQfQlbEIWLyA',
						),
						4  => array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-Rw5qeepMFvJVEZdSo1nDQD5B6wX0m7c5Z/pLNvjkB14W6Yki1hKbSEQaX9ffUbWe',
						),
						5  => array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-LAtyQAMHxrIJzktG06ww5mJ0KQ+uCqQIJFjwj+ceCjUlZ2jkLwJZt1nBGw4KaFEZ',
						),
						6  => array(
							'path'  => 'js/all.js',
							'value' => 'sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe',
						),
						7  => array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-G/XjSSGjG98ANkPn82CYar6ZFqo7iCeZwVZIbNWhAmvCF2l+9b5S21K4udM7TGNu',
						),
						8  => array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY',
						),
						9  => array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-IJ3h7bJ6KqiB70L7/+fc44fl+nKF5eOFkgM9l/zZii9xs7W2aJrwIlyHZiowN+Du',
						),
						10 => array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ',
						),
						11 => array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-qqI1UsWtMEdkxgOhFCatSq+JwGYOQW+RSazfcjlyZFNGjfwT/T1iJ26+mp70qvXx',
						),
					),
					'pro'  => array(
						0  => array(
							'path'  => 'css/all.css',
							'value' => 'sha384-oi8o31xSQq8S0RpBcb4FaLB8LJi9AT8oIdmS1QldR8Ui7KUQjNAnDlJjp55Ba8FG',
						),
						1  => array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-t3MQUMU0g3tY/0O/50ja6YVaEFYwPpOiPbrHk9p5DmYtkHJU2U1/ujNhYruOJwcj',
						),
						2  => array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-LDuQaX4rOgqi4rbWCyWj3XVBlgDzuxGy/E6vWN6U7c25/eSJIwyKhy9WgZCHQWXz',
						),
						3  => array(
							'path'  => 'css/light.css',
							'value' => 'sha384-d8NbeymhHpk+ydwT2rk4GxrRuC9pDL/3A6EIedSEYb+LE+KQ5QKgIWTjYwHj/NBs',
						),
						4  => array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-HLkkol/uuRVQDnHaAwidOxb1uCbd78FoGV/teF8vONYKRP9oPQcBZKFdi3LYDy/C',
						),
						5  => array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-drdlAcijFWubhOfj9OS/gy2Gs34hVhVT90FgJLzrldrLI+7E7lwBxmanEEhKTRTS',
						),
						6  => array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-8YpCivPy+AkMdZ0uAvEP04Gs77AN/6mS5AmZqkCwniP51zSG8rCMaH06OYuC4iXd',
						),
						7  => array(
							'path'  => 'js/all.js',
							'value' => 'sha384-d84LGg2pm9KhR4mCAs3N29GQ4OYNy+K+FBHX8WhimHpPm86c839++MDABegrZ3gn',
						),
						8  => array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-44Hl7UlQr9JXHFcZOp9qWHk2H1lrsAN/cG3GNgB2JqbciecuJ2/B9sjelOMttzBM',
						),
						9  => array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-BUkEHIKZJ0ussRY3zYfFL7R0LpqWmucr9K38zMTJWdGQywTjmzbejVSNIHuNEhug',
						),
						10 => array(
							'path'  => 'js/light.js',
							'value' => 'sha384-+iGqamqASU/OvBgGwlIHH6HSEgiluzJvTqcjJy8IN9QG9aUfd0z0pKpTlH7TpU7X',
						),
						11 => array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-1bAvs6o5Yb7MMzvTI3oq2qkreCQFDXb6KISLBhrHR+3sJ/mm7ZWfnQVRwScbPEmd',
						),
						12 => array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-CucLC75yxFXtBjA/DCHWMS14abAUhf5HmFRdHyKURqqLqi3OrLsyhCyqp83qjiOR',
						),
						13 => array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-LDfu/SrM7ecLU6uUcXDDIg59Va/6VIXvEDzOZEiBJCh148mMGba7k3BUFp1fo79X',
						),
					),
				),
				'version'       => '5.0.13',
			),
			10 => array(
				'srisByLicense' => array(
					'free' => array(
						0  => array(
							'path'  => 'css/all.css',
							'value' => 'sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt',
						),
						1  => array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-7xAnn7Zm3QC1jFjVc1A6v/toepoG3JXboQYzbM0jrPzou9OFXm/fY6Z/XiIebl/k',
						),
						2  => array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-ozJwkrqb90Oa3ZNb+yKFW2lToAWYdTiF1vt8JiH5ptTGHTGcN7qdoR1F95e0kYyG',
						),
						3  => array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-avJt9MoJH2rB4PKRsJRHZv7yiFZn8LrnXuzvmZoD3fh1aL6aM6s0BBcnCvBe6XSD',
						),
						4  => array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-TbilV5Lbhlwdyc4RuIV/JhD8NR+BfMrvz4BL5QFa2we1hQu6wvREr3v6XSRfCTRp',
						),
						5  => array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-5aLiCANDiVeIiNfzcW+kXWzWdC6riDYfxLS6ifvejaqYOiEufCh0zVLMkW4nr8iC',
						),
						6  => array(
							'path'  => 'css/v4-shims.css',
							'value' => 'sha384-epK5t6ciulYxBQbRDZyYJFVuWey/zPlkBIbv6UujFdGiIwQCeWOyv5PVp2UQXbr2',
						),
						7  => array(
							'path'  => 'js/all.js',
							'value' => 'sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9',
						),
						8  => array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-ZqDZAkGUHrXxm3bvcTCmQWz4lt7QGLxzlqauKOyLwg8U0wYcYPDIIVTbZZXjbfsM',
						),
						9  => array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-juNb2Ils/YfoXkciRFz//Bi34FN+KKL2AN4R/COdBOMD9/sV/UsxI6++NqifNitM',
						),
						10 => array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-Y+AVd32cSTAMpwehrH10RiRmA28kvu879VbHTG58mUFhd+Uxl/bkAXsgcIesWn3a',
						),
						11 => array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-Z7p3uC4xXkxbK7/4keZjny0hTCWPXWfXl/mJ36+pW7ffAGnXzO7P+iCZ0mZv5Zt0',
						),
						12 => array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-3qT9zZfeo1gcy2NmVv5dAhtOYkj91cMLXRkasOiRB/v+EU3G+LZUyk5uqZQdIPsV',
						),
					),
					'pro'  => array(
						0  => array(
							'path'  => 'css/all.css',
							'value' => 'sha384-87DrmpqHRiY8hPLIr7ByqhPIywuSsjuQAfMXAE0sMUpY3BM7nXjf+mLIUSvhDArs',
						),
						1  => array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-C1HxUFJBptCeaMsYCbPUw8fdL2Cblu3mJZilxrfujE+7QLr8BfuzBl5rPLNM61F6',
						),
						2  => array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-PnWzJku7hTqk2JREATthkLpYeVVGcBbXG5yEzk7hD2HIr/VxffIDfNSR7p7u4HUy',
						),
						3  => array(
							'path'  => 'css/light.css',
							'value' => 'sha384-ANTAgj8tbw0vj4HgQ4HsB886G2pH15LXbruHPCBcUcaPAtn66UMxh8HQcb1cH141',
						),
						4  => array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-6kuJOVhnZHzJdVIZJcWiMZVi/JwinbqLbVxIbR73nNqXnYJDQ5TGtf+3XyASO4Am',
						),
						5  => array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-rvfDcG9KDoxdTesRF/nZ/sj8CdQU+hy6JbNMwxUTqpoI2LaPK8ASQk6E4bgabrox',
						),
						6  => array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-/h6SKuA/ysT91EgYEGm9B6Z6zlaxuvKeW/JB7FWdGwCFalafxmGzJE2a63hS1BLm',
						),
						7  => array(
							'path'  => 'css/v4-shims.css',
							'value' => 'sha384-2RBBYH6GaI11IJzJ6V1eL7kXXON+epoQIt+HqpzQdBrtyT7gNwKPDxo2roxUbtW9',
						),
						8  => array(
							'path'  => 'js/all.js',
							'value' => 'sha384-E5SpgaZcbSJx0Iabb3Jr2AfTRiFnrdOw1mhO19DzzrT9L+wCpDyHUG2q07aQdO6E',
						),
						9  => array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-QPbiRUBnwCr8JYNjjm7CB0QP9h4MLvWUZhsChFX6dLzRkY22/nAxVYqa5nUTd6PL',
						),
						10 => array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-ckjcH5WkBMAwWPjTJiy7K2LaLp37yyCVKAs3DKjhPdo0lRCDIScolBzRsuaSu+bQ',
						),
						11 => array(
							'path'  => 'js/light.js',
							'value' => 'sha384-77i21WTcIcnSPKxwR794RLUQitpNqm6K3Fxsjx8hgoc3ZZbPJu5orgvU/7xS3EFq',
						),
						12 => array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-S21AhcbZ5SXPXH+MH7JuToqmKYXviahLaD1s9yApRbu1JDiMjPBGQIw/3PCHKUio',
						),
						13 => array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-q6QALO/4RSDjqnloeDcGnkB0JdK3MykIi6dUW5YD66JHE3JFf8rwtV5AQdYHdE0X',
						),
						14 => array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-9gfBAY6DS3wT0yuvYN1aaA1Q9R0fYQHliQWLChuYDWJJ0wQJpoNZrzlcqd4+qqny',
						),
					),
				),
				'version'       => '5.1.0',
			),
			40 => array(
				'srisByLicense' => array(
					'free' => array(
						0  => array(
							'path'  => 'css/all.css',
							'value' => 'sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk',
						),
						1  => array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-V5Z1KgRRJyY878qCx7+zUeTDm0FgjoYrbmSortFqRPGz+Ue6XDe4uIiMqB3tB/wd',
						),
						2  => array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-wESLQ85D6gbsF459vf1CiZ2+rr+CsxRY0RpiF1tLlQpDnAgg6rwdsUF1+Ics2bni',
						),
						3  => array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-Dn9L7vwedvmbdep+J8U5Zbrp+ES46dt8pm8ZMUu9iOR9isC4+Y/KP1h4StrDd/F+',
						),
						4  => array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-LA8Ug4T/nhVkyhrSmSirsoAo9iDrBk8E7U80aSPeD+w3vO8PzOJIS6agGcbIwwX0',
						),
						5  => array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-C4KLoR3asMHYArL0nLQXEaFZIFfRMiV0Ul0DvsMfSMZ+YLJwFu0Rpxix+EZwqxOy',
						),
						6  => array(
							'path'  => 'css/v4-shims.css',
							'value' => 'sha384-C2B+KlPW+WkR0Ld9loR1x3cXp7asA0iGVodhCoJ4hwrWm/d9qKS59BGisq+2Y0/D',
						),
						7  => array(
							'path'  => 'js/all.js',
							'value' => 'sha384-haqrlim99xjfMxRP6EWtafs0sB1WKcMdynwZleuUSwJR0mDeRYbhtY+KPMr+JL6f',
						),
						8  => array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-oEE/PrsvhwsuT1MjC4sgnz39CQ84HoPt8jwH0RLyJDdDOKulN+UEbm9IgJW0aTu5',
						),
						9  => array(
							'path'  => 'js/conflict-detection.js',
							'value' => 'sha384-OwOgf6Oss8Oh+cy6VnIGLlcyMhaaOPN+3gyLv2UyvjybuPrTNNgJljGYEAqSglUM',
						),
						10 => array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-hD97VKS04Rv8VYShf782apVZOVP6bVH/ubzrWXIIbKOwnD6gsDIcB29K03FL1A9J',
						),
						11 => array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-bPKzNk+f6IzEi89cU+jf3bwWzJQqo+U1/QYUijuD7XD9WO3MSrrAVVEglIOCo6VD',
						),
						12 => array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-9xA4r2/2cctd+IZZKLvI1hmeHZ5Yp8xXkS6J8inDtdyZCqhEHVcTGmSUCbNED5Ae',
						),
						13 => array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-oJX16kNznlRQV8hvYpOXlQKGc8xQj+HgmxViFoFiQgx0jZ4QKELTQecpcx905Pkg',
						),
					),
					'pro'  => array(
						0  => array(
							'path'  => 'css/all.css',
							'value' => 'sha384-iKbFRxucmOHIcpWdX9NTZ5WETOPm0Goy0WmfyNcl52qSYtc2Buk0NCe6jU1sWWNB',
						),
						1  => array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-GTxp/8UKFkexlguDtPsFi90d++F9f26nZCM99OSQo69514FK7Of5mgM9Efhs5O9L',
						),
						2  => array(
							'path'  => 'css/duotone.css',
							'value' => 'sha384-nuPd13VLdsw5iBtqelv9tQ6l6+CteSUrmoT5enzHVJodx7WdNUYXNwgVpA7bgsXn',
						),
						3  => array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-DHjwMcq12OEB4DQ+qulZDDroaXZqm7h9V6AjiP/RuUF8NhxUa8x6UWdv1AeZS+90',
						),
						4  => array(
							'path'  => 'css/light.css',
							'value' => 'sha384-IvEgf1JJYgCtB5fP9nmT3uC7DY96POpmhUjo/98B8FMju1w295nj5yGBfwgD3MYj',
						),
						5  => array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-Z3GHSXKByZgv1Ri9CiFq0jYUQ982JHZOOg4awUHcuVBjTxwNd+PVQO1/PSwChyzK',
						),
						6  => array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-Ymp/JSUSR6EuZ4KjxcliW8lJ7wkYBR6oasX7EMi6SG0QBPmNUDAEG9rd7Ogy0Ca/',
						),
						7  => array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-n/+zO4Fk1/R4EL7q+xf44zBEgvFziVgA7BUNwfjcGjHq/X6U0v25ESHqN/l5Wprm',
						),
						8  => array(
							'path'  => 'css/v4-shims.css',
							'value' => 'sha384-yV4xIIsecn1iqxJy3IC5YyRSLwtkkFuOvfPvj1hGH5NLLej9Cum4hPOUL2uQYfQ6',
						),
						9  => array(
							'path'  => 'js/all.js',
							'value' => 'sha384-OF9QwbqmlzSPpIxe2GYS8lkGFyaFfrgUPD2J3qj8zGVps17Y/x8EK2U8PEl6UrpH',
						),
						10 => array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-5u0zCiPDAEBQPvGxnai1VRZiSs9yQmyspSLrg0Fc7ru5CeddU1cef/24itMCpcWb',
						),
						11 => array(
							'path'  => 'js/conflict-detection.js',
							'value' => 'sha384-W0jz7GGBNDbeSyOhqqJrtOVDFLX4Qlqm/5K4RqM9ZpPIZL6tmDCMkEIheypFOiSK',
						),
						12 => array(
							'path'  => 'js/duotone.js',
							'value' => 'sha384-rutYU6OuFfIS5MmBE4wrpMhP633bNlRHqn/SFpcetMTKr+rsBxnoTd80mkHI7wum',
						),
						13 => array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-hwdDrjZFQbBwoFcHZZ/6e61XHiwY9csS0Wxi8i5jUgTurxmYITntaGLFYCssX7By',
						),
						14 => array(
							'path'  => 'js/light.js',
							'value' => 'sha384-soVEahH07bOeX1Nlhdi4VQ+yvDpIGN9A/qbzm/PgfDrpvh7AaCTyMkQNk1spjHbf',
						),
						15 => array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-GR++czVV+1briVrgT0SHxwKuKqqXqfkRb2NxZ8O4rad/c/iKIn85PDSaZQ3cjiAZ',
						),
						16 => array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-JwTquvZ50ZD4wvDw99MHsjx621x02jCoiXBKy103wTwDMBbDLmhRcCV4v9mq5CV4',
						),
						17 => array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-xczhE4W0SRyRFalFfxUKqclGdqLDVnc/F118WebJIQ/QyS3XKXIHXTieQKG1rG/+',
						),
					),
				),
				'version'       => '5.15.3',
			),
			41 => array(
				'srisByLicense' => array(
					'free' => array(
						0  => array(
							'path'  => 'css/all.css',
							'value' => 'sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm',
						),
						1  => array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-S5yUroXKhsCryF2hYGm7i8RQ/ThL96qmmWD+lF5AZTdOdsxChQktVW+cKP/s4eav',
						),
						2  => array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7',
						),
						3  => array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-e7wK18mMVsIpE/BDLrCQ99c7gROAxr9czDzslePcAHgCLGCRidxq1mrNCLVF2oaj',
						),
						4  => array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-Tv5i09RULyHKMwX0E8wJUqSOaXlyu3SQxORObAI08iUwIalMmN5L6AvlPX2LMoSE',
						),
						5  => array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-meSUsKN46Q06zfndZ6zDskLd5vJrCPwgb2izpfSMfWpQLijQApceQWIsbpLy2lAF',
						),
						6  => array(
							'path'  => 'css/v4-shims.css',
							'value' => 'sha384-Vq76wejb3QJM4nDatBa5rUOve+9gkegsjCebvV/9fvXlGWo4HCMR4cJZjjcF6Viv',
						),
						7  => array(
							'path'  => 'js/all.js',
							'value' => 'sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc',
						),
						8  => array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-xf4z6gHzXeY6YwFJm8AKcD9SSq8TsfF4+UJj1JxzwQHk+VNATxkknGEzmdtYV0w1',
						),
						9  => array(
							'path'  => 'js/conflict-detection.js',
							'value' => 'sha384-b4+d5l6vwWgdPDCbk4SG+VPRplFp3JtWehGqKvfat/MWON5/PSWvf0l89dpfUDUG',
						),
						10 => array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-dPBGbj4Uoy1OOpM4+aRGfAOc0W37JkROT+3uynUgTHZCHZNMHfGXsmmvYTffZjYO',
						),
						11 => array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-EEuk6Tk/hsJ0IJMUp+btTmHLuWPGGIm8I3xmxRawuWaY1xqWEm3EKVdnHNlYX+6t',
						),
						12 => array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-/BxOvRagtVDn9dJ+JGCtcofNXgQO/CCCVKdMfL115s3gOgQxWaX/tSq5V8dRgsbc',
						),
						13 => array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-bx00wqJq+zY9QLCMa/zViZPu1f0GJ3VXwF4GSw3GbfjwO28QCFr4qadCrNmJQ/9N',
						),
					),
					'pro'  => array(
						0  => array(
							'path'  => 'css/all.css',
							'value' => 'sha384-rqn26AG5Pj86AF4SO72RK5fyefcQ/x32DNQfChxWvbXIyXFePlEktwD18fEz+kQU',
						),
						1  => array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-Q9/9nfR6hUHbM3NjqxA59j5l/9c23JjwDDuPsV5SKplBvgLpFDtJmukyC2oCwp28',
						),
						2  => array(
							'path'  => 'css/duotone.css',
							'value' => 'sha384-Zi3Yce9z7/mhFiZHlM/DEBTnheymZyqrjMoWYPP8xtNCl+LtJKnaJ0vaGnPfqc/i',
						),
						3  => array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-ig3RKyui4sECvuz+WE8EmFYy7sjRvEvy82mmhfV7ljRieb+0f8eEZKxHv2KC0+io',
						),
						4  => array(
							'path'  => 'css/light.css',
							'value' => 'sha384-zCLzLBaV9kpBZtwZ72K00PI4UjqXZhrzMeVtYGOOHqL2N5PXSVw2MtJjaWTKYDHW',
						),
						5  => array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-sDvgA98ePLM7diZOYxIrDEITlUxoFxdt0CPuqjdLr/w62pPuOc73uFoigWEnVpDa',
						),
						6  => array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-2aj01VFITmYatwqdIKc7PHVmhLqFnnkVCilBk0Uj/fGoczNJXKvV45XlyHr/HU9g',
						),
						7  => array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-cHJCnE8H1fC+puOpWCd6OSOmJ1q8KxWtIm/JUpb9705KggGjyKbMzryJWJDw2OPb',
						),
						8  => array(
							'path'  => 'css/v4-shims.css',
							'value' => 'sha384-sKQhO4q55X7e4nIIO+wnutVfpIITv8+QJG6hE15hThUjV3ssIxUGT4VAoAGYmOU5',
						),
						9  => array(
							'path'  => 'js/all.js',
							'value' => 'sha384-8nTbev/iV1sg3ESYOAkRPRDMDa5s0sknqroAe9z4DiM+WDr1i/VKi5xLWsn87Car',
						),
						10 => array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-MwpSaMFXAxVGLfxKR0S/SL1BvfRLmlowKeqIE/yF7uW5ax+r1fqRs12asOCkF9Jf',
						),
						11 => array(
							'path'  => 'js/conflict-detection.js',
							'value' => 'sha384-my7QwPFkgZPqsrDx/vNCyAMQw86Ee5ZUeCUBA7CF0l9rWFcxoH+h+NdSGyYBh2pq',
						),
						12 => array(
							'path'  => 'js/duotone.js',
							'value' => 'sha384-AFpIAPhppteteZyLTXU8oPEbmuNz5WwwWSVAKJxuEn51LibO/iPZ+fC5DzmLJzoo',
						),
						13 => array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-RTs6cAeLGZoCPlBxXNxYfQnVIrvTagXGxIhrXFjWgp4i4E5urdGFLlkfbsk1Nd+L',
						),
						14 => array(
							'path'  => 'js/light.js',
							'value' => 'sha384-6EhWHErkaXt19GTK7f+5rRc16ekdzvItcFycGZi1GS/AycADXj7L2tkZ9z2O71ot',
						),
						15 => array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-WWzdx7E114gkDQnLVS/7s5WUTa5KQUqY5D8LGqBB7y132sxhUbrIHfqde9aenKnJ',
						),
						16 => array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-DfpPYefTs8qX3aeMuUJxalewnmVXDDtxcIJFo+Bz1qrNTaoEwMIaZkfoWx404GvG',
						),
						17 => array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-9lueRrgA8PnJBSmeS0/jHPFpZZ/hC/7n/XNQhCroAsZSoTtaEj6Q+ewHcpgFPqFw',
						),
					),
				),
				'version'       => '5.15.4',
			),
			60 => array(
				'srisByLicense' => array(
					'free' => array(
						0  => array(
							'path'  => 'css/all.css',
							'value' => 'sha384-QI8z31KmtR+tk1MYi0DfgxrjYgpTpLLol3bqZA/Q1Y8BvH+6k7/Huoj38gQOaCS7',
						),
						1  => array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-b+WfhKuxSUfSpx4cHUnwW9AYQ9NjTYa05djzsD9uueGwQSUmMpB7WmX4/4GB1Yjr',
						),
						2  => array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-EAbQoRbplocyBu1YBhlFf6o4MzZytG/DZuc3iQOvYNJouRrN9+AxSan5naDfaoqe',
						),
						3  => array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-NIsDz+gz6pFEfTuZBXT4siHyRAuVQEMpKt+WX7o9EqWfqIe1PJvMx0Jjr2/K9Igz',
						),
						4  => array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-VMniHmVvH7847gFXdwU6LLmyA9PDmJdk8BUlfBcZI6sbK/Hxs0qdmLSqALTVOwdt',
						),
						5  => array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-FkZTpTIsMMUUQPTqa28B1Q9fA3Z038vJSn+Yzxh2W6T3C38yr4sE7JtXMSxdXzKp',
						),
						6  => array(
							'path'  => 'css/v4-font-face.css',
							'value' => 'sha384-/mNHWa1pJzu+Gayjr0FS6Ed1Gt5yoN1bDeGWPkn3J2I5C1/fE2LyirFQ9Q+q7aWM',
						),
						7  => array(
							'path'  => 'css/v4-shims.css',
							'value' => 'sha384-R64+fQmO33bGWclNEac7wTslE6q6qYBlYBl8/ih3jdfiYZsUJ3OvPpaWQNgnKZL0',
						),
						8  => array(
							'path'  => 'css/v5-font-face.css',
							'value' => 'sha384-qFR2RMDRlRyeubfqfEzMGgh4to3lm3eUQQn4pYQIKMYNGHqHw9BdAdMwi7ck9RU+',
						),
						9  => array(
							'path'  => 'js/all.js',
							'value' => 'sha384-rxRGDl9CoH4u0AIeVyasIKlE45FVz6H2qXIl+fmc+3ImJn0CvfCseru5J4PALGH/',
						),
						10 => array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-D2NOkO1LiszTSE5eCA7Ygx6kT0clUZGJrNPS5n41GL3zEsxTA7BhpK2ZLJ7GxrPM',
						),
						11 => array(
							'path'  => 'js/conflict-detection.js',
							'value' => 'sha384-kefX+ApQKOdTsEjrvtOKgHXTuNvjNlzYacJwflj3RafXLE8TtTiMfpVxJzAsHRNP',
						),
						12 => array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-TIrPY+KnwskX0FR5bxDcwecBz6kaVflVjVHmsM83f6pe/Akko+GzLcTsgWBkKf9L',
						),
						13 => array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-Dl0OBhvLxvr1sUQaK6GP9Im5T0iZi5cIrXHq9SYcH8O6D/fa94W9wTJhtDikS7DD',
						),
						14 => array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-tOGJDd550PR1D0FSqKjS8FehwyDZWHO6AGg8lZe58jFNCN2Q5kdrNtKCLhfQ5L/B',
						),
						15 => array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-T50+nl9L/K0z0g6gcb6R2hZ5tAPG1aKeU6jdPm1QMnbFY2gTJrjoTWY4lmAQdGJ4',
						),
					),
					'pro'  => array(),
				),
				'version'       => '6.7.1',
			),
			61 => array(
				'srisByLicense' => array(
					'free' => array(
						0  => array(
							'path'  => 'css/all.css',
							'value' => 'sha384-nRgPTkuX86pH8yjPJUAFuASXQSSl2/bBUiNV47vSYpKFxHJhbcrGnmlYpYJMeD7a',
						),
						1  => array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-CNhPUG5cpX8UuKLY0BCb+gzedmWkhHPKATz919jTKgOXajXjkEY99Qr51B5V2wOQ',
						),
						2  => array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-AGSGRaBRodcsy1n0F2zMm+LfXuZry/ZJ6nfio36UgMuNBs/AOC8ciJ7py4SgkpoY',
						),
						3  => array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-6Zsk745fBctG7JVrpWegJSSYk7xb3Zjy7CNEEG3dFcFGiTU/ti4muXgYnTZ6nYys',
						),
						4  => array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-H/BU8KfYKZ0VK4RJyclToSd6x8TmMY4/Rym2YtHXnGQOUZAoLIYIaOxkIfyTAuVh',
						),
						5  => array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-La1g8AtwEh825NtYn5xyAQN3usA4ZizE2nZWvCt+g8okhStlHtUXuNSgfgo/u+ja',
						),
						6  => array(
							'path'  => 'css/v4-font-face.css',
							'value' => 'sha384-Y5XZJkJTFFCVfezUSk/mT3rropmGgfaIDhPShFdyjhON0UAHQjaq3t+bX+N+6aY/',
						),
						7  => array(
							'path'  => 'css/v4-shims.css',
							'value' => 'sha384-npPMK6zwqNmU3qyCCxEcWJkLBNYxEFM1nGgSoAWuCCXqVVz0cvwKEMfyTNkOxM2N',
						),
						8  => array(
							'path'  => 'css/v5-font-face.css',
							'value' => 'sha384-RxG9D9PsmiOdDFY0jfNnLlApnnL36kC04NEVKbj0S2RUc8ninvZZsgzCKdtsgQkk',
						),
						9  => array(
							'path'  => 'js/all.js',
							'value' => 'sha384-DsXFqEUf3HnCU8om0zbXN58DxV7Bo8/z7AbHBGd2XxkeNpdLrygNiGFr/03W0Xmt',
						),
						10 => array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-wRU6vtIpkIdXnWzp+Hq7CNH527PHkmlZz1n7ITVY0YhEPUcSlz2voGAQfVb3d9xe',
						),
						11 => array(
							'path'  => 'js/conflict-detection.js',
							'value' => 'sha384-1DJDcrFUodFx+Lmy9p6Xay8G2Iilua4vOtatfywfvhNgsa9pgJrVgOGyxHsuoxpM',
						),
						12 => array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-dCcP+1ToHaZKWNvVqy4+4ekZYXP73UfD3KsBQ0xg54c0+R0I6zsewwjQiM3JUwg+',
						),
						13 => array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-MW39uKwb/t9lOlXyzHqlUTAWu9JpFN3aDTfaeUg8y6V0WJY5jSDspEoE05PVIBQT',
						),
						14 => array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-Jx4lvM3f1foL3gcKtEZPpp/IOxYaIOJ+KQRq3vP7Towpgy4bjb6wo5QK5VRtnpLh',
						),
						15 => array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-WVm8++sQXsfFD5HmhLau6q7RS11CQOYMBHGi1pfF2PHd/vthiacQvsVLrRk6lH8O',
						),
					),
					'pro'  => array(),
				),
				'version'       => '6.7.2',
			),
			62 => array(
				'srisByLicense' => array(
					'free' => array(
						0  => array(
							'path'  => 'css/all.css',
							'value' => 'sha384-tGBVFh2h9Zcme3k9gJLbGqDpD+jRd419j/6N32rharcTZa1X6xgxug6pFMGonjxU',
						),
						1  => array(
							'path'  => 'css/brands.css',
							'value' => 'sha384-IzIkDWjFFaoFz413tu2x9R4cMiJ3EGuxOf/7Q8X0LFhqz9fU5zT2go7BgenYdKgN',
						),
						2  => array(
							'path'  => 'css/fontawesome.css',
							'value' => 'sha384-aeYCj6sbs4JVGoa3LTeURNoMDGaOU4kkAj6PMGL4HA8djL1ogsMYKcKlGxFd9l3B',
						),
						3  => array(
							'path'  => 'css/regular.css',
							'value' => 'sha384-PmxfVzUpFiyj5ZqzN3upnv7G4x9YAlMQar/qCBLEYSaWr/DUQ9f/8ITCT0aN7byC',
						),
						4  => array(
							'path'  => 'css/solid.css',
							'value' => 'sha384-HMy1VqP4zke4zzaS+hmFgbW3QXDYD+qtueW3unq30MTgdOnarIgANSya8s5qKRh5',
						),
						5  => array(
							'path'  => 'css/svg-with-js.css',
							'value' => 'sha384-k4aZSO6Y4DVDSn8+pbKg8vRBs9bLsobm8mDiKT+7v0qy7bm11Wg2vENNA4vCXqxD',
						),
						6  => array(
							'path'  => 'css/svg.css',
							'value' => 'sha384-nASHdsq7039P3zL4aFudeM9arq9ltQ5q9gpAvHZV8GWp10EHVjPJ50hPsyQcyblx',
						),
						7  => array(
							'path'  => 'css/v4-font-face.css',
							'value' => 'sha384-7c0mz5ReY2wCEDKNNEdrKdbtS/6+5dEgNsz/dU3e9m7xldAdTFwNTAuX+s4sJHJl',
						),
						8  => array(
							'path'  => 'css/v4-shims.css',
							'value' => 'sha384-NNMojup/wze+7MYNfppFkt1PyEfFX0wIGvCNanAQxX/+oI4LFnrP0EzKH7HTqLke',
						),
						9  => array(
							'path'  => 'css/v5-font-face.css',
							'value' => 'sha384-691KBFHHuy2pnDTyR36VZ90jy7dXWBfC5D1nzy5rkDlqQQ/vRs/nmmK++LBfAp/C',
						),
						10 => array(
							'path'  => 'js/all.js',
							'value' => 'sha384-zRXLxPg9pQ61oxmSjS56csC5TakUQYuHE2S0yVHsc8y9YCGC/ESUwHKQ6GlR/e1C',
						),
						11 => array(
							'path'  => 'js/brands.js',
							'value' => 'sha384-A3jzsfkDLxpshP330qgRBd4gDzPTDbru+aKtiuSHkoj0+insOzEhLCUNSwwQAxSG',
						),
						12 => array(
							'path'  => 'js/conflict-detection.js',
							'value' => 'sha384-UAavCIlgyaQ2Oita5VzSZHHonYB/S0sTsd9j5DqFD9xyYmKU9EFZ9TaJWrLz4J8o',
						),
						13 => array(
							'path'  => 'js/fontawesome.js',
							'value' => 'sha384-NSCMcVLzk5GbXmbtgTF2V5c7Q4uiYbFqfa0VcjcAKES+CRvFJ28JUYvK/oTRoHaI',
						),
						14 => array(
							'path'  => 'js/regular.js',
							'value' => 'sha384-HkW1QIb74+Y6dTGMSHxicBXnZOD7ZWzSar9kTOLodCobY+Xo7PqjnTJcE8/nAHne',
						),
						15 => array(
							'path'  => 'js/solid.js',
							'value' => 'sha384-e9lVLl7d3IOLUOOWnrcheqxjv7Cj2SQYuYESpfBUgWY0r5zXfFUus4S2D/P7SafZ',
						),
						16 => array(
							'path'  => 'js/v4-shims.js',
							'value' => 'sha384-snJEaAGGPINatMFK6NnvLcVGotCqpacdqYGYDfRMaaPeqOt6fH7+zsCrTocZNDjT',
						),
					),
					'pro'  => array(),
				),
				'version'       => '7.0.0',
			),
		),
	);
}
