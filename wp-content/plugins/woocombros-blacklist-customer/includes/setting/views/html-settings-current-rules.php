<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<input type="hidden" id="deleted-ids" name="deleted-ids" value="" />

<table class='form-table'>
    <tbody>
        <?php 
            $counter = 0; 
            foreach ( $saved_rules as $rule ) {
                $rule = (array)$rule;
        ?>
        <tr class="rule-row" id="rule-row-<?php echo $counter ?>">
            <th>Rule <?php echo ($counter+1) ?></th>
            <th>
                <?php echo $rule['rt'] . ' ' . $rule['m1'] . ' ' . $rule['val'] ?>
            </th>
            <td><button type="button" class="rule-delete" id="rule-delete-<?php echo $counter?>">Delete</button></td>
        </tr>
        <?php 
                $counter += 1;    
            }  
        ?> 
    </tbody>
</table>

<script type="text/javascript">
    jQuery(function() {
        
        jQuery(".rule-delete").click(function(event){
            var rule_num = event.target.id.split("-")[2];
            jQuery("#rule-row-"+rule_num).hide();
            jQuery("#deleted-ids").val(jQuery("#deleted-ids").val()+","+rule_num);
        });

    });
</script>