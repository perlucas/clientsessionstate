# Client Session State

Simple client session state PHP implementation for embedding the session data inside the HTML content of your web pages.
## Fundamentals & Basic Usage
This is one of many kinds of implementing the [client session state pattern](https://dzone.com/articles/practical-php-patterns/practical-php-patterns-client "client session state pattern"). Basically it consists on storing the session state on the client side by sending the data as an URL parameter or hiding it on a form; then restoring it on the server side for using it. [Here](http://www.rodsonluo.com/client-session-vs-server-session "Here") you can see a comparison between client session state and server session state.
Use this helper for storing non-sensitive data on your HTML markup, releasing that memory usage on your server. Typically, you start by requiring an instance of `ClientSession`, and setting up your encryption key by calling the *setEncodingKey* method. After that, you can start adding, retrieving and removing values from the session object. Take into account that it works in a key-pair format.
```php
<?php
use ClientSessionState\ClientSession;

$session = ClientSession::instance();
$session->setEncodingKey('This is my key'); // set key
$session->set('a_number', 22.5);
$session->set('an_array', array(11, 22, 33, 44));
$session->set('a_string', 'This is my session phrase');
$session->set('an_object', new stdClass());
$session->get('a_number'); // 22.5
$session->get('an_array'); // [11, 22, 33, 44]
$session->has('a_number'); // true
$session->has('an_unknown_value'); // false
$session->remove('a_number');
$session->has('a_number'); // false
```
### Outputting the session
After working with the session object, you may output the data for hiding it on the HTML markup. What you should see is the serialized encrypted version of the session object, which is a long size string. We'll call this string the *session string representation* or just *session string*. You can get the session string by calling the *output* facade:
```php
. . .
echo "Session string: " . $session->output()->string();
. . .
```
You can send the session string as an URL param while building your site links:
```php
<a href="./myPage?session=<?=$session->output()->string()?>">
	My Link
</a>
```

On the other hand, you may be able to send it within a form, maeby on a hidden input:
```php
<form action='./myPage.php'>
	. . .
	<?=$session->output()->input()?>
	. . .
</form>
```
Using the *input* method without arguments will automatically fill a hidden input named "session_data" with the session string representation. You can override the input attributes by passing it an attribute/value array:
```php
<form action='./myPage.php'>
	. . .
	<?=$session->output()->input([
		'name' => 'my_session',
		'type' => 'text',
		'readonly' => true
	])?>
	. . .
</form>
```
#### Adding a custom output
You can add your own formatter for outputting the session string representation. First of all, you must implement the `ClientSessionState\Contracts\SessionDataFormatter` interface by defining a class with the *format* method:
```php
. . .
class CustomFormatter implements SessionDataFormatter
{
	. . .
	public function format(string $input, ...$args) {
		// code here...
	}
}
```
The *$input* argument is the session string representation. Note that the format method may be called with more arguments. The *$args* array represents the arguments that you support on the format method. These arguments are passed in when you call the method from the output facade:
```php
. . .
$session->output()->custom($arg1, $arg2);
/* Here you should implement the format method 
* for supporting 2 arguments to be passed in to
* the method call along with the $input param
*/
. . .
```
After defining a new formatter, you must register it to be able to use it:
```php
. . .
$session->setFormatter('custom', new CustomFormatter);
. . .
// calling the formatter
$value = $session->output()->custom();
. . .
// calling the formatter with arguments
$value = $session->output()->custom($myFirstArg, $mySecondArg);
```
## Restoring the session
After embedding the session string on your HTML, you should prepare your backend for receive the string on $_GET or $_POST arrays. The *load* method will restore your session object from the session string. Just be sure you're using the same key you set up while encoding the session values:
```php
$session = ClientSession::instance();
$session->setEncodingKey('This is my key');
$session->load($_GET['session']);
// You can use the session values here
```
## Javascript SDK
You may want to manipulate the DOM on the client side without loosing the session string. The Javascript SDK gives you support for getting the session string and embedding it on forms. First of all, you must include the *script* tags that define the JS SDK by calling the *js* formatter:
```php
. . .
// <script> tags with the sdk definition
echo $session->output()->js();
. . .
```
Now, on the client side, you're able to use the js facade. It consists of an object named *ClientSession* with 2 methods:
- *toString* returns the session string. You can pass it a *prepend* and an *append* string for be returned before and after the session string.
```javascript
console.log(ClientSession.toString());
console.log(ClientSession.toString("before session string "));
console.log(ClientSession.toString(null, " after session string"));
```
- *addToForm* appends a hidden input named "session" to a form. You should pass it the form element or its id value. Optionally you can pass an object with the input attributes to be overriden.
``` javascript
. . .
ClientSession.addToForm(document.getElementById(formId));
. . .
ClientSession.addToForm(formId);
. . .
ClientSession.addToForm(formId, {
	name: 'session_data'
});
```
The *js* formatter on the session object can accept a parameter which is the js facade classname. You can use it to define a more convenient classname if you need to:
```php
. . .
echo $session->output()->js('SessionClass');
. . .
// then, on the client side, writing some javascript...
SessionClass.addToForm(formId);
```
## Extending the ClientSession class
The session facade lives as a `ClientSessionState\ClientSession` instance. You may want to extend this class to support other encryption or serialization methods.
The ClientSession class defines some template methods that allows you to easily extend features and support other methods for encrypting and serializing the data.
- The *createEncrypter* method is a factory method implemented on the ClientSession class that must return a [`ClientSessionState\Contracts\Encrypter`](./src/Contracts/Encrypter.php "`ClientSessionState\Contracts\Encrypter`") instance to be used as the encrypter engine.
- The *createSerializer* method must return a [`ClientSessionState\Contracts\Serializer`](./src/Contracts/Serializer.php "`ClientSessionState\Contracts\Serializer`") instance to be used as the serializer class. Note that the serializer class must serialize and deserialize an *array*. That is because the session data is hold using that data structure.
- The *setUpFormatters* method registers the *input, string and js* formatters. It can be extended to register other formatters when the ClientSession instance is created.
## Examples
You can see an example of a complete page to page navigation holding the session data on the client HTML presented on the *[example](./example/index.php "example")* folder. Additionally, you can load it on your server and run it to see how it works.