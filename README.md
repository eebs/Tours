Tourtoise API/RESTful Web Service
======================================

Introduction
------------

The Tourtoise API is used by clients wanting to access data for the Tourtoise mobile application.
The API and this documentation is located at https://www.eebsy.com/api

Clients
-------

Clients are applications running on either a mobile device or a desktop that need access to the API. For example, the Tourtoise mobile application is considered a client.

### Authorization

In order to access any of the API resources, clients must authenticate themselves with the server. This is done via HTTP headers and public/private key pairs. Clients must also pass a username and password of the user making the request. For more information users, see the User section. Authorization is done over SSL to prevent unauthorized access.

Several HTTP headers are required:

* **Date**

  The date header is used to ensure that the same request cannot be used at a later point in time by comparing the date sent in the header with the current date. The date in the header must be within 180 seconds of the current GMT time or the request will fail.

  The date header must be formatted according to RFC 822 (updated by RFC 1123).
  An example date is as follows: Sat, 22 Oct 2011 04:50:43 +0000

* **Authorization**

  The Authorization header is a custom header used to authenticate the client and the user requesting access to the API. The authorizatin header must be formatted as follows:

        PublicKey:PrivateString:UserID:Password

  where PublicKey is the public key of the client, UserID is the base64 encoded user ID of the user requesting access (usually their email address) and Password is the user's base64 encoded password. PrivateString must be formatted as follows:

        base64_encode(sha1(PrivateKey + "\n" + Date))

  where Date must be formated exactly like the Date header detailed above.

* **Accept**

  The Accept header is used to indicate what type of data the client expects from the server. Valid values are `application/xml` and `application/json` which will return XML and JSON respectively. If no value is specified, the server will default to JSON.

* **Content-Type**

  The Content-Type header is used for POST requests only. It is used to indicate what type of data the client is sending the server. Valid values are `application/xml` and `application/json` which indicate the client is sending XML and JSON respectively.

Users
-----

Users are people using the Tourtoise mobile application. They must make a Tourtoise account prior to being able to use the service. Currently this is down via the website, but will eventually be implemented in the mobile application.

Resources
---------

Resources are representations of data stored in the Tourtoise API. Currently there is only one resource available via the API, the `tour` resource. Because the Tourtoise is a RESTful API, all communication is down via HTTP verbs and URIs.

The following table shows how URI's are matched to functions:

<table>
	<tr>
		<td>GET	/api/tours/</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td>Api_ToursController::indexAction()</td>
	</tr>
	<tr>
		<td>GET	/api/tours/:id</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td>Api_ToursController::getAction()</td>
	</tr>
	<tr>
		<td>POST /api/tours/</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td>Api_ToursController::postAction()</td>
	</tr>
	<tr>
		<td>POST /api/tours/:id</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td>Api_ToursController::putAction()</td>
	</tr>
	<tr>
		<td>PUT	/api/tours/:id</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td>Api_ToursController::putAction()</td>
	</tr>
	<tr>
		<td>DELETE/api/tours/:id</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td>Api_ToursController::deleteAction()</td>
	</tr>
</table>
&nbsp;

### Tour Resource

The tour resource allows clients to retrieve and save tours. 

* **IndexAction**

  Requests to the Index action will return a list of all tours.

* **GetAction**

  Requests to the Get action will return the tour with the ID passed in via the URL parameters. So `GET /api/tour/1` will return a representation of the tour with ID 1.

* **PostAction**

  Requests to the Post action will create a new tour. The tour must be passed in the HTTP request body along with the appropriate request headers, either as JSON or XML.

* **PutAction**

  Requests to the Put action will update an existing tour. The tour must be passed in the HTTP request body like the Post action, but an ID must be passed in the URL parameters as well. So either `PUT /api/tour/1` or `POST /api/tour/1` will update the tour with ID 1. Note that using `POST /api/tour/1` is preferred over `PUT`.

* **DeleteAction**

  Requests to the Delete actino will delete the tour with the ID passed in via the URL parameters. So `DELETE /api/tour/1` will delete the tour with ID 1.

Testing
-------

To test the API, you may use this public/private key pair:

    * public key: TlTVIFYuzq9UgsSnjnJUUVFOQr1UbzTIwQFyWEaQ0P4xaZZ29wBp9jb18ofMG9rS
    * private key: tP8Y798c0tDwVAlgi26ESrTePMFfKVPrkYfRckD6M2tvE5MIEn9w9qm2EZPRFTeF

This keypair may only use the GET method, and may be disabled in the future.

Note that you must still register a user on the website. Currently all users have access to everything.

Examples
--------

