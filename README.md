SclZfCartPaypoint
=================

Module which allows an application which uses the
[SclZfCart](https://github.com/SCLInternet/SclZfCart) module to take payments
via [Paypoint's](http://www.paypoint.net/) hosted gateway.

Installation
------------

This module requires that you are using both the
[SclZfCart](https://github.com/SCLInternet/SclZfCart) and
[SclZfCartPayment](https://github.com/SCLInternet/SclZfCart) modules.

You can easily install this module via composer by adding the following to your
`composer.json` and running `php composer.phar install`.

```json
{
    "require": {
        "sclinternet/scl-zf-cart": "dev-master",
        "sclinternet/scl-zf-cart-payment": "dev-master",
        "sclinternet/scl-zf-cart-paypoint": "dev-master"
    }
}
```

Once the modules are installed add `SclZfCart`, `SclZfCartPayment` and
`SclZfCartPaypoint` to the modules section of your ZF2 application config.

You will need to refer to both the 
[SclZfCart](https://github.com/SCLInternet/SclZfCart) and
[SclZfCartPayment](https://github.com/SCLInternet/SclZfCart) modules for their
specific instructions setup. Once they are configured copy the
`data/scl_zf_cart_paypoint.global.php.dist` file to the your application's
config autoload directory and edit it with your Paypoint account settings.

Finally you will need to  add you will need to add 

`'paypoint' => 'SclZfCartPaypoint\Paypoint',`

to the `payment_methods` section of your `scl_zf_cart_payment` config.
