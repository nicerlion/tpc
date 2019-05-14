<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<input type="hidden" id="deleted-ids" name="deleted-ids" value="" />

<table>
    <?php 
        foreach ($violations as $violation) {
            $violation_id = $violation->ID;
            $violation_content = unserialize(base64_decode($violation->post_content));
    ?>
    <tr id="violation-row-<?php echo $violation_id ?>">
        <td>
<pre>
<b>Rule: </b><?php echo $violation_content->rule_val ?>            
<b>Customer Name: </b><?php echo $violation_content->customer_name ?>            
<b>Customer Billing Address: </b><?php echo $violation_content->customer_address ?>            
<b>Purchase Date: </b><?php echo $violation_content->date ?>            
</pre>            
        </td>
        <td><button type="button" class="rule-delete" id="rule-delete-<?php echo $violation_id?>">Delete</button></td>
    </tr>
    <?php 
        } ?>
</table>

<script type="text/javascript">
    jQuery(function() {
        
        jQuery(".rule-delete").click(function(event){
            var rule_num = event.target.id.split("-")[2];
            jQuery("#violation-row-"+rule_num).hide();
            jQuery("#deleted-ids").val(jQuery("#deleted-ids").val()+","+rule_num);
        });

    });
</script>

