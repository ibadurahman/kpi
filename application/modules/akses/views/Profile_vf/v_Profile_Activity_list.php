<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>
<div class="m-list-timeline m-list-timeline--skin-light">
	<div class="m-list-timeline__items">
            <?php 
            foreach($DataActivity->result() as $row)
            {
                $TglLog = $row->LOG_DATE;
                $Activity = $row->ACTIVITY;
                $Data = json_decode($row->DATA,true);
                $TglConversi= formatTimeString($TglLog);
                //var_dump($Data);
                //echo strtolower($Activity);
                //echo strstr(strtolower($Activity), 'view');
                if(strstr(strtolower($Activity), 'delete'))
                {
                    $cls="m-list-timeline__badge--danger";
                }
                elseif(strstr(strtolower($Activity), 'insert'))
                {
                    $cls="m-list-timeline__badge--success";
                    $Activity = $row->ACTIVITY." code ".$Data['data_code'];
                }
                elseif(strstr(strtolower($Activity), 'view'))
                {
                    $cls="m-list-timeline__badge--accent";
                    $Activity = $row->ACTIVITY." code ".$Data['data_code'];
                }
                elseif(strstr(strtolower($Activity), 'edit'))
                {
                    $cls="m-list-timeline__badge--brand";
                    $Activity = $row->ACTIVITY." code ".$Data['data_code'];
                }
                else
                {
                    $cls="m-list-timeline__badge--info";
                }
                
            ?>
                <div class="m-list-timeline__item">
			<span class="m-list-timeline__badge <?php echo $cls; ?>"></span>
			<span class="m-list-timeline__text"><?php echo $Activity; ?></span>
			<span class="m-list-timeline__time"><?php echo $TglConversi; ?></span>
		</div>
            <?php
            }
            ?>
	</div>
</div>