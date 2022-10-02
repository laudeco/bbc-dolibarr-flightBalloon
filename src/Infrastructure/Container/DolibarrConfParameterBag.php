<?php


namespace Laudeco\Dolibarr\FlightBalloon\Infrastructure\Container;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

final class DolibarrConfParameterBag extends ParameterBag
{
    public static function fromConf(\Conf $dolibarrConf): self
    {
        $parameters = new self();

        $parameters->add(json_decode(json_encode($dolibarrConf), true));

        return $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function add(array $parameters)
    {
        foreach ($parameters as $key => $value) {
            if (is_array($value)) {
                $this->addChildren($key, $value);
                continue;
            }

            if (is_callable($value)) {
                //not supported by Symfony
                continue;
            }

            $this->set(strtolower($key), str_replace('%', '%%', $value));
        }
    }

    /**
     * @param string $previousKey
     * @param array  $children
     */
    private function addChildren($previousKey, array $children)
    {
        $formattedChildren = [];

        foreach ($children as $key => $value) {
            $formattedChildren[$previousKey . '.' . $key] = $value;
        }

        $this->add($formattedChildren);
    }

}