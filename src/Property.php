<?php

namespace Larams\Cms;


abstract class Property
{

    protected $title;

    protected $name;

    protected $item;

    public function setConfiguration($configuration)
    {

        $vars = get_object_vars( $this );

        foreach ( $vars as $varName => $value ) {
            if ( isset( $configuration[ $varName ])) {
                $this->$varName = $configuration[ $varName ];
            }
        }

    }

    public function setItem( $structureItem )
    {

        $this->item = $structureItem;

    }

    public function getFormData( $formData )
    {
        return isset( $formData[ $this->name ] ) ? $formData[ $this->name ] : null;
    }

    public abstract function getHtml();

}
