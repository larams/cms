<?php


namespace Larams\Cms\Property;

use Larams\Cms\Property;

class Image extends Property
{

    protected $versions = [];

    protected $format = 'png';

    protected $automatic = false;

    public function getHtml()
    {

        $configuration = [
            'name' => $this->name,
            'format' => $this->format,
            'item' => $this->item,
            'automatic' => $this->automatic,
            'versions' => $this->versions,
            'hint' => $this->hint,
        ];

        return view('larams::properties.image', $configuration);

    }


    public function getFormData($formData)
    {

        $return = [];
        $format = (webp() ? 'webp' : $this->format);

        if (!empty( $this->automatic )) {
            $imageId = $formData[$this->name];
            $shouldDelete = !empty($formData[$this->name . '_delete']);


            if (empty($imageId) || !empty($shouldDelete)) {
                return $return;
            }

            $return = [
                'id' => $imageId,
                'url' => $imageId . '.' . $format,
            ];

            if (!empty($this->versions)) {
                foreach ($this->versions as $versionName => $dimensions) {
                    $return[$versionName]['url'] = $imageId . '.' . $format;
                    $return[$versionName]['cropped'] = $imageId . '_' . $dimensions['width'] . '_' . $dimensions['height'] . '_1.' . $format;
                    $return[$versionName]['fitted'] = $imageId . '_' . $dimensions['width'] . '_' . $dimensions['height'] . '_2.' . $format;
                    $return[$versionName]['absolute_url'] = asset('media/' . $return[$versionName]['url'] );
                    $return[$versionName]['absolute_cropped'] = asset('media/' . $return[$versionName]['cropped'] );
                    $return[$versionName]['absolute_fitted'] = asset('media/' . $return[$versionName]['fitted'] );
                    $return[$versionName]['width'] = $dimensions['width'];
                    $return[$versionName]['height'] = $dimensions['height'];
                }
            }
        } else {
            foreach ($this->versions as $versionName => $dimensions) {

                $imageId = $formData[$this->name.'_'.$versionName];
                $shouldDelete = !empty($formData[$this->name .'_'.$versionName. '_delete']);

                if (empty($imageId) || !empty($shouldDelete)) {
                    return $return;
                }

                $return[$versionName]['id'] = $imageId;
                $return[$versionName]['url'] = $imageId . '.' . $format;
                $return[$versionName]['cropped'] = $imageId . '_' . $dimensions['width'] . '_' . $dimensions['height'] . '_1.' . $format;
                $return[$versionName]['fitted'] = $imageId . '_' . $dimensions['width'] . '_' . $dimensions['height'] . '_2.' . $format;
                $return[$versionName]['absolute_url'] = asset('media/' . $return[$versionName]['url'] );
                $return[$versionName]['absolute_cropped'] = asset('media/' . $return[$versionName]['cropped'] );
                $return[$versionName]['absolute_fitted'] = asset('media/' . $return[$versionName]['fitted'] );
                $return[$versionName]['width'] = $dimensions['width'];
                $return[$versionName]['height'] = $dimensions['height'];
            }
        }

        return $return;
    }

    /**
     * Get default service configuration
     * @access public
     * @return array
     */

    function getConfigDef()
    {

        $service_config_def = array(

            'depends' => array(
                'StructService:struct' => '',
            ),

            'versions' => array(),

        );

        return ($this->mergeConfig(parent::getConfigDef(), $service_config_def));

    }


    /**
     * Push data to data pool ( output mode )
     * @param array &$data Reference to data pool
     * @return bool Success?
     */

    function pushData(&$data)
    {

        $ret_val = FALSE;

        if ($this->_configured) {

            $data[$this->_config['name']] = isset($this->_intern_data[$this->_config['name']]['image']) ? $this->_intern_data[$this->_config['name']]['image'] : array();
            $ret_val = TRUE;

        }

        return ($ret_val);

    }


    /**
     * Push data to data pool ( internal mode )
     * @param array &$data Reference to data pool
     * @return bool Success?
     */

    function pushInternData(&$data)
    {

        $ret_val = FALSE;

        if ($this->_configured) {

            $data[$this->_config['name']] = isset($this->_intern_data[$this->_config['name']]) ? $this->_intern_data[$this->_config['name']] : array();

            $ret_val = TRUE;

        }

        return ($ret_val);

    }


    function fixVersions()
    {

        $ret_val = FALSE;

        if ((count($this->_config['versions']) > 0) &&
            isset($this->_intern_data[$this->_config['name']]['image']['item_parent_id'])
        ) {

            $oStruct = &$this->getDependService('struct');

            $image_item = $oStruct->getItems(array('item_id' => $this->_intern_data[$this->_config['name']]['image']['item_parent_id'], 'data_dynamic' => TRUE, 'uncond' => TRUE, 'single' => TRUE));

            if (count($image_item) > 0) {

                $oItemHandler = &$image_item['item_handler'];

                $this->_intern_data[$this->_config['name']]['image']['versions'] = array();

                foreach ($this->_config['versions'] as $version) {
                    $this->_intern_data[$this->_config['name']]['image']['versions'][$version['name']] = $oItemHandler->createImageVersion($version['image_width'], $version['image_height'], $version['image_mode']);
                }

            } else {
                $this->_intern_data[$this->_config['name']] = array();
            }

        }

        return ($ret_val);

    }


    function pickEditorData(&$data)
    {

        $ret_val = FALSE;

        if ($this->_configured) {

            $this->_intern_data = array();

            if (isset($data[$this->_config['name'] . '_delete'])) {

                $this->_intern_data[$this->_config['name']] = array();

                $oStruct = &$this->getDependService('struct');

                $image_item = $oStruct->getItems(array('item_id' => $data[$this->_config['name']], 'data_dynamic' => TRUE, 'uncond' => TRUE, 'single' => TRUE));

                if (count($image_item) > 0) {

                    $oItemHandler = $image_item['item_handler'];

                    if (count($oItemHandler->_config['item']['item_data_handler']) > 0) {

                        $oItemHandler->onDelete();

                    }

                }

            } else {
                if (isset($data[$this->_config['name']])) {

                    $this->_intern_data[$this->_config['name']] = array();

                    $oStruct = &$this->getDependService('struct');

                    $image_item = $oStruct->getItems(array('item_id' => $data[$this->_config['name']], 'data_dynamic' => TRUE, 'uncond' => TRUE, 'single' => TRUE));

                    if (count($image_item) > 0) {

                        $oItemHandler = &$image_item['item_handler'];

                        if (count($oItemHandler->_config['item']['item_data_handler']) > 0) {

                            $this->_intern_data[$this->_config['name']]['thumb'] = $oItemHandler->_config['item']['item_data_handler']['image_thumb'];
                            $this->_intern_data[$this->_config['name']]['image'] = $oItemHandler->_config['item']['item_data_handler']['image_original'];
                            $this->_intern_data[$this->_config['name']]['image']['versions'] = array();

                            if (count($this->_config['versions']) > 0) {
                                foreach ($this->_config['versions'] as $version) {
                                    $this->_intern_data[$this->_config['name']]['image']['versions'][$version['name']] = $oItemHandler->createImageVersion($version['image_width'], $version['image_height'], $version['image_mode']);
                                }
                            }

                        }

                    }

                }
            }

            $ret_val = TRUE;

        }

        return ($ret_val);

    }

}
