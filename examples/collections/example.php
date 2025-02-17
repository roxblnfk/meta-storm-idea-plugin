<?php

namespace Framework {
    use Attribute;

    #[Attribute(Attribute::TARGET_CLASS|Attribute::IS_REPEATABLE)]
    class Command { public function __construct(string $name){} }
    #[Attribute(Attribute::TARGET_CLASS)]
    class Tag { public function __construct(string $name){} }

    class Container{ public function getCommand(string $name):mixed {} }

    #[Attribute(Attribute::TARGET_CLASS)]
    class ClassMarker {}
    #[Attribute(Attribute::TARGET_METHOD|Attribute::IS_REPEATABLE)]
    class AttributeValueMarker { public function __construct(string $name){} }

    interface AttributeArgumentValueInterface {
        public function attributeArgumentValue(string $name);
    }
    interface ClientInterface extends AttributeArgumentValueInterface {
        public function attributeArgumentValue(string $name);
        public function attributeClass(string $name);
    }
    class Client implements ClientInterface {
        public function attributeArgumentValue(string $name){}
        public function attributeClass(string $name){}
    }
}

namespace App {
    use Framework\Command;
    use Framework\Container;
    use Framework\Tag;
    use Framework\Client;
    use Framework\ClassMarker;
    use Framework\AttributeValueMarker;

    #[Tag('tag_logger')]
    #[Command('app')]
    #[Command('view')]
    class FileLogger {}
    #[Command('app')]
    #[Command('index')]
    class FooRenderer {}

    #[ClassMarker]
    class MyRenderer {}


    $c = new Container;
    $command = $c->getCommand('view'); // $value to be expected FileLogger class
    $tag = $c->getTag('tag_logger'); // $value to be expected FileLogger class

    #[ClassMarker]
    class Foo
    {
        #[AttributeValueMarker('method-baaaaar')]
        #[AttributeValueMarker('workflow-type')]
        public function bar()
        {
            echo "test";
        }
    }

    #[ClassMarker]
    interface FooInterface
    {}

    $a = new #[ClassMarker] class {};
    $b = new #[ClassMarker] class {#[AttributeValueMarker('workflow-calc')]public function calc(){}};

    $client = new Client();
    $client->attributeArgumentValue('');
    $client->attributeClass();

}
