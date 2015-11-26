HttpContext
===========
HttpContext is singleton class. You can use it inside Controllers with **$this->context** and with **HttpContext::getInstance()** outside. 
- **Cookies**
    - **$this->context->getCookies()->test = "2015";** - it will set cookie with name=test and value=2015
    - **$this->context->getCookies()->test;** - if there is a cookie with name=test it will return its value otherwise empty string
    - **$this->context->getCookies()->test->delete;** - if the cookie exits it will delete it
- **Session**
    - **$this->context->getSession()->test = "2015";** - it will add in the $_SESSION array value with key=test and value=2015
    - **$this->context->getSession()->test;** - if there is a session value with key=test it will return its value otherwise empty string
    - **$this->context->getSession()->test->delete;** - will unset Session value with key=test
- **Request**
    - **$this->context->getRequest()->userId** - if there is a $_GET value with key=userId it will return its value otherwise empty string
    - **$this->context->getRequest()->getForm()->username** - if there is a $_POST value with key=username it will return its value otherwise empty string
- **Identity**
    - **$this->context->getIdentity()->isLogged()** - will check if there is logged user. Return type: **bool**
    - **$this->context->getIdentity()->logout()** - will unset Session value with key=userId
    - **$this->context->getIdentity()->getCurrentUser()** - if there is logged user will return UserProfileViewModel object. Otherwise will return dummy UserProfileViewModel with empty string properties.
    - **$this->context->getIdentity()->setCurrentUser()** - if there is logged user will refresh user data with Db query.
    
Identity Code-First
===================
If you want some table to be created upon application start you must create a class in Identity/Tables.
- Possible class annotations:
	- **@Table table_name** - this annotation is **REQUIRED**!
    - **@Primary table_column_name** - OPTIONAL parameter for creating the column PRIMARY KEY
    - **@Foreign (column_name) References foreign_table_name(foreign_column_name)** - **OPTIONAL** parameter - will add   FOREIGN KEY($column_name) References $foreign_table_name($foreign_column_name) to the sql query
- Possible properties annotations:
    - **@Field column_name** - **REQUIRED**! The name of the column in the table.
	- **@Type column_type** - **REQUIRED**! The type of the column.
	- **@Length	column_length** - **REQUIRED**! The length of the column. You have to type it even for Integer numbers. Default Int value in MySql is 11.
	- **@Null** - **OPTIONAL** parameter. Allow null values for the column. Omit this annotation if you want NOT NULL for the column.
	- **@Primary** - **OPTIONAL** parameter. Add PRIMARY KEY for the column. **IMPORTANT!!! DO NO USE THIS ANNOTATION FOR PROPERTIES IF THE TABLE ALREADY HAS THE SAME ANNOTATION**
    - **@increment** - **OPTIONAL** parameter. Add AUTO_INCREMENT for the column.

Built-in Annotations
====================
- **Route**
	- **@Route(users/login/1)** - no parameters will be passed to the action
	- **@Route(users/profile/{int}/show)** - parameter of type int will be passed to the action
	- **@Route(new/{id}/author/{str})** - 2 parameters will be passed to the action - int and string types
- **Method**
	(if the action has no Method annotation the default will be GET)
	- **@POST**
	- **@PUT**
	- **@DELETE**
	- **@GET**	
- **NoAction**
	- **@NoAction** - this function will be excluded from actions
- **Other**
	- **@@Authorize** - checks for logged user. Redirects to users/login if there is no logged user.
	- **@@Admin** - check if there is logged user and is in admin role (the name of the admin role can be changed from AppConfig class)
	- **@@NotLogged** - check for logged user. Redirects to default controller and action if there is logged user.

Binding Models Annotations
==========================
All binding models annotations are **OPTIONAL**. MinLength and MaxLength doesn't make the field Required!
- **@Required**
- **@MinLength(3)**
- **@MaxLength(30)**
- **@Display(Full name)** - used when showing binding models errors. Default behaviour is using the field name;

Strongly Typed Views
====================
**OPTIONAL** for making the view usable with certain object. Will show error page if class does not exist.
- **<?php  /\*\* @var \Framework\Models\ViewModels\UserProfileViewModel $model */ ?>** - will make the view usable only with UserProfileViewModel. **IMPORTANT! Add this line at the beginning of your file otherwise it won't work.**

Custom Annotations
==================
Users could create custom annotations:
- **@@Some** - the framework will search for class SomeAnnotation in Annotations folder. This class must extend AbstractAnnotation class!
         The function dispatch of the Annotation class will be executed before the action execution.