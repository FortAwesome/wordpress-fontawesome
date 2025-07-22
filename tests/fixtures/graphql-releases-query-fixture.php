<?php
namespace FortAwesome;

function graphql_releases_query_fixture() {
	return
    [
        'latest_version_5' => [
            'version' => '5.15.4',
        ],
        'latest_version_6' => [
            'version' => '6.7.2',
        ],
        'latest_version_7' => [
            'version' => '7.0.0',
        ],
        'releases' => [
            0 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-VVoO3UHXsmXwXvf1kJx2jV3b1LbOfTqKL46DdeLG8z4pImkQ4GAP9GMy+MxHMDYG',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-JT52EiskN0hkvVxJA8d2wg8W/tLxrC02M4u5+YAezNnBlY/N2yy3X51pKC1QaPkw',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-7mC9VNNEUg5vt0kVQGblkna/29L8CpTJ5fkpo0nlmTbfCoDXyuK/gPO3wx8bglOz',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-JZ2w5NHrKZS6hqVAVlhUO3eHPVzjDZqOpWBZZ6opcmMwVjN7uoagKSSftrq8F0pn',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-TQW9cJIp+U8M7mByg5ZKUQoIxj0ac36aOpNzqQ04HpwyrJivS38EQsKHO2rR5eit',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-X1ZQAmDHBeo7eaAJwWMyyA3mva9mMK10CpRFvX8PejR0XIUjwvGDqr2TwJqwbH9S',
                        ],
                        6 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-2CD5KZ3lSO1FK9XJ2hsLsEPy5/TBISgKIk2NSEcS03GbEnWEfhzd0x6DBIkqgPN1',
                        ],
                        7 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-i3UPn8g8uJGiS6R/++68nHyfYAnr/lE/biTuWYbya2dONccicnZZPlAH6P8EWf28',
                        ],
                        8 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-tqpP2rDLsdWkeBrG3Jachyp0yzl/pmhnsdV88ySUFZATuziAnHWsHRSS97l5D9jn',
                        ],
                        9 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-hXqI+wajk6jJu2DXwf2oqBg6q5+HqXM5yz9smX94pDjiLzH81gAuVtjter66i1Ct',
                        ],
                        10 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-kbPfTyGdGugnvSKEBJCd6+vYipOQ6a+2np5O4Ty3sW7tgI0MpwPyAh+QwUpMujV9',
                        ],
                        11 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-BRge2B8T+0rmvB/KszFfdQ0PDvPnhV2J80JMKrnq21Fq6tHeKFhSIrdoroXvk7eB',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '5.0.1',
            ],
            1 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-bJB2Wn8ZuuMwYA12t6nmPqVTqT64ruKTAWqdxs/Oal3vexA7RPAo3FtVU5hIil2E',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-F8vNf2eNIHep58ofQztLhhWsZXaTzzfZRqFfWmh7Cup7LqrF0HCtB6UCAIIkZZYZ',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-CTTGZltCsihOiEwOCbT7p1lhij8kYk6lapCladmNzxj4yXj/AKp6q3+CRoNN3UCG',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-GtLUznQ3nMgus15JP1pAE2UH9HAQi8gjQTNfIT+Gq6zFPeeq3y+Xtxt5HUBFF0YO',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-WEKepgUDOaHRK2/r+qA7W/Srd+36IIOmBm/+wm9aSz6acYC0LkyM9UJElLVNy95T',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-sV6Qj6KRPF7HrXfo5NK0evVt+YbNxUuGZU2udYKDAxwxPVTuEE6lofcZJhRMK4WT',
                        ],
                        6 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-xiGKJ+4CP2p2WkTifyjHDeZVAg1zBrnJV8LU33N7J+5BWp1biPcSpEJJY7hFiRLn',
                        ],
                        7 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-V+scQ15NnQuKVajRBsSery7bV87d0xDAoCs4pB8ZcwW74+zzW5CkgRmIFOYw8kKX',
                        ],
                        8 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-CxMnuVDquTXcsJnW1rAfSm4uzGr12HENF1oe+JRZm4jcQDerJ6VeA1XLvAso396r',
                        ],
                        9 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-ihKlq3j4PocIYMPkNra+ieEVsLuFzj4rp1yjn3jq+La7r4G9kf9COpWfOI8SGapM',
                        ],
                        10 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-KDEuZV2OBU0Q264kBX2Idu9gYr5z/fQrtvUsKfuKGEDkDxV0GBVN/qi3QoLZPmbJ',
                        ],
                        11 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-0nloDHslShcnKvH94Zv8nb0zPlzTFCzfZGx9YxR2ngUWs9HXXHVx1PUQw0u9/7LE',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '5.0.2',
            ],
            2 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-KFTzeUQSHjcfuC8qqdFm+laWVqpkucx/3uXo41hhKQzUEtbNnNSk8KEEBZ+2lEQy',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-J6h7hpR0mfr79Ck/ZfDrhN14FnkbkLbd+mm0yTw5spSpK08yOK/AB9IRR/Dcg8EJ',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-l2oTZy4pLseT/J6oW0mwsjKPhjpTctOfU191uVonzezZiqw9PPcz4AMKsIAeyR4P',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-cDXlx+8npD3wa2ahyeSZvsi9VlRrMmJVIB1rpK7Ftyq4cppWM9d2mBhrlOqYBljt',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-ioYc/tyAAvPTKdlEWH/BDO/Fn0RGAWisNzyfZNt74mHfA6UPN2tzjD6Nm4ieQfBR',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-bnoXyQHIAXdkrtQTtvuajtPgmWqHQ8657dQ4vzySapygDMqzijBpEq96AwgX2u4N',
                        ],
                        6 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-4OPaVeLgwRHdGJplmRGxGcoGYwxBAdR8Qr9z/Av7blRYPlRIPtjTygdtpQlD1HHv',
                        ],
                        7 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-68dqWCRgViK/UsBTW5vGfntS6GdBDT5D4KWUBXTf6IkF2NFFD+X/0QNs0FZaIELt',
                        ],
                        8 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-sBtO3o3oG61AtAKrg74kfk50JP0YHcRTwOXgTeUobbJJBgYiCcmtkh784fmHww23',
                        ],
                        9 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-J0ggktpCvzBHSxd/a8EBQgQDIWBtASK5rhHMvGWuR/UyjuPgX0iCAcb3OlfhvlQz',
                        ],
                        10 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-DX1/9hggbc1yKVl40n2dNF9OzLf9ZPwZm87WzIW+FinkgjSq18PXpUxOL4I0iS1+',
                        ],
                        11 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-kysXtDCmCTYxM55rHL+9xPu6+Inoi3ZzZHvcxkXs+iPj5nymJKlauQdXyzubyD0b',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '5.0.3',
            ],
            3 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-DmABxgPhJN5jlTwituIyzIUk6oqyzf3+XuP7q3VfcWA2unxgim7OSSZKKf0KSsnh',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-1beec9tTZuu+KrTudmvRnGpK81r78DKCAXdphCvdG+PR+n/WCczsYPqTBTvYsM7z',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-xdTUmhbcetyLRVL4PAriRajOve+/5pjOiy5sJABnhXMcRMVc9HI9s2KmOCjjDK/P',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-nM5tBytXTc1HDZ/A3My2gNT2TxLk/M/5yFi0QrOxaZjBi7QpKUfA2QqT+fcSxSlg',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-g2aKxiZcFezoVOq4MsjaxuBbSxSlXD/NRQ5GaPLfvCtcTLgP3fYZKKAGxCM/wMfe',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-MCR8qGTbdyK+hklwz1eKgGiAjT57F5HEJMs/uHRAwZ6GI5602TyGI89FyrbUwiIc',
                        ],
                        6 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-nVi8MaibAtVMFZb4R1zHUW/DsTJpG/YwPknbGABVOgk5s6Vhopl6XQD/pTCG/DKB',
                        ],
                        7 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-dl3ONr32uA3YqpqKWzhXLs5k1YbKOn3dwiMbEP1S/XQMa3LPRwvJrhW7+lomL/uc',
                        ],
                        8 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-l7FyBM+wFIWpfmy8RYkWgEu/Me6Hrz98ijLu4nP3PkGbTtTCvtHB5ktI8hLEgEG3',
                        ],
                        9 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-lwwoO5Gg19TptbILrLBjV28EVJ9RW3tD3cGyjCRn3OY9IuLua/YRlE47btZIXfMv',
                        ],
                        10 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-4KkAk2UXMS9Xl3FoAAN43VJxRZ/emjElCz60xUTegPOZlbPLZGylvor2v7wQ0JNb',
                        ],
                        11 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-yfrMPoFcXUzdvECrvYRYE7wlxouXxjRSge5x6BlPPOb38tW4n0e8EW79RGU7VY0R',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-1RxicL8bcQJWgpr/clvtGVG7DVFJvDX/DVsJsbjKhXtdo8r5WVZQqB9AHTNPr08A',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-sFwP5Zsnp6I4zQxUMPHvv8Bk16eEzU0YhaNbMCftDHPKDD+BR8WdXAHKL4xpipII',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-VFi8UvBDvM8muKO8ogMXi2j8vdJiu8hq1uxpX/NS8BsftBiJpheM5AuhFH1dvURx',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-4FGoKudkcpRXgx5UNFa5TxzaHUhnvCGFDeZKncEn9KJx/l07kcid3VbpwajrvrFW',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-eyjlqgvgpHiWM0GoL4/hsTh22piTKmMTM+sfJYacddG2n9AEubqQB/w4CPJK1/1b',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-TlWtvBj4TXNlpJC5Qq4aHel0R/dywVcP/6eOFC0qptQ71WWSxJCvuTajjGb1duS9',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-rHay3RzsgCtbjvDmBLThu6ESXlU4Al5STjlHSpNygnbeyt04OP1uKZVXB2Zy16+T',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-vV0064GQjt+TcoZxVPm/f6vyAivSNofFvOHKLWxcDl784Dzm9W4BBpoTvUG4vi5a',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-/877azmwW/YhoBsPeM9dh61dNr5XGbuk24lyjPbFWyrPaZPyU2oxgOY6PE1OH4z4',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-7L9/YJQEf9kLPc6sdtoVIsuBNxCVi4OmHPcszcY685IJIcB52hgYoL1OiwTawJS/',
                        ],
                        10 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-iXxa9ExuZ0Fi2N2VO/buuWuAgYIUXNtOaJiKLa40Bjt43KJpzJdhg2TBHyBVqCPh',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-YzSStfq1m16y1v5M97ViNRpiQUCVpagVVOkqlmww8otyjFkY6EXT4dShlKNuxRDu',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-WJDZ/GI6pz1VoELs6i44T3f00fguksrLXIx3LXHdlaAzmOvX/mTK5j+qzHJdKejC',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-8XZ16R7aSGin4NRuv6gn5xfbsvad5H8LR41g48iduwkfZEqDgXlvUjkJKgxqZUiW',
                        ],
                    ],
                ],
                'version' => '5.0.4',
            ],
            4 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-VY3F8aCQDLImi4L+tPX4XjtiJwXDwwyXNbkH7SHts0Jlo85t1R15MlXVBKLNx+dj',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-rK0EPNdv8UCeRNPzX+96ARRlf9hZM+OukGceDTdbPH30DYcSI1x5QyBU7d2I2kHX',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-dbkYY2NmVwxaFrr4gq04oVh6w39ovmevsgD80Il1Od3hwpgREqyPb3XqbpaSwN4x',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-HGbVnizaFNw8zW+vIol9xMwBFWdV7/k61278Zo1bnMy9dLmjv48D7rtpgYRTe5Pd',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-GfC9nfESTZkjCPFbevBVig3FTd6wkjRRYMtj+qFgK8mMBvGIje2rrALgiBy6pwRL',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-U2b24h7gWqOYespg+vI5yiIn4ZYlTevT0N96xkGrw7ktP1gg9XwqEslsdTLJdlGg',
                        ],
                        6 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-0AJY8UERsBUKdWcyF3o2kisLKeIo6G4Tbd8Y6fbyw6qYmn4WBuqcvxokp8m2UzSD',
                        ],
                        7 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-4iSpDug9fizYiQRPpPafdAh5NaF8yzNMjOvu3veWgaFm0iIo8y4vUi7f3Yyz5WP1',
                        ],
                        8 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-rttr/ldR2uHigckjTCjMDe47ySeFVaL3Q7xUkJZir56u8Z8h/XnHJXHocgyfb25F',
                        ],
                        9 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-G375DXNEVfALvsggywPWDYrRxNOvXaCYt/kiq/GXmbaDW8/B0XtbC8iuLpXXm1jF',
                        ],
                        10 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-U0ZJ7q5xbT8hEoRqj61HzpvsqNOQ8bsHY2VqSRPqGOzjHXmmV70Aw+DBC/PT00p4',
                        ],
                        11 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-L8zntmMOcCbOxXiL5Rjn6ubB7KunZiQ8U3bb9x6FFTGDEvVEESW9n+x49jm34K3W',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-ldFHeX3xCFvM4uf7m0mCMIoCPVwM71jopwqLZRldf+ojynoGVSxDiphfScLukkwO',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-Ks7IvHjmJ4FIFxhK4iNrtW0rAVo1DlCYpe/nDsK8CnU+yactd38YiNE1GT018WPg',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-sATKZbJwxaEIU3unIoL1VMbIyrNNh7PlgnaiWlicWXeRA7qdnzfFzMP9AaN2wfTU',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-YWWfxaKIDrbFXuVQnpxASJDHmFl2K5f2vDgrcROb+rYycoqcQVdMlfu3U38boTg/',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-CydLcYoDSbudHX/6hygyQD4jBMPsv91d/RwdtH1qxI79KG8kII/OzxKDwsswywA4',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-uBARwTxpZ7FB08kQlCOS/dUaN3TrGGcHthrXYIhZBpdq7YtUdVDM1sAUH9NIozMl',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-BptPo+4C0N+fnMTnfw7ddW/zYUJhuNEe7edve8UrMbs+fCpfDJvJcC/lpa5Nvaky',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-FrB6Se1Wkxlx66xA4rPuOoOolLyQt5B1uptDmtLJSIVRJDbNkmE3QOLipnMuAbUW',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-G12tjfNd/W8L4IrE5+f13LUbpzVowwhNDv+WNecvxjbaGN9bbSY7epBOqUlRqXnq',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-Ln5PcCmuH8v+AF9nt+HkM2GfXjsn1CtVc0n+ciM8+oe3nwGyPCceDVva7bUjNfo0',
                        ],
                        10 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-jzS22FYPy68IBBet2IRM5aQDOXjg9X1g+drXIVonDtyqGFCtUA0YIdgHdvCCX/fD',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-M8TFIPAJNl8UIC8OP6GFcIE0SHkGN4zjwwjz+BBTz60XhNegOrZmjNtTQNKifmXX',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-R/e3QvpS9m8HcN9b9l6nNo678ekTXL31kFY/XtRHSjrihDX8A2DF8HaXhdlAtzMx',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-X9eLyweB0LOTEGCwMARo9+zibrXQYmBMSrhFk4ncpT/WYnPIcpTg0IgBFDgzuPwL',
                        ],
                    ],
                ],
                'version' => '5.0.6',
            ],
            5 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-IiIL1/ODJBRTrDTFk/pW8j0DUI5/z9m1KYsTm/RjZTNV8RHLGZXkUDwgRRbbQ+Jh',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-q3jl8XQu1OpdLgGFvNRnPdj5VIlCvgsDQTQB6owSOHWlAurxul7f+JpUOVdAiJ5P',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-A/oR8MwZKeyJS+Y0tLZ16QIyje/AmPduwrvjeH6NLiLsp4cdE4uRJl8zobWXBm4u',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-v2Tw72dyUXeU3y4aM2Y0tBJQkGfplr39mxZqlTBDUZAb9BGoC40+rdFCG0m10lXk',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-TGBI4yK0MJz2ga16RLBBt4xT4aoPMPmRYhfu1Kl5IJ0gsLyOBIKHEb49BtoO+lPS',
                        ],
                        6 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ',
                        ],
                        7 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-sCI3dTBIJuqT6AwL++zH7qL8ZdKaHpxU43dDt9SyOzimtQ9eyRhkG3B7KMl6AO19',
                        ],
                        8 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c',
                        ],
                        9 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-t7yHmUlwFrLxHXNLstawVRBMeSLcXTbQ5hsd0ifzwGtN7ZF7RZ8ppM7Ldinuoiif',
                        ],
                        10 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-+Ga2s7YBbhOD6nie0DzrZpJes+b2K1xkpKxTFFcx59QmVPaSA8c7pycsNaFwUK6l',
                        ],
                        11 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-4CnzNxEP5RK316IYY2+W4hc05uJdfd+p9iNVeNG9Ws3Qxf5tKolysO9wu/8rloj2',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-OGsxOZf8qnUumoWWSmTqXMPSNI9URpNYN35fXDb5Cv5jT6OR673ah1e5q+9xKTq6',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-VRONz34zTLl4P+DLYyJ8kP8C3tB1PGtqL5p8nBAvHuoc1u32bR3RHixrjffD8Fly',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-+5VkSw5C1wIu2iUZEfX77QSYRb5fhjmEsRn8u4r9Ma8mvu/GvTag4LDSEAw7RjXl',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-shmfBA2CRxp88gq8NcvWbEN8KExYU4uvQUBEG36BStGZ5k91nGKE4wDvvWvuimbu',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-0w6MzzKHIB9cUlfWSmSp1Pj6XqGGDseWSMz1Yppk3UOc1dhYhpFx1AuCkMBECEvC',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-+iHwwKZGTdlVFbv4fsKmLkogfdKlp47zQGkSMDN3ANc8kXjyKudKvQwinI5VH+2C',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-b2wDmqWyAwmI2rS5ut5UweBS1V32L/k1+2Oo7eCaHdXOS/1bFwC8AKevTI6N28LN',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-816IUmmhAwCMonQiPZBO/PTgzgsjHtpb78rpsLzldhb4HZjFzBl06Z3eu4ZuwHTz',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-gJijC/2qM/p3zm2wHECHX1OMLdzlu61sNp7YfmFQxo+OyT9hO1orX7MmnHhaoXQ4',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-Ht3fAeBiX/rVmKVyMwONAIIt0aRoPzZgq1FzdRgR9zFo+Kcd8YDwUbFlTItfaYW4',
                        ],
                        10 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-mfSnp84URDGC1t+cg63LgVKwEs63ulRUpjNneyDZMGMAE9ZKUNZ85rMBMHucGLYP',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-SIp/+zr0hyfSVIQPkAwB/L1h4fph6T3CmU4mE7IFtGJlgwoCko0Bye/1J0sjyh4v',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-jTxqWCb7UqRDQDd2Nkuh5BkHe9k+ElbFLa3NaJfid5kBK/+cVktzVRXrw0isFWxf',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-w/sFNq23wbOXJOUpFyISABLXk9tA4Z8r9hl80er2mobEwgS7VXXYDANaWyrCWe3/',
                        ],
                    ],
                ],
                'version' => '5.0.8',
            ],
            6 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-ATC/oZittI09GYIoscTZKDdBr/kI3lCwzw3oBMnOYCPVNJ4i7elNlCxSgLfdfFbl',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-Lyz+8VfV0lv38W729WFAmn77iH5OSroyONnUva4+gYaQTic3iI2fnUKtDSpbVf0J',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-seionXF7gEANg+LFxIOw3+igh1ZAWgHpNR8SvE64G/Zgmjd918dTL55e8hOy7P4T',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-29Ax2Ao1SMo9Pz5CxU1KMYy+aRLHmOu6hJKgWiViCYpz3f9egAJNwjnKGgr+BXDN',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-Hl6tZnMfNiJHYyFxpmnRV8+pziARxY3X/4XWfFXldG7sdkkLv+Od2Gpc57P7C1g6',
                        ],
                        6 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl',
                        ],
                        7 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-qJKAzpOXfvmSjzbmsEtlYziSrpVjh5ROPNqb8UZ60myWy7rjTObnarseSKotmJIx',
                        ],
                        8 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-2IUdwouOFWauLdwTuAyHeMMRFfeyy4vqYNjodih+28v2ReC+8j+sLF9cK339k5hY',
                        ],
                        9 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-BazKgf1FxrIbS1eyw7mhcLSSSD1IOsynTzzleWArWaBKoA8jItTB5QR+40+4tJT1',
                        ],
                        10 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-P4tSluxIpPk9wNy8WSD8wJDvA8YZIkC6AQ+BfAFLXcUZIPQGu4Ifv4Kqq+i2XzrM',
                        ],
                        11 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-9f5gaI9TkuYhi5O/inzfdOXx2nkIhDsLtXqBNmtY6/c5PoqXfd0U2DAjqQVSCXQh',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-L+XK540vkePe55E7PAfByfvW0XpsyYpsifTpgh/w8WvH6asVg/c2zqp0EfZfZTbF',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-+LMmZxgyldhNCY6nei3oAWJjHbpbROtVb+f5Ux/nahA+Xjm3wcNdu7zyB39Yj38S',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-31qpW3hduWGiGey9tdI9rBBxiog5pxZbPiAlD6YKIgy0P2V1meprKhvpk+xJDkMw',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-wD8IB6DSQidXyIWfwBrsFwTaHTQDsgzyeqzhd1jNdBZHvGSa7KRGb6Q5sMlroCyk',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-hJbmKHxbgrH79UtKxubo1UTe96bOL4Xfhjaqr0csD1UMPEPbeV+446QAC+IGxY+b',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-k8v16DuQ4ZFtRfpTeqTW4tcHIj5tkvUNQm1QiLs90XiToLzyFeV+yxujHjSZ2wim',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-yVUvm1bVSmayKKt0YHPKotNQzlBvgNhEBbQ6U1d38bjpapXMVmE+SLXrpQ9td4Ij',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-DtPgXIYsUR6lLmJK14ZNUi11aAoezQtw4ut26Zwy9/6QXHH8W3+gjrRDT+lHiiW4',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-yIJb2TJeTM04vupX+3lv0Qp9j0Pnk8Qm9UPYlXr3H0ROCHNNLoacpS++HWDabbzi',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-8QYlVHotqQzcAVhJny7MO9ZR0hASr6cRCpURV+EobTTAv5wftkn4i+U6UrMqoCis',
                        ],
                        10 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-06sraYAcw8BzUjsPn5z8Qi/QAA2/ZJl5GN3LGtRp7k+tZpu7kw+sRNXDDTU4RkOt',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-C6h/8oKUfY6cVuGfFSu9uGIlFkaD1u1j+ByYGFTdFbOpHOHpw39lKxqEpRgLQg6A',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-nISI3wKDp2gWn9L91zXOKXZ6JPt2mteGTnaJAMfeNgAoeLKl2AQsWLH69HMmBXHa',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-vuyo8HdrwozCl2DhHOJ40ytjEx9FGy0cqu8i5GHeIoSUm6MPgqCXAVoUIsudKfuE',
                        ],
                    ],
                ],
                'version' => '5.0.9',
            ],
            7 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-KtmfosZaF4BaDBojD9RXBSrq5pNEO79xGiggBxf8tsX+w2dBRpVW5o0BPto2Rb2F',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-8WwquHbb2jqa7gKWSoAwbJBV2Q+/rQRss9UXL5wlvXOZfSodONmVnifo/+5xJIWX',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-R7FIq3bpFaYzR4ogOiz75MKHyuVK0iHja8gmH1DHlZSq4tT/78gKAa7nl4PJD7GP',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-HTDlLIcgXajNzMJv5hiW5s2fwegQng6Hi+fN6t5VAcwO/9qbg2YEANIyKBlqLsiT',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-ucawWSvpdgQ67m4VQzI6qBOHIsGRoY2soJtCkkp15b6IaNCLgauWkbKR8SAuiDQ7',
                        ],
                        6 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+',
                        ],
                        7 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-6jhVhr5a+Z1nLr9h+fd7ocMEo847wnGFelCHddaOOACUeZNoQwFXTxh4ysXVam8u',
                        ],
                        8 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-M2FSA4xMm1G9m4CNXM49UcDHeWcDZNucAlz1WVHxohug0Uw1K+IpUhp/Wjg0y6qG',
                        ],
                        9 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-JWLWlnwX0pRcCBsI3ZzOEyVDoUmngnFnbXR9VedCc3ko4R3xDG+KTMYmVciWbf4N',
                        ],
                        10 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-Q7KAHqDd5trmfsv85beYZBsUmw0lsreFBQZfsEhzUtUn5HhpjVzwY0Aq4z8DY9sA',
                        ],
                        11 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-RLvgmog5EsZMMDnT3uJo6ScffPHTtMbhtV8pcT8kP5UJzlVRU1SP9Hccelk3zYZc',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-KwxQKNj2D0XKEW5O/Y6haRH39PE/xry8SAoLbpbCMraqlX7kUP6KHOnrlrtvuJLR',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-cyAsyPMdnj21FGg6BEGfZdZ99a/opKBeFa8z5VoHPsPj+tLRYSxkRlPWnGkCJGyA',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-HE+OCjOJOPZavEcVffA6E24sIfY2RwV4JRieXa/3N5iCY8vgnTwZemElENQ8ak/K',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-k/d3hya1Xwx/V3yLAr7/6ibFaFIaN+xeY1eIv42A1Bn2HgfB+/YjLscji1sHLOkb',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-D4yOV+i5oKU6w8CiadBDVtSim/UXmlmQfrIdRsuKT3nYhiF/Tb6YLQtyF9l0vqQF',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-WjYgBJXUWNFTzFd4wNJuzUZx28GSgjzXrPO4LJrng96HFrI/nLrG1R5NET65v1yR',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-S/uB02cfkgX8kd+j6f3gmw/PPTg8xSiE/w6d8dE852PzHXkGBYLrqpWFse9hInR2',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-+1nLPoB0gaUktsZJP+ycZectl3GX7wP8Xf2PE/JHrb7X1u7Emm+v7wJMbAcPr8Ge',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-OwdVp9K/baqiXthTvRnYzMcsTaqwG19SfDkTRc/GBIhK9eYlWVVBEvLlueA0STAP',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-TxXqLyCP6HYGVtr9V1M1rQE7IMbBEZoDdOX+MFeYNbWNwopWKVQM8NyqtU2x+5t2',
                        ],
                        10 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-rv/n2A+UxOzR1qs4wrcOtJ7Ai5Hcn3QQ8tvEkOo5lCvqCD3xwpeO3KZP18JpSXr3',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-QNGmoJVI8f07j7N4+DSn4Cdob1PTBJOR6jRGwUwqSPyL2HmvWaBPXuSXOcStGo9D',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-m3J/Wb6KcNkFJIpCugSSJITG80sKhEA+16UCFdq1LnpMTOCXwwpeyrE1FmyqoArv',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-H+U1wWQdWbEtuQPJ4ZpMl8yWydI6xc/306L/NZkpGY8BGpeSpu39V20x03S3xcMw',
                        ],
                    ],
                ],
                'version' => '5.0.10',
            ],
            8 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-Pln/erVatVEIIVh7sfyudOXs5oajCSHg7l5e2Me02e3TklmDuKEhQ8resTIwyI+w',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-rnr8fdrJ6oj4zli02To2U/e6t1qG8dvJ8yNZZPsKHcU7wFK3MGilejY5R/cUc5kf',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-RGDxJbFQcd3/Rei8rYb+3xO3YREd0abxm8WfLkYj7j4HHo5ZVuNUGVx8H8GbpFTQ',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-VxweGom9fDoUf7YfLTHgO0r70LVNHP5+Oi8dcR4hbEjS8UnpRtrwTx7LpHq/MWLI',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-N44Xrku5FaDiZLZ8lncIZLh+x9xiqk1r0NTlUJQ5xanSpdORyQHP4Zp2WQJ9GlpJ',
                        ],
                        6 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-Voup2lBiiyZYkRto2XWqbzxHXwzcm4A5RfdfG6466bu5LqjwwrjXCMBQBLMWh7qR',
                        ],
                        7 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-BPIhZF7kZGuZzBS4SP/oIqzpxWuOUtsPLUTVGpGw+EtB1wKt1hv63jb2OCroS3EX',
                        ],
                        8 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-6AOxTjzzZLvbTJayrLOYweuPckqh0rrB4Sj+Js8Vzgr85/qm2e0DRqi+rBzyK52J',
                        ],
                        9 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-6XNKyHeL6pEPXURVNSKQ0lUP80a5FHqN0oFqSSS8Qviyy2u0KmCMJlQ5iLiAAPBg',
                        ],
                        10 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-652/z7yNdGONCCBu0u5h5uF9voJhBdgruAuIDVheEaQ7O/ZC9wyyV+yZsYb32Wy7',
                        ],
                        11 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-STc8Gazx86A+NmeBWQTqa5Ob1wGSRQZevexYiUkKdiqZhi5LSZ28XYAvgptHK5HH',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-HX5QvHXoIsrUAY0tE/wG8+Wt1MwvaY28d9Zciqcj6Ob7Tw99tFPo4YUXcZw9l930',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-M4owBK0KiG0Vz+G5z/8v8tBb1+w9ts66Z6xKkZEPgBwzISkrcNra4GxZcvJPyaGB',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-ZDxYpspDwfEsC0ZJDb74i/Rqjb1CnX3a69Dz9vXv4PvvlTEkgMI02TATTRNJoZ06',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-PWGGmWk9+xVydf1Gzso0ouaikBBKLu4nCY52q+tBUMq5iXmRhpgTuDkjbtxZ1rXT',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-tYZB+BP2inzRg01pQhSlW4Tloc0ULXYGiBaf5kSB5Tb3+l84bJy+PKerqziKz3iv',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-KY40QRrgoQAM9BPN+gm7JoK30M/P6QqKRCbXUS3uWbPfycyiVeEsPkGNMhcNL3DU',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-ubRAMbpAKC+ULwg5mkUQLFReIXq1yeiKIcfV7cYp+rEaeINfEglYX6JOte80PCDk',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-quzri7saio48xMf3ED3HiI5YaItt68Q+0J3qc9EIfk1jk3QqCJhS24l6CZpUGfEe',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-QlvHmHtevrYI4s/vdiK6chTDouw2pRA5av6ZLVtENubkoCgSZz4ZaXVvplQ1FRPs',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-CUrLKzrygRugRUPtEJ1u4nV4Ec6GnuDMRDGaxfoFXLI+sraWS6rqGg2Sjfs6BTet',
                        ],
                        10 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-z7YlG414oqy0TO7qY/nGfC8zd1LL8JAX3iNQ3iLybUIziHzaMYqBwUvhizEwV0Fd',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-p/qo0lifpToZ0ubNiv1WFzlmYJU+BOenvU+evARCvCqALvbpZuqmZQ207vmYD6QL',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-y//1Knkpeyl2S568g2ECqUA4n3MKf+kpj1/sfjUQbR1WtBPONceBHrQVMiAqfjLH',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-6+8zJP76v3EziONR2vMd32iSU3qbdicAE8KNp+NWniM6mBmvN80NlY+sbvCO+w7M',
                        ],
                    ],
                ],
                'version' => '5.0.12',
            ],
            9 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-VGCZwiSnlHXYDojsRqeMn3IVvdzTx5JEuHgqZ3bYLCLUBV8rvihHApoA1Aso2TZA',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-GVa9GOgVQgOk+TNYXu7S/InPTfSDTtBalSgkgqQ7sCik56N9ztlkoTr2f/T44oKV',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-EWu6DiBz01XlR6XGsVuabDMbDN6RT8cwNoY+3tIH+6pUCfaNldJYJQfQlbEIWLyA',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-Rw5qeepMFvJVEZdSo1nDQD5B6wX0m7c5Z/pLNvjkB14W6Yki1hKbSEQaX9ffUbWe',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-LAtyQAMHxrIJzktG06ww5mJ0KQ+uCqQIJFjwj+ceCjUlZ2jkLwJZt1nBGw4KaFEZ',
                        ],
                        6 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe',
                        ],
                        7 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-G/XjSSGjG98ANkPn82CYar6ZFqo7iCeZwVZIbNWhAmvCF2l+9b5S21K4udM7TGNu',
                        ],
                        8 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY',
                        ],
                        9 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-IJ3h7bJ6KqiB70L7/+fc44fl+nKF5eOFkgM9l/zZii9xs7W2aJrwIlyHZiowN+Du',
                        ],
                        10 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ',
                        ],
                        11 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-qqI1UsWtMEdkxgOhFCatSq+JwGYOQW+RSazfcjlyZFNGjfwT/T1iJ26+mp70qvXx',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-oi8o31xSQq8S0RpBcb4FaLB8LJi9AT8oIdmS1QldR8Ui7KUQjNAnDlJjp55Ba8FG',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-t3MQUMU0g3tY/0O/50ja6YVaEFYwPpOiPbrHk9p5DmYtkHJU2U1/ujNhYruOJwcj',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-LDuQaX4rOgqi4rbWCyWj3XVBlgDzuxGy/E6vWN6U7c25/eSJIwyKhy9WgZCHQWXz',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-d8NbeymhHpk+ydwT2rk4GxrRuC9pDL/3A6EIedSEYb+LE+KQ5QKgIWTjYwHj/NBs',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-HLkkol/uuRVQDnHaAwidOxb1uCbd78FoGV/teF8vONYKRP9oPQcBZKFdi3LYDy/C',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-drdlAcijFWubhOfj9OS/gy2Gs34hVhVT90FgJLzrldrLI+7E7lwBxmanEEhKTRTS',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-8YpCivPy+AkMdZ0uAvEP04Gs77AN/6mS5AmZqkCwniP51zSG8rCMaH06OYuC4iXd',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-d84LGg2pm9KhR4mCAs3N29GQ4OYNy+K+FBHX8WhimHpPm86c839++MDABegrZ3gn',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-44Hl7UlQr9JXHFcZOp9qWHk2H1lrsAN/cG3GNgB2JqbciecuJ2/B9sjelOMttzBM',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-BUkEHIKZJ0ussRY3zYfFL7R0LpqWmucr9K38zMTJWdGQywTjmzbejVSNIHuNEhug',
                        ],
                        10 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-+iGqamqASU/OvBgGwlIHH6HSEgiluzJvTqcjJy8IN9QG9aUfd0z0pKpTlH7TpU7X',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-1bAvs6o5Yb7MMzvTI3oq2qkreCQFDXb6KISLBhrHR+3sJ/mm7ZWfnQVRwScbPEmd',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-CucLC75yxFXtBjA/DCHWMS14abAUhf5HmFRdHyKURqqLqi3OrLsyhCyqp83qjiOR',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-LDfu/SrM7ecLU6uUcXDDIg59Va/6VIXvEDzOZEiBJCh148mMGba7k3BUFp1fo79X',
                        ],
                    ],
                ],
                'version' => '5.0.13',
            ],
            10 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-7xAnn7Zm3QC1jFjVc1A6v/toepoG3JXboQYzbM0jrPzou9OFXm/fY6Z/XiIebl/k',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-ozJwkrqb90Oa3ZNb+yKFW2lToAWYdTiF1vt8JiH5ptTGHTGcN7qdoR1F95e0kYyG',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-avJt9MoJH2rB4PKRsJRHZv7yiFZn8LrnXuzvmZoD3fh1aL6aM6s0BBcnCvBe6XSD',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-TbilV5Lbhlwdyc4RuIV/JhD8NR+BfMrvz4BL5QFa2we1hQu6wvREr3v6XSRfCTRp',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-5aLiCANDiVeIiNfzcW+kXWzWdC6riDYfxLS6ifvejaqYOiEufCh0zVLMkW4nr8iC',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-epK5t6ciulYxBQbRDZyYJFVuWey/zPlkBIbv6UujFdGiIwQCeWOyv5PVp2UQXbr2',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-ZqDZAkGUHrXxm3bvcTCmQWz4lt7QGLxzlqauKOyLwg8U0wYcYPDIIVTbZZXjbfsM',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-juNb2Ils/YfoXkciRFz//Bi34FN+KKL2AN4R/COdBOMD9/sV/UsxI6++NqifNitM',
                        ],
                        10 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-Y+AVd32cSTAMpwehrH10RiRmA28kvu879VbHTG58mUFhd+Uxl/bkAXsgcIesWn3a',
                        ],
                        11 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-Z7p3uC4xXkxbK7/4keZjny0hTCWPXWfXl/mJ36+pW7ffAGnXzO7P+iCZ0mZv5Zt0',
                        ],
                        12 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-3qT9zZfeo1gcy2NmVv5dAhtOYkj91cMLXRkasOiRB/v+EU3G+LZUyk5uqZQdIPsV',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-87DrmpqHRiY8hPLIr7ByqhPIywuSsjuQAfMXAE0sMUpY3BM7nXjf+mLIUSvhDArs',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-C1HxUFJBptCeaMsYCbPUw8fdL2Cblu3mJZilxrfujE+7QLr8BfuzBl5rPLNM61F6',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-PnWzJku7hTqk2JREATthkLpYeVVGcBbXG5yEzk7hD2HIr/VxffIDfNSR7p7u4HUy',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-ANTAgj8tbw0vj4HgQ4HsB886G2pH15LXbruHPCBcUcaPAtn66UMxh8HQcb1cH141',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-6kuJOVhnZHzJdVIZJcWiMZVi/JwinbqLbVxIbR73nNqXnYJDQ5TGtf+3XyASO4Am',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-rvfDcG9KDoxdTesRF/nZ/sj8CdQU+hy6JbNMwxUTqpoI2LaPK8ASQk6E4bgabrox',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-/h6SKuA/ysT91EgYEGm9B6Z6zlaxuvKeW/JB7FWdGwCFalafxmGzJE2a63hS1BLm',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-2RBBYH6GaI11IJzJ6V1eL7kXXON+epoQIt+HqpzQdBrtyT7gNwKPDxo2roxUbtW9',
                        ],
                        8 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-E5SpgaZcbSJx0Iabb3Jr2AfTRiFnrdOw1mhO19DzzrT9L+wCpDyHUG2q07aQdO6E',
                        ],
                        9 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-QPbiRUBnwCr8JYNjjm7CB0QP9h4MLvWUZhsChFX6dLzRkY22/nAxVYqa5nUTd6PL',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-ckjcH5WkBMAwWPjTJiy7K2LaLp37yyCVKAs3DKjhPdo0lRCDIScolBzRsuaSu+bQ',
                        ],
                        11 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-77i21WTcIcnSPKxwR794RLUQitpNqm6K3Fxsjx8hgoc3ZZbPJu5orgvU/7xS3EFq',
                        ],
                        12 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-S21AhcbZ5SXPXH+MH7JuToqmKYXviahLaD1s9yApRbu1JDiMjPBGQIw/3PCHKUio',
                        ],
                        13 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-q6QALO/4RSDjqnloeDcGnkB0JdK3MykIi6dUW5YD66JHE3JFf8rwtV5AQdYHdE0X',
                        ],
                        14 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-9gfBAY6DS3wT0yuvYN1aaA1Q9R0fYQHliQWLChuYDWJJ0wQJpoNZrzlcqd4+qqny',
                        ],
                    ],
                ],
                'version' => '5.1.0',
            ],
            11 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-SYNjKRRe+vDW0KSn/LrkhG++hqCLJg9ev1jIh8CHKuEA132pgAz+WofmKAhPpTR7',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-0b7ERybvrT5RZyD80ojw6KNKz6nIAlgOKXIcJ0CV7A6Iia8yt2y1bBfLBOwoc9fQ',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-QNorH84/Id/CMkUkiFb5yTU3E/qqapnCVt6k5xh1PFIJ9hJ8VfovwwH/eMLQTjGS',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-S2gVFTIn1tJ/Plf+40+RRAxBCiBU5oAMFUJxTXT3vOlxtXm7MGjVj62mDpbujs4C',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-EH3TEAKYd7R0QbCS4OFuYoEpaXITVg5c/gdZ/beEaAbRjMGVuVLLFjiIKOneCzGZ',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-LCsPWAjCFLDeFHB5Y0SBIOqgC5othK8pIZiJAdbJDiN10B2HXEm1mFNHtED8cViz',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-BtvRZcyfv4r0x/phJt9Y9HhnN5ur1Z+kZbKVgzVBAlQZX4jvAuImlIz+bG7TS00a',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-0inRy4HkP0hJ038ZyfQ4vLl+F4POKbqnaUB6ewmU4dWP0ki8Q27A0VFiVRIpscvL',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-NY6PHjYLP2f+gL3uaVfqUZImmw71ArL9+Roi9o+I4+RBqArA2CfW1sJ1wkABFfPe',
                        ],
                        10 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-sAzYCvbTTKFOxT4VHu+ZjHRMXjvfjT6TAqOng28g4jba88Peg5+hkoVIqQKGjmj1',
                        ],
                        11 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-GXi56ipjsBwAe6v5X4xSrVNXGOmpdJYZEEh/0/GqJ3JTHsfDsF8v0YQvZCJYAiGu',
                        ],
                        12 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-T69Lzd4bE7W8/vVrxvfsx45/AAKf6QmKEg5zSl0v9aZwo/pTKseq81mxdpARTQpx',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-xyMU7RufUdPGVOZRrc2z2nRWVWBONzqa0NFctWglHmt5q5ukL22+lvHAqhqsIm3h',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-E5dVkWQIVhVPtBz/KK2TS7EM9l1+5XiWFPX7l3+5ayHPwDguGsHqof3GQbk55AS3',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-bHoj6f1b1CQ6zapOREeYBO/JnDjeV1fLuKn3KHnbqAAnkLva11KY3m8YyKPVXYLF',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-EGKQAl6ZrGi/zGxZ4ykVhc/A3tFVeBiLnneETILtcxQnZpo7ejmb4BkNa3zSgo4K',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-AKIrAHbICIQF+NEqtykrcdzMjExDiKLa9hOyUVsr4PlHtktH7xaD10vO98UnPjuE',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-Ux3tEr1RmnxCht2XbPkWWBuotwMVXKOe0PkWN/nmiD5CSV6Tyjl+Kr0J0iX1yd0q',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-++BmJ9x4V05AhCNnLr/RjPTY4BAFuhZsESUqH5hiwZspBvy7F+DRGvSH8tGHw9P/',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-TUicmScQcYANFcc4OQKEX6V1Zek9o9t+dwW/2tZoXmSigBk9JqfHxZZFlSo+0oRl',
                        ],
                        8 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-cHcg4nvWPIGArJhEgL2F5e09Cn1GyPQpNYKbPatFCpDefCbezZjPA3PhLozKTZnv',
                        ],
                        9 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-KCMfKsP/3VgeibBQRMu4bT+9041Hi2v9PIz9FLOPJBEvxCBklc4o7tRwwQu4FWsT',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-EWJRWU7LQt+ri8YtDjTr8adATyP7y8DwlpE8zruoUC4nHNjtWZMU+iPYK+tFaV3U',
                        ],
                        11 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-0rp6k6cJIuLV1ORowDSSKr4VbEqb664PQUWdBvhJyt6IfkshVb0r6UlOkX6yVdaI',
                        ],
                        12 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-Mw6yr+W+X+ckaAUbsPUb2BcU3Af9aSjmPMIlMr2iplN0VQIpscDWy/VwY5w0sz9w',
                        ],
                        13 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-PyvJtlnGBA/R+hfVbHbnzfeT8G/iTORqPhR5WKGTQXlfmLe5bV+d64NECHG4sIMa',
                        ],
                        14 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-rJQjFeDWQReL3KmIeV81jB594CgKx/MmXyAgiuu88Jo253P+PSMgWzivZQtR6N6J',
                        ],
                    ],
                ],
                'version' => '5.1.1',
            ],
            12 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-nT8r1Kzllf71iZl81CdFzObMsaLOhqBU1JD2+XoAALbdtWaXDOlWOZTR4v1ktjPE',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-HbmWTHay9psM8qyzEKPc8odH4DsOuzdejtnr+OFtDmOcIVnhgReQ4GZBH7uwcjf6',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-zkhEzh7td0PG30vxQk1D9liRKeizzot4eqkJ8gB3/I+mZ1rjgQk+BSt2F6rT2c+I',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-wnAC7ln+XN0UKdcPvJvtqIH3jOjs9pnKnq9qX68ImXvOGz2JuFoEiCjT8jyZQX2z',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-jKeGgxY7zPT61fNXg6OMRDu8vsxOPRLMlgAIUHo1KVag4lyu5B03KsDLYOTMM4ld',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-W14o25dsDf2S/y9FS68rJKUyCoBGkLwr8owWTSTTHj4LOoHdrgSxw1cmNQMULiRb',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-4oV5EgaV02iISL2ban6c/RmotsABqE4yZxZLcYMAdG7FAPsyHYAPpywE9PJo+Khy',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-4BRtleJgTYsMKIVuV1Z7lNE29r4MxwKR7u88TWG2GaXsmSljIykt/YDbmKndKGID',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-QcnrgQuRmocjIBY6ByWMmDvUg3HO4MSdVjY7ynJwZfvTDhVPPQOUI9TRzc6/7ZO1',
                        ],
                        10 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-YdSTwqfKxyP06Jj3UzTeumv8M+Pme60+KND4oF+5r5VeUCvdkw7NhSzFYWbe00ba',
                        ],
                        11 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-YmNA3b9AQuWW8KZguYfqJa/YhKNTwGVD5pQc1cN0ZAVRudFFtR17HR7rooNcVXe4',
                        ],
                        12 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-rn4uxZDX7xwNq5bkqSbpSQ3s4tK9evZrXAO1Gv9WTZK4p1+NFsJvOQmkos19ebn2',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-TXfwrfuHVznxCssTxWoPZjhcss/hp38gEOH8UPZG/JcXonvBQ6SlsIF49wUzsGno',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-Ei2oxwH0wpwmp7KPdhYnajC5fWDdMENOjDw9OfzWvcFcOGn0Egy+L5AAculaqBbD',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-4eP+1rYQmuI3hxrmyE+GT/EIiNbF4R85ciN3jMpmIh+bU5Hz2IU7AdcVe+JS+AJz',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-pcDR01P1wNxsYZiEYdROCAYhU2u8VHOctLrYRonRFtkf/TGEQFWt0rqFbPGWlyn4',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-g3XsWx0Sqi7JIjLKVnwUxEvqrxTMQPIf3PN+vTdWY2AhduP/rnj0rw89v0nbD4Ro',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-B/E/KxBX31kY/5sew+X4c8e6ErosbqOOsA3t4k6VVmx8Hrz//v0tEUtXmUVx9X6Q',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-O6mvz45yC1vfdu/EgUxAoSGrP+sFtepMtj7eOQIW1G3WT9Sj5djActZC0hd/F42D',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-2QRS8Mv2zxkE2FAZ5/vfIJ7i0j+oF15LolHAhqFp9Tm4fQ2FEOzgPj4w/mWOTdnC',
                        ],
                        8 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-yBZ34R8uZDBb7pIwm+whKmsCiRDZXCW1vPPn/3Gz0xm4E95frfRNrOmAUfGbSGqN',
                        ],
                        9 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-eg9wHuvEPj6+GlGomBRaMHLF0QfCnjdASWDKd84DMeM9phhyDaPFou/nHJBt0bz+',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-FQUuiJxt9F0hPc9IP3M5ndmqK53iBCGcy4ZSx8QirhYOIs8l7x+e1/zdswyZEigi',
                        ],
                        11 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-glAz6mCeiwAe/kHHHG/OvhrjA4+AH55ZfH8fwYp48YCY61POwUmOrH/oYOaF2Ujy',
                        ],
                        12 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-8hKZY21U4J3r9N0GFl+24YnDkbRhs8y/nXT6BaZ+sOJDNmz+1DhFawE9UYL37XzB',
                        ],
                        13 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-1j3ph9Rf+Aaz6rrizz6cdFxU9ZbUyvkbiwQ5+T/BY4I5mk37vUpTA8S9ZZOlfdWu',
                        ],
                        14 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-aoMjEUBUPf5GpXx1WJUeTZ/gBmGqQB1u8uUc2J5LW2xnQtJKkGulESZ+rkoj182s',
                        ],
                    ],
                ],
                'version' => '5.2.0',
            ],
            13 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-rf1bqOAj3+pw6NqYrtaE1/4Se2NBwkIfeYbsFdtiR6TQz0acWiwJbv1IM/Nt/ite',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-1rquJLNOM3ijoueaaeS5m+McXPJCGdr5HcA03/VHXxcp2kX2sUrQDmFc3jR5i/C7',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-ZlNfXjxAqKFWCwMwQFGhmMh3i89dWDnaFU2/VZg9CvsMGA7hXHQsPIqS+JIAmgEq',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-VGP9aw4WtGH/uPAOseYxZ+Vz/vaTb1ehm1bwx92Fm8dTrE+3boLfF1SpAtB1z7HW',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-4K9ulTwOtsXr+7hczR7fImKfUZY5THwqvfxwPx1VUCEOt4qssi2Vm+kHY7NJQPoy',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-lmquXrF9qn7mMo6iRQ662vN44vTTVUBpcdtDFWPxD9uFPqC/aMn6pcQrTTupiv1A',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-kW+oWsYx3YpxvjtZjFXqazFpA7UP/MbiY4jvs+RWZo2+N94PFZ36T6TFkc9O3qoB',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-2vdvXGQdnt+ze3ylY5ESeZ9TOxwxlOsldUzQBwtjvRpen1FwDT767SqyVbYrltjb',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-2OfHGv4zQZxcNK+oL8TR9pA+ADXtUODqGpIRy1zOgioC4X3+2vbOAp5Qv7uHM4Z8',
                        ],
                        10 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-sqmLTIuB+bQgkyOcdJ/hAvXl51Z7qqdK/lcH/rt6sdvDKFincQWI+fVgcDZM6NMz',
                        ],
                        11 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-GJiigN/ef2B3HMj0haY+eMmG4EIIrhWgGJ2Rv0IaWnNdWdbWPr1sRLkGz7xfjOFw',
                        ],
                        12 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-DtdEw3/pBQuSag11V3is/UZMjGkGMLDRBgk1UVAOvH6cYoqKjBmCEhePm13skjRV',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-9ralMzdK1QYsk4yBY680hmsb4/hJ98xK3w0TIaJ3ll4POWpWUYaA2bRjGGujGT8w',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-AOiME8p6xSUbTO/93cbYmpOihKrqxrLjvkT2lOpIov+udKmjXXXFLfpKeqwTjNTC',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-Yz2UJoJEWBkb0TBzOd2kozX5/G4+z5WzWMMZz1Np2vwnFjF5FypnmBUBPH2gUa1F',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-9QuzjQIM/Un6pY9bKVJGLW8PauASO8Mf9y3QcsHhfZSXNyXGoXt/POh3VLeiv4mw',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-pofSFWh/aTwxUvfNhg+LRpOXIFViguTD++4CNlmwgXOrQZj1EOJewBT+DmUVeyJN',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-wJu5pIbEyJzi+kRgVKVQkPNKI104yNC+IAyK7XXEVGgPGe+LTEERIkpSZbc/wrOx',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-Hmg9TonawJaGH8ayFFnEBwvkx61BYLPAOV7b/YDGQEVIs1jh9pWQigAavMuD+Vc/',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-1YFoQoO5Em1oxLErpWpJuswiqPFVHl8HLDUaLjJGJH8+Nra/Y1D6uOZkEgfH5OZf',
                        ],
                        8 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-eAVkiER0fL/ySiqS7dXu8TLpoR8d9KRzIYtG0Tz7pi24qgQIIupp0fn2XA1H90fP',
                        ],
                        9 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-am5AyalpQCEfbKe6FYiGZc2vX080nrcueZmrbkljxLdQDJ5q5Vu9QDROD/QefEp1',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-u3o36ga3mMU6/lK/zdiER4h7pPtAK7wBuN0DrZPH22v01RZL8bKZkULIjxcx2/X/',
                        ],
                        11 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-2R0W5LA7dXp3ze/WhvjXlUcDaHRhtGlKYxN9QMhGDdjmj2EI1bub5ysSwofJwGfI',
                        ],
                        12 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-EbI+OvKb7noKOfu8MSi/vCbi0KWlM61MjHDmRk4/vwJkPsMIRcJggYLDGWv7VeYY',
                        ],
                        13 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-U4vTrZsQ4ooEtzL162EZfTtCiJNTXOwGDBzV91//DI5L/h48ibzHBiHJmPLpx2hO',
                        ],
                        14 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-8e1r0+5VTqCqkg/9vG+cnipytzBkEh9fpESgVwBZAizMkWRfiaTkdhgdnhLGwuPd',
                        ],
                    ],
                ],
                'version' => '5.3.1',
            ],
            14 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-Px1uYmw7+bCkOsNAiAV5nxGKJ0Ixn5nChyW8lCK1Li1ic9nbO5pC/iXaq27X5ENt',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-BzCy2fixOYd0HObpx3GMefNqdbA7Qjcc91RgYeDjrHTIEXqiF00jKvgQG0+zY/7I',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-4e3mPOi7K1/4SAx8aMeZqaZ1Pm4l73ZnRRquHFWzPh2Pa4PMAgZm8/WNh6ydcygU',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-osqezT+30O6N/vsMqwW8Ch6wKlMofqueuia2H7fePy42uC05rm1G+BUPSd2iBSJL',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-2MWWLQq91kFwloAny7gkgoeV33bD/cE3A9ZbB2rCN/YAAR/VEHVoDq6vRJJYTaxM',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-YIDcSvDDaIskj/WDlWwjrNdK194YAGWc1CScdo2tXl3IQVS1zS07xQaoAFlXCf1P',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-L469/ELG4Bg9sDQbl0hvjMq8pOcqFgkSpwhwnslzvVVGpDjYJ6wJJyYjvG3u8XW7',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-lc/yFuYW3B0EW9B2QSpod2KeBxq6/ZizGwAW6mRLUe3kKUVlSBfDIVZKwKIz/DBg',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-ISRc+776vRkDOTSbmnyoZFmwHy7hw2UR3KJpb4YtcfOyqUqhLGou8j5YmYnvQQJ4',
                        ],
                        10 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-SQqzt64aAzh3UJ9XghcA//GE8+NxAIRcuCrrekyDokXP6Bbt/FYAFlV6VSPrZKwH',
                        ],
                        11 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-agDKwSYPuGlC0wD14lKXXwb94jlUkbkoSugquwmKRKWv/nDXe1kApDS/gqUlRQmZ',
                        ],
                        12 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-/s2EnwEz7C3ziRundAGzeOAoGYffu84oY4SOHjhI/2Wqk3Z0usUm9bjdduzhZ9+z',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-POYwD7xcktv3gUeZO5s/9nUbRJG/WOmV6jfEGikMJu77LGYO8Rfs2X7URG822aum',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-rmUpvtaCngUop5CYz7WL1LnqkMweXskxP+1AXmkuMSbImsUuy82bUYS4A8Syd3Pf',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-PPeKwWhk5XZBVVq089DuhGmjaEVB1r+jdmx6jZrqzlef8ojhZXG+E/D6SP7uO1dk',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-DZAoxBcs4G15aUXLX4vKbO53ye8L8AB/zg07HOVhIMVclhx8rdWye0AJSQl51ehV',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-xKPOvJDwdb/n5w2kh6cxds98Ae2d5N63xkIydEdoYeA2bxIKUmmyU9lZ9j58mLYS',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-oT4lQmwnKx98HRnFgaGvgCdjtKOjep9CjfMdAOPtJU8Vy6NY3X34GfqL0H43ydJn',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-j2EtHJUHBAZF9vkmX0TSA/QqYMf0Npp9P2leJGZFDbLHbcI62HH8w7FRcUMNf8Q2',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-aaXKvb/d7l2hTm3ZDWCy5v4ct5zXIslt+70K4xalZPLu3ifrkYcG61m4u+DIQGEk',
                        ],
                        8 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-0+tugznPwCEvPiypW+OwmFjAQvRKlgI0ZZZW3nofNlLMmbYXbmNvfX/9up9XQSRs',
                        ],
                        9 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-ShBqjf9lFG58e2NmhnbVlhAOPCWdzkPbBmAEcQ37Liu3TwOYxIizS7J1P3rRLJHm',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-8vKKeD0uIV/HXM5ym3RGB4O7rZ43fCdpiXqP047w7sEE3igcK0Y1U9ApEArcRBDJ',
                        ],
                        11 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-jlaccvPpizUbHU/8pYAsDEwhhBae8MUcYqHHsKkjFcFsEp3Y6LrVXh0GA84aAkTg',
                        ],
                        12 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-MB7Bz/7e8sBWnZgblSLUfFOOi+V1PIkRG/Ex1NMeu0CovaXCzHyCMwAwOF+FAo1s',
                        ],
                        13 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-KlTWIsOnBg7LJobQmLsv5fQ1qbx73K+o8/xhoUDoIba13SxF4bT5W2WgV3d8mZIw',
                        ],
                        14 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-e+EZ4XUeGXVd0FDmP/mFu7FFe+qVX738ayOS2AErNIPSLz5oZ3OgVa9zEyCds3HP',
                        ],
                    ],
                ],
                'version' => '5.4.1',
            ],
            15 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-BCEeiNUiLzxxoeYaIu7jJqq0aVVz2O2Ig4WbWEmRQ2Dx/AAxNV1wMDBXyyrxw1Zd',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-HU5rcgG/yUrsDGWsVACclYdzdCcn5yU8V/3V84zSrPDHwZEdjykadlgI6RHrxGrJ',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-OEIzojYBMrmz48aIjVQj7VG38613/sxpP58OW9h5zBYC7biGFlv9tyu5kWmaAYlF',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-uKQOWcYZKOuKmpYpvT0xCFAs/wE157X5Ua3H5onoRAOCNkJAMX/6QF0iXGGQV9cP',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-+moUZLBX5mmeUnjaImkzlTo5cXyQWAvzbqQapNFd7+dGIaap0koo0rtfe8lHD38R',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-SlbnWxwEHTVYxDLrpIRrG2BpsTpWALbJ6Tx5Fq+XNHRBL7xI6xwhVpuUGrrbLBXe',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-wp96dIgDl5BLlOXb4VMinXPNiB32VYBSoXOoiARzSTXY+tsK8yDTYfvdTyqzdGGN',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-i1RNpxOOEnRm63Ii3TuV0aM8bJ+6Pv6XHpRSJbN7QlIzZIsl7m36R0GhOTTGN3F9',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-n1qPouQQJ9VNZnZeNZWSDiclpIOJwZBS2bkD6rEX+DTmMXTKXBVCZw2cGbU/I17z',
                        ],
                        10 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-Uj7q9rRb3eJNp0j1kXwOBgEWDGbAiJ7Dcuz4hLRQdtza6pawbo/Bmwgr58THzHyR',
                        ],
                        11 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-OQNCj138epg9A13jaL9L/d5vMlK2jyPL4aOgi37KYt07aZARbv/eFGp/wnrCxkW5',
                        ],
                        12 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-fzYnAZZYxpOQTjc3Y1eP04DGdMLAy+PeiZ8+ICh4FDLkJR/NJiAgKgK2vEpGx3au',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-zhaLg9HKxTxDljOPXpWHGn91XMDH+sYAWRSgvzHes290/ISyrNicGrd6BInTnx3L',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-RjTk1OTKX8K8S4QfwhFOfbNSbQxLFgN6jqDw05QuBDDEbc/x6xlPtkPSO4vA1TtI',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-XkH+Vmez3OoFo52K+SkBE61xZ7vKh9tF35gL9Yf8rD3RtKUqIQGoTJTsLdR5u8rt',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-n0uyPlhqrQyWPPzm6+B9xDeZKCD81RgGRsTO7PQt3McgMXSR9zjhGaD5cXHwk+D8',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-+OdrK32QtByk1ipA7b4+uLddrcWs2bx3nn37Dl5h98PW1AYKIrRZKveBl6AcpgcD',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-SYCdBxlsgGngJi9eiKt5Tk6UtOJs1Jq5eU3yZDZ+hOe0GKk/obXhHy50IYVVdJro',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-3f24zIRoR/ma/cnROK52rTVZpgCXKQ92/89RDq7GO7/9IxIl3VQV/tF6ecGgvUs8',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-ah4vMGE5UgKcCIB90FZl8BOcusXAVTm070n1UuOrNQA9QwkgnhqASrop/Oblr6wY',
                        ],
                        8 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-+lZy0zDh4RS9ZG6+Od6x6irKqoBH4NSy0m7IW8UGbzGZ/rupt9Cd9NdEb5S7+V9w',
                        ],
                        9 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-LVdS6BqWBV1V0OyGzWK0HrGN4uDZbpO6hja1oVh86MhthieoER2crgKS/KsaiN8E',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-zMrS036pMtJ0Ukzo5x2YiTrYDGDaoeO8Yd0IHhI/PaEnfrY/nMHqvKME8C7dHhUE',
                        ],
                        11 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-hOiC7FL4572/E3aEEeWM6dF3ch/qFz59R91pAJqjYEKHBXN5u7e2oAYAgeSGF1VB',
                        ],
                        12 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-f1yYCENdJ+9NE5J2T8weglyMCtTqRJOeGP9qaLwO43aYY0PVeuAfmsGgTegByFW6',
                        ],
                        13 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-XlRgTEYU6HJ02+ZCuXW2/CgjnpV2+8FuQPTJSJ/+ZCQS5ZXRfIS5FHDRhMvOL++d',
                        ],
                        14 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-6TX+vqRZyQq+vB25wCb101/vY510EN37QZgs5f1dfG1+QYuIoQGdFFV8sx8W36AL',
                        ],
                    ],
                ],
                'version' => '5.4.2',
            ],
            16 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-QT2Z8ljl3UupqMtQNmPyhSPO/d5qbrzWmFxJqmY7tqoTuT2YrQLEqzvVOP2cT5XW',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-u5J7JghGz0qUrmEsWzBQkfvc8nK3fUT7DCaQzNQ+q4oEXhGSx+P2OqjWsfIRB8QT',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-z3ccjLyn+akM2DtvRQCXJwvT5bGZsspS4uptQKNXNg778nyzvdMqiGcqHVGiAUyY',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-rdyFrfAIC05c5ph7BKz3l5NG5yEottvO/DQ0dCrwD8gzeQDjYBHNr1ucUpQuljos',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-NKdowA6EzI4CWz/dLjoC7dhVj+KczesQbwkbt6y3aRTi1JPZBy2uOocsmHmYvkux',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-TTjEZR8VsD+LjNa98drkrTRYhdUEaS3gAGE7PGnx2qkePR3fZtnVNoAfxPNyf+IQ',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-S2C955KPLo8/zc2J7kJTG38hvFV+SnzXM6hwfEUhGHw5wPo6uXbnbjSJgw3clO4G',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-bNOdVeWbABef8Lh4uZ8c3lJXVlHdf8W5hh1OpJ4dGyqIEhMmcnJrosjQ36Kniaqm',
                        ],
                        10 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-XrvTJeiQ46fxxPrZP6fay5yejA2FV4G1XsS8E4Piz6Fz+7FaEFTw7A7GR972irVV',
                        ],
                        11 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-Xgf/DMe1667bioB9X1UM5QX+EG6FolMT4K7G+6rqNZBSONbmPh/qZ62nBPfTx+xG',
                        ],
                        12 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-vBDTb50BKnwbvJZ5ZC5dsGJNQydTI7ZoAjCeJkdta6nSewwGXCnppKI5lrIQX4Qu',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-j8y0ITrvFafF4EkV1mPW0BKm6dp3c+J9Fky22Man50Ofxo2wNe5pT1oZejDH9/Dt',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-t0iPfoyIjBoVR2Kw/65HArpRWQy0/xKBUmdEVTs5VYBb/yiPZxMY6egc9MROr/Og',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-srL3Qh9R/n855m4o5fegS//B2q0R1md7z6ndDYaPj8iEp0j0IuKdFVWMY0JosKPF',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-33RmjeesW9BZ4wR2Gm3n4iBXOvGTto4znqL2kZleiRanWDxM59IHIq5RsbRioqxb',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-UPs+YiUhgn0/I0swkJmk3PSj3SWmzDrM+S0S09xLI/UUmHBU7ivRHryI3uVL6H+m',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-YIyAArzQv8q6Av1kr9cwxHhFcfNBUaolJindR2XO8E3OLp6z3d8My3oWLd33ET7M',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-a2sfkqnB9p/zq6OT4QhuD80qQZ70fGDmo4JUNqP5E7NIICvgRNPjIBkQE/Qcl3SN',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-SNyDPad7e8WM4Nu7W/f1x3qsDrLxMCvXurQfwNdp418WWmkkTQuPBGYDZA6rSg0X',
                        ],
                        8 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-3yBLeJ4waqGSAf4A8pjZ13UF7GuhgbdKnBQvIp/TkWoXtQbtwjlIPNjkDRJ46UCn',
                        ],
                        9 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-oMyy7aPCmlH4ZGEaKHW+zAoaKDWIFh6iqJ53lusMpn+Kp8SN5nJ2kzkP1qd0+icb',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-oPma1F1txBbqTG+1O7BEx0A/qFtD+R661ULJLmI9RDQ0PfbRP1tQU3vBIBbJIAxL',
                        ],
                        11 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-SVEn5VmGP1fxV9V5TOZOTwL9dCg50Yb0Xn4fbV9Ic/kp8we6kv4zPVcs9seU0675',
                        ],
                        12 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-gbY/GPDSEaMQ9cjqWLbLcaxUCtCeExO9oUEZLrOQHfFLoV5ouwIrqF6mGnjyIOc2',
                        ],
                        13 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-VxezC2Q+YoC+yUILib+HlmOsFiqNzYtQIXsHYY6ST7QZVfgBNs2giKE97ijGMgUH',
                        ],
                        14 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-8sPM0eSaqmdF9ruedfsxEZfxVcIp0cwhosrBhWl/Q4t1eQSMXl6tYenNe87MraQ6',
                        ],
                    ],
                ],
                'version' => '5.5.0',
            ],
            17 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-aOkxzJ5uQz7WBObEZcHvV5JvRW3TUc2rNPA7pe3AwnsUohiw1Vj2Rgx2KSOkF5+h',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-oT8S/zsbHtHRVSs2Weo00ensyC4I8kyMsMhqTD4XrWxyi8NHHxnS0Hy+QEtgeKUE',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-J4287OME5B0yzlP80TtfccOBwJJt6xiO2KS14V7z0mVCRwpz+71z7lwP4yoFbTnD',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-yWI8JeRmJFie/rrEn4skBd/XXXfUWuc7wAhaj9q71PzjdYD3JslHSEU7BXCCcVyP',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-COsgLGwf6vbsibKzWojSqhIjQND/Sa0RWQ5BHFrKOz5JrUObnh5GEBUH2oZwITuM',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-nHELFCUV8tffuhz6PkFYcEl6VCneIQgaHNbLkOHukzJs12+rUiKwsVmVhbqhEAq7',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-HiCW4rrGA9WlUM512GMhD+YfcMidwWluZzyu+X55gfVYgAPrlIkG5BnHyAl/VHJO',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-z9ZOvGHHo21RqN5De4rfJMoAxYpaVoiYhuJXPyVmSs8yn20IE3PmBM534CffwSJI',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-GEA3+tbEaglIUriKygE2OQX9k7YrAMJ5oZF0mb8Xx7hUmTTWDuQDtPY4l13jl99w',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-tHFnt8QELQGC1IJzcTUX5zFEnn/FLVa0ADTmxRyeSmWukJ4umWnJbwiMTkw/bKEK',
                        ],
                        10 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-gy4pB6yY1j4DPCG6rZcE6NX1Lnqz8ZJEfotVUvCN2EGwlUS3WUHxcn8rrEOYiyiS',
                        ],
                        11 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-akyniW0Jfrt1Z7kvRmaF2fkq9vuVQAPEGN4qq7s17l9PG3zz7FThoWnfVxpvnUn9',
                        ],
                        12 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-08SAgv7bDUyzB5O71dehOCZ42IpryGqW/G+GdxeFmBfaB71QIZWe5ZXBFKYFTEu4',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-rTQdcTFdT69CgbBErourkScWQ6j5WQ4aAoCF0UyPhog3PNysM/xz/kqshWKP4NLA',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-84OQfm1oTwjnXmujNUnQC09L4G7mglZspQwfSNPvf5V3zAA1sdvqbIigA9AWY5DB',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-NFsDS9VURN70zaqw67F1OtJ6MtdeCrHeGMD1KzqIv5ft0JiHgVtV7u+v09yR+iEZ',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-aofICWgqJQbZZCaWEU7H0ULLqXTBu/DAALblEYqLfQSjb2ASOw0tADOdJ5rmVDWL',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-voao2F8iKUwwSMRhLJ982edrRSHOmc5v5rvQ/5aH5pvSAx1aoL6usygGSRz3jfHF',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-RYuivM1ikcxEL+96Q/7B/CcvyswPRuOatldvqvk+Bm3hwVKZUjay1ohuPUyD9ZYk',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-NYMicmsVmKaI5/JVN8JamOLMuIrbzeu4Gc+cike3jcoDpaLfMtvWPJeNhnx8K8x0',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-L7wiz9NeFS+vFpG/jl0zBsE7EqrVfeNoaHhnvxlsfwihUr9FIbDnfQqv5r8o02wQ',
                        ],
                        8 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-rDdEqfkiaN9iEfS6XrBzTxL5wVFzBoMsyHmoAIl/T7VdxJvGYuM5bDlDOkmE6r3C',
                        ],
                        9 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-TN18fDSDUbMxI3DK3z2G8Pl68N7jvVjWPBx8z0m7YhoWKnmGdKRJ6S90IcyeUXUy',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-Oa9P+sg4Q/5Yo0a/UoRAG8zLSexWLxLgbPb12tgvs/swrfePVf6IdrwoW2RGV2pU',
                        ],
                        11 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-6DMqAgIR8HN9OqBF3zfhQ4Tmh+KO9Sf0QAwxGkiaKO51dFGBBxBTmdOSneYESZZ0',
                        ],
                        12 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-LvwwgOzFfwTikawPye02NmwONhyBLBbmu04J+IuLBS6HdNHX3JnRqY80mscKVLTH',
                        ],
                        13 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-71d190zi1266uo3WuvCJ77V1YdXxDfm5GPMySGFKTMHsoHaxKhPe5XkKaH9iPLWC',
                        ],
                        14 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-Rr25noDuBAtBUFs9feRsF3EK8Pw5bWuhYxD7ztcDUJqR/eiCpNPGIeyO5Ago6pYW',
                        ],
                    ],
                ],
                'version' => '5.6.0',
            ],
            18 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-whKHCkwP9f4MyD1vda26+XRyEg2zkyZezur14Kxc784RxUU1E7HvWVYj9EoJnUV7',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-WK8BzK0mpgOdhCxq86nInFqSWLzR5UAsNg0MGX9aDaIIrFWQ38dGdhwnNCAoXFxL',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-l+NpTtA08hNNeMp0aMBg/cqPh507w3OvQSRoGnHcVoDCS9OtgxqgR7u8mLQv8poF',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-aj0h5DVQ8jfwc8DA7JiM+Dysv7z+qYrFYZR+Qd/TwnmpDI6UaB3GJRRTdY8jYGS4',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-ir31wc9kqVZclsGL3U5IucynDpj1TeEzDCvxEWqw8QuxLFETRgirOiygjXdjId3z',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-s0z+GcIRRdtdjGfnyKRFh9Oaw3aasU/TFotdFmreqjf+a+Mks2Umj0CrlN0S9lqi',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-R5JkiUweZpJjELPWqttAYmYM1P3SNEJRM6ecTQF05pFFtxmCO+Y1CiUhvuDzgSVZ',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-rsLJp1pKbmeEMVcdsNJfAWZ9FQP5CrQt6Vikj/usZcTgrD28FhqYqKJn5XIaoXjm',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-T6YzYwAGZAItTIkYlBzfwqa07o9R1AND3Lgt6Or6c5IdukY7tqShoryqwpKrpeIB',
                        ],
                        10 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-+e+pqX41PD6VrFw9HZ3YKJHFT+SZoEMBmnMpLUpHrdd5BE46xHCrzap9c6kfTi9H',
                        ],
                        11 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-8Lgyylu0vfTGCXDKe435hJgX8s96c19R+dvpH0NHKdX47GA7TmMj+BDiZZ76qqhT',
                        ],
                        12 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-LqOeBjW8oAuwB6xooSoyjAV+CcJLQGftH6m0Xoo+mhJ0TlEAVR9jBsAXXpeEJlyP',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-NJXGk7R+8gWGBdutmr+/d6XDokLwQhF1U3VA7FhvBDlOq7cNdI69z7NQdnXxcF7k',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-2k7wpGHb3PA1OZUtSqAk+nIVo2wgBQdEoL1F/FnC+/HHi2bh3N9aSstY0Af72gka',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-GQK3B9PHv3SNzYUrdlEpL6CFKQlW/Co4va906SViL0F6U16Li47NXtvwWmFnetYk',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-QXb14MpvHKJr57ixwhGSXACaU/eGo/NwF/uWE97+C5QPdq8sLQhM1+WKDk6vando',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-ThqFFlbk+2bnAn1zc61SL7r8sFUVUkFvtsT+jYr1Jy6xTlvdcqzcerrDGrHqWv6j',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-pbj30780YbUh3WmbEAhOL8tHgoaU4xrdmAN+RewL6HsW9EOMIIE4+6rerMXTfJXq',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-fjim8BUuF/D2Y8Qyr4U5iLdeKqzyQe927qD4SIdbPDyX2iSN6xNGhoyd2jTiw+Sx',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-c2aTxrKw0nWEPlLqENAD5t3J3Ajs/o5LBudKFP44hexDYKKQTgRCAaECkBk+p3L9',
                        ],
                        8 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-ncMWtRMSOo+cLmfdaa6vmMGzBJKysBDF9tq5YK1MAnAjcyipdW2vgTS1jOntY4fs',
                        ],
                        9 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-+4YdTIsot+hvYL7nKQ9cJs7OWaFvJ7ZTkVretfEoX8uDiTED9tumG/9RsRmlW3jX',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-Ya+lFT8MCnVaSXkMxO4FEUsv4BG1VrVAMY0PiCnmJ4Sq57zoarae8T2EgioHiaMA',
                        ],
                        11 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-hy7ipunNmCKP7KpzkasGow2eTRYx9IbxV0BvBqlWLWRu8mlWMNrj9y6qOLEnxIuF',
                        ],
                        12 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-8VWoI12VOwcfxYszEUreYXR4Jh1+oxv+mfsVISgPJTsc2Ftw4RC+bO719C+PunjY',
                        ],
                        13 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-Pl3KUQLNwa33i6dvnL77HMDxZPk93eoi1kB5xZ0eGKgTEt39iQkHdSM6/w53By9e',
                        ],
                        14 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-ts+GFi6rOAISeHC+EnLaj6AOSoosWr3TALIaYSeHCVsNHkGLlTtzdbMvolIe6tG7',
                        ],
                    ],
                ],
                'version' => '5.6.1',
            ],
            19 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-1KLgFVb/gHrlDGLFPgMbeedi6tQBLcWvyNUN+YKXbD7ZFbjX6BLpMDf0PJ32XJfX',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-jLuaxTTBR42U2qJ/pm4JRouHkEDHkVqH0T1nyQXn1mZ7Snycpf6Rl25VBNthU4z0',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-aubIA90W7NxJ+Ly4QHAqo1JBSwQ0jejV75iHhj59KRwVjLVHjuhS3LkDAoa/ltO4',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-+0VIRx+yz1WBcCTXBkVQYIBVNEFH1eP6Zknm16roZCyeNg2maWEpk/l/KsyFKs7G',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-KHV7fADs212mr+U2tmuDnxozv2BzTX1qhxPoZ/lT2QcUFkjwat694MI3AzyiVJ+q',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-DrjN/yxBJAblffPf548CARk30Xz2Glal7YO5kqQ8c8GHgrAMXZN2ZDTGwV9xTDJF',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-EIHISlAOj4zgYieurP0SdoiBYfGJKkgWedPHH4jCzpCXLmzVsw1ouK59MuUtP4a1',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-VLgz+MgaFCnsFLiBwE3ItNouuqbWV2ZnIqfsA6QRHksEAQfgbcoaQ4PP0ZeS0zS5',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-treYPdjUrP4rW5q82SnECO7TPVAz4bpas16yuE9F5o7CeBn2YYw1yr5oC8s8Mf8t',
                        ],
                        10 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-V+AkgA1cZ+p3DRK63AHCaXvO68V7B5eHoxl7QVN21zftbkFn/sGAIVR7vmQL3Zhp',
                        ],
                        11 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-F4BRNf3onawQt7LDHDJm/hwm3wBtbLIfGk1VSB/3nn3E+7Rox1YpYcKJMsmHBJIl',
                        ],
                        12 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-miy+FCz1uGOaEWy6IaOB4X2pp60+e6jaSECmnvz+qo7Os/Q1oflHUIrS0JdfNafk',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-LRlmVvLKVApDVGuspQFnRQJjkv0P7/YFrw84YYQtmYG4nK8c+M+NlmYDCv0rKWpG',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-1KLgFVb/gHrlDGLFPgMbeedi6tQBLcWvyNUN+YKXbD7ZFbjX6BLpMDf0PJ32XJfX',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-toEUmnrGu+eq8XUD6ovsr/vFX+R3v9+FUGAnpef+uwGKMCeqZkcZfkXQ0Pls5WS7',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-ouQ4uivIto2ZdBS6+torZMbImJhWA6/m7/CAGY9z0FNDmoAF6uWAEnavvIsR1EBt',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-IXqJGQI1K0IzdpdY2ASrRbDgPr1rUKzDAA90uL7iX1hPQf6Tkve9Z82TUVWm9aje',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-5XPOduYq6F78ZOuHxFHpQJCD2l7aCHCf0+o8qKTD2VfqJTgPT3YkyuBGsDSrVsic',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-KHV7fADs212mr+U2tmuDnxozv2BzTX1qhxPoZ/lT2QcUFkjwat694MI3AzyiVJ+q',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-U1d6UqL28bnGVHunjKzlOZ8IatZ4il21uTor0FijL3224okgH54hOnOVB50CDK0M',
                        ],
                        8 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-4Gm0M5DjJ0zGaEtLu0ztNIoHWiuJ5rKiaVlpZKeNqXAW49eIIa2ymxb3C4c3uEXR',
                        ],
                        9 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-VLgz+MgaFCnsFLiBwE3ItNouuqbWV2ZnIqfsA6QRHksEAQfgbcoaQ4PP0ZeS0zS5',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-treYPdjUrP4rW5q82SnECO7TPVAz4bpas16yuE9F5o7CeBn2YYw1yr5oC8s8Mf8t',
                        ],
                        11 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-E2rKHkorMllWJmt2GKXlwZ3+kPl6i3FrJ8ihFkf6F7F/AtGvuXY21bQC8mhz2Po+',
                        ],
                        12 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-nX7teCj1FtQErhxXjr+JWXfe4EjU6KlgeVBHAzQ/L95eWzwx+W1+HuQGmxZT9VkS',
                        ],
                        13 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-2ZaaAuh8tTVN1nHRrlXAX1tz8fGhZDgusJdBI5BBGycCq37AUonw8dHlPpx7iD6N',
                        ],
                        14 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-q8jijYZFNY4pjTA22Qe+33WWGmm0tpPPfMEdUxmXNoEkN5YeCMJYxGcl+XiCckQh',
                        ],
                    ],
                ],
                'version' => '5.6.3',
            ],
            20 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-BKw0P+CQz9xmby+uplDwp82Py8x1xtYPK3ORn/ZSoe6Dk3ETP59WCDnX+fI1XCKK',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-4aon80D8rXCGx9ayDt85LbyUHeMWd3UiBaWliBlJ53yzm9hqN21A+o1pqoyK04h+',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-IG162Tfx2WTn//TRUi9ahZHsz47lNKzYOp0b6Vv8qltVlPkub2yj9TVwzNck6GEF',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-r/k8YTFqmlOaqRkZuSiE9trsrDXkh07mRaoGBMoDcmA58OHILZPsk29i2BsFng1B',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-3oHRxwaq4aKTY0NVNLfynvnb/U7E0MGiosKUE4cNMIDRezfXvssVlwQ+xsuBLbXf',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-DrjN/yxBJAblffPf548CARk30Xz2Glal7YO5kqQ8c8GHgrAMXZN2ZDTGwV9xTDJF',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-qD/MNBVMm3hVYCbRTSOW130+CWeRIKbpot9/gR1BHkd7sIct4QKhT1hOPd+2hO8K',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-zJ8/qgGmKwL+kr/xmGA6s1oXK63ah5/1rHuILmZ44sO2Bbq1V3p3eRTkuGcivyhD',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-av0fZBtv517ppGAYKqqaiTvWEK6WXW7W0N1ocPSPI/wi+h8qlgWck2Hikm5cxH0E',
                        ],
                        10 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-Gxfqh68NuE4s0o2renzieYkDYVbdJynynsdrB7UG9yEvgpS9TVM+c4bknWfQXUBg',
                        ],
                        11 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-6FXzJ8R8IC4v/SKPI8oOcRrUkJU8uvFK6YJ4eDY11bJQz4lRw5/wGthflEOX8hjL',
                        ],
                        12 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-miy+FCz1uGOaEWy6IaOB4X2pp60+e6jaSECmnvz+qo7Os/Q1oflHUIrS0JdfNafk',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-6jHF7Z3XI3fF4XZixAuSu0gGKrXwoX/w3uFPxC56OtjChio7wtTGJWRW53Nhx6Ev',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-BKw0P+CQz9xmby+uplDwp82Py8x1xtYPK3ORn/ZSoe6Dk3ETP59WCDnX+fI1XCKK',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-iD1qS/uJjE9q9kecNUe9R4FRvcinAvTcPClTz7NI8RI5gUsJ+eaeJeblG1Ex0ieh',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-puvvQVSC+mXL7INuI0i5Q7QkwwIyYIBJ7caGHiUXD7FndtoyNd78NxgvuBJAYI2m',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-4Cp0kYV2i1JFDfp6MQAdlrauJM+WTabydjMk5iJ7A9D+TXIh5zQMd5KXydBCAUN4',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-j+2fZ2qAg9GyYKkVpuwm+HLQVz6EYCaTqS3KKx8oectYXMgm4bRmohzCfEvi5j7J',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-3oHRxwaq4aKTY0NVNLfynvnb/U7E0MGiosKUE4cNMIDRezfXvssVlwQ+xsuBLbXf',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-U1d6UqL28bnGVHunjKzlOZ8IatZ4il21uTor0FijL3224okgH54hOnOVB50CDK0M',
                        ],
                        8 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-uyhTADGMAJuHgGNdH+rozTpOkfXUORTgjTmMBtxR8ISQjOs+IIWb8UBn9ixSd4xo',
                        ],
                        9 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-zJ8/qgGmKwL+kr/xmGA6s1oXK63ah5/1rHuILmZ44sO2Bbq1V3p3eRTkuGcivyhD',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-av0fZBtv517ppGAYKqqaiTvWEK6WXW7W0N1ocPSPI/wi+h8qlgWck2Hikm5cxH0E',
                        ],
                        11 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-Vs12SjRkIvphC81scjUNowpLYnSOLOrSGxOwVe00oEvWto49wVgjd6BfdeCPcArI',
                        ],
                        12 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-JZmzMsvgUATRcNmXpyJHLhiqsREsPN/GBj7O5ifVfRU1o4vBp2dsjawGzYzl0QVW',
                        ],
                        13 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-OzCiQJ65BS/RiwFjTWyem+uRtZ4/LnrVVbwHTT8fR5Q9rYqAaavyOK51RDxkXQzm',
                        ],
                        14 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-q8jijYZFNY4pjTA22Qe+33WWGmm0tpPPfMEdUxmXNoEkN5YeCMJYxGcl+XiCckQh',
                        ],
                    ],
                ],
                'version' => '5.7.0',
            ],
            21 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-BKw0P+CQz9xmby+uplDwp82Py8x1xtYPK3ORn/ZSoe6Dk3ETP59WCDnX+fI1XCKK',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-4aon80D8rXCGx9ayDt85LbyUHeMWd3UiBaWliBlJ53yzm9hqN21A+o1pqoyK04h+',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-IG162Tfx2WTn//TRUi9ahZHsz47lNKzYOp0b6Vv8qltVlPkub2yj9TVwzNck6GEF',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-r/k8YTFqmlOaqRkZuSiE9trsrDXkh07mRaoGBMoDcmA58OHILZPsk29i2BsFng1B',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-3oHRxwaq4aKTY0NVNLfynvnb/U7E0MGiosKUE4cNMIDRezfXvssVlwQ+xsuBLbXf',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-DrjN/yxBJAblffPf548CARk30Xz2Glal7YO5kqQ8c8GHgrAMXZN2ZDTGwV9xTDJF',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-eVEQC9zshBn0rFj4+TU78eNA19HMNigMviK/PU/FFjLXqa/GKPgX58rvt5Z8PLs7',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-zJ8/qgGmKwL+kr/xmGA6s1oXK63ah5/1rHuILmZ44sO2Bbq1V3p3eRTkuGcivyhD',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-Qmms7kHsbqYnKkSwiePYzreT+ufFVSNBhfLOEp0sEEfEVdORDs/aEnGaJy/l4eoy',
                        ],
                        10 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-Gxfqh68NuE4s0o2renzieYkDYVbdJynynsdrB7UG9yEvgpS9TVM+c4bknWfQXUBg',
                        ],
                        11 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-6FXzJ8R8IC4v/SKPI8oOcRrUkJU8uvFK6YJ4eDY11bJQz4lRw5/wGthflEOX8hjL',
                        ],
                        12 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-miy+FCz1uGOaEWy6IaOB4X2pp60+e6jaSECmnvz+qo7Os/Q1oflHUIrS0JdfNafk',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-6jHF7Z3XI3fF4XZixAuSu0gGKrXwoX/w3uFPxC56OtjChio7wtTGJWRW53Nhx6Ev',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-BKw0P+CQz9xmby+uplDwp82Py8x1xtYPK3ORn/ZSoe6Dk3ETP59WCDnX+fI1XCKK',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-iD1qS/uJjE9q9kecNUe9R4FRvcinAvTcPClTz7NI8RI5gUsJ+eaeJeblG1Ex0ieh',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-puvvQVSC+mXL7INuI0i5Q7QkwwIyYIBJ7caGHiUXD7FndtoyNd78NxgvuBJAYI2m',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-4Cp0kYV2i1JFDfp6MQAdlrauJM+WTabydjMk5iJ7A9D+TXIh5zQMd5KXydBCAUN4',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-j+2fZ2qAg9GyYKkVpuwm+HLQVz6EYCaTqS3KKx8oectYXMgm4bRmohzCfEvi5j7J',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-3oHRxwaq4aKTY0NVNLfynvnb/U7E0MGiosKUE4cNMIDRezfXvssVlwQ+xsuBLbXf',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-U1d6UqL28bnGVHunjKzlOZ8IatZ4il21uTor0FijL3224okgH54hOnOVB50CDK0M',
                        ],
                        8 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-5atZgfYD4MHp6kAnxjw4yM3binN4Yh5XXKAIO6m2kIB9CqdRUladdvTdffLnTK3N',
                        ],
                        9 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-zJ8/qgGmKwL+kr/xmGA6s1oXK63ah5/1rHuILmZ44sO2Bbq1V3p3eRTkuGcivyhD',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-Qmms7kHsbqYnKkSwiePYzreT+ufFVSNBhfLOEp0sEEfEVdORDs/aEnGaJy/l4eoy',
                        ],
                        11 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-ua13CrU9gkzyOVxhPFl96iHgwnYTuTZ96YYiG08m1fYLvz8cVyHluzkzK9WcFLpT',
                        ],
                        12 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-SdSeoV46BZSFmxvlUQwl3ImF6ton2ST4pPzYOmTTkFUm+UjdzORM0pTtF0sIHydx',
                        ],
                        13 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-eLZVpmyzMTRsfwRGkcmyu0PXR5qqYDBCSh5PoYLdWFfDmMIibSuru0Blk+nq1Vfm',
                        ],
                        14 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-q8jijYZFNY4pjTA22Qe+33WWGmm0tpPPfMEdUxmXNoEkN5YeCMJYxGcl+XiCckQh',
                        ],
                    ],
                ],
                'version' => '5.7.1',
            ],
            22 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-BKw0P+CQz9xmby+uplDwp82Py8x1xtYPK3ORn/ZSoe6Dk3ETP59WCDnX+fI1XCKK',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-4aon80D8rXCGx9ayDt85LbyUHeMWd3UiBaWliBlJ53yzm9hqN21A+o1pqoyK04h+',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-IG162Tfx2WTn//TRUi9ahZHsz47lNKzYOp0b6Vv8qltVlPkub2yj9TVwzNck6GEF',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-r/k8YTFqmlOaqRkZuSiE9trsrDXkh07mRaoGBMoDcmA58OHILZPsk29i2BsFng1B',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-3oHRxwaq4aKTY0NVNLfynvnb/U7E0MGiosKUE4cNMIDRezfXvssVlwQ+xsuBLbXf',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-DrjN/yxBJAblffPf548CARk30Xz2Glal7YO5kqQ8c8GHgrAMXZN2ZDTGwV9xTDJF',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-0pzryjIRos8mFBWMzSSZApWtPl/5++eIfzYmTgBBmXYdhvxPc+XcFEk+zJwDgWbP',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-zJ8/qgGmKwL+kr/xmGA6s1oXK63ah5/1rHuILmZ44sO2Bbq1V3p3eRTkuGcivyhD',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-xl26xwG2NVtJDw2/96Lmg09++ZjrXPc89j0j7JHjLOdSwHDHPHiucUjfllW0Ywrq',
                        ],
                        10 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-Gxfqh68NuE4s0o2renzieYkDYVbdJynynsdrB7UG9yEvgpS9TVM+c4bknWfQXUBg',
                        ],
                        11 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-6FXzJ8R8IC4v/SKPI8oOcRrUkJU8uvFK6YJ4eDY11bJQz4lRw5/wGthflEOX8hjL',
                        ],
                        12 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-miy+FCz1uGOaEWy6IaOB4X2pp60+e6jaSECmnvz+qo7Os/Q1oflHUIrS0JdfNafk',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-6jHF7Z3XI3fF4XZixAuSu0gGKrXwoX/w3uFPxC56OtjChio7wtTGJWRW53Nhx6Ev',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-BKw0P+CQz9xmby+uplDwp82Py8x1xtYPK3ORn/ZSoe6Dk3ETP59WCDnX+fI1XCKK',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-iD1qS/uJjE9q9kecNUe9R4FRvcinAvTcPClTz7NI8RI5gUsJ+eaeJeblG1Ex0ieh',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-puvvQVSC+mXL7INuI0i5Q7QkwwIyYIBJ7caGHiUXD7FndtoyNd78NxgvuBJAYI2m',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-4Cp0kYV2i1JFDfp6MQAdlrauJM+WTabydjMk5iJ7A9D+TXIh5zQMd5KXydBCAUN4',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-j+2fZ2qAg9GyYKkVpuwm+HLQVz6EYCaTqS3KKx8oectYXMgm4bRmohzCfEvi5j7J',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-3oHRxwaq4aKTY0NVNLfynvnb/U7E0MGiosKUE4cNMIDRezfXvssVlwQ+xsuBLbXf',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-U1d6UqL28bnGVHunjKzlOZ8IatZ4il21uTor0FijL3224okgH54hOnOVB50CDK0M',
                        ],
                        8 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-I3Hhe9TkmlsxzooTtbRzdeLbmkFQE9DVzX/19uTZfHk1zn/uWUyk+a+GyrHyseSq',
                        ],
                        9 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-zJ8/qgGmKwL+kr/xmGA6s1oXK63ah5/1rHuILmZ44sO2Bbq1V3p3eRTkuGcivyhD',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-xl26xwG2NVtJDw2/96Lmg09++ZjrXPc89j0j7JHjLOdSwHDHPHiucUjfllW0Ywrq',
                        ],
                        11 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-ua13CrU9gkzyOVxhPFl96iHgwnYTuTZ96YYiG08m1fYLvz8cVyHluzkzK9WcFLpT',
                        ],
                        12 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-SdSeoV46BZSFmxvlUQwl3ImF6ton2ST4pPzYOmTTkFUm+UjdzORM0pTtF0sIHydx',
                        ],
                        13 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-eLZVpmyzMTRsfwRGkcmyu0PXR5qqYDBCSh5PoYLdWFfDmMIibSuru0Blk+nq1Vfm',
                        ],
                        14 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-q8jijYZFNY4pjTA22Qe+33WWGmm0tpPPfMEdUxmXNoEkN5YeCMJYxGcl+XiCckQh',
                        ],
                    ],
                ],
                'version' => '5.7.2',
            ],
            23 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-Mmxa0mLqhmOeaE8vgOSbKacftZcsNYDjQzuCOm6D02luYSzBG8vpaOykv9lFQ51Y',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-5G2m52y/zN053yjBCyNXXotYpL2r5k1wg9aakiM5OgK9kdcCB68EECUce5vZiz/8',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-Sbwc59I1SOoVoCGgBCwAe/M1j5a9cHixHv/7x9vOxORnT73jUaxyK0paobkk3JSt',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-Vma7aWQBdmjVfr98uRd1HcA/r6wPYrlNrIvQBJhDCvZi3X9gVuHtqUKUYep/1KKk',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-n4xPrkfCJ3FzmPwM/Nf1QQu7Qx6oDcsbMp+qPOxrJ5w0Tq19ZWd9ylcMWkzKEpwP',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-5ywFB7dcUP6RcAWMLvCE58MQE5YMXWSPjly1IqItdN0w0TqoJD+w68U7C3ShoZRk',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-IaQiZkMW7NRKIS04GeT98++WyQ6RNaEQlHoHoDrhU+hhCJE4EkfL7itJyj/vanQT',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-ukiibbYjFS/1dhODSWD+PrZ6+CGCgf8VbyUH7bQQNUulL+2r59uGYToovytTf4Xm',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-Gt4maPu5ZO/PkTh32sKMYmmCLGuWtMkv5YBtFZpx4Tu+Of3kFZPYBw9iD/pi4L6s',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-TAztyRuTlqgZ97tz982rMo44MRC58wyCC0pqKZY3cKWJNkK00qMd3DhQ7R25jpCe',
                        ],
                        10 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-IQnlolMpq26nEj6AOd6JOnY2jqCa69uFBqCGBCWSm4EFZYprebVtp3Z2xVLMElvs',
                        ],
                        11 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-prcFDC6iTvvWsx2iSZtbDdeMVWWOtxcQXXagr9uPHwi42uae31Y3Q17eehHuC0JL',
                        ],
                        12 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-l9bFz0TmR1ecMQdb9mzBeiLLX3z0mqeK0Bsxhim3nnHB9PoA6o3FUumLH7K6W6/D',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-/pOR6TNYPdUaQQQRKQ4XHznZ4U2K/Lscb3u6jshUngC/31fLTuyX9FZb24gp4O3J',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-OxPYtFc8yWHWBo2MFY4rHs5dKcTpNGuyft0hQ+K/vSUJA21jrxi+Py412o2wMvsL',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-/0C3VuTlEzBany89/Wf2OJLSGrduLCC28kuoGL/PCGJjGj01pVtiqOcgZZ9AtlET',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-YmipRqYc8Wly1koaxcpAPTnvJIqXBN4Ue5+l0drZn34sdM+UufP6v8D8/s9xxXOI',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-iUhpWyroENmdb/oNEGUdCk4J+TfFOm/SNYi79nN/Hb1aQgjofylAAuRTUfpK2yP1',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-maIT5Qg1FqlJhNYpN2IgLAb5XPLY8CqZ7tKBQyjHh+nx/7JXsI5bp+8JHnUgeuyw',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-BUeh/IoVXY+o863GdrQzogOOSo3ABFpxuc9xZhQVnsM2T2vKmrpHGZwaEqqX/SZs',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-lRITDKAHusCdCcsQiEA2IIoqExMRD36Tbn9CZj00L8klRpDyMeOoPSv6ubcNAHux',
                        ],
                        8 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-gUdv3ElxXd3gVdbCqjppYoQanRONrQDSdaZY3zn1KeASeS8YGy+T/JDaD2ohyarV',
                        ],
                        9 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-XLy4uPbRNbMJUgEm6JLmHI784E68XjgSbheIn0fP/6GdZtCcsZmlXvceAGvhzKCh',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-aoV9M7ZLyivlmo8GKrkeWiOUQzBnYBpP6U8gW7WXfhssy+HtO87KzowcBokSiK3g',
                        ],
                        11 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-+itlrN2dvS1RqmWnkLQkDqzANbdKqtt6JyQfE/DXxFnhg/PXf0ufRBCSp0c6q81i',
                        ],
                        12 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-GoKOHat5yLSUYiGMfLJkuCErUZrNlW+2FeFYuKOt7sUWbqvMQOqfB+mdpfCU/8Q4',
                        ],
                        13 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-jOmpRjxTFmJAVhf7+H7o9joWtQWHRZLdr+B25WojM1yfhB9wFkDvQ3x0VDDn4aAI',
                        ],
                        14 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-gaNKDFtFZuAyZDkB8Wov1Vl24lMu5MD5MXLmUSu+4HzB8tTVwemJnhqN4Zuj27wd',
                        ],
                    ],
                ],
                'version' => '5.8.0',
            ],
            24 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-n9+6/aSqa9lBidZMRCQHTHKJscPq6NW4pCQBiMmHdUCvPN8ZOg2zJJTkC7WIezWv',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-vd1e11sR28tEK9YANUtpIOdjGW14pS87bUBuOIoBILVWLFnS+MCX9T6MMf0VdPGq',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-FKw7x8fCxuvzBwOJmhTJJsKzBl8dnN9e2R4+pXRfYoHivikuHkzWyhKWDSMcGNK8',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-QokYePQSOwpBDuhlHOsX0ymF6R/vLk/UQVz3WHa6wygxI5oGTmDTv8wahFOSspdm',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-acBDV8BDMPEP50gJeFdMIg9yE8eOPuFdBV9r+2F492NUbKhURdQvglFkG0Q+0rlE',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-knhdgIEP1JBPHETtXGyUk1FXV22kd1ZAN8yyExweAKAfztV5+kSBjUff4pHDG38c',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-rUOIFHM3HXni/WG5pzDhA1e2Js5nn4bWudTYujHbbI9ztBIxK54CL4ZNZWwcBQeD',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-EMmnH+Njn8umuoSMZ3Ae3bC9hDknHKOWL2e9WJD/cN6XLeAN7tr5ZQ0Hx5HDHtkS',
                        ],
                        10 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-Uc9toywOA44owltk1MWl0lQZ+L0mBzJkLQcdif6+JtG9izvok9DLJtCZX57Uq3k2',
                        ],
                        11 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-IA6YnujJIO+z1m4NKyAGvZ9Wmxrd4Px8WFqhFcgRmwLaJaiwijYgApVpo1MV8p77',
                        ],
                        12 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-DWlD0qU0+4WTFKXrFbt8wXq/1NHvOGT8vwllYM0W2gIeqgaCC3bZ0U464mDtbR70',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-Bx4pytHkyTDy3aJKjGkGoHPt3tvv6zlwwjc3iqN7ktaiEMLDPqLSZYts2OjKcBx1',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-9Wenwezdk1eEhfcpps+Heco4zWw6KuZ2VlevoPomUwWYYZd3nBX0kZ1hBV2zSIKF',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-4HqGlagEHMyfaDQVabl1wx7GCtGw6hDl3sKJEhqQjOCrXrvizhaA2j4hK8Piewtr',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-3SMOAKCN8LYSMjkWz1ChDg4pHSLtD+LuKXaZoHxE1oyDneLR6Ebjm3XHMHO9fWu3',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-ELBQxbOyxSZRtZPNO1mVgYkEzMOXFNmQY6CLV1nw+4IZoiHWeuwYTnABxPxxsuBE',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-MkkthiFx7890Rev6vwUJO4gRT4yuH5tqMm/Wl4/n9/qptaBpiGcMyjfgq2K4h394',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-LnvOeE4ntog9dzgq63i0OoI6jKPp3p0y693Fh4Fd4eOyx/UsAw0kHXbLKqML1p9R',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-68zdIccmue/irEHOgRiyNsWTZAGftSb6RkEtUhgaD+8213AXnbThq7m3WsO+B02H',
                        ],
                        8 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-GBwm0s/0wYcqnK/JmrCoRqWYIWzFiGEucsfFqkB76Ouii5+d4R31vWHPQtfhv55b',
                        ],
                        9 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-b4zU5X+9uCyU5wpeWBsEIFph6tTD8ERLbUs93uYGQGNqzbcfPDeY6c4jMhTAfBri',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-w6QYwIdCVqcYkHtaFutVu3VlDeu+pBFvlp7e0/tygMFwnWTl13KuVYfsp0ediPpA',
                        ],
                        11 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-avwGKnev1pyXYEbWxXSg9S4rpTsws+5vQpoj76SfcccEzOL162Ei8+z4a6AlaMeE',
                        ],
                        12 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-lv9QOXVC8fPRX14JTtgPGx1JjQPfjnqnp+bTlEnrW2FRawdJ4V8oe4Yq4kdfgJIp',
                        ],
                        13 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-sJjbbGVKgAaulHq0KZK5MsUx9YmPj+4G3oY2vmW12iBNEFkkhObBezK0ZhSXchIs',
                        ],
                        14 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-J8Vif9iMSqb5RK45yq6+dnrM1lTP1oQcIHtKpoH0irzUJD/1gCK0pQgIr0hO+hta',
                        ],
                    ],
                ],
                'version' => '5.8.1',
            ],
            25 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-i2PyM6FMpVnxjRPi0KW/xIS7hkeSznkllv+Hx/MtYDaHA5VcF0yL3KVlvzp8bWjQ',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-sri+NftO+0hcisDKgr287Y/1LVnInHJ1l+XC7+FOabmTTIK0HnE2ID+xxvJ21c5J',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-hCIN6p9+1T+YkCd3wWjB5yufpReULIPQ21XA/ncf3oZ631q2HEhdC7JgKqbk//4+',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-ioUrHig76ITq4aEJ67dHzTvqjsAP/7IzgwE7lgJcg2r7BRNGYSK0LwSmROzYtgzs',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-PLvJTjM1QH/74H66d1I1vU8KYsjkbjSJn87gUIUsIO6Xjf8fRO8Hxdevr46EkV7M',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-XyBa62YmP9n5OJlz31oJcSVUqdJJ1dgQZriaAHtKZn/8Bu8KJ+PMJ/jjVGvhwvQi',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-DJ25uNYET2XCl5ZF++U8eNxPWqcKohUUBUpKGlNLMchM7q4Wjg2CUpjHLaL8yYPH',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-GtvEzzhN52RvAD7CnSR7TcPw555abR8NK28tAqa/GgIDk59o0TsaK6FHglLstzCf',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-Ia7KZbX22R7DDSbxNmxHqPQ15ceNzg2U4h5A8dy3K47G2fV1k658BTxXjp7rdhXa',
                        ],
                        10 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-iFYyWQkY/Zvsdq3IIxRJI2FBoXPj6g73ok7rIH3sZGulA7E5PvFqB5BOELomUuyh',
                        ],
                        11 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-+2/MEhV42Ne5nONkjLVCZFGh5IaEQmfXyvGlsibBiATelTFbVGoLB1sqhczi0hlf',
                        ],
                        12 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-5i8QG9UXrCZePXfj1ac87dq22tNtGoJ22fmjXaJI8iIy072+ZKv1NZHbsTMfYvnV',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-xVVam1KS4+Qt2OrFa+VdRUoXygyKIuNWUUUBZYv+n27STsJ7oDOHJgfF0bNKLMJF',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-BeZiOfMYSXjscewXEIJ0PDoBy27u+zVSTP5ZuW3kjEZKCn7pOB7v+oQVtAtHfY0v',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-fqilzf6i0kkOYm+DT4UC9pWzYf4/eFdJKroY1jZyE7n8eYLujyYM9VCucGf/LdVD',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-0WqtEOayxoyo7wgxUc5l2RvIbaWTyny0LrJbwsKhrKXUyopxvaNFLIoob4dXRwLO',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-jyNdSTwsauV6/i9u6sKFOZBrxlr4QREAY295HsNy8laz4LYryhnPdz0ewFVERKfV',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-dUUyoHgD2BplZp1AnRbRu0HPC5jscpJEJaJjqnBh7Y5PT1gW7cM6BQEgrcOsSa7e',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-+BcpgpzTfqttc/C2LUPzGXIGunaa/aIuSC/BPO2BBqqMbHNRCF7d3DU54LxbCzTS',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-TpRSvWoRbPKMMxDvVZgEa9wxoOZyawahRkC2P+ksDRxjPSvZjhEf5nU7pqSWBCQF',
                        ],
                        8 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-RLPiEwcAdrH2NjFcwJipJtlFoIN1xvqPYeeDX5yYtSNu+HTIkQCDvPQ9thsUnPUS',
                        ],
                        9 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-NBtHk407eZGNubj82MbaKt5CrNLfhnYmCbpjSyDk/nWemMXE/mfvm3c1MPjfnWmU',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-b7K10RWf2Q3m26zPrKzM95th5yJnxEw+vpCzNITZFKV8UgxPgHb61bS0xFkKdV2I',
                        ],
                        11 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-BMiulaMo0kY9ExzwDFFjsXkU373Br7qSwYa/hdDlWEWEkE3flk4mBFvMwlpye3Aw',
                        ],
                        12 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-uMEQdPXvyCTabszTyCxRRMDh/xIcRlT/fpq2DKkcjR6+lOqq2111EL0C1OiRVu1E',
                        ],
                        13 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-9fQzIUDeLlrPRI2CT9AqVv6Yr0JgEY0+rr7ngyaatQAQrEHhCv5CvG8F8UFdgk7u',
                        ],
                        14 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-Ts0FauTmSRKZNl+Uw+WC04UuoVYd2gXlJ+OcUvb1NDrV2XmDcgCr8PPv5MY/7KZR',
                        ],
                    ],
                ],
                'version' => '5.8.2',
            ],
            26 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-i1LQnF23gykqWXg6jxC2ZbCbUMxyw5gLZY6UiUS98LYV5unm8GWmfkIS6jqJfb4E',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-vfTtNoEyqnxivzqkzc+mvlVeCWPGwMlIIkeTkt0mcUQNmFLyyXxY5SgZIkKQIXRK',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-NnhYAEceBbm5rQuNvCv6o4iIoPZlkaWfvuXVh4XkRNvHWKgu/Mk2nEjFZpPQdwiz',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-5E/NXotaQSDJW8gq/9pxwQHSPRrb21suHuLPqOIlgob8QC8ltM13i6HLujrhWmBL',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-ypqxM+6jj5ropInEPawU1UEhbuOuBkkz59KyIbbsTu4Sw62PfV3KUnQadMbIoAzq',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-Bfk4oyOug+rBqsciYilQ+iwazXsMTURz/M6Gfx7fb02KNeW5VHwt7aHTXWNU9B2W',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-zpflLcSaYRmTsnK2LTOdvChgML+Tt/4aE2szcblLVBXd8Jq/HGz6rhZqZ+4TkK75',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-7Gk1S6elg570RSJJxILsRiq8o0CO99g1zjfOISrqjFUCjxHDn3TmaWoWOqt6eswF',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-CZZj1HZWqgh/CGR22Lnl6+fZC6IDR10ga+wECjipCR3zId+7ZxZP1JNI+YgdzyO/',
                        ],
                        9 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-RXRrB6R44g3RRohoKLAOK5MjNq4PVvz7iZErCckeyobGIJLpTP2qq6xjJFuKnfZu',
                        ],
                        10 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-xrLv+W4OudHJZ6QDKuv+el28Wyr4OMO0qSQuBiPqhBsnSGKdGct/ElQm+2/fx/eS',
                        ],
                        11 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-kDWpGOpzLEy85/cK1Df/ba6PkpDHAKUGOX4YHEt0sFzHdrTY1rGmT/gYHN3zCcF0',
                        ],
                        12 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-npD7syUhXOZUTbAzJEyIPGq/8gGAhBmei7JkUwUki9hAtz9oPkFJwx5f3vGb7SOi',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-vlOMx0hKjUCl4WzuhIhSNZSm2yQCaf0mOU1hEDK/iztH3gU4v5NMmJln9273A6Jz',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-wRa49NRotGDh34aLO1Hjbu65qHSTF/ZNSBm7uTpMUa2EQ1Csq7Zlswm+FR9hcWtn',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-QSCxeayZXa6bvOhHReoQRGN7utvnOnY3JoBHGxM61JQQ1EXA7AT3m7dnlHXLhnCj',
                        ],
                        3 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-/ggAGHSQWxssDRflcj0aeAlGN2rNgsnWOLv1ZU5FEvjQWxP53glq5pNPjtfldVVN',
                        ],
                        4 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-FrLF2uGffV1P93pQZme192v/cHRu1XlgjMreWAScHPPjBz/p9pNTx/bTV83x8peQ',
                        ],
                        5 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-KyLwW4NRDhAz4RVatBCvFATniD3ze5rJvP1usxUFectdGgG8n+7OTcZug8s4bj5H',
                        ],
                        6 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-dwNK02s77FqYOBDJpF4ttbI23g2UUTrI9euJ+OQGonHAy4W1kCpAyV7ozLK24GWz',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-tlZ/hMWxtcO6JxnBPYGsa5Oiu1gmAqp/bY7s7G6m5OOCJvcNQ6Fo39YHu4Elr+Hf',
                        ],
                        8 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-nKdXFHC25mX+ztWymakpQ8nRykznAcZ+yHi9XETJ8CuVvvSGeg/0QCPhvDb41hUb',
                        ],
                        9 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-4Md2NBtJT8CgVnGaoonPkhRdMvGcFRH/nATvRJ0+2VsJ5bjySPpBil+KbSC+9yFv',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-nFIVFc2+uHHcH70YEBnMC6UmUjVxcQ0rZJe7u58lz5aUDQRz0l3xFmVSdao7Ag/K',
                        ],
                        11 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-C6XejYBP1H4YOZVReSXSBion6LKXOt7htNgjRlcKQSsMnL+/Ok1vyvI5EQs1/H1e',
                        ],
                        12 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-GlXg5Pw5UjuoWpx2tbE3LsctnmBsngO5u5c+nK1slAwSuwN86zPzez+sFxncM+Tc',
                        ],
                        13 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-pAEZwWHMzeWUPLx+edoghTzc+LBoBSIWMNFPeZGDiFDP6WL4g+EHr7DhQMUpjSLZ',
                        ],
                        14 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-A2MQ6ZItVBjKp0Efdmi8Xze6uRApxGoHzuGImgZGk6JfuaQ9Vkcev6HtJSQzftWE',
                        ],
                    ],
                ],
                'version' => '5.9.0',
            ],
            27 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-0c38nfCMzF8w8DBI+9nTWzApOpr1z0WuyswL4y6x/2ZTtmj/Ki5TedKeUcFusC/k',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-19EzMRnOAF4Gg36FukRf0Bee26rnZC49Ld5mFG+8XiQ8ddeKQYj7Rnl12YxIoHe6',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-YYaKmJMZQbIhKGKC1QGjVKSQ3s9OlZitN6xQQEPksarSkM0WNkq5Kke0yehyNwyT',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-OVGJJ0J6OIuVjxoE5rUQPFweGgzO0xT+HKN5IChh3LTrsWQKjHocfKq+nk/8DogN',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-dHM1276IWlmmltsiRRg04ASaTBbgAqnnjneOemUaqff0rqTtVHw5qqKE5i0k4Qll',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-oBn2TNb41FLJEvg05fPEoAhWHErn7PR1FiyT6NjQkoPzDDg1n/e/GrwRgh34gDmQ',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-R4Ah6+FGj2TWi1SbbJo01aRwLwdNunBoW4ALQ4SdcDpyQpKoP0pTL3Ce0Hf0oMOh',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-BfzGEucsDAHnSR99xBvG8cNHx7h6sEbKJejtvqlMrN8nMi3gP2ds+sMAjWfWnZyn',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-SgCx6DCTHwPNfTrT8PeDNKVR+bLsTKTVnBbtZYSLgfp4dd+KGa6j4/Jy96HTd0nw',
                        ],
                        9 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-yhpUSfH+AXwjqsle/7pS92NQZivmuHw41bqBfGxkaV4ftpRTE9Z6MNd2oh9x/BBm',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-LMbxIMq/Ra43sLL8MF9d0C8NDym6Cp7d2rtvvZUd5n4EuGE3GSYBmf6JV41EB7+y',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-eX5P9jt8OdQQ4ME1Y4Q90r5k0qCw55F9jie73NYjcSEHIYYV+x3MW3XgqK7HDuOG',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-WvtEEwvz7coGHFMqz/gUsacHkjubSgzLIieTORXey1KIpl+/r1Sk5owMdBxnGFHy',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-RT+uACaLSP2jOOLdRXKvxcgxA/WNa36UYkM14r9ODCgz51g7frfTdR+Jv3q46NW3',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-/BwiSb9M4ZqztN8bEG+VrC9ohWSBX3qEV95+/+gBJoE4+zG3KqcLj8ShUhBIALSm',
                        ],
                        2 => [
                            'path' => 'css/duotone.css',
                            'value' => 'sha384-R3QzTxyukP03CMqKFe0ssp5wUvBPEyy9ZspCB+Y01fEjhMwcXixTyeot+S40+AjZ',
                        ],
                        3 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-eHoocPgXsiuZh+Yy6+7DsKAerLXyJmu2Hadh4QYyt+8v86geixVYwFqUvMU8X90l',
                        ],
                        4 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-2CRj/5C4pwyS5v+q0KXxQ39b3qsKQNE6T+9FFaAOlps/XjJcK+M20aMUxuQtRLaZ',
                        ],
                        5 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-pWItZRjB6NLzlrnwcL+2alve4CtHiaLj9W5ZwGPgy6dtMzCPsGv/qEcRvrbVkW5i',
                        ],
                        6 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-Zbnz7QaugaSWTYmuSFTHGzMLxXAu2vzmqJhA/DS3bnaZGJaatH8apOWXfFaP6PMh',
                        ],
                        7 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-85qDq8Thytv8iDkEBcdksps8EZiX4DEo3vh6Ijk38Xi4RVm37Ttn+HU9rsXho2fN',
                        ],
                        8 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-y51MGgwaeLjbh5fbY1GJ6PypnEoMkGu8MoR1HRE/p/hHfiEE1G9bK/79bstJpyYk',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-G/ZR3ntz68JZrH4pfPJyRbjW+c0+ojii5f+GYiYwldYU69A+Ejat6yIfLSxljXxD',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-8TDwqaS9Kr9a/3cVS6+XkvWUM1tz6XdS8s2urD5rXY1Cz22kPF77ZuG1gIWaz6kZ',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-JB1N15Wp6AIOL3sQ9Tm4a0kATlQy9/+/nLmU9B2wv4K4gGNAUFZEU7qDcxIPJLXy',
                        ],
                        12 => [
                            'path' => 'js/duotone.js',
                            'value' => 'sha384-PcDzzpTJzDDda2YUM4EY5ZqnZQ3DTIFtoaAn7t07N0UIY1HVyaxIHRzROmFBd48z',
                        ],
                        13 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-8YSeMunSTZdDZy7rZxfG3NqC3KnYaCKxTJMm9yoILgIoMpXeTKDrV8TeV9C5ItEc',
                        ],
                        14 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-sEc8iKGnMxm+Dm4AQabXbw0DKZU9FtFrWMppMOsxaUZsLL5pcpQs4aL/OfefTw7g',
                        ],
                        15 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-wNQjNuGVt9TzLWqaxsZvH5uIDIxEkpSCeSPg6nF2ud6AK9jXY9yMFA6CbcZrr+cZ',
                        ],
                        16 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-Vh+IVHoo4c4JXOfJBoUxIiEJf6bB443zoyGtwY8WbBmCU+7fAq9QX9JLtFcNSPZl',
                        ],
                        17 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-vzU1ar4oP9lOG/JJdj1q/+3aatI/ZbpyHIMelvsAi2Ee8gCiTIb/YhqRymLLZkje',
                        ],
                    ],
                ],
                'version' => '5.10.0',
            ],
            28 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-wxqG4glGB3nlqX0bi23nmgwCSjWIW13BdLUEYC4VIMehfbcro/ATkyDsF/AbIOVe',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-+B+cmd37r9agFUqHw5ABups/+o97SqA/Y6S5b3ly2q0ABacloQs0HZOQAX1NpJhF',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-jUGOH+gYMCfz2jbO6DW8vojES/a323h7dcoT6qI7Bvod9mew/wwTZryjccmaMOkf',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-gr19od0wAxe2+mYHEXvS7Y1ppn+ESoAQzTYGPauVJYyAYYl0NBQaKveeQnzez2Rm',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-VUnOJnDrNS0aVOhF6puq5SPJOP5oOvIO6n54m14E2/OHv6DU1gklJ4EImoD382c5',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-94OQehjHMl3lApC2tWmjwtxlB0oEtSE2zrTdf8uuWEaDEkkCxXK/w0vFs5J5WPU1',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-i1lF6V7EeiD7KOgGLtAvJiK1GAQx4ogzG6B9gpEaDuHSLZuM3sFtPZrI6H2Gzqs6',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-aC/bNmpJEYrEVX5KNHN+m0CmvycQX9wDnYv8X2gdXQjrbtDP5OcU5DRiXwL6bPwr',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-BZIBcmKlroIkWe3e13MZbUHZdmagAU/8cnXo9mIW5p5wzf+/U5ULLQ8TVioSuCnC',
                        ],
                        9 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-A6TzAYakDQ9XwDY1hOPxAxI/3t6kol61Ed9hvHegEwcENzAE0vLojG6wItQDmclf',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-NXKh+ixIINN/JHIorH6fcTNwaAekBk2v7azch6cKmQm7wtb0yBt8ctqn1FAspAW5',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-7Sk1mIxPYoZb2I3YK86sPsPMftKqv0aWP+dgX//x1mF1mSOYydXmX7DbtHN99bea',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-dc4FEGpFyXnyL9DbieF6I8Xzipdt7GRHX6k8RM/ow6+IDISjPeeTwTiAkNzjv2OI',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-BtUWeH6hQDQGUZewQDmWRMisAxvs1LtqoVQgmbFptFnH1GpBw2b2vZenxfFmRtOS',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-y++enYq9sdV7msNmXr08kJdkX4zEI1gMjjkw0l9ttOepH7fMdhb7CePwuRQCfwCr',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-9J78p9RP9gty/jk0TJPvYSzmYYCH4cRRkDMnZGxZNh1wdaXLvXzIk90EWrxjjqr9',
                        ],
                        2 => [
                            'path' => 'css/duotone.css',
                            'value' => 'sha384-Na50X0DRTNz+Sc+4XbFXONmaknKHBHw6gvRZ4coLQCl7ZLXziulq+4wvTZxkaM+U',
                        ],
                        3 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-OvQaO09Stu8nVnOdc+6B3WjpKg9dfBxoakdLxJKAYgsz62+DzBUCvWRxPl9LRVSq',
                        ],
                        4 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-CL557/BMzDSg/4ctPpKDphHJgLqpdJ5rvOklcaHzLHpX+qsgd4V/xao6Rya4xKMQ',
                        ],
                        5 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-yLDdP4XFV3JqISKN0JaZ0kdyks9S+U2o9uBmNbmZh85yjdF/kpu+oY3/eXQcGHhT',
                        ],
                        6 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-BrYpEWmuPyxLgVmvUGa111AoxZ3kKwiG4TVjjewWZV9vww+dTLWpmEffDSEg9Gf5',
                        ],
                        7 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-V8iByeksgr2la9ceLV1jNv7uWdzI3pYZLNzgYqWmQuQZa7khs4d6QC84YnMWoKxx',
                        ],
                        8 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-rql5zubvrhoXpo5buqgoiKryiT02OHCEtveKZrj4NX/C2Kuy7W2P7vl+RVzBUl9m',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-FW78RPcSpi13vjx77nPWQIrQbNSLkPBopb0qGzLCxD2x4Kr6FA8V05C/6cpgkKPL',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-DGr5D3fYhGn4bylN+nFRaxvPt6s4FjV7B5EhOOFUKW0JKU2vco3q3xtgSZeeEYpw',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-++EkH6KNUkbsGzUhPmRa5yboy873FnCrHLPNWnvcfYOzCCShCQHtdQ3RQTt3WDsW',
                        ],
                        12 => [
                            'path' => 'js/duotone.js',
                            'value' => 'sha384-QwVJpiaupNLHQYsfQUftqzWXMT+SsU4AKnlvxDGzNjTq5xPXRbG/ohsvyIEyK2uf',
                        ],
                        13 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-v97MeHGTkmNphZhn+D7412xlPlc61o4jy6CouRwKfNltfXH68HcYhmQBr2j/J/Vp',
                        ],
                        14 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-TZInz5PvbxRzxSlGI1WYKmrrBBk/XTTZymO6w+smmSVD6RFpfZd+JtSye/viSFxA',
                        ],
                        15 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-ZlV+aQMpcvCEqNPe9qTu/S6+eBL+DfRjOxr9wtsoZyGnJ/vwQk/U2SZhZ8tJqH5F',
                        ],
                        16 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-WtnuXyp6MLUsHy3FAqJyL7aL0a/mdUjPwIs/Ub7FXJZufo/0qH9aFsTDY5Q6Bx3m',
                        ],
                        17 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-P9HMMmM/ObyzYMvKfF0Xf40MYwNdkI08AwhSyCsAVlmXZkJ9GaI0Z23pozRg8HAe',
                        ],
                    ],
                ],
                'version' => '5.10.1',
            ],
            29 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-rtJEYb85SiYWgfpCr0jn174XgJTn4rptSOQsMroFBPQSGLdOC5IbubP6lJ35qoM9',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-qVnmyLTtnGPGEN3HDG2MCEOXWH1Yk/i70lKRuV+gMCDQg+jblQlFGPf1mejWUyYG',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-hM7EQerc09E4O3zhtvF2iqcB4ZkEu9xkLQndhXdGGCEJ/sB4JK54SuKGmIC35UTf',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-zuVEAfuEXYtKnHpmwmkhzwMdR2uek5gePU1XveESmScyRJHbncv8rLEAt+ofv7ze',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-qPldrzmea0i8jhonuql0da/kQWeaXdQl+krGXcTQUdRUGHcXBfSrBbZLbyMcCWcF',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-G0mvrlfkz9DnjBCRmY8Wf7nC8wTxDsHE3pGAc7/4rDLh5+v9Z00qi/uyjjcDf1nf',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-updXts+unDswrMsYxLc5R+HfSmF8CuEIOe48Rj3DoVoPUIImOT1fs26H/tr/H9gC',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-QMu+Y+eu45Nfr9fmFOlw8EqjiUreChmoQ7k7C1pFNO8hEbGv9yzsszTmz+RzwyCh',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-0kDL5YEgNJjL/kNToZYEds3evLmosarb6OU2eKqRYu6O28jcJc121tjUC40sG9VB',
                        ],
                        9 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-Hg1lNcVEsyCqBb1J4/U9X9IW2DEhAKIBfBIE0J0eiWGEX9LEpEULwcsqoAb6HDgG',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-5WtMZ7frOu4PgR22YgRSlercgEU28i5Zn39Svk6+2cg1MOigLDSsvXccsmJO2Wxp',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-CYi/gunDGMYA12KV546MNRqsjbbWSyKgPjA9BwVMBQmIMhzVrjyUJwkV9uujzHLJ',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-RbVpZhfPW/1SmcShwIOauawY5vJWxTCeEnmiUCiY2SbkrbKuSGTqJ9NnBUmcP95A',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-gDM1aRghQ5DRg+fSCROSYawrJhbAHqa6Teb2Br0qRJtb+vRJlyU4U4xnmN5cwJ9j',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-XxNLWSzCxOe/CFcHcAiJAZ7LarLmw3f4975gOO6QkxvULbGGNDoSOTzItGUG++Q+',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-hIpb1kefRKjC/r6WxN0S6Nai7+AuherqCoHKD0HNdXkbzJkZcS4o62bJ7ODiBWAu',
                        ],
                        2 => [
                            'path' => 'css/duotone.css',
                            'value' => 'sha384-B6+5TXCEkY2Io8b+v2Ki0aEWnpCFgBYkOzXAHY3oQ4tr90JpQC1RErwFbvJ9CRt8',
                        ],
                        3 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-1sdMwbsd8X7Y+nVcEr/4D35smQEaEd6Qz+R00Y+NPUkG8MyRa97RrX5I4nqDt6X7',
                        ],
                        4 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-dlxpRYGi8Pjg49IqtrDIVZmCOQZ//oDKDkoqbn/IXrwwQDP4Uf0ys6+eH1z9sfhV',
                        ],
                        5 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-hKM7KqUOh6F2PI59uEhofbDs/5qHHdJEULlmNWJEQcu3D/5/vl5zpwBrveC4GAbI',
                        ],
                        6 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-FCdq+BRoY+lV7Zy7HKKQ4zoywYLRyasGk6IrmrXfmYs0xIgL0QrPeEPTu3T4Uqcc',
                        ],
                        7 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-+OTv1mrGtdzHGeAuFSVKpPvaMXNpUu+W+Xs4xYz2RgUlrBctmMyE3noRImN5j+ot',
                        ],
                        8 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-88Tda+TyAtJK9/cRRXAWdJjyE56Tg4ai2x7RoSEqSVodcInAoV0HNQ2ofaGCidyr',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-lowSFbzpSYKDOsvnpi2JVneSnkrbVjOTwcHOWpC+tj/YT1mxTDIB3ZqbtllmfUSC',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-nyTyvpFz3BvQZucRUSSEDlyivN7GAC2Xhgl9M92o/rt/KfEZ7LkqusFXlCjM4DvC',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-eYjh/PZbsWw6lqYWtDM+NlcRs3pUkOk8r4mxv/x0xDjmYPXTxPKQ8ZNXxOnd0UCL',
                        ],
                        12 => [
                            'path' => 'js/duotone.js',
                            'value' => 'sha384-2j1n2yG+7lkO9CjnN1DSQOGJoDEaJPEr+TPmTer3pK/yD3bQ/Kk8bqJyS3LfCK26',
                        ],
                        13 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-sy0tjZ+ivgcg2wUVVEmLMO5wfntWOSyQaD7AQec0iXINci5JAP92T8sM4YldYQIA',
                        ],
                        14 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-vh/BsPXkl02OgBjk1HJkukipMWFU6vHADY4W3u9BXIrKjcRFw5Y5XikVLoLElHee',
                        ],
                        15 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-p89srWlrnSOel/vi/SpBD/wyTTJhu+27jcfOazOCUnLTpcxG+NVuYs/okkO2JBox',
                        ],
                        16 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-JzK2muq5DGAdfmBP1xyuFUAYGceTmP/Y84tZvRxkdtsjwuIcd8Hpf1D+5izeBUQP',
                        ],
                        17 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-z089sTZgTLfns4lyNCTpVbdQA6JAhOs6JXwRH4ig0M6EHPg+Lzp/hdcx2OHQn/v8',
                        ],
                    ],
                ],
                'version' => '5.10.2',
            ],
            30 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-XLYVh3ZsmvjnjODXg/qvDYjcINmPLORACP+Tk6qA3jNLbStl84PzAeEz2Su02511',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-ngkCSSyhFgmeG9/8GICGMwnX44Q70/NN2XuNgrpMHOAjXVjYwTvtQML/2+2EH5mm',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-saSWCOAroWA1DTfG19axC5l7ej+/lsLpGrQjthhULGGw0FKZqZmxdjRhWqjypqgH',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-NJ6bXu66piTFdxVfLXmQuxcjGye4blIA4H2DybHqY1WFdYSxbKQo6W0G53caD7MY',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-1Ln0i7HCe1LMHO25AgX/9s/3XzTLIMev2SYgQz8xSyXSa3775gIb15NIpJoDRYDg',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-utbeJwkEmotPPgnsjR2cFDH5mR1JrU1EX02CRdVYlT6MuuLA6/jK0M1UcDXBVNa1',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-QZ/09hWMymER1waFUW4M2iM55h3bf5FVf516rOAYf9G2mHSpAj+oo/6jrxhxiVq4',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-Zgm+jt84FBq52ezxzG1WPrUHXPTLraCVSuBDiGgz/mX0FZxgdkTZNephFvciYglv',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-FYnxcuBilMBfd4M0z3ZhTEWrorBL6P6mqaDWsYN46z3iJszwg7yqVAft8mxPhWQf',
                        ],
                        9 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-nDF1UhY85TnH6TtkBtlcaTXQh2EGA+oy54oi//hchZ6BIO8n0yZOdEDcqy3Lj6SH',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-+4PGPfaOiBMXBdbxBpjj3c78flBTf1SoDBBbEHY2P8SuIKsjNJ59vjhjpMClcRVk',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-sPFXZNRvY5NMeQlqaEJyF/3Lrrcqi+EowkFdHnHe2B5/GSLq+RN8eAfpDiFzWveB',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-abaNJNBN26YUz3JKjkP/eHqZP+7EaMLIkyR/I4JNQXin7CWBKc81Tmgh2//K2gfd',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-uQinggJhGToi55IHZla+hhoeR3xafp4JLhuIZzag3QFHKDyLLolL8IuCRM2aLdxy',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-eRd7BE4pd4YyGL79iaO+/+GQtuNU464XOqRShZHNdRwR66wJIzi0UirzOFzuoMOo',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-/DL+sGDGYNVXNSXzx8omqgYJuKJWhPfJC0j3sM06CPE7CKypUtyAtAburBBMbhWn',
                        ],
                        2 => [
                            'path' => 'css/duotone.css',
                            'value' => 'sha384-JrGJDz5LRxQ3s3dW4Av8oo0oPABX1FQPzGwpVizHFqVT7RXKd2suPslh8/k6EFvo',
                        ],
                        3 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-ASwVckljSlVqrp7J4fCNW1Zfqp4GBw13f/oq/bwtr1KNG1j5lzKrfTpvoivwJZpS',
                        ],
                        4 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-SE3odAKV/Li06jtOem3j03b4qHD5AfOLS3ip3Ie7HS0QtdLJuRozlFcEiBnKhIjj',
                        ],
                        5 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-v0Phnxb9e1tIN8ABEpuqr9+U98eA2hbSnnxnIFWqTyvwFd4QjVV9NOCl19hLotTv',
                        ],
                        6 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-23irw3gzc0cirSOm9k0vC4Cb8339DDxFatLW9p83F4RsFK/1HuRvePKAltYrdlBX',
                        ],
                        7 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-c8uzxHbCxkqcTDgRCHmj0nVIK7Z72qzR5ciNuZIQQKWVMb0Trzdh3g9EmdybHyb/',
                        ],
                        8 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-+/X59I6aJtu7U5st0yw42TmOgz2GTi80ici4b4Zr3fVKaib7AhAhXm17vhXVqNN6',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-jaxx6ehyna+t5i9JERhQruWpH3C/xGZQJz6/+xqO5C/eWWJ7ysIZIe9BAULfRy+f',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-om6tKqxNyejPYGBkAEpF5czG8EOB93m9G17YUGoJgRtei7kJnA4P4+w73UfDPtLl',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-I8WM/bXtfWQr8u2t0OIaUfJNpTd6LnCbNnrQpaKQN4/Pdek5IOtrXdpcXpLwzCoc',
                        ],
                        12 => [
                            'path' => 'js/duotone.js',
                            'value' => 'sha384-tit+/K18O6+uMPCuvEcobuzvT7aFly7Raxqnszuar7OzNloVr2oIugu9S/T3MNgn',
                        ],
                        13 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-kAYceFs9TzH4f4HsWzAZvbE7yJRTcOUe2UeJVCdVV8AYbspSlxAIwUg7yGHrtSKe',
                        ],
                        14 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-zam67iVIo4OJbdPFYrgsf4Te4l96q61wYKpT72nLO78ICkwXk27OlsN4SQYHOlI6',
                        ],
                        15 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-8QzBYxpPIH9HEZ96HhicnkJ8XYzELjI6YQabAc2ANT0wExEgzeKwnNdQM3B0YPzX',
                        ],
                        16 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-vTIqr5UHlJnlDEDAZB19P3NuSQy0Ynbzj7w5ofBkLPpN1bb7N2uZ/z0GNZGCIFxW',
                        ],
                        17 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-56L2fWZDluSTJKVxfc7PF+HoFsBrcdkn/Wj79nB2pzTgaYmqLT5T2pn6PLbMvHHq',
                        ],
                    ],
                ],
                'version' => '5.11.0',
            ],
            31 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-IT8OQ5/IfeLGe8ZMxjj3QQNqT0zhBJSiFCL3uolrGgKRuenIU+mMS94kck/AHZWu',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-UMAQJEtrY4iFRXQIYIXWfTd0GPzHrhSPK1SJ3fEeGGgtkC3m5qhKESA0yOXahpmJ',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-8dpIy0am6bmWHK+abUbC1sgkCSD6WstSMjjNB7JVa+rprKurA6xisqNHg6DESJWW',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-5JoPxivOfpG9KRKbjXkqhwpMZ7vvAATGi77NPd6sC2ruJrWa/hKqoLBIWC1n1N/U',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-20Qlvv++Kgw8B9SXDkUX4JrITPco1UXcaB1mkymQFgx8cM9azG2Ig9Sy3khBpWip',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-jv39B+1DxC6iSROYUwIeI9RUDrl9ckXFPOOlys2dTXchRTodXzqX0lm6GUwN4iLA',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-iJU+Et4BsM2cUxdymLmM7B8IF6IkyAYIcJRKroT/XuA5+2bWL9u+KJ1ZItC4bcdo',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-4Uei2cJ8mOycRxb1dxppaomro+V4vHdGuT3NfYGpENdgukEOcOrNB43OdzBiHdpZ',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-q5JjSRgEoLV9cBFXvjGX8xxIxWN+LcGaDFBxSid/9XwjhecfXMQK9Ak7bcPSFT0M',
                        ],
                        9 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-LqGhhRx8iThhBm6ytksB4x9veweiV+qNa2soZmn8V37E4Nohq1ccRoaSr4o8YAGQ',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-jwx8I0tSvPLf7ZV1KwBdmXpCHgduVujQNEzmHuLEiCYql63uV/C9TCtdBU7E5TL/',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-W1XmDNwB/NY1P/H0BiR107pc9NC7aTrPvwXbrZewndT3nyrmFm/7IIc0AxxcHQ/N',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-kDwQ866HvlesMeZEZYvoa7AceBir+K+jB/0PVVSs/1bX0JtTvAm3aFEgOCOCt3c3',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-gtnOUe72T7BrqVgxbkcbbwZGJLyyHFFtefPxPZ5t/rmQ7vMNXbxml7JJkSNfHmkV',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-sr3GDThhNP8BxHFoTK4zKFgOjcrT8vzaiLwnwU+yB31BCaNj3QMX6YVXcv8AeBAy',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-4sG0FgVejJMQM47pqYyG+7afeARX2P0HYkQ8JCKf3ZqTcpJ3/SWefUFX8kdm8eYV',
                        ],
                        2 => [
                            'path' => 'css/duotone.css',
                            'value' => 'sha384-q4v2/qv2HhGIAcd04NDH2XuGq8Bzu+xNYUI3gcKFfWt09m/dgZlvUC0rQJ3KtGg/',
                        ],
                        3 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-O68Og25nY+MZZRUiP6gm7XPDuHsNC5DgKWEoxn6+3CFcGLRXuFihbGO/8c5Ned0i',
                        ],
                        4 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-Rg8mXhpzJH99uBsgdsCp9zXjkcsw/pm+s4Kgu/56eRQSd8SAszYc6hssH5MLusHl',
                        ],
                        5 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-RjVm0cyaQYehIEaR5Tt+JDfgnUUtY7GP/N4rEglG6DxLUhzozRl6HTH5NfPQ0X1/',
                        ],
                        6 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-/SNkE+jEmgiOubdXCmBU+e2fWH200um/crHWjo/Rni9rhQuxT4demqM/PAyc+tXU',
                        ],
                        7 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-9q0WPwNHncxttx1Sf3c/G9lszy6f82L4rYAYW+JF0PRBNvJ1mVyYivrsep7J+Fud',
                        ],
                        8 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-1oMR0RRrEohmWSZo0t/tezQF1gyGc/b73Bba+qyZLEGdTAPORCf4p+pQm/iycsgj',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-7DVhSuOn0R5KmazSuDzmwQHOIPfU4+n8x8AifcGCoSOGATBJh55ZY41LSL37PB6m',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-QRf6gn0gPrg4U0aYZ5s/Sx7xXy9gplYMzh82CI51530v89R9s9xGG8ljaSqYflQU',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-jKcJk7TgESeW6RZgq9/e8kTr0jRQ/JvaM//YDKwhF9wyvXk8lQs27OQ6cgv3FXTt',
                        ],
                        12 => [
                            'path' => 'js/duotone.js',
                            'value' => 'sha384-CeUA4+L5GZZwc5CGnvQVaT/Yrv5HuRydWW/QDCiXZnuORKxut4zKDa2WUaCS7fvo',
                        ],
                        13 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-hvER25BD06AWxsJLW7cQmGKjQp9PSZttpMIo36kIq2TTPEhP4lIT3VMFul89Ym6d',
                        ],
                        14 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-qvh52W5+cWrTxhfM559wBnsSqplMQIEjQkHnAE8c6MViBcH1OKvI1u4IGR+26hZK',
                        ],
                        15 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-owKa0I4sfD0ooTioBE3KJEbjcmAZi2LeCbkqHr7/vkUeG/U5OyCGxYlcz8axgnSe',
                        ],
                        16 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-hNm7JVaYkbmX1gZWRwOXVFKJ3onp68grA2bFGmFSMCQueJbgNvKR+iItAjM/PiuT',
                        ],
                        17 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-1MuEmp8vgjvrraTYbqRjvuZbLs+vFg2oeN+87QTVYX2EAXM90T4bzBm7HIFFzAp7',
                        ],
                    ],
                ],
                'version' => '5.11.1',
            ],
            32 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-KA6wR/X5RY4zFAHpv/CnoG2UW1uogYfdnP67Uv7eULvTveboZJg0qUpmJZb5VqzN',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-tft2+pObMD7rYFMZlLUziw/8QrQeKHU4GYYvA5jVaggC74ZrYdTASheA2vckPcX5',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-+pqJl+lfXqeZZHwVRNTbv2+eicpo+1TR/AEzHYYDKfAits/WRK21xLOwzOxZzJEZ',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-zgXo5aJZxI4cJSgWSRtbv7q4JB6PzrmOTAWiZt2CqN25ifeKsCuQZ/pUNoPgjcTb',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-doPVn+s3XZuxfJLS7K1E+sUl25XMZtTVb3O46RyV3JDU2ehfc0Aks4z0ufFpA2WC',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-PCpLTPQTGcSAXFltutjYRSDJAXJItRY88oa9XgNyYJuwrgJGx+uNVmtGSDS2PPvL',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-/EdpJd7d6gGFiQ/vhh7iOjiZdf4+6K4al/XrX6FxxZwDSrAdWxAynr4p/EA/vyPQ',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-b3ua1l97aVGAPEIe48b4TC60WUQbQaGi2jqAWM90y0OZXZeyaTCWtBTKtjW2GXG1',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-b2GpqFrJizV0BUEdbrITdOA5HnxnlrErt7MlEERWd6NSJ32rHeibEvyyCuA13OAS',
                        ],
                        9 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-b1XIrGvAvE1F4q9vHz2OmkU7bBKvxebE+Q/bW+d4lG90kACkPFm/ZQuS9tlTwVD+',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-EYYaHDhIRoBhd/Ir/1fPnxg9rZLk/55lKtlNT5KrIcONoCS2kjf7ZWzMoCLLACeo',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-vIxiYcREJ+yKr8tRXG0gCdepcyuhCTkHwiTdG0qVTHSQvjO0pmllh1QAy93JYsE5',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-Mf3ap7OwO+bjTkzM1RsrothLh38uKXvMWJ2TQPXGHqZcqfeI/cyCV+sfV0IDnBDq',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-G5fIV0dSzZ1nDQSh+B5u3TRX2UtPcd5UWyi2WS1fZIpJQ/JpJCdShAZ+wmILZ7Qd',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-zrnmn8R8KkWl12rAZFt4yKjxplaDaT7/EUkKm7AovijfrQItFWR7O/JJn4DAa/gx',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-dd+UlUKIkNDLBFy2GZJRdMODxfdUjx/PanzxBbsXaRBkyjHzUeDX3mj6q53uL825',
                        ],
                        2 => [
                            'path' => 'css/duotone.css',
                            'value' => 'sha384-tHth4ugEmPOZTBSN4Hi2oYiHY6vpxIL8clasFZidKyR6Gm34+U6wx6A9eZHqTs2W',
                        ],
                        3 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-bQakmC+XBF+eCf93fSR/57kAeX91i0BDyXyj8My8/e/3Bcno5zhEGM02xNvpXV+2',
                        ],
                        4 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-yNf+8hATd/MoR/yfZG0nBBtjTfxZEM1rJos9BgjBaVuLcu711wcecTXBlfS91nfj',
                        ],
                        5 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-H5RIR1XTDkiiLdUTNtbYvWKpNd2qsPBeGzpT5PD495znZL9JCA7119EMPNfCASw1',
                        ],
                        6 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-LkNnzh6wVxsC0m3vcQ0T5L6csSYpgSYniG/AKJqWBsHT7PVpeO0QHkBw4dW1WfVu',
                        ],
                        7 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-Mh++Qzb28x/RVEo6SYO87IyopQpwhzveyGIVg/AfbCLCEHUINYcCy24fkArgPFNc',
                        ],
                        8 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-A1hDH1BUL9ZdoEFsPEJY4LRFhu70QJj+RaY50Zoqd568i+ONa9LHCI+uoWDT0Lut',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-S++1cFhwpxbtRScUliTyprAMK33gMHbukurY4rNyt9CxIniGm6PfioUsQPoAITQJ',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-NuqRsJYX4n2gSY6iMRHPZJxtpR40C8Lc/CV66yyeP1Vu5W2QSuVyPxMRpRIGihE+',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-GLrjh9czojGY48hc8pYlf/3FRNEBu9OWvNAta7SMilmijx8+ciGGVZyD+VwV4FVP',
                        ],
                        12 => [
                            'path' => 'js/duotone.js',
                            'value' => 'sha384-uO8Ntsr5QW0kAl13UUiYRBDhu3foxlKI+jZjPBApRxFDX2tgO/GYiCXIYiGixOU5',
                        ],
                        13 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-FdPoPmNNPrerz9uF/cNSTyPmNCRf6b81QDEPk0JlXAaailLV3DT9yA8plMzyffNZ',
                        ],
                        14 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-zE0WHJZIhNaysmywEoQBm6THN0uK5wAyfKWoN6lJPGOlrMB8hf0Yt4/+bex9jZi2',
                        ],
                        15 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-+3mzeMYwSyHPQfOsqYlwcE3OSC7aI/+DjyVLkBxqWP9O+JyoEtzidrSonbNKh1uy',
                        ],
                        16 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-9I7yL3g1YvBlMZjZ0bWzPqP1m3Ic5t3EgFq/MqNm2r8FUxDVowt7dO4S1IFleLqZ',
                        ],
                        17 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-+Onl+wOd5BbZvaC8Q/mQUO3lZAqsUyD+xqhS57VlU7gIpqXBMcS9Tw94A9uMZRwX',
                        ],
                    ],
                ],
                'version' => '5.11.2',
            ],
            33 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-REHJTs1r2ErKBuJB0fCK99gCYsVjwxHrSU0N7I1zl9vZbggVJXRMsv/sLlOAGb4M',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-ouytoyjvzHVJu1m+KEtJ+2Ys+WFsXUlknprEuQAUs62XNn0shj9U2QeTwdJQmPR1',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-VoScp22LWX8GkkUAmdkkkj+rz+/r84lmCD6FALIryJxjwBSz6kE6oebSlamQx19e',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-uUtN9GUP/RxDz5kko+qO6znqTP45OrABIxrrPhm8tax1s1huRxYCF7xDm+YunNDB',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-9AfJF7pZ+RYk3wXpf8ge6fc3XhPaW3Xl57Qj/mSzPckn9Tu8zJ9qUipWq+/utX20',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-e3I5IwYfes9z/NL+oosxhrbsLa9R8TaEY+Krsm07Fcz7q/R+8nswvn20QsrR8tsb',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-AL44/7DEVqkvY9j8IjGLGZgFmHAjuHa+2RIWKxDliMNIfSs9g14/BRpYwHrWQgz6',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-S+e0w/GqyDFzOU88KBBRbedIB4IMF55OzWmROqS6nlDcXlEaV8PcFi4DHZYfDk4Y',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-NLUhiMQCi+OH3uxQu0Ems+2GYt6KJ89f90f4kZlK0BoDB63kHZqAICPl7nQHppJy',
                        ],
                        9 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-PpGSW7GgJeChJyQc4XW1MIgUrRkMZudoPYOYAqGERZ+w8ammaWDBQvHM3Qp85XCV',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-aolToWrR1Hn3EFHDZtvTl0mtjuJJKLxSu/6b2tlr1g9dS+RLt6QVshweU+2e1v6V',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-LCyqT0dvDekY5RP1UquYgUJARvp4tHVJocO5ICwoWSyVoSXrKpJrRrDYxj7+ukHO',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-QsXs4eh2k/7mk3dvvNMhJJDjh8UQ++vWm4e7ULJ1UZTbOv3wQOzn+4ULg5iLW+Ph',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-NNQFVmb048Dmy0GH4ex0kGVcjxaPeY6JA1+ImM4Lsfr4HOD5CNMvCSoIfjeJJWX9',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-ekOryaXPbeCpWQNxMwSWVvQ0+1VrStoPJq54shlYhR8HzQgig1v5fas6YgOqLoKz',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-z3CBOpMFSI4D+GXPvBsSW5vXhm4MEzWuC/CycHv+vsuzuztOzPpomZimFLeWNOgk',
                        ],
                        2 => [
                            'path' => 'css/duotone.css',
                            'value' => 'sha384-SnqCl1xqt09zXtBnCqJWrwMR2wbeWfxeAEB8e2QuoHdWNY1V5k0HrDi889EMHehh',
                        ],
                        3 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-CtsKDnRWWHDhjRZ5qgpCFCGpib2FU2SChFu0xRt81grgvXq1P+lbpROQoBLxlU4o',
                        ],
                        4 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-i+ivMdAc0+wLEnd+UdXLpYGNTbyn/0Rjz7EqmkqEOkfat5/2T+S63wn3WDk6h4Yh',
                        ],
                        5 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-hCQzyeTkj8xmAEG5HT7Hx6t6DUkpTM34rr6FHL04J4AWtPtryU6EjsEDb+Gf17KD',
                        ],
                        6 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-U9f9KTMQ1TBvUUFLpp6FgAy1M59lrF3q3rYTHPRVtT8OzY3xyyFUzKevJFYHEbhq',
                        ],
                        7 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-CpTDS+d/m1rbSfuYxoVJXNCmq6ovovJAD1qgFE+K1Vf5N/n5Nt5yEoZq1UovRsXR',
                        ],
                        8 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-w49b1IAwJTEsYuPUW2QuSzpWNnhksbL+b/1q2eGObJ2CVV/HO5ubRS4jyMLB4cGs',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-t1m5KR+UJYhp5D1IG6cS5MuYjxDyh/lIkrB1YUpSPfGxgR4r7pA2xW+KoAfcE5IZ',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-L2A2TL70Fg2x6gHvF0zTdYDo163eb/op5YdWXAr/rWfprmIjt6Ib+mdHv60yzNh2',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-Tj7c3TfdpwGV2RqPFYgEbtUTrY+wJeAPDMsuUTvdrbMDWlP6gpUN6LNbXNf1C8BA',
                        ],
                        12 => [
                            'path' => 'js/duotone.js',
                            'value' => 'sha384-wAGnJyD+rhKARbazT5ohAk3YosShbJZGkuSG5lrKQOfQpG+7Q7o6ZmAvNqeJ7mFf',
                        ],
                        13 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-YdKgBdzRKP5F/uorpoOtlS1fRNfveZicpRkkQTn0pQdqGWQs6AMr7Jby3mA/G53+',
                        ],
                        14 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-VuS+lIluvKV9KjbEENEaZi4Ixed0QRYlUr6DI6+U1vj/rOfMP7wl84Z53+fMZXM5',
                        ],
                        15 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-lS00sjHGt6pxefm2C7siOngllQ0WM3NoXEgwBb79KI3nh2iB5F/vkL7q09F/Z3tj',
                        ],
                        16 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-ejND26kSb92qqj9cH70EMoR8jytCElYWiCB0v+JkXBz6+2ccBkNJkJZuMmrXY9L+',
                        ],
                        17 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-xCtgvUZSTFqAix3U6PrST0KLLMXPkzVPwXq3AbYkoKi81K4Ppryd5D8lUII1MeU+',
                        ],
                    ],
                ],
                'version' => '5.12.0',
            ],
            34 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-v8BU367qNbs/aIZIxuivaU55N5GPF89WBerHoGA4QTcbUjYiLQtKdrfXnqAcXyTv',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-+2AYGyI2bR10NExh4Lu/3NQmpNxck8EcRE7aATrMi9QQ9OAKQAQw1bcrlWkp0tdM',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-C1VkjHy10mh0wo7rz2xEDdqrfn5C+AJpaCpUyScFHzKb0mnAU3I//2RrdAE+LfQ6',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-ZYhRqsbjqPY5BrYAS/7RLN0cbKU9T2MfB24Lb42Gyv2BHvW5sujo7gc5gXEReTq9',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-yiUBjfJC2dVbhAEtVzEfH+R8ZQJ91V1C+Vtr1ZDTX+gUBZWrNyVrs/Nvc1fzi8GP',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-XBFwYq8dzGeC/rGkEgveavwuEU0D16mIKfWeCX6deYzhMUaa8GX4CgA5c/YHP2xo',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-C8a18+Gvny8XkjAdfto/vjAUdpGuPtl1Ix/K2BgKhFaVO6w4onVVHiEaN9h9XsvX',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-ZbbbT1gw3joYkKRqh0kWyRp32UAvdqkpbLedQJSlnI8iLQcFVxaGyrOgOJiDQTTR',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-KASsDRWwlErb8dTf+e5TxRXMnbXrVlbPbn1hS5B/yS4vNsF7mHHO+Gw1bBDhcyOt',
                        ],
                        9 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-fHnSzPZE3xYvvXY0y51vln9J+Jd0eK4HughCkcA0NsBpmAGgU97n65RbDqUgnWf1',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-H4naMsxnUrIT8qihjWfwIKXi5biIYnqUsQ+vIJGZIKfA+7/O3FxgvMrdH77X+aID',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-yUk5aOIIy62R2bRFbFq0+bo+ChWYs75cusETAJ1KYvEMRiEbQZmNU6u+PK60t536',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-OSCcNUu98kEBVxq0vZaBr0wdmmd2ojuJwvWuSRKD0V10PWmvTetja8mxGfZm5PsV',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-/OZ1Lht4J1/FfstamqqFX1tF7PkDWDKbvat1bkWByC2KRJwGzm/H2bVuw8N4SD8y',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-TxKWSXbsweFt0o2WqfkfJRRNVaPdzXJ/YLqgStggBVRREXkwU7OKz+xXtqOU4u8+',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-oRjDIXtfHT9YAjxHLAbf8PsJklTJN+dl7PmnAlOTYJhNAspi+/xgU4f12vi5xGzz',
                        ],
                        2 => [
                            'path' => 'css/duotone.css',
                            'value' => 'sha384-qrJ30c8jzW/3IOQRl4RddzzMsw3YIUWq5YhHW/8D8EJnS+5J13GpCGVEVI3ELc/W',
                        ],
                        3 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-k8n1hWo+b1vuRb6E3KATGC++lfNDnJTtJ6pS2BFF3tp/OshnO7uhzoOj/zJbGfwg',
                        ],
                        4 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-iUpVK/Fzq7teRSWAUmJsnlccV1OgC2fMpgreA8gxAm68UxbZPiMu3GP4IbKdKIUh',
                        ],
                        5 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-QprxpKrx/cRYKXmWVkM97ert3857dCN6bbf6cRMELoa1+IYdsHoqweHwJksEfb0j',
                        ],
                        6 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-uef1Ib3WhVuFbw7CZtyE+4IDCiKe1/bGU0vJ2naf8VQHKAeA67yU344LBk/H6nhx',
                        ],
                        7 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-GucW5chDMZnyGPL1yaIe1GOHu/X7ixbmNjinYEIVr8a4Q4ewZjgipeXJhVi1lsrd',
                        ],
                        8 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-58YCAaXf5eAJ+1vna1eEUPuU+Ez6EhIPG77PXmK7QciGJsDNAHt2D8ke3vDio+Hz',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-RiuSF/PBDHssKXqYfH16Hw3famw7Xg29hNO7Lg636dZXUg42q2UtNLPsGfihOxT9',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-yrJPiY+1PdmFAwIfz5kqOJt6qBz7DmhXnjLZWLQ9FopoqnhHIBdOQk6hafYoSquV',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-bIg1sG9EStRr/9ohrrZJs0/uTEvUEEOO+NWuOAsIj3a1ZCHqvWUW6w975b4BSbqI',
                        ],
                        12 => [
                            'path' => 'js/duotone.js',
                            'value' => 'sha384-1EFXmt5rBEAK6aeEt/mZiYu0QhdFqz7oRm0Kc4xKyZ2IkrQYBc5F77PWXv3Jl4jY',
                        ],
                        13 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-P6BxA/EZmb6ypE1RKWOU6G8Ww/wI6w4R6uP6u9mkq3uaBehDQxHOLax3fLvDqkvt',
                        ],
                        14 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-08D3jBd9Co2q3IJB/9qnaukQ4ZhFWVLATRpNirJUQ+yQ/oUORDPfJ7Z2OWySf7/A',
                        ],
                        15 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-zw99I3pdjnsTnY9W+2pz18pxMpOw12uAiVqYL4dZJOf0Lm8dio2v03Y0L2wzECI7',
                        ],
                        16 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-Jr2b2cxzFQ84TxM+s7yh1jUu1f4FLCHQQDT3ZeBYZNQo+xvCw52PmB7GbC9yqSqA',
                        ],
                        17 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-sLzGuPzMXKEht2hBPBvC5ere217qvxFZ1AogesHLWdB5ojWBInm4wE4J+HV7PB6z',
                        ],
                    ],
                ],
                'version' => '5.12.1',
            ],
            35 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-yZSrIKdp94pouX5Mo4J2MnZUIAuHlZhe3H2c4FRXeUcHvI2k0zNtPrBu8p3bjun5',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-syoT0d9IcMjfxtHzbJUlNIuL19vD9XQAdOzftC+llPALVSZdxUpVXE0niLOiw/mn',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-rbtXN6sVGIr49U/9DEVUaY55JgfUhjDiDo3EC0wYxfjknaJamv0+cF3XvyaovFbC',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-fZFUEa75TqnWs6kJuLABg1hDDArGv1sOKyoqc7RubztZ1lvSU7BS+rc5mwf1Is5a',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-zMDYkJEHc2iapAk7o9HXGGD5N2+GGhOFQPDdNTYvlcc0gBA5r7r5f0aSYeCvm0qn',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-/7iOrVBege33/9vHFYEtviVcxjUsNCqyeMnlW/Ms+PH8uRdFkKFmqf9CbVAN0Qef',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-ujbKXb9V3HdK7jcWL6kHL1c+2Lj4MR4Gkjl7UtwpSHg/ClpViddK9TI7yU53frPN',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-c4QRk2vaIFBj+66H3IMCeLBpgmeNbFV8HqOs55qMib1v/dM3JXdodyctPNa9hTyl',
                        ],
                        9 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-sDmAMseQ6ZkNcFsP2c8NLyUmSqzUpn9PdoWqr/IP+mXZANSiuN9/09SKaEaMJ39l',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-/uNTArWag0fq+MOMnITxuc/uQTqh5NVc+1x0LO4xG//FFwUa8Xff8zrZXIpETdf9',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-5FWE8IhPJgMtacw/tJgCapT/ag4ftBYmykFO3KUsozTQ9JKaQhH2oX7RZdCDyWxg',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-dCJKkv4KgC8c4IlevkK2DC4yY+rQidnMOt91EmILDbdn8M6cdsjaUbf6awWnsCaZ',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-XrjUu+3vbvZoLzAa5lC50XIslajkadQ9kvvTTq0odZ+LCoNEGqomuCdORdHv6wZ6',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-IIED/eyOkM6ihtOiQsX2zizxFBphgnv1zbe1bKA+njdFzkr6cDNy16jfIKWu4FNH',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-YJugi/aYht+lwnwrJEOZp+tAEQ+DxNy2WByHkJcz+0oxlJu8YMSeEwsvZubB8F/E',
                        ],
                        2 => [
                            'path' => 'css/duotone.css',
                            'value' => 'sha384-oRY9z8lvkaf2a1RyLPsz9ba5IbYiz1X/udoO3kZH3WM+gidZ+eELnojAqaBwvAmB',
                        ],
                        3 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-tSxOKkJ+YPQOZg1RZd01upxL2FeeFVkHtkL0+04oWgcm9jnvH+EQNLxhpaNYblG2',
                        ],
                        4 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-HLeT9I9TL5c2ujLOZhv6z58D+FdF5R//KTyhCOiYBp1ZX9ZEdaVKPxZmzPx/tMWY',
                        ],
                        5 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-BPtrG4jSUTPogkW6mA5hAGjvJapJnnMa8tKHQOR9MnrINanXN/IGDInK/SngoAFb',
                        ],
                        6 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-9mSry5MRUHIfL5zghm8hV6FRKJIMfpofq3NWCyo+Kko5c16y0um8WfF5lB2EGIHJ',
                        ],
                        7 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-9WuNcdGCglpaefA1oUecTWMQL/+LmrCJiJJM+pDHX+82lfkj1CKUYLc6DZJQ+1/s',
                        ],
                        8 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-/WH+7sthk7TduL5PHd16Jew3Hd7eKInsAclAq/MoZWeyR4bMgUj12MSN79PtHEjc',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-Z0e6PSokCQP510gixgZGPs+obVv8eogS/eS2+/7lLSMOfmLnWBgPQppPispQXGUM',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-T90KA1rFqB4OFs7EjJ9EGjXJkOXPhELY4hLaFVnB0LaTNUFGn3QyzNJZh307KVVc',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-8g5Au/J6e7pPZjkCDisd8Jd9psYpdlosRUbac9lOdXAADXrNgc20T1Xc24eIy3I7',
                        ],
                        12 => [
                            'path' => 'js/duotone.js',
                            'value' => 'sha384-dkbWEvgccxMcr38iB9BWNiExUnolXcLY54hGUJkFUqThvx5XsvcEervgRgRWz5fl',
                        ],
                        13 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-bU46hq+Od2wfS4XGCT7Ab5XmYYYY8LURSiGsr4YLIrUWBPeImW/B+OkFEcHhOzuF',
                        ],
                        14 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-ipYj2yPBG2ozjlrUCd6AheWkvEpqcCQNY7yxX8wDoIJc5Lr1zVXAE4sKB3hVfjfT',
                        ],
                        15 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-5CC2/v59nxbyM1595fgM84ERvZXK5WbpCnB9/dd1gTJc2LyitbiKhULkaiXZNj6V',
                        ],
                        16 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-Imz7xdjp2/vTu6azMFMusPHfSLwcYmj5ZWzOXv3esrLD8IDP9AMA28bwpJZwaR1g',
                        ],
                        17 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-ZbnNry/TJ2Ald71QRyefS1elxArPz0oOfiNFxpfSO0Yb5lnnftVJMFbENL3j0hCf',
                        ],
                    ],
                ],
                'version' => '5.13.0',
            ],
            36 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-xxzQGERXS00kBmZW/6qxqJPyxW3UR0BPsL4c8ILaIWXva5kFi7TxkIIaMiKtqV1Q',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-pmyS4Hp0pc0tA0poF+AKYeURgyIgYLt12rD/6gLC98rTImbSYIe75vT2/3jK4zIh',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-O6duc3QftgMWW3awKiGYswymy288kVFZgGWC/4YCl48Y0codWJRgs8DA0N4dX/zx',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-aDoEE1PtWF0YZqVk7el3O+QPApPko7v9/7VYyuzjhHWwJ3cmn0m7xE3/FkHSpPNT',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-wG7JbYjXVhle8f17qIp6KJaO/5PsPzOrT76RgvdRGLHj0yXZZ3jg98yb0GNRv1+M',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-CFCaxC5Lp+1aYrNgJjxz8bNrgnzVPnSxma3pb+m90jym25B+q2vYd3JfLQR00SNn',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-KkCLkpBvvcSnFQn3PbNkSgmwKGj7ln8pQe/6BOAE0i+/fU9QYEx5CtwduPRyTNob',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-heKROmDHlJdBb+n64p+i+wLplNYUZPaZmp2HZ4J6KCqzmd33FJ8QClrOV3IdHZm5',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-Ay9V1h0l5sywM7gJ5YvOc05QytfKqZAElRgqU5kPcIIUAUBqLOYwu9gnW6p5t/FN',
                        ],
                        9 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-xDU4X/EdF/mFSa0TktUKBTHd/td1gTc+xWNLKdYcvrAUZExjiWhDnrLM4lGkqzeH',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-4NJBLvz0eHSgtSVDb+VOLh4cxmVluIBqCaNw97NvJAo18r+qV9pze1g4YnhB/X6Y',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-omrmE/gvA72r1j409JaSn3V6w5f7Mx7GZpjB8xqS4nLwGpT7Zj2obev62Y9QcCZr',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-81RFXCmeESYg4G/uFGo6Tu/eeK3klw0oKItW3nPhi2BuryJcE4lkOkwWsW6jzoNz',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-CtI1i5e/58ZMUgZkT75wgboNZAbEXBNToPY17SfEmfyKvGuJW7DP418LdXkjI++F',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-B9BoFFAuBaCfqw6lxWBZrhg/z4NkwqdBci+E+Sc2XlK/Rz25RYn8Fetb+Aw5irxa',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-e0CAD3LQqbxBCI1WW9pe35Vr+ogbg41axplGx9yY6Woaw6h+zHnB7v4sVuZjHDnK',
                        ],
                        2 => [
                            'path' => 'css/duotone.css',
                            'value' => 'sha384-jZslG/z2CMKpawOGi2BzAUH7QBRu5umkFNeP0Op1SZksaT8WGx5MuZazFfE/XR9h',
                        ],
                        3 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-eKHMjnfl7jrOmk1Fw4dpPDTetBHFOho47C/omrsmBVN2ii45aI8s97OUFVtGg1CR',
                        ],
                        4 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-N45G0WPo8CMcXE4y+hOnuWLp2TJxNbhk/YbM4GQEymB5fPGzOXVH+er/7Z15oBjl',
                        ],
                        5 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-h1Eirl+AlKkBdUtIMW1hm36KarFrx3iEfjcnTYKeeUdZTOsT8hLDc0lnlNG2jPn5',
                        ],
                        6 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-F78AVlY1oEzT5bXRSwVzraqWTcbpglP7ILEEE3rmu1gIfm/TUo5gpdN4YVfvp7Xj',
                        ],
                        7 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-ZFFudtU+0nvUFj6ogUZSspaq7QhLb6JJX6jSIu5UiZAbZMhnBJfNwZahptQ4MQ/i',
                        ],
                        8 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-He820UjOck3Qu+A0dH2+CmHOeYAYN0kqRW3s6hHC/Jzu8IXSeZF2pn+lgVpz4KuJ',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-RFburpZVVirucdjarLLIoBiT+LY5YuPB8XboZYWRuWpElr46csH7Ia2nsHfkfBZF',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-bM9U2rf0yP/4jsztQkRVwJnqtVcLJzwAMaVgd4sfQYxxm0ru+TieQ4ZaxKW4vsyo',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-DuzRvwD99f8XqXEPIxkpB1F+Ik6c2AZMj6gWcEDwFUCAgtVSelRH9Dos4SMxw/+i',
                        ],
                        12 => [
                            'path' => 'js/duotone.js',
                            'value' => 'sha384-uABtWM9HIHso7RIYTkd4w0zB8IgL/hTcPNyYTVA62Qw0lK3umduLb+vIYtXCd6W8',
                        ],
                        13 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-Ta21ZAqXVyXVqLCnHENnO2ULnrJQzNdGFAbMR1nbZOSV7PcTcZVIWZJCCcRYy2Q4',
                        ],
                        14 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-+8Y6x3Roex77ZBdaQqtTN2QKu/TIOdzoswRYxryfW9ELmUxMTYLgzdz5nlA/3ndC',
                        ],
                        15 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-sSHWg/dKYjGSJU6C17C2qGImASfPcJqy2BaW/iTzifkPJmzprIMH1tl4/tIbWq8M',
                        ],
                        16 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-VBOdkc1roPM6EIGTBi2yraUNs04SZ9+TsLzF0vIecIKYf6oXYxAYgjzMpH8UdZYh',
                        ],
                        17 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-iwdWtJevtQK06+Bbqeb7Oo+osfnPQWsHQWR+5SeND0soWVUGjfyRC2XdttrYI2j+',
                        ],
                    ],
                ],
                'version' => '5.13.1',
            ],
            37 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-MiOGyNsVTeSVUjE9q/52dpdZjrr7yQAjVRUs23Bir5NhrTq0YA0rny4u/qe4dxNj',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-PRy/NDAXVTUcXlWA3voA+JO/UMtzWgsYuwMxjuu6DfFPgzJpciUiPwgsvp48fl3p',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-e46AbGhCSICtPh8xpc35ZioOrHg2PGsH1Bpy/vyr9AhEMVhttzxc+2GSMSP+Y60P',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-TN9eFVoW87zV3Q7PfVXNZFuCwsmMwkuOTOUsyESfMS9uwDTf7yrxXH78rsXT3xf0',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-PB7dcmSOBXciTYYzTvxdvcCEy4k3woMwwVAtsIA3LUQyKW21C7UL9EcGtd6IRNLc',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-9aKO2QU3KETrRCCXFbhLK16iRd15nC+OYEmpVb54jY8/CEXz/GVRsnM73wcbYw+m',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-3Nqiqht3ZZEO8FKj7GR1upiI385J92VwWNLj+FqHxtLYxd9l+WYpeqSOrLh0T12c',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-V7gsTxvUZaeC6NAsCa24o3WvPOXwSsUM8/SBgy+fxlzWL3xEGXHsAv2E3UO5zKcZ',
                        ],
                        9 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-uMs7U5rgbKM9mJ/p05oZ+z+8uK1lwLhl96KWxP5odG0wm26IfhzgKQ0ktZnc2PYP',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-DNo9bmYZCHLtp0n0l0XA2UsoRHX1nx38aRP+p9yoP5A8kVTfeWG3aySMOq5FD/v3',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-zHXcIX0meH+eFgqCa9QdLtYfc+0p7KcF4fVB+gMVFjV6rzYv+LxSIuF5i2eGVDlt',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-4RG3cEPIlCBy6VNzxM9ZoEwZW+65ed5JDOfaJAnQqwV6ha/jZDJTXjFmvjFM4bk4',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-g+ezV6Pq6549QkJkkz2wmW/wpazNaliTdSg/HX4bKsQ7S8cfyMOiyAfzfWPtlVR9',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-VhBcF/php0Z/P5ZxlxaEx1GwqTQVIBu4G4giRWxTKOCjTxsPFETUDdVL5B6vYvOt',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-DkuHshSFBB5Ozmaoq36ICABPCsIIbamipzuH7NO0sxDIDrJloLD43yBzNLI3gxS6',
                        ],
                        2 => [
                            'path' => 'css/duotone.css',
                            'value' => 'sha384-QRFqAT1IRNAzMGALiXfanFtQEBoLDPPh1vnrMbxHa+UeJkCTHO3TpYXHQ+GK1pKg',
                        ],
                        3 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-CAxg0L30Vie2vI3AniQ4UA+pSswoJmr/MK5Dl5DP9YlE1nzJn4z5updw5S3i/Nsn',
                        ],
                        4 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-LmKkPHDqucxgmrtLKWrMGZc5nnHQYAdFkSzMtl1OcvTZn4pebmVziSZPtp27MA6u',
                        ],
                        5 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-izRgjQadEFrlAsdFZjlQ4v6Ff2E0R02RwYZwdL8lrt398rQmLNOFYYNk9qQoqjDP',
                        ],
                        6 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-qJugmlTDyF5CNuv00JB+04BCmCVi5C2ZZhsIVMX0wxWr7U3ZuOsmO+nOLtoTxeWG',
                        ],
                        7 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-EjLtrKO3gucE2cOzLw8A5aJpQ9oXEJTxlTkbLrrL4JR7xGLPI8B1fyK3ygNxeLxq',
                        ],
                        8 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-oydBLEZZlqJqf0OWwXyyj91mRqrL25j/VMAvTl0BA0iIMoJGDTSksMDnqkl+TWLA',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-8nFttujfhbCh3CZJ34J+BtLPrg9cGflbku3ZQUTUewA7mqA8TG5Uip4fzQRbERs0',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-9112PiGcvkxlUNBecZ0rk0c6zEGUKlR/enlHdLy0Xu42kfHEbIKsFVBsmEn+6cEt',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-9rbnCwKDHzpLDHYvYRqRWcyLZc3anAu+oe1dRxPOk7RcqBzjAv7CYTvAQJGkUNXS',
                        ],
                        12 => [
                            'path' => 'js/duotone.js',
                            'value' => 'sha384-HFlrQxjzjMUAiYmFuUKrkp90VMEpD/dpb8unLEWH5QXnUs2xHw5zd8aiztrPBLbT',
                        ],
                        13 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-XULY2W1C7bGq9gruRvsk8Zyhq33b1/TgBBKzJ+8dzWkJm0kObgcry2qU+Qf+HOZw',
                        ],
                        14 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-a8Ul+Nmi3glFYXvks3ShdxGHyk09LsZ3+TIjDr2vj9lMx2F29TqTJm7U0EutxFdH',
                        ],
                        15 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-B8V2/SCNt/naDJB0LkeljUBBYYhGFm/rUVnNsFYlutzbeSTTzVEqxRo8SN3tuHSl',
                        ],
                        16 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-CjNAVlgtLE9uQuDgWphA+b5vXjcy5spSSezhnbGWUZl0VDkAxzeU8elFOdDs4qaU',
                        ],
                        17 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-kN/8Lc85No/I30OsF5JSmBzc0W1W0AvgBJGA1eEtVSfaiIeg8oPTJ8CerHqDREVn',
                        ],
                    ],
                ],
                'version' => '5.14.0',
            ],
            38 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-/feuykTegPRR7MxelAQ+2VUMibQwKyO6okSsWiblZAJhUSTF9QAVR0QLk6YwNURa',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-ijEtygNrZDKunAWYDdV3wAZWvTHSrGhdUfImfngIba35nhQ03lSNgfTJAKaGFjk2',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-APzfePYec2VC7jyJSpgbPrqGZ365g49SgeW+7abV1GaUnDwW7dQIYFc+EuAuIx0c',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-yo370P8tRI3EbMVcDU+ziwsS/s62yNv3tgdMqDSsRSILohhnOrDNl142Df8wuHA+',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-wvKQCF3aHjf73vG90/oO/tFarRthMbxfbW1DeHM+eJJYWmiFLJ0DyCzE1aSFHazB',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-WCuYjm/u5NsK4s/NfnJeHuMj6zzN2HFyjhBu/SnZJj7eZ6+ds4zqIM3wYgL59Clf',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-9/D4ECZvKMVEJ9Bhr3ZnUAF+Ahlagp1cyPC7h5yDlZdXs4DQ/vRftzfd+2uFUuqS',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-GUtlu2Qit8cdodM5DbKnbDIWFJA8nWCVEwETZXY2xvKV1TFLtD/AL+bCOsPyh05M',
                        ],
                        9 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-sefi04js7ZytQojQsuOy097ewgefakplyIWjkCI75Wz1IxHB/9NAAinmgLG3uDt/',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-v0OPwyxrMWxEgAVlmUqvjeEr48Eh/SOZ2DRtVYJCx1ZNDfWBfNMWUjwUwBCJgfO4',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-i9Vys31h0tPXNeAe12HKp4zkBi0S3LAH4OGYRSWKSrdnPYTS4pQgCc/HakrenJBh',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-oKbh94nlFq571cjny1jaIBlQwzTJW4KYExGYjslYSoG/J/w68zUI+KHPRveXB6EY',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-IEHK9LKBXJdi7Y/gik7R6VYPuwx8hMiwQuaOh7BQUQ9rKmWr2N04KYFdmt5Xi0qG',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-9ZfPnbegQSumzaE7mks2IYgHoayLtuto3AS6ieArECeaR8nCfliJVuLh/GaQ1gyM',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-YgEKO0tR8hhGPO9Dv3YGK+GstKp44//D72dbOA0oTX+7myWawnkifErid6FIpP9W',
                        ],
                        2 => [
                            'path' => 'css/duotone.css',
                            'value' => 'sha384-bXXzjCj9fg9FACS6tpRWhBsNqQ7j7swH/U3MKTJrZuRbF3ktmj9g/lie7L3CNSTd',
                        ],
                        3 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-RFOcGND+1HYm6OyEAF5WKkoZnwv/cXQpCX6KduKC1vAKAoohkNYWNPhkx4fsH9Fn',
                        ],
                        4 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-yWmEVLm9kM0L2w+XPDQQUv6tARNHEYPPwdDplMiVced5iOVoiUIToRveagZ56DVa',
                        ],
                        5 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-pvlGSUiPzTZa8YsqGs23BENlf3D4ddnLRdl2q5R1ekGw7nnWJZ0AK74DUr0mzLTH',
                        ],
                        6 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-LRz1HmzqffP7wO7piC0QSObi89cOdpFP7qMIx/UZ+qK2TdoDBdl+LidxFVnYu23p',
                        ],
                        7 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-mFHdQxElacASluqApikB6+SUGnAOWouxc19KqW5eZGoZ+b4A/Cj6pMUCGn6g1uZ+',
                        ],
                        8 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-r35xeRHwDKxzFjeApFdZuwo9D/nV4p0BPL4BxIVmsyKQGWWBaxG59Gr/9x7IfVog',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-Vipr9QSlUeD/qnhkau6GBnZnUmVkbaRZ0PgB1KjvWa1UoNBKnuzg1TgbJJn2a12T',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-rdZ4AVYAMfVJRjRJzozK2JY6LOdLxKdUkHuegulAuMdllLH7M9AllgBLuYmBe+zm',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-qgGl/EYa0JYIveAO7M9W/hshMqlMyo0G/QHio/5D5r1ZbZxAoqcTTReeL4gRrL4m',
                        ],
                        12 => [
                            'path' => 'js/duotone.js',
                            'value' => 'sha384-4qqOVq7ZvSMSgZij30G8q1kOs7pBiAWrSVKqWRv32l99D/qqXlMpFQK8wLSfeQEZ',
                        ],
                        13 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-whiLNjPVOuBfSNjL/tLtRWANHP97vxmZ5OoUK496MOTzH07UdmxDLsnSBgvvjLNf',
                        ],
                        14 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-AEYbWLXnCyDCeopMCsF+A4qHLchpzJ4wMnZiE74Bcp6qLWwXIJCWY0ASqAf0qYrf',
                        ],
                        15 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-wM50oZlS/21q6M6tlw0EWan+0yFpuRC/PrPeimdGxjCjfx45F0x3NZggS5uFp5uv',
                        ],
                        16 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-PezVa2U3+0USHwNA7bgvfA+uSS1IPVdTat51a5IgvNGHUJjcvsj+TheZ6X30JybM',
                        ],
                        17 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-MafE1kr6MZ6PhxNeH0/kvg7f5ramk1tE+y/dBi4C6WgxaKU4mNGRxPNxcEZ5maAx',
                        ],
                    ],
                ],
                'version' => '5.15.1',
            ],
            39 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-RTi1U6SIW2G3kUi5NslKQjA34F8CsQCVduJO50jqtxhR2KY++LR7KZS2886EwXrk',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-Hx1dya9ptAdKu2hLNR5C2Cwgm+wCfwD0VMGE6jk5OUxxa9I58YfxOCwEtRog+3wk',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-GMkIgTgosuQEt2PEwBHI7MMRsrQplN2sT/7bzPOIxG+Hn37iTlZXFb37m6uE+iHj',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-6qO6EOFIDfvv6uzAzozX/BvMu/qkIIHxWYOVMjpVjX+NtPuNyd3YiOEflKIIV2ka',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-6iJDq4HKs21oqDV0KkGhh5uve3aJBXwTX0ACa8Fp5Sx7fcZtIumvT+GSzqSEsceV',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-1CjXmylX8++C7CVZORGA9EwcbYDfZV2D4Kl1pTm3hp2I/usHDafIrgBJNuRTDQ4f',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-vuFJ2JiSdUpXLKGK+tDteQZBqNlMwAjhZ3TvPaDfN9QmbPb7Q8qUpbSNapQev3YF',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-CFHIjJ6e4s9fugmZkgMS+xAN9t3pMb8WzxVLSL61rvRx/NfBorLHHVF+7/xxhpll',
                        ],
                        9 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-SY45zU2Pf71PV9B/kvEgK9jzpEbe14MiprEwrg1VcbXdBcjXbNTPwoXfp6A+ntJG',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-PIP1h/CVyNo59Pr+vM6s86Zkm82HEv890eKMTpB5eqJZFZQwZuMwf73Sy5SzVrK8',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-ghS5pTGfZccQRYN4cnBH4kBWGY/ePY4j4VKfFliJmM6ZYomFMIo462PxXa2RGqWR',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-rKdfCFMYG2O/K+5WQDPmcKngEtAvqyIxYkazidXjp48yEiCcl//F6lxZ9cZ8MhM+',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-VxtQ3wW8qt0QTDld0MGEB9IMEOyCOtvOXC7I0JU3T01V6NR+C6MP5HxC+tGNkhdV',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-yJpxAFV0Ip/w63YkZfDWDTU6re/Oc3ZiVqMa97pi8uPt92y0wzeK3UFM2yQRhEom',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-rsNdgxJGzM0RuTegPn4p1eHXocyvt3ZbnTifPXmOewdRLCOqzP22d/M+WxbRiwSN',
                        ],
                        2 => [
                            'path' => 'css/duotone.css',
                            'value' => 'sha384-E4/odus3ylondNThYB3uIGSZpewOhvhh0QD8x2p7S0ot6p/JcbVd//lr7cMEUIBc',
                        ],
                        3 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-RZW433tEsVW3OLEaC2n31z0V1DmyQdjrwNKMRLBjyZQ7r4RU0PxYhkvjKCsZMCO3',
                        ],
                        4 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-oJib4m7hS3ZSiUXjFvObb+ZFf2AGOBOUX+MFk3CuBZwz8LQSe3d3EgZHHJBkJGXT',
                        ],
                        5 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-ffFT2jJN64hGajTqkZsA2KE2SDBO2Gcmb0wr10fRLpKNDWYcl3M3KsLuzQHg5QAh',
                        ],
                        6 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-PfqDBw8PmSrNcYq7F4SvYoZekYP2x84SYAyG41rncZdySTjSS9eWEE7ynvJRElQY',
                        ],
                        7 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-MeQL8xjLhct6yZa8AXEQOD0yWeV925K9YrlcgspMC+IdCbI3q1b8B7VX8NS6N3lS',
                        ],
                        8 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-vfegZgYJmcP2K/VrhAwtTtU1OgvF83Y8zoQ524YvQFIGowI3tr8C6wvpWUsSLUZA',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-ZbBwfM248+qoG5GJvuV2PmK9gvlW3dXpgC/jeIn45pWWroL3v+5K1ZAth+gs165y',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-K53M8ZRlon+Wd3MVzcIEU1NZXEh4h98NnLM8WZ/7E98pbg0J1q17tKGgr45c5qCs',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-whZrbu3lLf9+EK7QxSHsdpAWM0drsjefOTFm3zfcUhZSInAwLaIrdOd2Qd8MKDMW',
                        ],
                        12 => [
                            'path' => 'js/duotone.js',
                            'value' => 'sha384-nTarcZNLMStpbHz1QpoaqVDyKoUrzncdV+zZ040hkinCtVKl8gTXSiyUM4h0K48M',
                        ],
                        13 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-dy2wSTcBbCGnFNjThZw/FfuNbPeoGoOSWgX7HmvH3PKcJ0Se3w3CZnalamfRuLpE',
                        ],
                        14 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-gL1IbgNyLHskDPg9uinrWBfxmDsla3neHzcEAIjbzQTx6W69Jvs9S/fRBXUt6FbW',
                        ],
                        15 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-9JMXUFvwOD5rSQZs74FEC4SsybjccRbbwK7iiQiriFSd4sPr7pB7/ghp1KZH7tCr',
                        ],
                        16 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-oVJ5+ellTPbci7MOrfl59xerw0M0RnQEGG0jx/JlNyOpkvrXHaZUCfKJUs08+gVi',
                        ],
                        17 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-ht5Q/pi1VU6byhn9MctthIZ2kSBqK5GhhR9gnTzPM+BJlAyCymRS3xx74c9twxdh',
                        ],
                    ],
                ],
                'version' => '5.15.2',
            ],
            40 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-V5Z1KgRRJyY878qCx7+zUeTDm0FgjoYrbmSortFqRPGz+Ue6XDe4uIiMqB3tB/wd',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-wESLQ85D6gbsF459vf1CiZ2+rr+CsxRY0RpiF1tLlQpDnAgg6rwdsUF1+Ics2bni',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-Dn9L7vwedvmbdep+J8U5Zbrp+ES46dt8pm8ZMUu9iOR9isC4+Y/KP1h4StrDd/F+',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-LA8Ug4T/nhVkyhrSmSirsoAo9iDrBk8E7U80aSPeD+w3vO8PzOJIS6agGcbIwwX0',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-C4KLoR3asMHYArL0nLQXEaFZIFfRMiV0Ul0DvsMfSMZ+YLJwFu0Rpxix+EZwqxOy',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-C2B+KlPW+WkR0Ld9loR1x3cXp7asA0iGVodhCoJ4hwrWm/d9qKS59BGisq+2Y0/D',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-haqrlim99xjfMxRP6EWtafs0sB1WKcMdynwZleuUSwJR0mDeRYbhtY+KPMr+JL6f',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-oEE/PrsvhwsuT1MjC4sgnz39CQ84HoPt8jwH0RLyJDdDOKulN+UEbm9IgJW0aTu5',
                        ],
                        9 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-OwOgf6Oss8Oh+cy6VnIGLlcyMhaaOPN+3gyLv2UyvjybuPrTNNgJljGYEAqSglUM',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-hD97VKS04Rv8VYShf782apVZOVP6bVH/ubzrWXIIbKOwnD6gsDIcB29K03FL1A9J',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-bPKzNk+f6IzEi89cU+jf3bwWzJQqo+U1/QYUijuD7XD9WO3MSrrAVVEglIOCo6VD',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-9xA4r2/2cctd+IZZKLvI1hmeHZ5Yp8xXkS6J8inDtdyZCqhEHVcTGmSUCbNED5Ae',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-oJX16kNznlRQV8hvYpOXlQKGc8xQj+HgmxViFoFiQgx0jZ4QKELTQecpcx905Pkg',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-iKbFRxucmOHIcpWdX9NTZ5WETOPm0Goy0WmfyNcl52qSYtc2Buk0NCe6jU1sWWNB',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-GTxp/8UKFkexlguDtPsFi90d++F9f26nZCM99OSQo69514FK7Of5mgM9Efhs5O9L',
                        ],
                        2 => [
                            'path' => 'css/duotone.css',
                            'value' => 'sha384-nuPd13VLdsw5iBtqelv9tQ6l6+CteSUrmoT5enzHVJodx7WdNUYXNwgVpA7bgsXn',
                        ],
                        3 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-DHjwMcq12OEB4DQ+qulZDDroaXZqm7h9V6AjiP/RuUF8NhxUa8x6UWdv1AeZS+90',
                        ],
                        4 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-IvEgf1JJYgCtB5fP9nmT3uC7DY96POpmhUjo/98B8FMju1w295nj5yGBfwgD3MYj',
                        ],
                        5 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-Z3GHSXKByZgv1Ri9CiFq0jYUQ982JHZOOg4awUHcuVBjTxwNd+PVQO1/PSwChyzK',
                        ],
                        6 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-Ymp/JSUSR6EuZ4KjxcliW8lJ7wkYBR6oasX7EMi6SG0QBPmNUDAEG9rd7Ogy0Ca/',
                        ],
                        7 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-n/+zO4Fk1/R4EL7q+xf44zBEgvFziVgA7BUNwfjcGjHq/X6U0v25ESHqN/l5Wprm',
                        ],
                        8 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-yV4xIIsecn1iqxJy3IC5YyRSLwtkkFuOvfPvj1hGH5NLLej9Cum4hPOUL2uQYfQ6',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-OF9QwbqmlzSPpIxe2GYS8lkGFyaFfrgUPD2J3qj8zGVps17Y/x8EK2U8PEl6UrpH',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-5u0zCiPDAEBQPvGxnai1VRZiSs9yQmyspSLrg0Fc7ru5CeddU1cef/24itMCpcWb',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-W0jz7GGBNDbeSyOhqqJrtOVDFLX4Qlqm/5K4RqM9ZpPIZL6tmDCMkEIheypFOiSK',
                        ],
                        12 => [
                            'path' => 'js/duotone.js',
                            'value' => 'sha384-rutYU6OuFfIS5MmBE4wrpMhP633bNlRHqn/SFpcetMTKr+rsBxnoTd80mkHI7wum',
                        ],
                        13 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-hwdDrjZFQbBwoFcHZZ/6e61XHiwY9csS0Wxi8i5jUgTurxmYITntaGLFYCssX7By',
                        ],
                        14 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-soVEahH07bOeX1Nlhdi4VQ+yvDpIGN9A/qbzm/PgfDrpvh7AaCTyMkQNk1spjHbf',
                        ],
                        15 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-GR++czVV+1briVrgT0SHxwKuKqqXqfkRb2NxZ8O4rad/c/iKIn85PDSaZQ3cjiAZ',
                        ],
                        16 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-JwTquvZ50ZD4wvDw99MHsjx621x02jCoiXBKy103wTwDMBbDLmhRcCV4v9mq5CV4',
                        ],
                        17 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-xczhE4W0SRyRFalFfxUKqclGdqLDVnc/F118WebJIQ/QyS3XKXIHXTieQKG1rG/+',
                        ],
                    ],
                ],
                'version' => '5.15.3',
            ],
            41 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-S5yUroXKhsCryF2hYGm7i8RQ/ThL96qmmWD+lF5AZTdOdsxChQktVW+cKP/s4eav',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-e7wK18mMVsIpE/BDLrCQ99c7gROAxr9czDzslePcAHgCLGCRidxq1mrNCLVF2oaj',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-Tv5i09RULyHKMwX0E8wJUqSOaXlyu3SQxORObAI08iUwIalMmN5L6AvlPX2LMoSE',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-meSUsKN46Q06zfndZ6zDskLd5vJrCPwgb2izpfSMfWpQLijQApceQWIsbpLy2lAF',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-Vq76wejb3QJM4nDatBa5rUOve+9gkegsjCebvV/9fvXlGWo4HCMR4cJZjjcF6Viv',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-xf4z6gHzXeY6YwFJm8AKcD9SSq8TsfF4+UJj1JxzwQHk+VNATxkknGEzmdtYV0w1',
                        ],
                        9 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-b4+d5l6vwWgdPDCbk4SG+VPRplFp3JtWehGqKvfat/MWON5/PSWvf0l89dpfUDUG',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-dPBGbj4Uoy1OOpM4+aRGfAOc0W37JkROT+3uynUgTHZCHZNMHfGXsmmvYTffZjYO',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-EEuk6Tk/hsJ0IJMUp+btTmHLuWPGGIm8I3xmxRawuWaY1xqWEm3EKVdnHNlYX+6t',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-/BxOvRagtVDn9dJ+JGCtcofNXgQO/CCCVKdMfL115s3gOgQxWaX/tSq5V8dRgsbc',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-bx00wqJq+zY9QLCMa/zViZPu1f0GJ3VXwF4GSw3GbfjwO28QCFr4qadCrNmJQ/9N',
                        ],
                    ],
                    'pro' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-rqn26AG5Pj86AF4SO72RK5fyefcQ/x32DNQfChxWvbXIyXFePlEktwD18fEz+kQU',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-Q9/9nfR6hUHbM3NjqxA59j5l/9c23JjwDDuPsV5SKplBvgLpFDtJmukyC2oCwp28',
                        ],
                        2 => [
                            'path' => 'css/duotone.css',
                            'value' => 'sha384-Zi3Yce9z7/mhFiZHlM/DEBTnheymZyqrjMoWYPP8xtNCl+LtJKnaJ0vaGnPfqc/i',
                        ],
                        3 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-ig3RKyui4sECvuz+WE8EmFYy7sjRvEvy82mmhfV7ljRieb+0f8eEZKxHv2KC0+io',
                        ],
                        4 => [
                            'path' => 'css/light.css',
                            'value' => 'sha384-zCLzLBaV9kpBZtwZ72K00PI4UjqXZhrzMeVtYGOOHqL2N5PXSVw2MtJjaWTKYDHW',
                        ],
                        5 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-sDvgA98ePLM7diZOYxIrDEITlUxoFxdt0CPuqjdLr/w62pPuOc73uFoigWEnVpDa',
                        ],
                        6 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-2aj01VFITmYatwqdIKc7PHVmhLqFnnkVCilBk0Uj/fGoczNJXKvV45XlyHr/HU9g',
                        ],
                        7 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-cHJCnE8H1fC+puOpWCd6OSOmJ1q8KxWtIm/JUpb9705KggGjyKbMzryJWJDw2OPb',
                        ],
                        8 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-sKQhO4q55X7e4nIIO+wnutVfpIITv8+QJG6hE15hThUjV3ssIxUGT4VAoAGYmOU5',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-8nTbev/iV1sg3ESYOAkRPRDMDa5s0sknqroAe9z4DiM+WDr1i/VKi5xLWsn87Car',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-MwpSaMFXAxVGLfxKR0S/SL1BvfRLmlowKeqIE/yF7uW5ax+r1fqRs12asOCkF9Jf',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-my7QwPFkgZPqsrDx/vNCyAMQw86Ee5ZUeCUBA7CF0l9rWFcxoH+h+NdSGyYBh2pq',
                        ],
                        12 => [
                            'path' => 'js/duotone.js',
                            'value' => 'sha384-AFpIAPhppteteZyLTXU8oPEbmuNz5WwwWSVAKJxuEn51LibO/iPZ+fC5DzmLJzoo',
                        ],
                        13 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-RTs6cAeLGZoCPlBxXNxYfQnVIrvTagXGxIhrXFjWgp4i4E5urdGFLlkfbsk1Nd+L',
                        ],
                        14 => [
                            'path' => 'js/light.js',
                            'value' => 'sha384-6EhWHErkaXt19GTK7f+5rRc16ekdzvItcFycGZi1GS/AycADXj7L2tkZ9z2O71ot',
                        ],
                        15 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-WWzdx7E114gkDQnLVS/7s5WUTa5KQUqY5D8LGqBB7y132sxhUbrIHfqde9aenKnJ',
                        ],
                        16 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-DfpPYefTs8qX3aeMuUJxalewnmVXDDtxcIJFo+Bz1qrNTaoEwMIaZkfoWx404GvG',
                        ],
                        17 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-9lueRrgA8PnJBSmeS0/jHPFpZZ/hC/7n/XNQhCroAsZSoTtaEj6Q+ewHcpgFPqFw',
                        ],
                    ],
                ],
                'version' => '5.15.4',
            ],
            42 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-QTEmscQJYWW3qGP+JMq44fmHSM1SbRIn3hxdZ0RBhX7yzbDOmdhCzVDY/nCs7Yfh',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-YxspAfDWGMmVGaoWFDjr/ceg8QdLKNj76+YDQ3iXiX1d64PMg/rVRUQMIcd7loDR',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-Y63uHbYQVeMm+hkTj/YJpPSWvwA7maoOgWIcH/L/Zil8zxKQNclQIgNioLyE+zQT',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-3+YTU1oGJl/DJPoU+JvGaD8K0waHM6gIPSWeabncnJ1y/LzxnMdPNvXxvbJtzkH4',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-SVoL9P0p4yDjJ7K7qukXf8FBr4TcwUEZpvnQv80juxlb+QtrhT0zH3Gidw6aACkN',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-bhQY/O7CPf/LJ1fFQ19Hb4zwFDg7vUCZT9GLZM4RVTzxhZCINjHGSM7VaB36hnHe',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-4q5P4wLQvP0vMZgsfSOPe2qSqfL+Y76J/5hi9QW1QqtZ0qdgSrcFRIv5MgSNtFX4',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-s6zGSTvDy4KZ4ncPlsj+2l4ATGBt+gXsKFfd4lR4QKFl2RgB4iOoqZzDkRqndbvR',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-gksSOJLGNOMoFqSuS5Ki/PIhYoVzeS8bWP7Gg6b/6gY3FXNGW3ZwRY12rkFGpvz9',
                        ],
                        9 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-JsmVGsnClQ/8mX7vDm+8UJ9XHlqIuwxPIKrIkpXt4mJZiaeCzg/uXxY3OjB7MajC',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-PkZHTzZps6BUB70Jc6Ujwh17lPpgjVJlG98uCR+Dg+bsDNAHk7UbcsVq9pUY0QM5',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-i/4zUQF6PMLPil02YpE9smRx7XTQ0/bwaSlMl4QZRk0yFj0PCJqkv231+5hjbcsq',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-ufQzc6WFPbylIrm5F6yJOtKS4KCrT6hoEuGPNEMv+9Y2ZVmEC0Jt5Tqf25Q2hOa8',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-3dTEd1SkEJhxEBZpeAOJF+PzflHEdVc87NLQ1dQd1UFpZNiygckU0Ku29kJavA2Q',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '6.0.0-beta1',
            ],
            43 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-H8oq+jCbb0QVbhroj1DucOj59MYLAHR4vQPc0ClgJJzMS/YL7OcRJfM/ehkfKqhU',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-9RVmH5wLHK5upannGNFElXHKDeCRaoz+RuosjPpGqwUmn2+p5J5IBUd0P726kTk3',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-m+NmQ9JGB4PGDECPUaU3EyjsUk6jyyMoM53D/n//nHSADtoSKusJc/BF/ZffIvI0',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-mwb6xqj3Cg9cBoRZDNp2p4Sv49gYTCgHVLVwbErL3sJCA+RJ3Xhwq19ezzyT1KqX',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-sBOgtFigRpSU/zNyZLGNKX6O+VrUJzHdITsX3+nGRutcAaSdRMmnc8LOJk8XzoDM',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-/ShrxWgDzY0RmtJK6gusdzSMS1yYysWIr6y1FFEG9B7naj2HqXMNxatmNRgmRDCx',
                        ],
                        6 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-wA6dLShvXgKngeGUYrFpv9/zgLLUtPxBL9y1OD9u5uQmeT3wWxvZVue3BO4xo4f0',
                        ],
                        7 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-vwquPQ7YyWL/EWINiNcgCpPP9Wbx44bLyI1NbrUJmEacQGGGWUzpERymaTAjvS9H',
                        ],
                        8 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-X5eSej258z73rxsuRybt1adaWo6MobuyduuEYgYhbJMavb1jXYBhCqd1ZwRC9/7W',
                        ],
                        9 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-MOke50TwkELSa34Yzu6DEGxTlT3Wdn5DynHvqLANi/pFPBZxRDnFhJnD6mE/GuoP',
                        ],
                        10 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-vo5XH3GmQrg9pkTZYURBhzEXm7Xslw9fD0z49HVMvdquMGvwTiUKJP4he5iFSPot',
                        ],
                        11 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-UDm7R3v5rW8y32ssB0WDalZIS8AztwsdQERaPBHTRLStI7Bfr/fhWLuXr5nYZG8M',
                        ],
                        12 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-f199SbfL8tgeze5wETQ87SF+anBX6Dmf9bWZSBvW02HFz602Fqhv1u1iCnKgdbls',
                        ],
                        13 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-Teg5BVlogMJp4To5SNk5eS6Ct/+y3KN9D/UWWXr4e2JhUbT1rgnLDWGXp/TG/0a/',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '6.0.0-beta2',
            ],
            44 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-5e2ESR8Ycmos6g3gAKr1Jvwye8sW4U1u/cAKulfVJnkakCcMqhOudbtPnvJ+nbv7',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-Lzg1sLP4sLS8KyVySlmRH4QzbOnIzlp/h2MYRTDkxMPKwaD+zxathmN655nRjRSG',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-RAtjHVFRUZs4Tif4stxk4r1UN31mhO2m2ii67jtwlyWDXls6IDZ6/N2bHxt3bA48',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-TvfVCWnd24+5zZ+qmyScSguhYpT7YtOajZ0b4IVLn3+T3dFYzXkgu/EE/Nrf2km5',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-4veAyGk1Tas2qyx7CD/29iLDa8aarX6vdaWWVPD7K/m8FdvH9ae9yFNbWOxmP1hZ',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-MLxC4sgXwbw5k1vFBDb68XNAF7UdJ7e1ibhu+ySJnAakTpweYCcq7jCcQpd5nJjU',
                        ],
                        6 => [
                            'path' => 'css/v4-font-face.css',
                            'value' => 'sha384-LJQ43yQLnfgXK8pn645vHWEmSJrVqisZaieRPj7NGV7cCzlL/B67BDv8gMRBS53i',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-zCIuCI9fw3QOcUPL5/7JfB3Qw6sjEimma+57eLWmHPHyVgqGmX5XLwGi3Ak5fLzQ',
                        ],
                        8 => [
                            'path' => 'css/v5-font-face.css',
                            'value' => 'sha384-W7b35mq2oJvzl9StEqMDWhapHEgwLh3/iohOpz2RopU0+3/eOmb8eubYCz0OwUcj',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-6e7nA5mhBVXnMIAtGPETl10C7oipDhu2IN/lyxyjAJG+KzNtRLqrqFJN5wJ+6/qU',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-zY1eKUaz/NWcOf6xnU5eePxV3anVtTTAlu33RytBcT9jGz8dstwzZbVpp2l609NT',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-rN+BHnX2WMsUD7VYL6PykWIyqG6SyEu6IdhgM42fLyWqC7JlY2k76ufmZvMFU43a',
                        ],
                        12 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-W1qlouWJA+8MQIORaSCnwNHhaPuAMwQGosDEwU/g4kkawDb4WwLy3ZWVpa/KtRXb',
                        ],
                        13 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-Axuj5+DJ+mQA38QqwpWCujH6bCefx3brdTdN+ffhy6oxdqSvs1evxn4iX828SSe6',
                        ],
                        14 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-9d1SM0Z1PczSHlc0bwe5j/n1kjp14H06SgMcxbmNkp6ZSQa6CqneEHKQkfVGPcR7',
                        ],
                        15 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-ZkRpffzN60bZU7hfI/zFR3Nv603593UFKpz6QAm3FUAUqGa60uzGmuEGLB5BZNsY',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '6.0.0-beta3',
            ],
            45 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-3B6NwesSXE7YJlcLI9RpRqGf2p/EgVH8BgoKTaUrmKNDkHPStTQ3EyoYjCGXaOTS',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-Adcde+txsvO9VVaHmK9GsiU0ps9W6rwF+IlMCjHpCeU5j18z8lenKNx6AV7OuQKy',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-caIQK8zI/KcZVq2HWogTcGbcxd9c0Alp2SDcy0eOHIjipClzJQ8HEkSNcoXtKq+w',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-CAcRRHVEmhGr2UjS0hlffWvnfewfvVqvDJP03d3f3NctPBCvDfPMY6L8r4to10MT',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-zW4IamLJkgRrzYFdEixnM4hbhScK8Q/B0aYHqhGxQf6jrj1pxNaEzS7n65YVdFsW',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-+FYTcfgXTek/jHYrY62q/wv2/QxcumMqXHB/9ZHrAwFBiACe0XD+xXBvrlpG93Qd',
                        ],
                        6 => [
                            'path' => 'css/v4-font-face.css',
                            'value' => 'sha384-K7jXM/Fd0TzcNoMz1bK2/PRaJLYkgynKTlUyKXatOFEovvEO1Zownee30wS0rxq4',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-Mo3tUbn02WJ1eXNOTbemz64sjSQx9PEUk4o3BJbDNrfhSAfbPobKWeqYpV3xkTBC',
                        ],
                        8 => [
                            'path' => 'css/v5-font-face.css',
                            'value' => 'sha384-iYWocEeLglluGxouLD/E0jzilCIbE6LTAKof7ZPB7/YSAogAA6bLTJyo2T98POzn',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-l+HksIGR+lyuyBo1+1zCBSRt6v4yklWu7RbG0Cv+jDLDD9WFcEIwZLHioVB4Wkau',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-ZCobqGyWQ2Qg///QRAi+jqRlO/9aWmMHd6tb0emtG9QBX9t77I71IHg19T90mlfk',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-5v1FR2qOT+wEONoibSzBiWIvpXEOyyRuvOtNOfwijR3h4K7tg12vL4TNx4iSsQWX',
                        ],
                        12 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-pULjvYk4ZbCHxvgkOUhY3s6wbSkRp/9WHqh+NdM+FkmDQsdJeg2XyOHSEQ0AZlr4',
                        ],
                        13 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-7XHlSs/t85udVElMnHlVDct1GXjA01UIyQLQRbYc3bxChziaGT776dBUgqd/o82r',
                        ],
                        14 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-IWq2srnodX6Z+US+NFdwALHXDvdogKkBx7sUMzfypASSeqsNzF+gAS48WnkPcYbf',
                        ],
                        15 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-ybkuz/OxDnyDU81HhdheMi5FjVHdKkPPnnfX2H5pClfR9x+aAMkenwEbVe0AdPt9',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '6.0.0',
            ],
            46 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-eLT4eRYPHTmTsFGFAzjcCWX+wHfUInVWNm9YnwpiatljsZOwXtwV2Hh6sHM6zZD9',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-E8UvjEv9HnIyjcD0D2Nfr/M7y5wA7GK+DoLhh5Sbfd0MtCSpdREBn8Wc/SdeaBDA',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-RLM8Rxp/DcBfCfSI3bGwwoMMxxy34D2e58WAqXmmdnh0WYlAQ8jeOB3A1ed5KUSm',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-luZMTbX5lx1yPkwYfjdCtbXx2AL3j1H+ffZ1LJSuxepC2TKyGzv3zkgftThS/BDN',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-ltWlpN+Dl8XfKEnC9oW+dDRF8Z7jsYkxQ/WMRoJ2VHH5G2nQZ4if2NWwmV0ybzZ7',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-gLJsqV+iGZdsakTXDecPQLbmHTTUB6vIJ2ukjLJTPa+YXsdHu5alOSYZZTagrVSG',
                        ],
                        6 => [
                            'path' => 'css/v4-font-face.css',
                            'value' => 'sha384-WTcUA4jr+YtMif40YOsaoMazuo9cigaWqC7Vrj6PjPzPt/VegPK08OEyRvvIauzD',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-k1PPow2i4/GbflsJCusORB91wBmXUDdw6pOkXu2vQWXIsmLbIL0t/aA7FroyJf1r',
                        ],
                        8 => [
                            'path' => 'css/v5-font-face.css',
                            'value' => 'sha384-SXOfPW9HC6/r4BP4QoUVZNVol9D+ncClNpAseJsRONb9L1F7QgV6ltEXcLnYJv9H',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-vLLEq/Un/eZFmXAu4Xxf8F00RSSMzPcI7iDiT6hpB4zFpezCEGhb5daeR8PLyrLI',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-cNUzI2P088AN66Vx9jSolJDKuj/ZWgTtbwYleQo9MedrXul9DrmthXUDN2iFVk9u',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-te3/sj8uC87v52yVrB6zr3Fm5m0AyGLAHYUIx853+yLbLffUUfXrdztSp/yFACrc',
                        ],
                        12 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-n82ItqkVbr/bDMKi4caJ2ZLCgihjr3y0aF69FTVAfwQmyFRVucR9QvBKz7DliBNY',
                        ],
                        13 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-/wcH7fFePVuXUD0zgIUKgQwvWV21321nbGpvX01SjmZ01yE/n68/Wp8rBxpsKI/+',
                        ],
                        14 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-A4ZBrBkKFVj3yXr0kIOFHs3vCQDJSHAU9OiRxm9X42e+amWJl68HpDCbONxiMp12',
                        ],
                        15 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-WqC1w5exlfB7/5UiHTZp/YAnoS9Ovlzh55EwGjzaMxZZtL1omDGlh7KehDlpgKUr',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '6.1.0',
            ],
            47 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-/frq1SRXYH/bSyou/HUp/hib7RVN1TawQYja658FEOodR/FQBKVqT9Ol+Oz3Olq5',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-GjGxypaJovIS9KvmJ0F1G5aXPEfMvk9dMgnwAAw7UOfX7zTQZMapUiXX/+8HlctD',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-zIaWifL2YFF1qaDiAo0JFgsmasocJ/rqu7LKYH8CoBEXqGbb9eO+Xi3s6fQhgFWM',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-i84Ve3MkmiZYhWmYDjLPpHYYvg36qy5F11ipncNWsQMTrwZ8nGSSX3Q2QnmwEGdR',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-DhmF1FmzR9+RBLmbsAts3Sp+i6cZMWQwNTRsew7pO/e4gvzqmzcpAzhDIwllPonQ',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-ET/prSuhSJFD66MbC3j2l1MrZtW8jdamNc+wmMcmh804U+5Isyo29kVkPjr+4+9P',
                        ],
                        6 => [
                            'path' => 'css/v4-font-face.css',
                            'value' => 'sha384-DPkhMKJRq9+6LzxVlr0poYa5+EQVr/onntse7iwk6coJonLqzoCBzSKF6ccKoXRm',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-4Jczmr1SlicmtiAiHGxwWtSzLJAS97HzJsKGqfC0JtZktLrPXIux1u6GJNVRRqiN',
                        ],
                        8 => [
                            'path' => 'css/v5-font-face.css',
                            'value' => 'sha384-QmV/KObe6h/Mb8GC5urJmE9hmFaZDtdnqpCUz9P9nDHFgMeDXyI6IARqnuDRkYu1',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-xBXmu0dk1bEoiwd71wOonQLyH+VpgR1XcDH3rtxrLww5ajNTuMvBdL5SOiFZnNdp',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-jUDsa+5FKZnKIWUpGkvYZHGEx5UxPEu6XJtEMH9ZGXZZkUNVWX1vs+a51vHKs3EY',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-SgqpzfPaFrGdMcCtSUb4dAD1aDr5a93AfPBL+tk14acF93aGDvasqDcPFbHe24pS',
                        ],
                        12 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-9zErGp+biBilRrlpD1l3ExnaqXc8QLITlNpGtb4OL6W1JChl0wwmDNs4U/0UA8L8',
                        ],
                        13 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-5ZhDHsI9yoa8E6DaGJCLj2Lgi8w4KE42IQi4jvmqYVCaza4Iqi8/hSniWspK7fUs',
                        ],
                        14 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-KPytPVc+hwHwX9HXl4tA7SWJ0Sob6StzjVRoxC4Q4U0JgXujpuVrkBxR0Hsf8A25',
                        ],
                        15 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-lUDzd+x9AFWWpLYlM0ZCD+x586cN20gzVDrjHh8HUz22j1QwqTKQGkmd64bfBeZi',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '6.1.1',
            ],
            48 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-fZCoUih8XsaUZnNDOiLqnby1tMJ0sE7oBbNk2Xxf5x8Z4SvNQ9j83vFMa/erbVrV',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-bSSRmv/7zc8N//nlEscKMJrVdXnmDX0i3KY5/Z25DbCimvRgRrefGMGQORqrdfD+',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-X8QTME3FCg1DLb58++lPvsjbQoCT9bp3MsUU3grbIny/3ZwUJkRNO8NPW6zqzuW9',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-VkONnoon0mCxG87ODS8tYdngkEsiD8Sd23d3b4KRiZfPqB9YD9hlTNWSc1pkWUct',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-0BumEd2qDQ2SCps2Pnnhegpr+si0PveDhbdhKgLYwY9x611h8s22Zh8td+W7jeys',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-GCDsQfUYx2ESsVn+lTf9CyU+PGOUBXnknizovQ4IJxE5loN0RHLpN+vRHxwybMFN',
                        ],
                        6 => [
                            'path' => 'css/v4-font-face.css',
                            'value' => 'sha384-E84k0fsWgsf0UqlJxsjgvjalIakzDn/aoXROK5S9mgTazm9ZOb/8zZ0qyqkdKDD7',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-iW7MVRJO9Fj06GFbRcMqdZBcVQhjBWlVXUjtY7XCppA+DZUoHBQ7B8VB+EjXUkPV',
                        ],
                        8 => [
                            'path' => 'css/v5-font-face.css',
                            'value' => 'sha384-C2uLsOCgtzzsIRkD2hyqhqJnsO6tKm8ec1erAE0iUqF9rveCxghE19k8tc41ksjq',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-11X1bEJVFeFtn94r1jlvSC7tlJkV2VJctorjswdLzqOJ6ZvYBSZQkaQVXG0R4Flt',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-U5yq7AQDGZ6J9YLnrFCX7Qb4jl4/ARIio5SQIZcB5bLjDxI9j3Z3rg1jows2sbu3',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-vGTTZfVQhZ4yWSot55BXgm/SDH+MsKEeG2GFPNoKnoFJmosfJzkaPyMucBkV94KT',
                        ],
                        12 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-hAYe7Q//ZOaw3fT5VW5hCn+guWuzOj8+KjXlS95ZxcRnVX+SxyugquCJURnqC7UK',
                        ],
                        13 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-60G9FrRhST1TC039tICDDsfkkIa1Smg8kwF6wa9wYEpDqGrd5kQtp9JCsfWW7GCA',
                        ],
                        14 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-tc7MH1B8eIPGWXxQScItgwJcDhnfKKXr7R39oJJCo9oQ5QssIq6fJM9HvdSHlmUE',
                        ],
                        15 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-JwJ3z2CNw6j4LN4k+tA6GEN2OQSUzcSBpWIsEqlngCZqnfxDsQUe5SURjhpXLhvY',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '6.1.2',
            ],
            49 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-SOnAn/m2fVJCwnbEYgD4xzrPtvsXdElhOVvR8ND1YjB5nhGNwwf7nBQlhfAwHAZC',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-aPlaxY3ZTSh7uDmsF2W7hsMfri06sIyTmCDnY7ERd0fdq3Sf5bUKYZMvomNxUaXn',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-z4tVnCr80ZcL0iufVdGQSUzNvJsKjEtqYZjiQrrYKlpGow+btDHDfQWkFjoaz/Zr',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-wn3adrQUGPbU211xcXhUrH0E0l+tYlkc3uXQ8WiBvnHj6ZU9E1vKwzjRaCKUenlU',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-0mfI7+kSnb5u0q8irmrfJVv1jYIBfeR+8BsSsgUDjP4HCYuQ+kLshHc4xpHeBqrp',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-lvs3gozt+olLidIy5GkpdCk5cvS3LPkq49a9KDlN1Xh1bkPTNGeTL6SJCX6gqyYx',
                        ],
                        6 => [
                            'path' => 'css/v4-font-face.css',
                            'value' => 'sha384-RSx4BCEB9OLjPKMTvFSenXMC8VTsramvoyHB5iSB1VvRvjZ+nendH6WKbigGUl31',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-MAgG0MNwzSXBbmOw4KK9yjMrRaUNSCk3WoZPkzVC1rmhXzerY4gqk/BLNYtdOFCO',
                        ],
                        8 => [
                            'path' => 'css/v5-font-face.css',
                            'value' => 'sha384-RS0a4x4GGXTod9x2HdKnveb/E8M6PuU4d/ZQVzhS+333QRA/Ozo84SeOKdLTZ2yN',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-W5zCdxUh9KjkijDohSc4bFCIfbZKNYcz/hdWjfRL1whrEJO6YBXMaZcAZU5YWJNW',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-09m3HDo5mYd2JdkpussYgOLApaYuUblFkHtmeNGHcQv5bXjDeCFdH2iVYjUT8dQ/',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-lbmBDViH+2PwoLg/9cPkkkTMdiyjpcY/jpRNab/Tt0ZmaSdv+85nXkEXaCe/kFp0',
                        ],
                        12 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-KZ1LJTCtJ2KL1x2pH7hR3CElXzG3s0P624sTHaiTFoSKBMBlwu0mrvkjm8jKox6f',
                        ],
                        13 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-9P5qtFxImyObPMiImjKy+Kc+r+0+br3QTmRpQSswRkuWxTlb1Jsn7wG/i1i5xJjp',
                        ],
                        14 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-H6YBpm4VRWLTfp0nRZIrLoT2zc1rWaEEYxYC+HyWXxSKY+AUn5evalgkgT0EpMDN',
                        ],
                        15 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-FirTqNsw+MidIWcJQan+CwXPSApCil9UBGO7gSOrDvmnzlApH42azPyb5gSH12vT',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '6.2.0',
            ],
            50 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-twcuYPV86B3vvpwNhWJuaLdUSLF9+ttgM2A6M870UYXrOsxKfER2MKox5cirApyA',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-zzq6oTpui+lGFqUViC9Wq0M0ruPnfZLT+vZoMnTIf7z5TIhLggF72ZKZD0dGWakx',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-ec0IxhWgl7nOQwUxu15+OAt2ylNSDoZllO5JM+Wlfp5iRzHOV7834BmFjztiNi1a',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-XA4GNh8NX8EYkM7X7NCXQzS7tTEzSelPJ2gF6s+KKgR7Fcep3WAa9iKAxyYEQBqh',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-Hb+xoMIh5T/8ALSNePRt0QBxUzia2Csd7In9RrXrwe3btQGQk9QHDQtpl5W/3oNR',
                        ],
                        6 => [
                            'path' => 'css/v4-font-face.css',
                            'value' => 'sha384-O4Uaae/V6mzTlKODhK4IpUZZiXIuaH//HQIvOJgzp+YRf+0ms93I87n4WtBYLudx',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-RreHPODFsMyzCpG+dKnwxOSjmjkuPWWdYP8sLpBRoSd8qPNJwaxKGUdxhQOKwUc7',
                        ],
                        8 => [
                            'path' => 'css/v5-font-face.css',
                            'value' => 'sha384-MReR7mQQUkCxHgYCao8fyFmmRcib7wPhbYWSNMZeFKTaoe0r0NePq6eeDHHfDHoR',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-sCgwm7cN2+PN5J6MEF+tnqkCY4Wc5WRcGU+I9b04LSQaPRMO09dnbrVilAWAbH1z',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-paSlHD0OmJVQU3bqeDxqGDmSDHe9M4KOKTS5fMPqUnLBatCB5mFvvUWCyFmuaWU/',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-+VJZyx6TPe/0fC+AtQuiPhcJ3vxer0IsFetCmdTQKAlBkj0JQPtHG5wlHTjTMR2P',
                        ],
                        12 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-zqHeJ5LxaaUrtMetMhaqvaChYEnpeC2GD7jY9JtkUU7ALLAiMHF8VEs/9hI45Rlk',
                        ],
                        13 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-V8GcQvIrFZ6r5GLjZ1HYSOuM0xejDxJM7Q88AzR4e3ErN2SHiVEIRJ9fMxu8hLD9',
                        ],
                        14 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-hnLkLr3nX34CKy5QEs25fE1nSgfHyy9WeOa2te+FT3Q9L5m4L5aNizHqOEdFPX7s',
                        ],
                        15 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-r4s+tpoonjJ7uL821D+ZropRuilrahBs/t7I5GxACKAAVGLOlq+1O+yQklgFyawo',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '6.2.1',
            ],
            51 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-nYX0jQk7JxCp1jdj3j2QdJbEJaTvTlhexnpMjwIkYQLdk9ZE3/g8CBw87XP2N0pR',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-nAID/7ZbfvEYU+xSZ0WSonEMJwE3L/H601tipVgerMsWXyzaigVLkTK01HvpcFXt',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-IfdMaxM7xApqzQmi9UKLIQPSX+440ganmZq+rMGyqDukniVtKl003KdPruUrtXtK',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-ix51dCg7sGikKC5kWHfI3mtSd1gIH4xMi7/QU+Af5fqLFjJf8hpbeb3TYZ6cIUV+',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-PxcNnk8LvpDOF9+oRKY/0jnWn7dad+8aYUBNBvUlkcVedXQVe08FomQti4AD5v8V',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-/siyQcTjrZDFe29mEtEHK7Eb4EhdKEvYw+vgxleGBDIrHDHZbq3CnTLFfBubXXI4',
                        ],
                        6 => [
                            'path' => 'css/v4-font-face.css',
                            'value' => 'sha384-NKf3ykwJFzOuD3j328idnfCz39TdN8EmH8pKT9lKR8HGEwrr7e8EetwwJ4easRJd',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-SQz6YOYE9rzJdPMcxCxNEmEuaYeT0ayZY/ZxArYWtTnvBwcfHI6rCwtgsOonZ+08',
                        ],
                        8 => [
                            'path' => 'css/v5-font-face.css',
                            'value' => 'sha384-a4b/G2DeLnJR7cWqyrY2Sp1zq2yloVgemqVyajo2TOgC+CyG89CFGs3h/4t6tE6C',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-QM3vQ1ro1SUguF26PKxC17ZxibTi/ixpgL9NRL5/RHw1AmA0pfSeGCh6k+uqbyzJ',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-+dgonENyuv/Ma5wK3qD7a5ah/QkyvBj6vKZRydt/XL8UZ4/vW+knK6Mzgz0n1Tur',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-9spX59FjXN5m4FE1qKeJAkbeccFpPSSkK7uRDbyfsWMLoovjBrKMwI7QPzr9IItI',
                        ],
                        12 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-/fIp3d9vqOYL5eP47pOEUYZ/h5dXL4fD9Rc4DWSuIqMZkUj+DA94qNELNYZm8VJS',
                        ],
                        13 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-sQbun49r1isRugOLIXUMavarR+iGPwX3CD+RnzFVwcq5a6ytn90mjg95EavZR7FQ',
                        ],
                        14 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-G+v/7MQzsBBqsKVV3XKv8ThIDYIyXG6LJWqTPBrADbzQf/Ok8cTgjl0X+smak2c5',
                        ],
                        15 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-wIToinlzS6m/RbLlDnKRNYNV9AH+JiQw4YYjKJLDHvRHM3otJbm3Yo6HW5Tmlm6Q',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '6.3.0',
            ],
            52 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-iw3OoTErCYJJB9mCa8LNS2hbsQ7M3C0EpIsO/H5+EGAkPGc6rk+V8i04oW/K5xq0',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-2ExAXhxetFPlyL5ZypKQbz0ZrD6S0xW1jF2n+bGda67tIfsjcfHQy3FkuA1IjuxK',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-bGIKHDMAvn+yR8S/yTRi+6S++WqBdA+TaJ1nOZf079H6r492oh7V6uAqq739oSZC',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-PwY/RecMsWJ0YLCPnyfLG+ditDiQgCzulWE8Smf0xlxWwmIct3nAJIYTB4KiBmol',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-o96F2rFLAgwGpsvjLInkYtEFanaHuHeDtH47SxRhOsBCB2GOvUZke4yVjULPMFnv',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-TYQbrAtum7hSQLm6r6N4LzjKCQcUdp06+INnw7PSirZXzTDCnTYfXHs9rKgd3rXF',
                        ],
                        6 => [
                            'path' => 'css/v4-font-face.css',
                            'value' => 'sha384-RJB8qXHAWja9guGLx18CQW+Z9LexNZMjoJw8l6YyjDEbb0KGlh9Zm82z19LHC1Am',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-TjXU13dTMPo+5ZlOUI1IGXvpmajjoetPqbUJqTx+uZ1bGwylKHNEItuVe/mg/H6l',
                        ],
                        8 => [
                            'path' => 'css/v5-font-face.css',
                            'value' => 'sha384-QjaWSlkEh5wyDERdlOeoQqTkMLC4uT8RssNlE2KX9a59xyaVpqRTyfed0QhFkT6H',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-Y7LSKwoY+C2iyfu/oupNnkGEN3EgA6skmJeVg5AyQk7ttcjX0XsLREmmuJW/SdbU',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-LZKIVE6U9qJ1ysu6iReojA6FFHyh3907bZcgwYnIGZZGKNFIbzPGCF76fZdKRIpS',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-PJJ6fWM8zRjqPjf5DIS4/IdPD0hjOoh1BJdH1TKp7N/Kl6Udgg0WaO6fc0IeMYvX',
                        ],
                        12 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-UOiUgfGrkdraMjJCXCBJ3es7S0WlAfRzwutEkKdSvdAJBEi80T6ccH436MepipvI',
                        ],
                        13 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-fjFyr4zQKu1Z1JVjcnvN7Leu0+LILepNI2mfYinScaEyzjpQeBqpaOzw63muFY6v',
                        ],
                        14 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-AjHxetn+/jiyhsDh7L3DL9B9DkI+MfPjArOp6M34vqincKmDeAn77n8d5tFsopuW',
                        ],
                        15 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-nWS6DcsdR7/yv6wq4luARu6vZs/04baVXV/1X6zrvy63FZuMoIv5DvS0I9HRZuNE',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '6.4.0',
            ],
            53 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-kjpykepEMjugguAhJkXwcfET7pbrXrP3Xv+uS6EUmR2aHXI4b7zHffvacfrhF39/',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-J1jdtNZGe4Wc5IYc1OlZow87jcNr6HnHpojEw9YuPbTwkl7Kx7NqvEgxb59Iski3',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-P6O5pbBNnrpS0pILLzahZhFOP1UpcX7AMd73G9IuE2nF8HyPrUbIeLjvZEs0Ug7b',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-MbJGQW0c7awBys9sW+AAoBKV1U2kQxiIxXqd8A4febZ60zN3B4UVTSRjRDYntCv+',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-6tgiprR9pLbvcfkGzWxHwhJH2jzw56OQ7s2NnY2FuILGo5UmXETk8L3aFYwPpteC',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-NQoFKbwXmyuKVJTvBi7CsAIsHXT6mwCybNUvHrU32r1X+BTbaMoiT3Ir6tg7MX+L',
                        ],
                        6 => [
                            'path' => 'css/v4-font-face.css',
                            'value' => 'sha384-U3414fYccumRqk4+ReNAk1QyXcZ6yPQskOCLFtjj+LH1H9Br3fraFMi2UsvxlOWg',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-NAfgAM5AYoEaYx6qI1zuWC7Vnm+IGYraBS6e3Ictl2u7+giHMRDHuiU2VdIhpwG/',
                        ],
                        8 => [
                            'path' => 'css/v5-font-face.css',
                            'value' => 'sha384-Zf5ib/vBlmsWb669+mZLzGHfsdf7+F1cMBmYUYjWSUOunf2TmRo/y9FLMKQ6MFDq',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-XTz3JQr6C2UgQyMjOXqtE1ktB22L84QvY/8e3iReKei6VGYNS1c3vfN7tkatleGm',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-bN6dDWPHPXl3lPomKGOzW55M7flHxNfki0fIeDHz5I95fUy/KSPRyoLa2cFmmeHd',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-/tkC+DsW6wGAAuYHzm8moq4WwyPHbxeoeYIdmYCqnCBwPfEVbma64R5StM6McXfT',
                        ],
                        12 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-Aj/6TFpUzUHDZXFwF1XFeekLst+gcZBlYfTBFTFuAJ421PJ3prYGyWJnIwyE6mVy',
                        ],
                        13 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-tnBSYFMgfb4WogZHJ3seCNCCpk3MYR021WyVrcOOy+pXWRXx58/5ERosIXTkPUdg',
                        ],
                        14 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-hDNCpQUw2n0Ov+4u2SwyiGyABcpjtGu2S2D9OU7SOO7thmkEeXKHPiAWCH6xG+qr',
                        ],
                        15 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-oclpB7dZf9YOfq4V7npmeZegIGMkDUrO4O8SWF4DmaWxhvrx2KDt+5S5OU10W24Q',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '6.4.1',
            ],
            54 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-blOohCVdhjmtROpu8+CfTnUWham9nkX7P7OZQMst+RUnhtoY/9qemFAkIKOYxDI3',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-zLGWoEQo4d0pyo9mhl8re+s13DMgD50yZvmt2KepO9EKPRKSKb6ejYyyrOacdxbF',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-BY+fdrpOd3gfeRvTSMT+VUZmA728cfF9Z2G42xpaRkUGu2i3DyzpTURDo5A6CaLK',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-Gr3CEO2spqs7Ewi5axeUTudhnllwvDm72lMG5zKbXWSq+U2Ff8hmq0WdfRrI5nKd',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-mg8zF75oNHlYRnMloT+F976njuLh73k82hwA0CQiqS/puYzt7Malpig8RB7LITnK',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-PCXckRqKk8Xt3VfIU/oSoVwuHBgHF9BH4O3YqogDn6oyjR522YZn39faZ53B4D5p',
                        ],
                        6 => [
                            'path' => 'css/v4-font-face.css',
                            'value' => 'sha384-ei3Y0Qqq+DvNJsXkVPPQXhcsPOyaiBoUs3RNHwBpCEg2IPjfyoGWr/TvaJzcuG7t',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-IqMDcR2qh8kGcGdRrxwop5R2GiUY5h8aDR/LhYxPYiXh3sAAGGDkFvFqWgFvTsTd',
                        ],
                        8 => [
                            'path' => 'css/v5-font-face.css',
                            'value' => 'sha384-RxpdTG8UQZB3H27HKEylcaGUDSJZCrrGOimS4DWEHS7jUgWlV9hKmCKx99zQRgmA',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-NhxsZw9+Y+PdEOvg8BK3sOUXXTzoRmr4/ncl+Ogurt6kQgJAVJaJ4LFhjD8qXtol',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-HgDRzw9OXl6njKttsRM6bzXDEX0jXjFz4ftMEacmpWzS/YHZMrzhqmx/hCizzsD+',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-1yE9Wj7LRkXyyUe0SlAsUwkMCqav8PeA/E9JQG6l1eM0VF+CZLdyD2eMeXRAGlDU',
                        ],
                        12 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-/iuJV08jLDUeRALEMlZ6fs0Bw++/li2mlOSJxBM7Iv5yj5XbrUdLKtMQN43ZZFBp',
                        ],
                        13 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-k9pHsn2VVHLVUoLLHm5UPmO16bFnmJc7la2s6uYaMQiHNADkZEig8rlqQaqLI150',
                        ],
                        14 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-zBYnK6/d/8LjD972/72gCvlHfb+ySSWaznogBkpV6JsVtY9cvEmRy1ACPom2Frtr',
                        ],
                        15 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-qx63XMht9MNrP09QOmEVrRXzomNz1CKA/p07kyef8nQ+qC/FNDZROxdpMzpLVjeD',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '6.4.2',
            ],
            55 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-/o6I2CkkWC//PSjvWC/eYN7l3xM3tJm8ZzVkCOfp//W05QcE3mlGskpoHB6XqI+B',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-rc8N/WOF/H+rKehhzM5ImP8wTvPozK8RQvzO8o6JAfDzq0KRSgo6i+j66nIEudeH',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-7ZjpdZCGaVoUcrOCjSdvnVVuVG1lIsZ2aQ209jwcxdvLz2fmPLwupbXnHctdLoU7',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-jwLSR3Fa8bOns4+ORzfXEKi/bQnPF0530na7DqUyRNnaJcWC9rrCer+Go7a1EC8m',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-iWtHCKbAjIX4uT8lZc6XhUb5MvYyD8dxuw3FydZMTESdM3TbaWCk2xZBwnoXiD3r',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-sezckoKjOoY7xa6Q1yl/mBoyUcWdzURzLDUHqGc6eCwXg/8uTyufNe8hG1tX7hXY',
                        ],
                        6 => [
                            'path' => 'css/v4-font-face.css',
                            'value' => 'sha384-rgO2rp/0KW+mzt0ore2KYf+TKafkSiUSIplK+Ta5b/QdpcpcCwfsjVa4ot+dSKI6',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-Gchs3pk5vJ6rNXyLYEW0h4LxMtAZtY6TI1xrFSBYD6AVTmQTwqBWkrQgHYjVFH98',
                        ],
                        8 => [
                            'path' => 'css/v5-font-face.css',
                            'value' => 'sha384-YQ8l7/1+xvgQd7Sj9/eQJNTS6ypVoZxDJWOVJMll2DPk+oVZ36vlNNoJ62QVsGQ6',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-xJg9IXkLBF6DBCGIEmpH5d2Pzct5onYpW8EegteK+7n0rxjhN4PUzfPxGbpWVjQf',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-L6PiDa9VmZdeblRHc9Lvjj/cBVmIpC3wTOCenJbV3a6VkkfR54U+blZ9U/rAknfM',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-/Rc5s6lpUSRVKERpkcP/EyGJMY/vNfeLAHFaY0dVpU1Bcgq3hy8DLzntbctckjSN',
                        ],
                        12 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-fczeVPs3vI1I4dC9UE4Rn3p4XtoE+5vVsWJvjppuzU0M01EcO1Y2ngjQPM6bCyRg',
                        ],
                        13 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-fRE+LPjVJ2ZEpQEitNFCGQ8WmWw7JA62+2UZ3dG4+rDSA3aGOaiat1XS8yUKLnRs',
                        ],
                        14 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-Vws6iS4SDsBgBLGHFxVz6O/maT4KwPqDxxkd+KNAaZCNPSnU5WAqc2/wQXl69hDo',
                        ],
                        15 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-/92mVmELKUSys+AjbeSvITO3rhI9KtDAENPjak7fYPIxTdmKqt1Z2WCbRbI8ybF2',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '6.5.0',
            ],
            56 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-t1nt8BQoYMLFN5p42tRAtuAAFQaCQODekUVeKKZrEnEyp4H2R0RHFz0KWpmj7i8g',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-/BRyRRN0wxxRgh/DAXU621go9pdoMHl6LFPiX5Pp8PZYZlKBQCDXj9X9DHx6LOud',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-55jldat+GoQjPHn/QQUMQuFEtiGB4UuSki3Jl9keOFLCpi1mQ5KRzpezhqCTiOOm',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-k5640LgghgAohDLPwSqVWa96yQwWouT6wsAL+J1g0CFJVITNKYkIh1XpPLYKQe7Y',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-8yO/A/BtltnG0hDxdwmmkza8UAleyDoAD1FhXiH6rsOQQsCho1P6WZP9TpBBH3YP',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-yMdWfzE9MX4Kfw6CAOm3HwUY9dTg+q0iASAGCCc8WHwpjTpTWnVD+sceD2fhmOkh',
                        ],
                        6 => [
                            'path' => 'css/v4-font-face.css',
                            'value' => 'sha384-d2Yn1/9Iw78r3oqwk5B+EcpRcmepXR5LyhmRF2a+WoSe9mpRGvVk0ZviFwDGDOTO',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-5Jfdy0XO8+vjCRofsSnGmxGSYjLfsjjTOABKxVr8BkfvlaAm14bIJc7Jcjfq/xQI',
                        ],
                        8 => [
                            'path' => 'css/v5-font-face.css',
                            'value' => 'sha384-/mBKnLlGtog8q2qQrgugURRDV+iHWHAPvM5KulYXT1C2ErKOKkBI0vbff8ZPq7rL',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-3ve3u7etWcm2heCe4TswfZSAYSg2jR/EJxRHuKM5foOiKS8IJL/xRlvmjCaHELBz',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-ZLiXRVukSL14lFTleu1lTAr2TeLHPaDuMiJCkchL/8FPG7dwZ2wtrXxpC/zdv5xn',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-UYRdH8bK5N1CVJCNns5uaqi/6Ar3kibcem5vpabHgcMxElJynrnhz/KsdHcKhgX3',
                        ],
                        12 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-E14KwrB3IyWfxYMw1QY2oDIPw9rx0prapjOJl4SQfXyxoFrUahGl9xhVYoDAOawk',
                        ],
                        13 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-rtVRl2UebrkBOegQzvNMdCV3O9bYq2eB3FYS0aTuZ1wQf8tfLfk9O2Frlo2VA+AA',
                        ],
                        14 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-Ek2vi33vZQTWariNBJSX6YQzIKkAWI00/OhiBBm7QAccyWpXrOaoWh7Ry3oeUmhM',
                        ],
                        15 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-HJMj0TodsrM5KmHW8l+5NnGnq9DLtu9LlpFYFFXVne/+pnZYGxIWtFFGRQSbcPo9',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '6.5.1',
            ],
            57 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-PPIZEGYM1v8zp5Py7UjFb79S58UeqCL9pYVnVPURKEqvioPROaVAJKKLzvH2rDnI',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-hu7sKftLeB/8IYmWPfl2Jo6MTRHquwXVmGPT/08RqhuANVZrbNFBIsvWPOiUduYX',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-5t0634b3BeTSoxIIgd8lhUy22xY2BGs89gw0vReAMGcfJXXfA7fblIRGVkRFWRDL',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-bvJbeZziR9BXg5K01HJM2RVTINetqVhPDH2/SJzZRIfFnC4FCiqU1iUYCoUBAOAZ',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-+CMpNM/Tv3YfWmU43LPsvXlIdOUnxSooWv5fY/Tkap65JU4QTLBHp8nMrEkIEb3u',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-Ja4dExpeo54nrFkcdBEDj8bT+Z8/kHeA+SYpzysVyGEQ0poh2xSpG94Pz1xM4o8h',
                        ],
                        6 => [
                            'path' => 'css/v4-font-face.css',
                            'value' => 'sha384-6Oel/YhLbBdCe8ERRAZyt2pZBFGhzrHu87JyGbASfl5UYxaNMVcIXbuhjZGKMPH/',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-XyvK/kKwgVW+fuRkusfLgfhAMuaxLPSOY8W7wj8tUkf0Nr2WGHniPmpdu+cmPS5n',
                        ],
                        8 => [
                            'path' => 'css/v5-font-face.css',
                            'value' => 'sha384-a1AIUapvbI3jyVtWxhc0MU3C5l6s4pGZ2NO8lda3JOqFh2prsG41pkLD09tgo90j',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-QvGJBgkqeVjFCXW39Q3psy0yEymI5WTMC5V+6LnvmNIeDfvGo1AI/j0AlTrID9lQ',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-IDPW/rHApD6Ix3qBqXAu6q9G6nIxKRabaI4ckYN0ZUi2kWctYXM+yASINDvx3XZM',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-LuC3i5Ct+5JSmt0n2l/KFBk9NnSBOqI5eYeLnYY4LBM7LvawT7y8mIlcn14zDIzL',
                        ],
                        12 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-k95boTdQuOXfMHiAQ5KS8ut5+VDe/XkMOa7cHZthiY9NyrGMjeGyFdQRV5qkJIBo',
                        ],
                        13 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-VENQe1UnxdGwDelZI4zTMu9pOwnwDZbg8bzjnJGsEK5uhl0TXZRho/pmwD5LXKEV',
                        ],
                        14 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-EXSuehoGxvgthEEh8uj117jhbr9OJ8AqfxfZyLxZUpklNJ8+q6qO5J3s2TMSRxCO',
                        ],
                        15 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-tj5YmFIdBVO/XRERdNj8QOyAFv67yagv304wrKG+kWqr14aj14FTlN5L5ijoDM9a',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '6.5.2',
            ],
            58 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-h/hnnw1Bi4nbpD6kE7nYfCXzovi622sY5WBxww8ARKwpdLj5kUWjRuyiXaD1U2JT',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-kONVjBbDa5e18xBGGoLguGqAr2FtXB+dqTdiDLZVkKogOJnS12iAheJLVYIa5J8h',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-NvKbDTEnL+A8F/AA5Tc5kmMLSJHUO868P+lDtTpJIeQdGYaUIuLr4lVGOEA1OcMy',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-PLNAinc+pk6pWS1N3h3B/AncazdeYQGFQj2vtyzzbi4n8nkoy/fki9txBWVQ8/zs',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-JN5YK8e9Be0IBEB/Z3BYAzxlDbH7hFQbYtlnB60vKU7JE8v86SmeuD4031oI7nAy',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-F2ItJJttusGddRtPG+oSkIWaypigkYuC1XJLzapknSsevbuLRW68aNCoAWQfxALA',
                        ],
                        6 => [
                            'path' => 'css/v4-font-face.css',
                            'value' => 'sha384-nmJ0khbCDW2kQtbB3+FbzIaUYRYH5Ka3EnqKXpydgAXJgxj1+YR7MXs3CCzzJ6lh',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-Heamg4F/EELwbmnBJapxaWTkcdX/DCrJpYgSshI5BkI7xghn3RvDcpG+1xUJt/7K',
                        ],
                        8 => [
                            'path' => 'css/v5-font-face.css',
                            'value' => 'sha384-NTfn38O/5bHHzqmrowrnqFpW1PLPr5V1GjTQ7Cr7E1tYNhPMI3UOiMb5YMNFw8Ps',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-dgEl3vRKux81M373f/TdgoDTV5oZj+yjHrr/1qR5b4btG5q63kYS62t5kod+7Q6v',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-WGmCmFVcmbr3qbRF50iEqdK5BUZs0j60avmXTYWoEtkzl1+TKc1twYLrChw4qWv+',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-pWrGfmykUr9ujlZv4t5d8IzZjGrbXIPCbc1TAK9gu4+6Y3niDr+V5MnlbSBfpYn8',
                        ],
                        12 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-v45///5Qcli6mecEr/gdSpzEluOAFIqluhZ4F6LZ30s23Dv9EU76fyJvTC/A3ncA',
                        ],
                        13 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-Gk2RYSJ/TjgKQv6ccayyf1dccurihJUVtv6e8Lfv3g8/cZNFedp/SHUWal78Kri+',
                        ],
                        14 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-NRBi/Kq1lDLpYNcj2E06xTq03Y6jqNGv3DGELNisBlWBSIUilmB4WYdPzMLK/ToO',
                        ],
                        15 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-M9y++reQwf5nddw5loUHChCbGE4kwaeHzeEM2yWidMfaRMQeHM6MSwwPuiSnSMHF',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '6.6.0',
            ],
            59 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-nMrp5ZsUTqQhbYtRk9ykIA4NlAIb530sj9RpfUkoGv/2gV+x0ZzFdUnT7Q8J8EgH',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-x+7dxPZBVPou9OnYzqRD6TIDU4pgZb4nm8W/CjSoAQiyyg7YlLk9am1mpKORKPjs',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-HeR4h/kzKX4V6BeDV0EhPt8aMEBt9T28mmbvPyrkkWGWBVbV/Hs+uznrkbs/WLeK',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-3jqusAlgwk3x1MKlsWqRELP8smmE56gqooNFDa3k4tgXHXPZkoo/bA8SBE8ijHlB',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-WcE4cHjihykkU/ggqLtOuWZS9j9ujIxLh+4OWKgXMa80Lq7X00Vq7xCtu6Zko43z',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-nYuP4tjk7+rX6nLMA2jKmkHuDEltHUq4C+ahl0KxxVl8RgG3MznNIu5DV7gCZUBp',
                        ],
                        6 => [
                            'path' => 'css/v4-font-face.css',
                            'value' => 'sha384-BIMXrelgMrPKqNfKscbmlUJC7MSs7wcxksdJ2H0pNHvCZpf2V0ulpf2L4XXPvfnM',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-wLq06ctqRnOQKBQeLwsgn+WXyTQl6i+8FiIw9yF32a8xBWM8fAYTWobpo9xDZk74',
                        ],
                        8 => [
                            'path' => 'css/v5-font-face.css',
                            'value' => 'sha384-bE2ab5QI4hbOJ+/WoeAXj7GobeGOcIP+Gat400iVAMuhQMDkYNaUZWzqlqhA9Jae',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-W/RULPqPfRI1AFuJTFpd4KXbd0zUede93robiDPaDUqCTsmfpAdkGQLJL2y51XNt',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-tPR8xaNjG181pYBvMFLlOwpK1li/66bT6Dsyy3h7R6LWV8kOZYLWtkfom6QTYAGk',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-tMX9gWQ9aNwYp+dDU9qMk/oaRspF6mibutTr61iQWm5GtV5kD9cYufsobWopVRUq',
                        ],
                        12 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-/R4616VE/b8hy9qC67aqozbhgEfSyAtiEu5US/nFht/KHmQ3+MUfg9FpWN1a9fHA',
                        ],
                        13 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-X0mP7r66/fLSBJYJneaSDWxUMF4ENzrGMMgNqPclratZNu3CY0mljb02Z7MoCxzz',
                        ],
                        14 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-3nNnrtwWJpds1OejnxV445eKnehoB1v/LhKkXWNSDIWhyPh/qGWh4C/5oFYQEHbA',
                        ],
                        15 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-uXhYgYbJWEDWnahlKFxLmGQwC19Ja7mkY/RG+tVIz1EnwNAoSxwg3YGyS1943jYf',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '6.7.0',
            ],
            60 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-QI8z31KmtR+tk1MYi0DfgxrjYgpTpLLol3bqZA/Q1Y8BvH+6k7/Huoj38gQOaCS7',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-b+WfhKuxSUfSpx4cHUnwW9AYQ9NjTYa05djzsD9uueGwQSUmMpB7WmX4/4GB1Yjr',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-EAbQoRbplocyBu1YBhlFf6o4MzZytG/DZuc3iQOvYNJouRrN9+AxSan5naDfaoqe',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-NIsDz+gz6pFEfTuZBXT4siHyRAuVQEMpKt+WX7o9EqWfqIe1PJvMx0Jjr2/K9Igz',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-VMniHmVvH7847gFXdwU6LLmyA9PDmJdk8BUlfBcZI6sbK/Hxs0qdmLSqALTVOwdt',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-FkZTpTIsMMUUQPTqa28B1Q9fA3Z038vJSn+Yzxh2W6T3C38yr4sE7JtXMSxdXzKp',
                        ],
                        6 => [
                            'path' => 'css/v4-font-face.css',
                            'value' => 'sha384-/mNHWa1pJzu+Gayjr0FS6Ed1Gt5yoN1bDeGWPkn3J2I5C1/fE2LyirFQ9Q+q7aWM',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-R64+fQmO33bGWclNEac7wTslE6q6qYBlYBl8/ih3jdfiYZsUJ3OvPpaWQNgnKZL0',
                        ],
                        8 => [
                            'path' => 'css/v5-font-face.css',
                            'value' => 'sha384-qFR2RMDRlRyeubfqfEzMGgh4to3lm3eUQQn4pYQIKMYNGHqHw9BdAdMwi7ck9RU+',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-rxRGDl9CoH4u0AIeVyasIKlE45FVz6H2qXIl+fmc+3ImJn0CvfCseru5J4PALGH/',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-D2NOkO1LiszTSE5eCA7Ygx6kT0clUZGJrNPS5n41GL3zEsxTA7BhpK2ZLJ7GxrPM',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-kefX+ApQKOdTsEjrvtOKgHXTuNvjNlzYacJwflj3RafXLE8TtTiMfpVxJzAsHRNP',
                        ],
                        12 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-TIrPY+KnwskX0FR5bxDcwecBz6kaVflVjVHmsM83f6pe/Akko+GzLcTsgWBkKf9L',
                        ],
                        13 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-Dl0OBhvLxvr1sUQaK6GP9Im5T0iZi5cIrXHq9SYcH8O6D/fa94W9wTJhtDikS7DD',
                        ],
                        14 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-tOGJDd550PR1D0FSqKjS8FehwyDZWHO6AGg8lZe58jFNCN2Q5kdrNtKCLhfQ5L/B',
                        ],
                        15 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-T50+nl9L/K0z0g6gcb6R2hZ5tAPG1aKeU6jdPm1QMnbFY2gTJrjoTWY4lmAQdGJ4',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '6.7.1',
            ],
            61 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-nRgPTkuX86pH8yjPJUAFuASXQSSl2/bBUiNV47vSYpKFxHJhbcrGnmlYpYJMeD7a',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-CNhPUG5cpX8UuKLY0BCb+gzedmWkhHPKATz919jTKgOXajXjkEY99Qr51B5V2wOQ',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-AGSGRaBRodcsy1n0F2zMm+LfXuZry/ZJ6nfio36UgMuNBs/AOC8ciJ7py4SgkpoY',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-6Zsk745fBctG7JVrpWegJSSYk7xb3Zjy7CNEEG3dFcFGiTU/ti4muXgYnTZ6nYys',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-H/BU8KfYKZ0VK4RJyclToSd6x8TmMY4/Rym2YtHXnGQOUZAoLIYIaOxkIfyTAuVh',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-La1g8AtwEh825NtYn5xyAQN3usA4ZizE2nZWvCt+g8okhStlHtUXuNSgfgo/u+ja',
                        ],
                        6 => [
                            'path' => 'css/v4-font-face.css',
                            'value' => 'sha384-Y5XZJkJTFFCVfezUSk/mT3rropmGgfaIDhPShFdyjhON0UAHQjaq3t+bX+N+6aY/',
                        ],
                        7 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-npPMK6zwqNmU3qyCCxEcWJkLBNYxEFM1nGgSoAWuCCXqVVz0cvwKEMfyTNkOxM2N',
                        ],
                        8 => [
                            'path' => 'css/v5-font-face.css',
                            'value' => 'sha384-RxG9D9PsmiOdDFY0jfNnLlApnnL36kC04NEVKbj0S2RUc8ninvZZsgzCKdtsgQkk',
                        ],
                        9 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-DsXFqEUf3HnCU8om0zbXN58DxV7Bo8/z7AbHBGd2XxkeNpdLrygNiGFr/03W0Xmt',
                        ],
                        10 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-wRU6vtIpkIdXnWzp+Hq7CNH527PHkmlZz1n7ITVY0YhEPUcSlz2voGAQfVb3d9xe',
                        ],
                        11 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-1DJDcrFUodFx+Lmy9p6Xay8G2Iilua4vOtatfywfvhNgsa9pgJrVgOGyxHsuoxpM',
                        ],
                        12 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-dCcP+1ToHaZKWNvVqy4+4ekZYXP73UfD3KsBQ0xg54c0+R0I6zsewwjQiM3JUwg+',
                        ],
                        13 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-MW39uKwb/t9lOlXyzHqlUTAWu9JpFN3aDTfaeUg8y6V0WJY5jSDspEoE05PVIBQT',
                        ],
                        14 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-Jx4lvM3f1foL3gcKtEZPpp/IOxYaIOJ+KQRq3vP7Towpgy4bjb6wo5QK5VRtnpLh',
                        ],
                        15 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-WVm8++sQXsfFD5HmhLau6q7RS11CQOYMBHGi1pfF2PHd/vthiacQvsVLrRk6lH8O',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '6.7.2',
            ],
            62 => [
                'srisByLicense' => [
                    'free' => [
                        0 => [
                            'path' => 'css/all.css',
                            'value' => 'sha384-tGBVFh2h9Zcme3k9gJLbGqDpD+jRd419j/6N32rharcTZa1X6xgxug6pFMGonjxU',
                        ],
                        1 => [
                            'path' => 'css/brands.css',
                            'value' => 'sha384-IzIkDWjFFaoFz413tu2x9R4cMiJ3EGuxOf/7Q8X0LFhqz9fU5zT2go7BgenYdKgN',
                        ],
                        2 => [
                            'path' => 'css/fontawesome.css',
                            'value' => 'sha384-aeYCj6sbs4JVGoa3LTeURNoMDGaOU4kkAj6PMGL4HA8djL1ogsMYKcKlGxFd9l3B',
                        ],
                        3 => [
                            'path' => 'css/regular.css',
                            'value' => 'sha384-PmxfVzUpFiyj5ZqzN3upnv7G4x9YAlMQar/qCBLEYSaWr/DUQ9f/8ITCT0aN7byC',
                        ],
                        4 => [
                            'path' => 'css/solid.css',
                            'value' => 'sha384-HMy1VqP4zke4zzaS+hmFgbW3QXDYD+qtueW3unq30MTgdOnarIgANSya8s5qKRh5',
                        ],
                        5 => [
                            'path' => 'css/svg-with-js.css',
                            'value' => 'sha384-k4aZSO6Y4DVDSn8+pbKg8vRBs9bLsobm8mDiKT+7v0qy7bm11Wg2vENNA4vCXqxD',
                        ],
                        6 => [
                            'path' => 'css/svg.css',
                            'value' => 'sha384-nASHdsq7039P3zL4aFudeM9arq9ltQ5q9gpAvHZV8GWp10EHVjPJ50hPsyQcyblx',
                        ],
                        7 => [
                            'path' => 'css/v4-font-face.css',
                            'value' => 'sha384-7c0mz5ReY2wCEDKNNEdrKdbtS/6+5dEgNsz/dU3e9m7xldAdTFwNTAuX+s4sJHJl',
                        ],
                        8 => [
                            'path' => 'css/v4-shims.css',
                            'value' => 'sha384-NNMojup/wze+7MYNfppFkt1PyEfFX0wIGvCNanAQxX/+oI4LFnrP0EzKH7HTqLke',
                        ],
                        9 => [
                            'path' => 'css/v5-font-face.css',
                            'value' => 'sha384-691KBFHHuy2pnDTyR36VZ90jy7dXWBfC5D1nzy5rkDlqQQ/vRs/nmmK++LBfAp/C',
                        ],
                        10 => [
                            'path' => 'js/all.js',
                            'value' => 'sha384-zRXLxPg9pQ61oxmSjS56csC5TakUQYuHE2S0yVHsc8y9YCGC/ESUwHKQ6GlR/e1C',
                        ],
                        11 => [
                            'path' => 'js/brands.js',
                            'value' => 'sha384-A3jzsfkDLxpshP330qgRBd4gDzPTDbru+aKtiuSHkoj0+insOzEhLCUNSwwQAxSG',
                        ],
                        12 => [
                            'path' => 'js/conflict-detection.js',
                            'value' => 'sha384-UAavCIlgyaQ2Oita5VzSZHHonYB/S0sTsd9j5DqFD9xyYmKU9EFZ9TaJWrLz4J8o',
                        ],
                        13 => [
                            'path' => 'js/fontawesome.js',
                            'value' => 'sha384-NSCMcVLzk5GbXmbtgTF2V5c7Q4uiYbFqfa0VcjcAKES+CRvFJ28JUYvK/oTRoHaI',
                        ],
                        14 => [
                            'path' => 'js/regular.js',
                            'value' => 'sha384-HkW1QIb74+Y6dTGMSHxicBXnZOD7ZWzSar9kTOLodCobY+Xo7PqjnTJcE8/nAHne',
                        ],
                        15 => [
                            'path' => 'js/solid.js',
                            'value' => 'sha384-e9lVLl7d3IOLUOOWnrcheqxjv7Cj2SQYuYESpfBUgWY0r5zXfFUus4S2D/P7SafZ',
                        ],
                        16 => [
                            'path' => 'js/v4-shims.js',
                            'value' => 'sha384-snJEaAGGPINatMFK6NnvLcVGotCqpacdqYGYDfRMaaPeqOt6fH7+zsCrTocZNDjT',
                        ],
                    ],
                    'pro' => [
                    ],
                ],
                'version' => '7.0.0',
            ],
        ],
    ];
}