* **Tour Listing**

    * **JSON**

            {
              "tours": {
                "tour": [
                  {
                    "id": "1",
                    "title": "Test Tour",
                    "description": "This is a test tour",
                    "access": "Walk",
                    "rating": "5",
                    "tags": "test",
                    "numdownloads": "0"
                  },
                  {
                    "id": "2",
                    "title": "Tour 2",
                    "description": "This is another test tour",
                    "access": "Drive",
                    "rating": "3",
                    "tags": "second tour",
                    "numdownloads": "4"
                  }
                ]
              }
            }

    * **XML**

            <?xml version="1.0" encoding="UTF-8"?>
            <tours>
                <tour>
                    <id>1</id>
                    <title>Test Tour</title>
                    <description>This is a test tour</description>
                    <access>Walk</access>
                    <rating>5</rating>
                    <tags>test</tags>
                    <numdownloads>0</numdownloads>
                </tour>
                <tour>
                    <id>2</id>
                    <title>Tour 2</title>
                    <description>This is another test tour</description>
                    <access>Drive</access>
                    <rating>3</rating>
                    <tags>second tour</tags>
                    <numdownloads>4</numdownloads>
                </tour>
            </tours>

* **Single Tour**

    * **JSON**

            {
              "tour": {
                "id": "1",
                "title": "Test Tour",
                "description": "This is a test tour",
                "access": "Walk",
                "rating": "5",
                "tags": "test",
                "numdownloads": "0",
                "stops": {
                  "stop": [
                    {
                      "id": "1",
                      "title": "Stop 1",
                      "description": "This is a stop in a tour",
                      "accessibility": "1",
                      "admission": "5",
                      "category": "1",
                      "ageaccess": "PG-13",
                      "starttime": "2011-11-08 14:39:49",
                      "endtime": "2011-11-16 00:00:00",
                      "tourId": "1",
                      "media": {
                        "file": [
                          {
                            "uniqueFileName": "fa26be19de6bff93f70bc2308434e4a440bbad02",
                            "originalFileName": "filename1.png",
                            "tourId": "1",
                            "stopNumber": "1",
                            "mediaNumber": "1",
                            "type": "image",
                            "fileSize": "122",
                            "hasUploaded": "1"
                          },
                          {
                            "uniqueFileName": "c6b308339bf1168660591aed67b18b430c0a01ca",
                            "originalFileName": "soundfile.mp3",
                            "tourId": "1",
                            "stopNumber": "1",
                            "mediaNumber": "2",
                            "type": "sound",
                            "fileSize": "2342",
                            "hasUploaded": "1"
                          }
                        ]
                      }
                    },
                    {
                      "id": "2",
                      "title": "Stop Number 2",
                      "description": "This is another stop in a wonderful tour.",
                      "accessibility": "0",
                      "admission": "0",
                      "category": "1",
                      "ageaccess": "PG",
                      "starttime": "2011-11-09 19:57:20",
                      "endtime": "2011-11-17 00:00:00",
                      "tourId": "1"
                    }
                  ]
                }
              }
            }

    * **XML**

            <?xml version="1.0" encoding="UTF-8" ?>
            <tour>
                <id>1</id>
                <title>Test Tour</title>
                <description>This is a test tour</description>
                <access>Walk</access>
                <rating>5</rating>
                <tags>test</tags>
                <numdownloads>0</numdownloads>
                <stops>
                    <stop>
                        <id>1</id>
                        <title>Stop 1</title>
                        <description>This is a stop in a tour</description>
                        <accessibility>1</accessibility>
                        <admission>5</admission>
                        <category>1</category>
                        <ageaccess>PG-13</ageaccess>
                        <starttime>2011-11-08 14:39:49</starttime>
                        <endtime>2011-11-16 00:00:00</endtime>
                        <tourId>1</tourId>
                        <media>
                            <file>
                                <uniqueFileName>fa26be19de6bff93f70bc2308434e4a440bbad02</uniqueFileName>
                                <originalFileName>filename1.png</originalFileName>
                                <tourId>1</tourId>
                                <stopNumber>1</stopNumber>
                                <mediaNumber>1</mediaNumber>
                                <type>image</type>
                                <fileSize>122</fileSize>
                                <hasUploaded>1</hasUploaded>
                            </file>
                            <file>
                                <uniqueFileName>c6b308339bf1168660591aed67b18b430c0a01ca</uniqueFileName>
                                <originalFileName>soundfile.mp3</originalFileName>
                                <tourId>1</tourId>
                                <stopNumber>1</stopNumber>
                                <mediaNumber>2</mediaNumber>
                                <type>sound</type>
                                <fileSize>2342</fileSize>
                                <hasUploaded>1</hasUploaded>
                            </file>
                        </media>
                    </stop>
                    <stop>
                        <id>2</id>
                        <title>Stop Number 2</title>
                        <description>This is another stop in a wonderful tour.</description>
                        <accessibility>0</accessibility>
                        <admission>0</admission>
                        <category>1</category>
                        <ageaccess>PG</ageaccess>
                        <starttime>2011-11-09 19:57:20</starttime>
                        <endtime>2011-11-17 00:00:00</endtime>
                        <tourId>1</tourId>
                    </stop>
                </stops>
            </tour>

* **Authorization Header**

        Authorization: JMoEudX2ESn5ZNiUcMbFd25ynBErffCF7l4ezRWRe959PENv6XVYNckiImF7P34Q:MjMyYzg2NGQ3YWEwNmRjNTgxYTExYWQ2NDhhNDU5NTBlYmU5YTIyMg==:bGlmZWlzbXVzaWM0MzRAZ21haWwuY29t:cGFzc3dvcmQ=

* **Date Header**

        Date: Sat, 22 Oct 2011 04:50:43 +0000
