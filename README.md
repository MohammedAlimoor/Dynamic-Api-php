# Dynamic-Api-php

a dynamic api php, mysql  with output json (for  small project)
Give you  many services to manage your database (select , search , add ,  update , remove )
## Getting Started
![alt tag](https://raw.githubusercontent.com/MohammedAlimoor/Dynamic-Api-php/master/ScreenShot.png)

### Config database

link api with  your  database 
```
$Config_DB_Host="localhost";  // Database Host
$Config_DB_Name="test";  // Database  name
$Config_DB_User="root";   // Database user name
$Config_DB_Password="root"; // Database user password
```

### Other options  
secure your api by Authentication Code   

```
$Config_Required_Auth=FALSE;   //is required Authentication
$Config_Auth_Code="any code";   //Authentication Code
```



## How to use ```with example```

you need to send json template   to  POST  ``` request ```

### get all data in table  

 This command enables you to retrieve all the rows in the table ``` user ```

```
{
  "action": "all",
  "auth": "any code",
  "from": "user"
}
```

### Retrieve records by a particular column value

 retrieve records data from table ```user```  by column ```id```
```
{
  "action": "get",
  "auth": "any code",
  "from": "user",
  "key": "id",
  "data": {
    "id": "1",
  }
}
```
### Search  records in table

 Search   records data from table ```user```  by column ```name```
```
{
  "action": "search",
  "auth": "any code",
  "from": "user",
  "key": "name",
  "data": {
    "name": "ali",
  }
}
```
### Insert record in table 

 add  record  in table ```user```  with values
```
{
  "action": "add",
  "auth": "any code",
  "from": "user",
  "data": {
    "id": "1",
    "name": "ali",
    "pass": "05980727"
  }
}
```
### Update record in table 

 record  record  in table ```user```  with a particular column ```id``` 
```
{
  "action": "edit",
  "auth": "any code",
  "from": "user",
  "key": "id",
  "data": {
    "id": "1",
    "name": "ali",
    "pass": "05980727"
  }
}
```
### Remove record in table 

 remove  record  in table ```user```  with a particular column ```id``` 
```
{
  "action": "delete",
  "auth": "any code",
  "from": "user",
  "key": "id",
  "data": {
    "id": "1"
  }
}
```

## Development
* [Email](mailto:ameral.java@gmail.com) - mohammed alimoor
