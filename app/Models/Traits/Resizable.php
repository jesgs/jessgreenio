<?php
/**
 * Created by PhpStorm.
 * User: jess
 * Date: 2/4/18
 * Time: 7:15 PM
 */

namespace App\Models\Traits;

trait Resizable
{
    /**
     * Method for returning specific thumbnail for model.
     *
     * @param string $type
     * @param string $attribute
     *
     * @return string|array
     */
    public function thumbnail($type, $attribute = 'image')
    {
        // Return empty string if the field not found
        if (!isset($this->attributes[$attribute])) {
            return '';
        }

        // We take image from posts field
        $image = $this->attributes[$attribute];
        $imageArray = json_decode($image);
        if (is_array($imageArray)) {
            $images = [];
            foreach ($imageArray as $image) {
                // We need to get extension type ( .jpeg , .png ...)
                $ext = pathinfo($image, PATHINFO_EXTENSION);

                // We remove extension from file name so we can append thumbnail type
                $name = rtrim($image, '.'.$ext);

                $images[] = $name . '-' . $type . '.' . $ext;
            }
            return $images;
        } else {
            // We need to get extension type ( .jpeg , .png ...)
            $ext = pathinfo($image, PATHINFO_EXTENSION);

            // We remove extension from file name so we can append thumbnail type
            $name = rtrim($image, '.'.$ext);

            // We merge original name + type + extension
            return $name.'-'.$type.'.'.$ext;
        }
    }
}
