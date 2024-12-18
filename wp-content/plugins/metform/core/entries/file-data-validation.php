<?php

namespace MetForm\Core\Entries;

defined('ABSPATH') || exit;

class File_Data_Validation
{
    /**
     * @var mixed
     */
    private static $fields_setting;

    /**
     * @var array
     */
    private static $response = [];

    /**
     * @param $fields_setting
     * @param $file_data
     */
    public static function validate($fields_setting, $file_data)
    {
        self::$fields_setting = $fields_setting;
        foreach ($file_data as $input_name => $file_data) {
            self::file_size_validation($input_name, $file_data);
            self::file_extension_validation($input_name, $file_data);
        }
        return self::$response;
    }

    /**
     * @param $input_name
     * @param $file_data
     */
    private static function file_size_validation($input_name, $file_data)
    {
        if(!isset(self::$fields_setting[$input_name])){
            self::$response[$input_name] = [esc_html__("No File found", 'metform')];
            return; 
        }
        $field_setting = self::$fields_setting[$input_name];
        $limit_status  = isset($field_setting->mf_input_file_size_status) && $field_setting->mf_input_file_size_status == 'on' ? true : false;
        if ($limit_status) {
            $file_size_limit = isset($field_setting->mf_input_file_size_limit) ? $field_setting->mf_input_file_size_limit : 128;
            $file_size       = is_array($file_data['size']) ? array_sum($file_data['size']) / 1024 : $file_data['size'] / 1024;
            if ($file_size > $file_size_limit) {
                // translators: Error message for file size limit. %s is the input name, %u is the file size limit in kilobytes.
                $error_message = sprintf(esc_html__('%$1s size cannot exceed %2$u kb.','metform'),
                    $input_name,         // Value for %s placeholder (input_name)
                    $file_size_limit     // Value for %u placeholder (file_size_limit)
                );

                self::$response[$input_name] = [$error_message];
            }
        }
    }
    /**
     * @param $input_name
     * @param $file_data
     * @return null
     */
    private static function file_extension_validation($input_name, $file_data)
    {
        if(!isset(self::$fields_setting[$input_name])){
            self::$response[$input_name] = [esc_html__("No File found", 'metform')];
            return; 
        }
        $field_setting      = self::$fields_setting[$input_name];
        $allowed_file_types = isset($field_setting->mf_input_file_types) ? $field_setting->mf_input_file_types : ['.jpg', '.jpeg', '.gif', '.png'];
        
        if(is_array($file_data['name'])){
            foreach ($file_data['name'] as $key => $value) {
                $file_extension = '.' . strtolower(pathinfo($value, PATHINFO_EXTENSION));
                if (in_array($file_extension, $allowed_file_types) === true && array_key_exists($file_extension, self::mimes()) === true) {
                    if (function_exists('finfo_open')) {
                        $mime_type = self::mimes()[$file_extension];
    
                        $finfo = finfo_open(FILEINFO_MIME);
                        $mime  = finfo_file($finfo, $file_data['tmp_name'][$key]);
                        finfo_close($finfo);
    
                        if (is_int(strpos($mime, $mime_type['mime']))) {
                            continue;
                        }
                    } else {
                        continue;
                    }
                }
                self::$response[$input_name] = 
                // translators: Error message for allowed file types. %1$s is the input name, %2$s is a list of allowed file types.
                [sprintf(esc_html__('%1$s only allow %2$s file types.','metform'), $input_name, implode(', ', $allowed_file_types) )];
                return;
            }
        }
    }

    /**
     * @return mixed
     */
    private static function mimes()
    {
        $mimes = [
            '.docx' => [
                'mime' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ],
            '.png'  => [
                'mime' => 'image/png'
            ],
            '.jpg'  => [
                'mime' => 'image/jpeg'
            ],
            '.jpeg' => [
                'mime' => 'image/jpeg'
            ],
            '.gif'  => [
                'mime' => 'image/gif'
            ],
            '.pdf'  => [
                'mime' => 'application/pdf'
            ],
            '.doc'  => [
                'mime' => 'application/msword'
            ],
            '.icon' => [
                'mime' => 'image/x-icon'
            ],
            '.pptx' => [
                'mime' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation'
            ],
            '.ppt'  => [
                'mime' => 'application/vnd.ms-powerpoint'
            ],
            '.pps'  => [
                'mime' => 'application/vnd.ms-powerpoint'
            ],
            '.ppsx' => [
                'mime' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation'
            ],
            '.odt'  => [
                'mime' => 'application/vnd.oasis.opendocument.text'
            ],
            '.xls'  => [
                'mime' => 'application/vnd.ms-excel'
            ],
            '.xlsx' => [
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ],
            '.psd'  => [
                'mime' => 'image/vnd.adobe.photoshop'
            ],
            '.mp3'  => [
                'mime' => 'audio/mpeg'
            ],
            '.m4a'  => [
                'mime' => 'audio/x-m4a'
            ],
            '.ogg'  => [
                'mime' => 'audio/ogg'
            ],
            '.wav'  => [
                'mime' => 'audio/x-wav'
            ],
            '.mp4'  => [
                'mime' => 'video/mp4'
            ],
            '.m4v'  => [
                'mime' => 'video/x-m4v'
            ],
            '.mov'  => [
                'mime' => 'video/quicktime'
            ],
            '.wmv'  => [
                'mime' => 'video/x-ms-asf'
            ],
            '.avi'  => [
                'mime' => 'video/x-msvideo'
            ],
            '.mpg'  => [
                'mime' => 'video/mpeg'
            ],
            '.ogv'  => [
                'mime' => 'video/ogg'
            ],
            '.3gp'  => [
                'mime' => 'video/3gpp'
            ],
            '.3g2'  => [
                'mime' => 'video/3gpp2'
            ],
            '.zip'  => [
                'mime' => 'application/zip'
            ],
            '.csv'  => [
                'mime' => 'text/plain'
            ],
            '.stl'  => [
                'mime' => 'application/octet-stream'
            ],
            '.stp'  => [
                'mime' => 'text/plain; charset=us-ascii'
            ]
        ];
        return $mimes;
    }

    /**
     * Check every file widget is there any invalid large files uploaded by user
     * @param $mf_files
     * @param $file_data
     * @param $fields
     * @return array
     */
    public static function check_files( array $mf_files, array $file_data, array $fields ): array
    {
           
            foreach ($mf_files as $index => $single_file_widget) {

                $s_files = $file_data[$single_file_widget] ?? [];

                // if single file upload 
                if (isset($file_data[$single_file_widget]) && !is_array($file_data[$single_file_widget]['error'])) {

                    if (($file_data[$single_file_widget]['error']) == UPLOAD_ERR_NO_FILE) {
                        continue;
                    }

                    if (($file_data[$single_file_widget]['error']) == UPLOAD_ERR_INI_SIZE) {
                        self::$response['status'] = 0;
                        self::$response['error'] = esc_html__($s_files['name'] . ' file size exceeded ' . size_format(wp_max_upload_size(), 2), 'metform');
                        return self::$response; 
                    }
                }
                // if multiple file upload is enabled
                foreach ($s_files['error'] as $key => $sf) {

                    if (($sf) == UPLOAD_ERR_NO_FILE) {
                        continue;
                    }
                    if (($sf) == UPLOAD_ERR_INI_SIZE) {
                        self::$response['status'] = 0;
                        self::$response['error'] = esc_html__($s_files['name'][$key] . ' file size exceeded ' . size_format(wp_max_upload_size(), 2), 'metform');
                        return self::$response;
                    }

                }
            }
            return self::$response;
    }
}