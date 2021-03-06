<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}

/**
 * Helper class for resizing images, returning the correct URL to the image etc
 */
class MetaSliderImageHelper {

    private $crop_type = 'smart';
    private $container_width; // slideshow width
    private $container_height; // slideshow height
    private $id; // slide/attachment ID
    private $url;
    private $path; // path to attachment on server
    private $use_image_editor;

    /**
     * Constructor
     *
     * @param integer $slide_id
     * @param integer $width      - required width of image
     * @param integer $height     - required height of image
     * @param string  $smart_crop
     */
    public function __construct( $slide_id, $width, $height, $crop_type, $use_image_editor = true ) {

        $upload_dir = wp_upload_dir();

        if ( get_post_type( $slide_id ) === 'attachment' ) {
            $this->id = $slide_id;
        } else {
            $this->id = get_post_thumbnail_id( $slide_id );
        }

        $this->url = apply_filters("metaslider_attachment_url", $upload_dir['baseurl'] . "/" . get_post_meta( $this->id, '_wp_attached_file', true ), $this->id);
        $this->path = get_attached_file( $this->id );
        $this->container_width = $width;
        $this->container_height = $height;
        $this->use_image_editor = $use_image_editor;
        $this->set_crop_type($crop_type);
    }


    /**
     * Add in backwards compatibility for old versions of MS Pro
     * 'true' = smart, 'false' = standard, 'disabled' = disabled
     *
     * @param string $crop_type
     */
    private function set_crop_type( $crop_type ) {

        switch ( $crop_type ) {
            case "false":
            case "standard":
                $this->crop_type = 'standard'; // smart crop enabled
                break;
            case "disabled":
                $this->crop_type = 'disabled'; // cropping disabled
                break;
            case "disabled_pad":
                $this->crop_type = 'disabled'; // cropping disabled
                break;
            case "true":
            case "smart":
            default:
                $this->crop_type = 'smart';
        }

    }


    /**
     * Return the crop dimensions.
     *
     * Smart Crop: If the image is smaller than the container width or height, then return
     * dimensions that respect the container size ratio. This ensures image displays in a
     * sane manner in responsive sliders
     *
     * @param integer $image_width
     * @param integer $image_height
     * @return array image dimensions
     */
    private function get_crop_dimensions( $image_width, $image_height ) {
        if ( $this->crop_type == 'standard' ) {
            return array( 'width' => absint( $this->container_width ), 'height' => absint( $this->container_height ) );
        }

        if ( $this->crop_type == 'disabled' ) {
            return array( 'width' => absint( $image_width ), 'height' => absint( $image_height ) );
        }

        $container_width = $this->container_width;
        $container_height = $this->container_height;

        /**
         * Slideshow Width == Slide Width
         */
        if ( $image_width == $container_width && $image_height == $container_height ) {
            $new_slide_width = $container_width;
            $new_slide_height = $container_height;
        }

        if ( $image_width == $container_width && $image_height < $container_height ) {
            $new_slide_height = $image_height;
            $new_slide_width = $container_width / ( $container_height / $image_height );
        }

        if ( $image_width == $container_width && $image_height > $container_height ) {
            $new_slide_width = $container_width;
            $new_slide_height = $container_height;
        }

        /**
         * Slideshow Width < Slide Width
         */
        if ( $image_width < $container_width && $image_height == $container_height ) {
            $new_slide_width = $image_width;
            $new_slide_height = $image_height / ( $container_width / $image_width );
        }

        /**
         * Slide is smaller than slidehow - both width and height
         */
        if ( $image_width < $container_width && $image_height < $container_height ) {
            if ( $container_width > $container_height ) {
                // wide

                if ( $image_width > $image_height ) {
                    // wide
                    $new_slide_height = $image_height;
                    $new_slide_width = $container_width / ( $container_height / $image_height );

                    if ( $new_slide_width > $image_width ) {
                        $new_slide_width = $image_width;
                        $new_slide_height = $container_height / ( $container_width / $image_width );
                    }
                } else {
                    // tall
                    $new_slide_width = $image_width;
                    $new_slide_height = $container_height / ( $container_width / $image_width );

                    if ( $new_slide_height > $image_height ) {
                        $new_slide_height = $image_height;
                        $new_slide_width = $container_width / ( $container_height / $image_height );
                    }
                }
            } else {
                // tall
                if ( $image_width > $image_height ) {
                    // wide
                    $new_slide_height = $image_height;
                    $new_slide_width = $container_width / ( $container_height / $image_height );

                    if ( $new_slide_width > $image_width ) {
                        $new_slide_width = $image_width;
                        $new_slide_height = $container_height / ( $container_width / $image_width );
                    }
                } else {
                    // tall
                    $new_slide_width = $image_width;
                    $new_slide_height = $container_height / ( $container_width / $image_width );

                    if ( $new_slide_height > $image_height ) {
                        $new_slide_height = $image_height;
                        $new_slide_width = $container_width / ( $container_height / $image_height );
                    }
                }
            }
        }

        if ( $image_width < $container_width && $image_height > $container_height ) {
            $new_slide_width = $image_width;
            $new_slide_height = $container_height / ( $container_width / $image_width );
        }

        /**
         * Slideshow Width > Slide Width
         */
        if ( $image_width > $container_width && $image_height == $container_height ) {
            $new_slide_width = $container_width;
            $new_slide_height = $container_height;
        }

        if ( $image_width > $container_width && $image_height < $container_height ) {
            $new_slide_height = $image_height;
            $new_slide_width = $container_width / ( $container_height / $image_height );
        }

        if ( $image_width > $container_width && $image_height > $container_height ) {
            $new_slide_width = $container_width;
            $new_slide_height = $container_height;
        }

        return array( 'width' => floor( $new_slide_width ), 'height' => floor( $new_slide_height ) );
    }


