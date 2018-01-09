# G+J DataPush SDK

This SDK provides an easy to use interface for secured data exchange between G+J and 3rd Party Applications. All communications are GPG encrypted.

### Installing

To use G+J DataPush SDK simply install package via composer:

```
composer require guj-dvs/data-push-sdk-php
```

### Usage with PushData-Object

```php
<?php

require "vendor/autoload.php";

use \Guj\DataPush\Model\Child;
use \Guj\DataPush\Model\Order;
use \Guj\DataPush\Model\PushData;
use \Guj\DataPush\Model\UserData;
use \Guj\DataPush\Provider\GujDataPushProvider;

/**
 * Configure
 */
GujDataPushProvider::init(
    array(
        // 'aws_sqs_region'      => 'eu-west-1', // default value
        'aws_sqs_queue_name'  => '[[ QUEUE_NAME ]]',
        'aws_sqs_key'         => '[[ AWS_KEY ]]',
        'aws_sqs_secret'      => '[[ AWS_SECRET ]]'
    )
);

/**
 * Create PushData and set base data
 */
$data = new PushData();
$data->setProducer('TestProducer'); // REQUIRED
$data->setClient('TestClient'); // REQUIRED
$data->setType('TestType'); // REQUIRED
$data->setCreatedAt( time() );

/**
 * Set UserData
 */
$userData = new UserData();
$userData->setSsoId(123456789);
$userData->setDateOfBirth('01.01.1950');
$userData->setName('John');
$userData->setLastName('Doe');
$userData->setEmail('mail@example.com');
$userData->setCity('SampleCity');
$userData->setPostcode(12345);
$userData->setStreet('Street');
$userData->setStreetNo('1');

$data->setUserData($userData);

/**
 * Add Child to collection
 */
$child = new Child();
$child->setName('Jane');
$child->setLastName('Doe');
$child->setGender('f');
$child->setDateOfBirth('01.01.1990');

$data->addChild($child);


/*
 * Add other data...
 * See full List of possible data in README.md
 */

/**
 * Encrypt and push data
 */
$result = GujDataPushProvider::encryptAndPushObject($data);

var_dump($result);

```
### Usage with PHP array

```php
<?php

require "vendor/autoload.php";

use \Guj\DataPush\Provider\GujDataPushProvider;


$data = array(
    'version'           => '1.0.0', 
    'producer'          => 'TestProducer', // REQUIRED
    'client'            => 'TestClient', // REQUIRED
    'type'              => 'data', // REQUIRED
    'createdAt'         => '2016-03-22T08:04:22Z', // REQUIRED
    'userData'          =>
        array(
            'ssoId'       => '123456789',
            'customerNo'  => '',
            'userName'    => 'johnDoe',
            'name'        => 'John',
            'lastName'    => 'Doe',
            'gender'      => 'm',
            'dateOfBirth' => '2001-01-01T00:11:22Z',
            'email'       => 'mail@example.com',
            'phone'       => '123456789',
            'mobile'      => '132456789',
            'company'     => 'Company Ltd.',
            'street'      => 'Street',
            'streetNo'    => '1',
            'careOf'      => 'at Ms. Smith',
            'postcode'    => '12345',
            'city'        => 'TestCity',
            'country'     => 'SampleCountry',
        ),
    'children'          =>
        array(
            0 =>
                array(
                    'name'        => 'Jane',
                    'lastname'    => 'Doe',
                    'gender'      => 'f',
                    'dateOfBirth' => '2001-01-01T00:11:22Z',
                ),
        ),
    'newsletter'        =>
        array(...),  // See example for full details
    'orders'            =>
        array(...), // See example for full details
    'optIn'             =>
        array(...), // See example for full details
    'terms'             =>
        array(...), // See example for full details
    'campaigns'         =>
        array(...), // See example for full details
    'appUsage'          => '',
    'milestoneDelivery' => ''
);

/**
 * Encrypt and push data
 */
$result = GujDataPushProvider::encryptAndPushArray($data);

var_dump($result);

```


### Possible values

List of possible values for the root and child objects.


#### Root-Object: *PushData*
| Information | Feldname | Typ |
| --- | --- | --- |
| Sendendes System | producer | string |
| Client	| client | string |
| Objekttyp	| type | string |
| Erstellungsdatum des Objektes | createdAt	| datetime |
| Daten zur Person | userData | Single object: **UserData** |
| Kinder | children | List of objects: **Child** |
| Newsletter Abonnements | newsletter | List of objects: **Newsletter** |
| Bestellinformationen | orders	| List of objects: **Order** |
| Opt Ins | optIns | List of objects: **OptIn** |
| Terms	| terms	| List of objects: **Term** |
| Teilnahmen an Kampagnen | campaigns | List of objects: **Campaign** |	 	 	 


