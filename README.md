Rokko MVC
=========
@Author Rodrigo Formigone Silveira http://www.rodrigo-silveira.com

An awesome PHP MVC Framework designed with simplicity and efficiency in mind.

[![Build Status](https://travis-ci.org/formigone/rokko-mvc.png?branch=master)](https://travis-ci.org/formigone/rokko-mvc)

### Framework goals
 * Provide a light-weight, flexible, and secure application framework
 * Provide an elegant way to organize application code - multiple applications can share the framework's core libraries
 * Help newcomers to Model-View-Controller paradigm get used to concepts easily

### Framework features
 * Very, very modular
 * Models, controllers, and custom libraries can be namespaced and still get autoloaded
 * Easily configured from a single configuration file
 * Heavily documented with PHPDocs
 * Build using Test Driven Development, giving the framework a higher degree of reliability, confidence, and predictability

### Sample Usages
##### Throwing Exceptions
Just remember to reference the global namespace if/when inside another namespace
```php
   try {
      throw new \Rokko\Exception\TestException("Catch me if you can");
   } catch (\Rokko\Exception\TestException $e) {
      var_dump($e->getMessage());
      try {
         throw  new \Exception("Caught because I could");
      } catch (\Exception $e) {
         var_dump($e->getMessage());
      }
   }
```
