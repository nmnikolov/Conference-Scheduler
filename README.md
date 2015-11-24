** Identity Code-First **
===========================
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
** Built-in Annotations **
==========================
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
**Custom Annotations**
======================
Users could create custom annotations:
- **@@Some** - the framework will search for class SomeAnnotation in Annotations folder. This class must extend AbstractAnnotation class!
         The function dispatch of the Annotation class will be executed before the action execution.