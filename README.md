## Client test

1. After downloading the code, first run the command to install all the components:

```bash
$ composer install
```

2. Then setup the api address into the .env file for the API_URL variable

3. Once everything is correct, you can use the commands listed by "bin/console"

4. The commands related to this task are:
4.1. To list the items:

```bash
$ bin/console api:list
```

4.1.1. With the available options --stock=false|true and --more=0
4.1.2. The stock option will only accept false or true while the more option will only accept numerical values

4.2. To get an item:

```bash
$ bin/console api:get --id=12345
```

4.3. To add an item:

```bash
$ bin/console api:new 'Name of the product' 'amount in stock'
```

4.4. To edit an item:

```bash
$ bin/console api:edit --id=12345 'Name of the product' 'amount in stock'
```

4.4.1. To simplify the example, both name and amount are required parameters

4.5. To delete an item:

```bash
$ bin/console api:delete --id=12345
```

5. Rules implemented
5.1. Items cannot have the same name or negative amount
5.2. Request for list cannot have values different than true/false or a non-numeric parameter for the has_more_than parameter
