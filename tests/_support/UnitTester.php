<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class UnitTester extends \Codeception\Actor
{
    use _generated\UnitTesterActions;

   /**
    * Define custom actions here
    */

    /**
     * Return value of a private property using ReflectionClass
     *
     * @param \Guj\DataPush\Model\DataPushModel $instance
     *
     * @return array
     */
    public function getPrivatePropertiesValueByReflection(\Guj\DataPush\Model\DataPushModel $instance)
    {
        $properties = [];
        $reflector = new \ReflectionClass($instance);
        $reflector_properties = $reflector->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED);
        foreach ($reflector_properties as $property) {
            $property->setAccessible('true');
            $properties[$property->getName()] = $property->getValue($instance);
        }

        return $properties;
    }
}
