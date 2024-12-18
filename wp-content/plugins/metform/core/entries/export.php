<?php

namespace MetForm\Core\Entries;

use MetForm\Traits\Singleton;

defined('ABSPATH') || exit;

class Export {

	use Singleton;
    
    public function export_data($form_id)
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $fields = Action::instance()->get_fields($form_id);
        $title = get_the_title($form_id);

        global $wpdb;
        $entries = $wpdb->get_results($wpdb->prepare("SELECT `post_id`  FROM `" . $wpdb->prefix . "postmeta` WHERE `meta_key` = 'metform_entries__form_id' AND `meta_value` = %d", $form_id), OBJECT);
        $entries = (is_array($entries)) ? $entries : [];
        $export = [];
        $header = [];

        foreach ($entries as $entry) {
            $entry_modify = [];

            $form_entry = get_post_meta($entry->post_id, 'metform_entries__form_data', true);
            $form_entry = (is_array($form_entry) ? $form_entry : []);
            $file_entry = get_post_meta($entry->post_id, 'metform_entries__file_upload_new', true);
            $file_entry = (is_array($file_entry) ? $file_entry : []);

            $entry_data = array_merge($form_entry, $file_entry);
            $entry_data = (is_array($entry_data)) ? $entry_data : [];

            $entry_modify['ID'] = $entry->post_id;
            $header['__id'] = 'ID';

            foreach ($fields as $key => $value) {
                $header_key = (($value->mf_input_name != '') ? htmlspecialchars($value->mf_input_name) : $key);
                $header[$header_key] = empty($value->mf_input_label) ? $key : htmlspecialchars($value->mf_input_label);

                if ($value->widgetType == 'mf-file-upload' && isset($entry_data[$key])) {
                    $entry_modify[$header_key] = (isset($entry_data[$key]) ? ((isset($entry_data[$key]['url'])) ? $entry_data[$key]['url'] : ' ') : ' ');
                    for ($index = 0; $index < isset( $entry_data[$key] ) && is_array($entry_data[$key]) ? count($entry_data[$key]) : 0 ; $index++) {
                        $entry_modify[$header_key] .= (esc_url($entry_data[$key][$index]['url']) . " \n");
                    }
                } else if ($value->widgetType == 'mf-simple-repeater') {
                    $data_string = '';
                    if (is_array($entry_data[$key])) {
                        foreach ($entry_data[$key] as $key => $value) {
                            $data_string .= htmlspecialchars($key) . ": " . htmlspecialchars($value) . " \n";
                        }
                    }
                    $entry_modify[$header_key] = $data_string;
                } else {
                    $entry_modify[$header_key] = (isset($entry_data[$key]) ? ((is_array($entry_data[$key])) ? implode(', ', $entry_data[$key]) : ($entry_data[$key])) : ' ');
                }

                // Prevent CSV injection by prefixing a single quote to values that begin with '=', '+', '-', '@'
                if (preg_match('/^(\=|\+|\-|\@)/', $entry_modify[$header_key])) {
                    $entry_modify[$header_key] = "'" . ltrim($entry_modify[$header_key], '='); // ltrim remove the equal sign from the formula  `=HYPERLINK()` will be `HYPERLINK()`
                }
            }

            $entry_modify['DATE'] = get_the_date('d-m-Y', $entry->post_id);
            $export[] = $entry_modify;
            $header['__dt'] = 'DATE';
        }

        $file_name = $title . "-export-" . time() . ".csv";
        // Sanitize the file name to prevent directory traversal
        $file_name = sanitize_file_name($file_name);

        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header("Content-type: text/csv");
        // Sanitize the file name to prevent CSV injection
        header("Content-Disposition: attachment; filename=\"" . str_replace(array('"', "'", "\\", "\0"), '', $file_name) . "\"");
        header("Expires: 0");
        header("Pragma: public");
        $file_pointer = @fopen('php://output', 'w');
        $csv_header = false;

        // sort data
        usort($export, function ($item1, $item2) {
            return $item1['ID'] <=> $item2['ID'];
        });

        foreach ($export as $data) {
            // Add a header row if it hasn't been added yet
            if (!$csv_header) {
                // Use the keys from $data as the titles
                // Sanitize the header row to prevent CSV injection
                fputcsv($file_pointer, array_map(function ($value) {
                    return str_replace(array('"', "'", "\\", "\0"), '', $value);
                }, $header));
                $csv_header = true;
            }
            // Sanitize the data to prevent CSV injection
            $sanitized_data = array_map(function ($value) {
                return str_replace(array('"', "'", "\\", "\0"), '', $value);
            }, $data);
            // Put the sanitized data into the stream
            fputcsv($file_pointer, $sanitized_data);
        }
        // Close the file
        fclose($file_pointer);
        exit;
    }
}