    /**
     * Return the image URL, crop the image to the correct dimensions if required
     *
     * @param bool $force_resize
     * @return string resized image URL
     */
    function get_image_url( $force_resize = false ) {
        // Get the image file path
        if ( ! strlen( $this->path ) ) {
            return apply_filters( 'metaslider_resized_image_url', $this->url, $this->url );
        }

        // get the full image size dimensions
        $orig_size = $this->get_original_image_dimensions();

        // bail out if we can't find the image dimensions, return the full URL
        if ( $orig_size == false ) {
            return apply_filters( 'metaslider_resized_image_url', $this->url, $this->url );
        }

        // get our crop dimensions (this is the size we want to display)
        $dest_size = $this->get_crop_dimensions( $orig_size['width'], $orig_size['height'] );

        // if the full size is the same as the required size, return the full URL
        if ( $orig_size['width'] == $dest_size['width'] && $orig_size['height'] == $dest_size['height'] ) {
            return apply_filters( 'metaslider_resized_image_url', $this->url, $this->url );
        }

        // construct the file name
        $dest_file_name = $this->get_destination_file_name( $dest_size );

        if ( file_exists( $dest_file_name ) && ! $force_resize ) {
            // good. no need for resize, just return the URL
            $dest_url = str_replace( basename( $this->url ), basename( $dest_file_name ), $this->url );
        }
        else if ( $this->use_image_editor ) {
            // resize, assuming we're allowed to use the image editor
            $dest_url = $this->resize_image( $orig_size, $dest_size, $dest_file_name );
        }
        else {
            // fall back to the full URL
            $dest_url = $this->url;
        }

        $dest_url = apply_filters( 'metaslider_resized_image_url', $dest_url, $this->url );

        return $dest_url;
    }


    /**
     * Get the image dimensions for the original image.
     *
     * Fall back to using the WP_Image_Editor if the size is not stored in metadata
     *
     * @return array
     */
    private function get_original_image_dimensions() {
        $size = array();

        // try and get the image size from metadata
        $meta = wp_get_attachment_metadata( $this->id );

        if ( isset( $meta['width'], $meta['height'] ) ) {
            return $meta;
        }

        if ( $this->use_image_editor ) {
            // get the size from the image itself
            $image = wp_get_image_editor( $this->path );

            if ( ! is_wp_error( $image ) ) {
                $size = $image->get_size();
                return $size;
            }
        }

        return false;
    }


    /**
     * Return the file name for the required image size
     *
     * @param array $dest_size image dimensions (width/height) in pixels
     * @return string path and file name
     */
    private function get_destination_file_name( $dest_size ) {
        $info = pathinfo( $this->path );
        $dir = $info['dirname'];
        $ext = $info['extension'];
        $name = wp_basename( $this->path, ".$ext" );
        $dest_file_name = "{$dir}/{$name}-{$dest_size['width']}x{$dest_size['height']}.{$ext}";

        return $dest_file_name;
    }

    /**
     * Use WP_Image_Editor to create a resized image and return the URL for that image
     *
     * @param array   $orig_size
     * @param array   $dest_size
     * @return string
     */
    private function resize_image( $orig_size, $dest_size, $dest_file_name ) {
        // load image
        $image = wp_get_image_editor( $this->path );

        // editor will return an error if the path is invalid
        if ( is_wp_error( $image ) ) {
            return $this->url;
        }

        $crop_position = $this->get_crop_position();

        $dims = image_resize_dimensions( $orig_size['width'], $orig_size['height'], $dest_size['width'], $dest_size['height'], $crop_position );

        if ( $dims ) {
            list( $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h ) = $dims;
            $image->crop( $src_x, $src_y, $src_w, $src_h, $dst_w, $dst_h );
        }

        $saved = $image->save( $dest_file_name );

        if ( is_wp_error( $saved ) ) {
            return $this->url;
        }

        // Record the new size so that the file is correctly removed when the media file is deleted.
        $backup_sizes = get_post_meta( $this->id, '_wp_attachment_backup_sizes', true );

        if ( ! is_array( $backup_sizes ) ) {
            $backup_sizes = array();
        }

        $backup_sizes["resized-{$dest_size['width']}x{$dest_size['height']}"] = $saved;
        update_post_meta( $this->id, '_wp_attachment_backup_sizes', $backup_sizes );

        $url = str_replace( basename( $this->url ), basename( $saved['path'] ), $this->url );

        return $url;
    }


    /**
     * Get the image crop position
     *
     * @return array
     */
    private function get_crop_position() {

        $crop_position = get_post_meta( $this->id, 'ml-slider_crop_position', true );

        if ( $crop_position ) {

            $parts = explode( "-", $crop_position );

            if ( isset( $parts[0], $parts[1] ) ) {
                return array($parts[0], $parts[1]);
            }
        }

        // default
        return array('center', 'center');

    }
}