<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-03-21
// |Description : 
// +-------------------------------------------------------------

return [
    // 应用appid
    'appId'                 => '2021000117625496',
    // 支付宝网关
    'gatewayUrl'            => 'https://openapi.alipaydev.com/gateway.do',
    // 应用私钥（支付宝密钥工具生成）
    'rsaPrivateKey'         => 'MIIEpAIBAAKCAQEAnZSTjf2razmqJ3CKiQYY8tqAHj0it6v2xVAj6ZHiWwG0zldk/gaHhsfY4cfSt6rEPqudA+sOUzdGWd3NS2ni5WV84ia+q9xH3zov2MaCZaNRRzqESnQRBTSKNDpOV/GI8hMiSmwuEeXwgqIaYAJ6J9jvJJtb0eiUPh5n4H1AFxmV1mgg45w9BB/g4cdny3ztkhjcWQEK9xPOss37IV1FKGAL86SYmRjGXrGfSzXeJ41GOl6TZqY3W1XLBLtbLZjALGAPct/1GqVIzylvKFuf19Z8W6bYFfCtRxfvU7WxiRhCTcLk8E4dVaVgTITxLoWivTpKf/vr2KFaJODvktX4SQIDAQABAoIBADGikhPAmlUM9da0cT6V6Bfe0Uo1EZFvHiyqgJVauUTXNb9k8c+9+MRwgJUlnu7xYB0payzHxlxZ5dP6tGaTtL9zBzIo6Bg0K4NZzaZnaL1hAwH/oZneE1pjYUDwOKskznEJq9xrVNuYZPiQ3OPvA9E3WKRcN0DYFJG4fBnO+fgMPYlencBrDf1qgSskBBJRedGDzKcU8nkObNZPvAh+SoZzsGdQxPyHsA4IdK1LbGjvZpja4VRrpt8lmepYepuVhYoYhpeiXwKU1TIvEGhd3YVV0++n8iU302yAMQRUF6dktIM63MbO7W3yYhb0+R+NVSkDamY9heziZ5gTKuulRYECgYEAyU+Z+XcqZhq4V0bPHVaaLeVHzcQIb9FeShDbDdA/45qFs7TJBbZ5U8x4SpRgulbMwE5S08unvU1ka8UCX7XbcA1tXxhTOXuRNMe+W/UEduetAWju0sjYYKrJoglq5s+K9jRmqrzLs94S2438v8eE0U86YCHVPdDo5iLd+PhpSZkCgYEAyGOu06oxcmfhECBrAA6a/j1e81Z2DPqQ8q9cLC0cGn9zzNetQE0hFV3SdzrnuICnhyWIStsb5sRJIqHMsEP2ZQWWJ32yClhuIHefOj80gxfUV4x/E4+EQcrm/iBTJoznHvvj32cqHJ4ntKiePdJq5wDvfbY9DLiu1hJFy0AnMjECgYEArltNZu25QTn/U0g29pgdbYbaC/Ovwvk5izjSIUKvMziQeLcqLNKAfv3naeDdbkbji+PKhTosjB7NzTGS/saJyqE2i1iMLItDls0xqH+sYDgEdeYmg1YFYqRJgxhZCJPVLazxBwwB+kVrW9G8iXYLKSZPzxc+lA2uyjSEwLCWsHECgYAtXDsv2J+2yQLuNphh++xjzpqWtKSmTXXQKZfQvClXajBZVxz1qD/r6UACE0huwFirw/g1EaIgO6BegYenAstclMYnjFFn/Bp5qPpXIgWOAy/i3X/KersydW6SadjIqi6LGfO8F0s2DSrpvx2K2v2t6s1LhJwPLCMPfDVmS9BTkQKBgQCeP6yLX17pOVi7Q5jVuTXoI4HgLDL70AlvgPWW1N8oNJQwXgjY4EuyF601hxF0nfdkD9ZtaXmFPa5yw6uOnEesjEpNgLsPhlD3cJBP8ebbLcK+ykfdTWVoJK9xxirz0oLKYHRNJnqqzvByBIYYwnXM+5vCP3tVZYmDobTQGxNtlw==',
    // 支付宝公钥
    'alipayrsaPublicKey'    => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAlNnY7IIAqsOB7KMJ+RLCPZV8QlaZPz1n12xQpGDZBy5cfLWRWRYvfIGVF6eGp+hQ6ZHVMqhrROoHGOSvqmmEAqZpiq9tHdAkQB2zLnAAwgBeJNrOQ1oQBgV3pE8l8i2k/Zud5A8Y6XJExqWVK5OB6cuT82pAt8QMvsu3aCS0WzGttR4HwR8Wbyzu6vc/Oju9SgxKaMz5qSf+UPSR5gYaWmUcRvVYLgzp+WCuCRu4yF7aREsQDoZh/omO6mgmZ80RX8E0sRqKApcwsnyBPrs68IW1vafvJ/FyRIDlkTiUxhBf7n8HuDuT1j21J6AIJ1+awESLZoFhKWplEGJ8hDKXAwIDAQAB',
    // 密钥类型
    'signType'              => 'RSA2',
    // 同步通知回调url
    'returnUrl'             => 'http://42fh69.natappfree.cc/public/index/index/index',
    // 异步通知回调url
    'notifyUrl'             => 'http://42fh69.natappfree.cc/public/index/index/index',
    // 数据格式
    'format'                => 'json',
    // 业务数据
    'biz_content'           => '',
];

