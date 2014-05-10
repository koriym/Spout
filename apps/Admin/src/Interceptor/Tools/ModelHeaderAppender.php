<?php

namespace Mackstar\Spout\Admin\Interceptor\Tools;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Mackstar\Spout\Interfaces\StringInterface;
use Ray\Di\Di\Inject;


class ModelHeaderAppender implements MethodInterceptor
{

    private $string;

    /**
     * @Inject
     */
    public function setString(StringInterface $string)
    {
        $this->string = $string;
    }

    public function invoke(MethodInvocation $invocation)
    {
        $response = $invocation->proceed();
        $path = parse_url($response->uri)['path'];
        $names = explode('/', $path);
        $i = count($names);
        $name = $names[$i-1];
        if ($name === 'index') {
            $name = $names[$i-2];
        }
        if (isset($response->body[$name])) {
            $modelName = $name;
        } else {
            $singular = $this->string->singularize($name);
            if ($name != $singular && isset($response->body[$singular])) {
                $modelName = $singular;
            }
        }

        if (isset($modelName)) {
            $response->body['_model'] = $modelName;
        }

        return $response;
    }
}
