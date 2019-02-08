<?php

namespace App\Services;

/**
 * Description of ReactionService
 *
 * @author tony
 */
class ReactionService
{
    protected $reactableTypes = ['post','comment'];

    /**
     * Check if reaction type is in the reactableTypes
     * 
     * @param type $type
     * @return type
     */
    public function checkIfIsAlowedType($type)
    {
        return boolval(in_array($type, $this->reactableTypes));
    }

    /**
     * Get Reactable type
     * 
     * @param type $reactableType
     * @return type
     * @throws \Exception
     */
    public function getReactableType($reactableType)
    {
        if (!$this->checkIfIsAlowedType($reactableType)){
            throw new \Exception('Not alowed type for Reactions!');
        }

        return 'App\\'. ucfirst($reactableType);
    }
}
