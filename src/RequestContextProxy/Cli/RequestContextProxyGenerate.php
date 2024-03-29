<?php

namespace Imi\RequestContextProxy\Cli;

use Imi\Bean\Annotation;
use Imi\Bean\Annotation\Bean;
use Imi\Bean\BeanFactory;
use Imi\Bean\Parser\BeanParser;
use Imi\Bean\ReflectionUtil;
use Imi\Main\Helper;
use Imi\RequestContextProxy\Annotation\RequestContextProxy;
use Imi\Tool\Annotation\Arg;
use Imi\Tool\Annotation\Operation;
use Imi\Tool\Annotation\Tool;
use Imi\Tool\ArgType;
use Imi\Util\File;
use Imi\Util\Imi;
use ReflectionClass;
use ReflectionMethod;

/**
 * @Tool("generate")
 */
class RequestContextProxyGenerate
{
    /**
     * 生成请求上下文代理类.
     *
     * @Operation("requestContextProxy")
     *
     * @Arg(name="target", type=ArgType::STRING, required=true, comments="生成的目标类")
     * @Arg(name="class", type=ArgType::STRING, required=true, comments="要绑定的代理类名")
     * @Arg(name="name", type=ArgType::STRING, required=true, comments="请求上下文中的名称")
     * @Arg(name="bean", type=ArgType::STRING, default=null, comments="生成的目标类的 Bean 名称")
     * @Arg(name="interface", type=ArgType::STRING, default=null, comments="生成的目标类要实现的接口")
     *
     * @param string      $target
     * @param string      $class
     * @param string      $name
     * @param string|null $bean
     * @param string|null $interface
     *
     * @return void
     */
    public function generate($target, $class, $name, $bean, $interface)
    {
        Annotation::getInstance()->init(Helper::getAppMains());
        if (class_exists($class) || interface_exists($class))
        {
            $fromClass = $class;
        }
        else
        {
            $data = BeanParser::getInstance()->getData();
            if (isset($data[$class]))
            {
                $fromClass = $data[$class]['className'];
            }
            else
            {
                throw new \RuntimeException(sprintf('Class %s does not found', $class));
            }
        }
        if (null === $interface && interface_exists($fromClass))
        {
            $interface = $fromClass;
        }
        $namespace = Imi::getClassNamespace($target);
        $shortClassName = Imi::getClassShortName($target);
        $fileName = Imi::getNamespacePath($namespace);
        if (null === $fileName)
        {
            throw new \RuntimeException(sprintf('Get namespace %s path failed', $namespace));
        }
        $fileName = File::path($fileName, $shortClassName . '.php');
        $requestContextProxyAnnotation = Annotation::toComments(new RequestContextProxy([
            'class' => $class,
            'name'  => $name,
        ]));
        if (null === $bean)
        {
            $beanAnnotation = null;
        }
        else
        {
            $beanAnnotation = Annotation::toComments(new Bean([
                'name'  => $bean,
            ]));
        }
        $refClass = new ReflectionClass($fromClass);
        $methods = [];
        foreach ($refClass->getMethods(ReflectionMethod::IS_PUBLIC) as $method)
        {
            if ($method->isStatic())
            {
                continue;
            }
            $methodName = $method->getName();
            // 构造、析构方法去除
            if (\in_array($methodName, ['__construct', '__destruct']))
            {
                continue;
            }
            if (preg_match('/@return\s+([^\s]+)/', $method->getDocComment(), $matches) > 0)
            {
                $returnType = $matches[1];
            }
            elseif ($method->hasReturnType())
            {
                $returnType = ReflectionUtil::getTypeComments($method->getReturnType(), $method->getDeclaringClass()->getName());
            }
            else
            {
                $returnType = 'mixed';
            }
            $params = [];
            foreach ($method->getParameters() as $param)
            {
                $result = '';
                // 类型
                $paramType = $param->getType();
                if ($paramType)
                {
                    $paramType = ReflectionUtil::getTypeCode($paramType, $param->getDeclaringClass()->getName());
                }
                $result .= null === $paramType ? '' : ((string) $paramType . ' ');
                if ($param->isPassedByReference())
                {
                    // 引用传参
                    $result .= '&';
                }
                elseif ($param->isVariadic())
                {
                    // 可变参数...
                    $result .= '...';
                }
                // $参数名
                $result .= '$' . $param->name;
                // 默认值
                if ($param->isDefaultValueAvailable())
                {
                    $defaultValue = $param->getDefaultValue();
                    $result .= ' = ' . (\is_array($defaultValue) ? '[]' : var_export($defaultValue, true));
                }
                $params[] = $result;
            }
            $params = implode(', ', $params);
            $item = $returnType . ' ' . $methodName . '(' . $params . ')';
            $methods[] = '@method ' . $item;
            $methods[] = '@method static ' . $item;
        }
        $methodCodes = '';
        if (null !== $interface)
        {
            $refInterface = new ReflectionClass($interface);
            foreach ($refInterface->getMethods(ReflectionMethod::IS_PUBLIC) as $method)
            {
                $methodName = $method->name;
                if ('__construct' === $methodName)
                {
                    continue;
                }
                $paramsTpls = BeanFactory::getMethodParamTpls($method);
                $methodReturnType = BeanFactory::getMethodReturnType($method);
                $returnsReference = $method->returnsReference() ? '&' : '';
                if ('void' !== ReflectionUtil::getTypeCode($method->getReturnType(), $method->getDeclaringClass()->getName()))
                {
                    $code = 'return ';
                }
                else
                {
                    $code = '';
                }
                if ($method->isStatic())
                {
                    $code = "throw new \RuntimeException('Unsupport method');";
                    $static = 'static ';
                }
                else
                {
                    $code .= "self::__getProxyInstance()->{$methodName}({$paramsTpls['call']});";
                    $static = '';
                }
                $methodCodes .= <<<TPL
    /**
     * {@inheritDoc}
     */
    public {$static}function {$returnsReference}{$methodName}({$paramsTpls['define']}){$methodReturnType}
    {
        {$code}
    }


TPL;
            }
        }
        // @phpstan-ignore-next-line
        $content = (function () use ($namespace, $requestContextProxyAnnotation, $methods, $shortClassName, $beanAnnotation, $interface, $methodCodes) {
            ob_start();
            include __DIR__ . '/template.tpl';

            return ob_get_clean();
        })();
        File::putContents($fileName, $content);
    }
}
