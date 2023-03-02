<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>
<div class="m-list-timeline m-list-timeline--skin-light">
	<div class="m-list-timeline__items">
            <?php 
            foreach($DataNotifikasi->result() as $row)
            {
                $TglLog = strtotime($row->tgl_input);
                $Activity = $row->pesan;
                //$Data = json_decode($row->DATA,true);
                $TglConversi= formatTimeString($TglLog);
                //var_dump($Data);
                //echo strtolower($Activity);
                //echo strstr(strtolower($Activity), 'view');
                
            ?>
                <div class="m-list-timeline__item">
			<span class="m-list-timeline__badge"></span>
			<span class="m-list-timeline__text"><a href="<?php echo site_url($row->link); ?>" class="m-link reminder-link" ><?php echo $Activity; ?></a></span>
			<span class="m-list-timeline__time"><?php echo $TglConversi; ?></span>
		</div>
            <?php
            }
            ?>
	</div>
</div>