<?php

namespace Wame\RouterModule\DI;

use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Helpers;

class Extension extends CompilerExtension
{

    public function addDefultRoutes(&$lines, $defaultRoutes)
    {
        foreach ($defaultRoutes as $route => $param) {
            if (is_string($param)) {
                $presenterName = explode(":", $param);

                //defualt module and action
                if (count($presenterName) < 3) {
                    array_unshift($presenterName, '');
                }
                if (count($presenterName) < 3) {
                    array_shift($presenterName, 'default');
                }

                $lines[] = Helpers::format(
                        '$routerEntity = new \Wame\RouterModule\Entities\RouterEntity();' .
                        '$routerEntity->setRoute(?);' .
                        '$routerEntity->setModule(?);' .
                        '$routerEntity->setPresenter(?);' .
                        '$routerEntity->setAction(?);' .
                        '$service->add($routerEntity);', $route, $presenterName[0], $presenterName[1], $presenterName[2]
                );
            } elseif (is_array($param)) {
                $parts = ['$routerEntity = new \Wame\RouterModule\Entities\RouterEntity();'];
                foreach ($param as $key => $value) {
                    $parts[] = Helpers::format('$routerEntity->? = ?', $key, $value);
                }
                $parts[] = '$service->add($routerEntity);';
                $lines[] = implode(";", $parts);
            }
        }
    }

    public function afterCompile(ClassType $class)
    {
        $config = $this->getConfig();

        $init = $class->getMethod('createServiceDefaultRoutesRegister');
        $lines = explode(";\n", trim($init->getBody()));
        $init->setBody(NULL);
        array_pop($lines);

        if (isset($config['defaultRoutes'])) {
            $this->addDefultRoutes($lines, $config['defaultRoutes']);
        }

        $lines[] = 'return $service;';
        $init->setBody(implode(";\n", $lines));
    }
}
