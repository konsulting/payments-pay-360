<?php

namespace Konsulting\Payments\Pay360\Concerns;

trait HasEndpoints
{
    public function getEndpoint($name, $resources = [])
    {
        $replacements = ['{instId}' => $this->instId];

        foreach ($resources as $resource => $value) {
            $replacements['{'.$resource.'}'] = $value;
        }

        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            $this->api->getBaseUrl().$this->endpoints[$name]
        );
    }
}