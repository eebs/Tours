iCompute Tours API RESTful Web Service
======================================

Introduction
------------

The Tours API is used by clients wanting to access data for the iCompute Tours mobile application.
The API can be accessed via the following base URL and a resource: http://www.eebsy.com/api

Resources
---------

There are currently two resources available via the API. Neither of them do anything at the moment.

* /tour
* /resource

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

Authorization
-------------

In order to access any of the API resources, clients must authenticate themselves with the server. This is done via HTTP headers and public/private key pairs.
Each client may request and receive a public/private key pair for use with the API.

Two headers are required, Authorization and Date.

* Date must be formatted according to RFC 822 (updated by RFC 1123).
  An example date is as follows: Sat, 22 Oct 2011 04:50:43 +0000
  
* Authorization must be formatted as shown below:

  PublicKey:PrivateString
  
  where PrivateString = base64_encode(sha1(PrivateKey + "\n" + Date)) and Date is formatted the same way as the header.
  
Note that when sending requests, the client must make sure its time is correct. When the server received a request, it checks to make sure the time sent via the Date header is within 180 seconds of the current GMT time.

Testing
-------

To test the API, you may use this public/private key pair:

* public key: TlTVIFYuzq9UgsSnjnJUUVFOQr1UbzTIwQFyWEaQ0P4xaZZ29wBp9jb18ofMG9rS
* private key: tP8Y798c0tDwVAlgi26ESrTePMFfKVPrkYfRckD6M2tvE5MIEn9w9qm2EZPRFTeF

This keypair may only use the GET method, and may be disabled in the future.

Examples
--------

Note this example will not work as is due to the time constraint. It is merely to serve as a example of the correct syntax, and curl command.

    curl -H "Authorization: TlTVIFYuzq9UgsSnjnJUUVFOQr1UbzTIwQFyWEaQ0P4xaZZ29wBp9jb18ofMG9rS:Y2E4YTU2OTVkNTgzYjM1ZjI4OWFhMmE5OGU3YmY0ZGQ0YmQ2MGI2NQ==" -H "Date: Sat, 22 Oct 2011 05:40:10 +0000" http://eebsy.com/api/resource