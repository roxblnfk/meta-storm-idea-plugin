# 🌟 **MetaStorm** – Smarter References and Autocompletion for PHPStorm! 🚀

![Downloads](https://img.shields.io/jetbrains/plugin/d/26121-meta-storm)
![Rating](https://img.shields.io/jetbrains/plugin/r/rating/26121-meta-storm)
![Version](https://img.shields.io/jetbrains/plugin/v/26121-meta-storm)

Plugin on Jetbrains Marketplace: https://plugins.jetbrains.com/plugin/26121-meta-storm/

**MetaStorm** is the ultimate tool for developers who want their IDE to understand their code on a deeper level. 
With a single customizable rule, you can unlock both **references** and **autocompletion** simultaneously! 
Save time, avoid mistakes, and navigate your projects effortlessly. 💻✨

## Quick start

Short Youtube demo: https://youtu.be/fFGrRNFDZIg

1. Create a file with the name `.meta-storm.xml` at any place in your project with the following content:
```xml
<?xml version="1.0" encoding="UTF-8" ?>
<meta-storm xmlns="meta-storm">
    <definitions>
        <properties
                className="\ArrayHelper"
                methodName="getValue"
                argumentIndex="1"
                relatedTo="argument"
                relatedArgumentIndex="0"
        />
    </definitions>
</meta-storm>
```

2. Create a PHP file with the following content:

```php
<?php

class User { private $id; protected $name; public $age; }

$a = new User;

class ArrayHelper {
    public static function getValue(object $object, string $name) {} 
}

ArrayHelper::getValue($a, 'age');

```

3. Start doing

- Click with pressed CTRL / COMMAND on the `'age'` and PhpStorm navigates you to the `$age` property declaration.
- Remove `age` and start typing, you can see properties completion for the existing properties.
- Click on the property `$age` in the class `User` and PhpStorm highlight you all the usages and add references to them

> That was example how it works. Read the rest documentation to understand what you can do with the plugin.

## Configuration

### Configuration files

Meta Storm searches for any files with the `.meta-storm.xml` at the end of file name so:
- A file can be placed at any place (except ignored directories)
- A file may have any name with the specific postfix, e.g.: `arrays.meta-storm.xml`, `files.meta-storm.xml`, `.meta-storm.xml`, etc
- Configuration files could exist more than one at the moment
- The whole config is combines with several config files

> The best way to use the plugin is to add a specific configuration to a package and distribute the config file with the package.

###### Empty configuration file
```xml
<?xml version="1.0" encoding="UTF-8" ?>
<meta-storm xmlns="meta-storm">
    <definitions>
    </definitions>
</meta-storm>
```


### Definitions

There are two different, but very similar ways to make your IDE more interactive:
- [Properties definitions](#properties-definitions)
- [Files definitions](#files-definitions)

Once you configured a method plugin activate the following features:
- Referencing string literals as program language entities that automatically enables:
  - Navigating from the usage to the definition
    - From `method('prop')`  to `class { public $prop }`
    - From `render('index')`  to `templates/site/index.php`
  - Navigating from the definition to the usages
      - Vise-serve of the navigating from the usage to the definition
  - Renaming
  - Refactoring
  - Finding usages
- Autocompletion
  - When you start typing inside the string literal IDE suggest you necessary endings

#### Properties definitions (\<properties\>)

Provide properties of the related class.

- `className`: **required**
  - Should be a FQN classname, e.g. `\App\Helper\Arrays`
- `methodName`: **required**
  - Should be desired method name without parenthesis: `getPropertyValue`
- `argumentIndex`: **required**
  - Numeric position of the interactive element in the parameters list
  - Zero-based
- `relatedTo`: **required**
  - Complex parameter changes interpretation of the referenced value
  - Values and meanings are described [here](#relatedto)


#### Files definitions (\<files\>)

Provide files and directories at the related filesystem point.

- `className`: **optional**
  - Should be a fully qualified classname, e.g. `\App\Helper\Arrays`
  - Or absent if `methodName` is a function in global scope
- `methodName`: **required**
  - Should be desired method name without parenthesis: `getPropertyValue`
- `argumentIndex`: **required**
  - Numeric position of the interactive element in the parameters list
  - Zero-based
- `fileExt`: **required**
  - File postfix
  - Used to filter possible values and auto-append to the value
- `relatedTo`: **required**
  - Complex parameter changes interpretation of the referenced value
  - Values and meanings are described [here](#relatedto)

`directoryProcessors` is applied here as the children element. See more.

#### Collection definitions (\<collection\>)

Provide value from the [defined collections](#collections)

- `className`: **optional**
  - Should be a fully qualified classname, e.g. `\App\Helper\Arrays`
  - Or absent if `methodName` is a function in global scope
- `methodName`: **required**
  - Should be desired method name without parenthesis: `getPropertyValue`
- `argumentIndex`: **required**
  - Numeric position of the interactive element in the parameters list
  - Zero-based
- `collectionName`: **required**
  - Collection name defined at `<collections>` section

### Collections

Using collections helps to first define a set of values, prepare, filter and then use as definitions.

Collections can be merged. So it's possible to build a collection with different sources (attributes, yaml, json, php).

#### Attribute argument collection (\<attributeArgument\>)

Collects **arguments** from the attribute usages:

- `name`: **required**
    - Collection name
- `className`: **required**
    - Attribute fully qualified name, e.g. `\Attributes\AsCommand`
- `argumentIndex`: **required**
    - Numeric position of the interactive element in the parameters list
    - Zero-based

#### Attribute class collection (\<attributeClass\>)

Collects **arguments** from the attribute usages:

- `name`: **required**
    - Collection name
- `className`: **required**
    - Attribute fully qualified name, e.g. `\Attributes\AsCommand`

### Other

##### `relatedTo`
  - Complex parameter changes interpretation of the files
  - Possible values:
    - `file` – related to the current (opened) file
    - `directory` – related to the current file directory
    - `project` – related to the project path
    - `argument` – related to the positioned argument: it's `$obj` in `$service->method($obj, $prop)`
    - `variable` – related to the variable holding the method: it's `$service` in `$service->method()`


### Processors

#### `regexp`
  - Regular expression based processor, helps you to change directory, convert camelCase to snake_case and other
  - Parameters:
    - `from`: **required** 
      - Regular expression
    - `to`: **required**
      - Regular expression, could you $1, $2, etc as group references
  - Example: `<regexp from="([a-z])([A-Z])" to="$1-$2"/>` – converts `HelloWorld` to `Hello-World`

#### `append`
  - Such prefixing basically used for some static values like static path from the project directory
  - Parameters:
    - `value`: **required** 
      - String
  - Example: `<append value="/common/mail"/>`

## XSD Scheme

The plugin for PhpStorm natively adds support of XSD scheme, but if you want to look at it deeper please open the [link](docs/config-scheme.xsd).

### Screenshots

##### references
![references.png](docs/images/references.png)
![references2.png](docs/images/references2.png)

![files.png](docs/images/files.png)

##### autocomplete
![autocomplete.png](docs/images/autocomplete.png)

##### collections
![collection_arguments.png](docs/images/collection_arguments.png)
![collection_classes.png](docs/images/collection_classes.png)
