function wpai_send_email($import_id)
{
    // Only send emails for import ID 47.
    if($import_id != "47")
        return;
    
    // Retrieve the last import run stats.
    global $wpdb;
    $table = $wpdb->prefix . "pmxi_imports";

    if ( $soflyyrow = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM `" . $table . "` WHERE `id` = '%d'", $import_id ) ) ) {
        
        $count = $soflyyrow->count;
        $imported = $soflyyrow->imported;
        $created = $soflyyrow->created;
        $updated = $soflyyrow->updated;
        $skipped = $soflyyrow->skipped;
        $deleted = $soflyyrow->deleted;

    }
    
    // Destination email address.
    $to = 'someone@somewhere.com';

    // Email subject.
    $subject = 'Feed Import ID: '.$import_id.' complete';

    // Email message.
    $body = "Import ID: " . $import_id . " has completed at " . date("Y-m-d H:m:s") . "\r\n" . 'File Records:' . $count . "\r\n".'Records Imported:' . $imported . "\r\n" . "Records Created:" . $created;
    $body .= "\r\n" . "Records Updated:" . $updated . "\r\n" . "Records Skipped:" . $skipped . "\r\n" . "Records Deleted:" . $deleted;

    // Send the email as HTML.
    $headers = array('Content-Type: text/html; charset=UTF-8');
 
    // Send via WordPress email.
    wp_mail( $to, $subject, $body, $headers );
}

add_action('pmxi_after_xml_import', 'wpai_send_email', 10, 1);