##### Object: *UserData*
| Information | Feldname | Typ |
| --- | --- | --- |
| SSO ID | ssoId | string |
| Kundennummer | customerNo | string |
| Benutzername | userName | string |
| Vorname | name |string |
| Nachname | lastName | string |
| Geschlecht | gender | string |
| Geburtsdatum | dateOfBirth | date |
| E-Mail | email | string |
| Telefon | phone | string |
| Mobile | mobile | string |
| Firma	| company | string |
| Straße | street | string |
| Hausnummer | streetNo | string |
| zu Händen von | careOf | string |
| PLZ | postcode | string |
| Wohnort | city | string |
| Land | country | string |

##### Object: *Child*
| Information | Feldname | Typ |
| --- | --- | --- |
| Vorname Kind | name | string |
| Nachname Kind | lastName | string |
| Geschlecht Kind | gender | string |
| Geburtsdatum Kind | dateOfBirth | date |

##### Object: *Newsletter*
| Information | Feldname | Typ |
| --- | --- | --- |
| Newsletter Art | type | string |
| Registrierungsdatum | registeredAt | datetime |

##### Object: *Order*
| Information | Feldname | Typ |
| --- | --- | --- |
| Art der Bestellung | type | string |
| order ID | orderID | string |
| order date | orderDate | datetime |
| order value | orderValue | string |
| lifetime_value | lifetimeValue | string |
| purchase_device | purchaseDevice | string |
| discount_name	| discountName | string |
| discount_value | discountValue | string |
| category name_0 | categoryName0 | string |
| category name_1 | categoryName1 | string |
| category name_3 | categoryName3 | string |
| paper_format | paperFormat | string |

##### Object: *Optin*
| Information | Feldname | Typ |
| --- | --- | --- |
| Opt In Art |	type | string |
| Opt In ID	| id  | string |
| Opt In Text | text | string |
| Double Opt-in	| doubleOptIn | boolean |

##### Object: *Term*
| Information | Feldname | Typ |
| --- | --- | --- |
| Art der Terms	| type | string |
| Terms ID	| id  | string |
| Terms Text | text | string |

##### Object: *Campaign*
| Information | Feldname | Typ |
| --- | --- | --- |
| Name der Kampagne	| name  | string |
| Teilnahmedatum | registeredAt  | datetime |


### Example Structure in JSON:
```json
{
    "version": "1.0.0",
    "producer": "TestProducer",
    "client": "TestClient",
    "type": "data",
    "createdAt": "2016-03-22T08:04:22Z",
    "userData": {
        "ssoId": "123456789",
        "customerNo": "",
        "userName": "johnDoe",
        "name": "John",
        "lastName": "Doe",
        "gender": "m",
        "dateOfBirth": "2001-01-01T00:11:22Z",
        "email": "mail@example.com",
        "phone": "123456798",
        "mobile": "13245789",
        "company": "Company Ltd.",
        "street": "Street",
        "streetNo" : "1",
        "careOf": "at Ms. Smith",
        "postcode": "12345",
        "city": "SampleCity",
        "country": "SampleCountry"
    },
    "children": [{
        "name": "Jane",
        "lastname": "Doe",
        "gender": "f",
        "dateOfBirth": "2001-01-01T00:11:22Z"
        }],
    "newsletter":[{
        "type": "MyNewsletter",
        "registeredAt": "2001-01-01T00:11:22Z"
        }],
    "orders":[{
        "type" : "SampleProduct",
        "orderID": "12345",
        "orderValue": "46,33",
        "orderDate": "2001-01-01T00:11:22Z",
        "lifetimeValue": "123,12",
        "purchaseDevice": "iPhone",
        "discountName": "DiscountName",
        "discountValue": "10",
        "categoryName0": "A",
        "categoryName1": "B",
        "categoryName3": "C",
        "paperFormat": "A4"
        }],
    "optIn": [{
        "type": "marketing",
        "id": "1234",
        "text": "I accept that",
        "doubleOptIn" : "false"
        }],
    "terms": [{
        "type": "privacy",
        "id": "1234",
        "text": "I accept that"
        }],
    "campaigns": [{
        "name": "SampleCampaign",
        "registeredAt" : "2001-01-01T00:11:22Z"
        }],
    "appUsage": "",
    "milestoneDelivery": ""
}
```

## Built With

* [Amazon AWS SDK for PHP](http://docs.aws.amazon.com/aws-sdk-php/v3/guide/)
* [php-gpg](https://github.com/jasonhinkle/php-gpg) - php-gpg is a pure PHP implementation of GPG/PGP

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/guj/data-push-sdk-php/tags). 
 
## License

MIT? GNU GPL? 