<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function get_menu_parent_aktif($Limit=NULL,$Offset=NULL){
        
        $this->db->select("menu.*");
        $this->db->from('menu');
        $this->db->where('menu.Level','1');
        $this->db->where('menu.status_show','1');
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_quick_menu_aktif($Limit=NULL,$Offset=NULL){
        
        $this->db->select("menu.*");
        $this->db->from('menu');
        $this->db->where('menu.quick_menu','1');
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    
    public function get_quick_menu_aktif_permission($user_id){
        
        $sql="select menu.* from menu where kd_menu in (select  permission.kd_menu
                        from users_groups
                        left join groups on users_groups.group_id = groups.id
                        left join perms_groups on groups.id = perms_groups.id_groups
                        left join permission on permission.kd_permission = perms_groups.kd_permission
                        where users_groups.user_id = ?)";
        $bind= [$user_id];
        $query = $this->db->query($sql,$bind);
        return $query;
        
    }
    public function get_menu_child_aktif_all($Limit=NULL,$Offset=NULL){
        
        $this->db->select("menu.*");
        $this->db->from('menu');
        $this->db->where('menu.Level >','1');
        $this->db->where('menu.status_show','1');
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_menu_parent_aktif_permission($user_id){
        
//        $sql="select * from(
//                        select @pv:=concat(@pv,',',ifnull(tabel.kd_menu_parent,0)) as kode_parent,tabel.* 
//                        from ( select * from menu order by kd_menu desc) as tabel
//                        join
//                        (select @pv:=(select GROUP_CONCAT(kd_menu) from menu where kd_menu in (select  permission.kd_menu
//                        from users_groups
//                        left join groups on users_groups.group_id = groups.id
//                        left join perms_groups on groups.id = perms_groups.id_groups
//                        left join permission on permission.kd_permission = perms_groups.kd_permission
//                        where users_groups.user_id = ?)))tmp
//                        where FIND_IN_SET(tabel.kd_menu, @pv)
//                        ) as akses_menu
//                        where kd_menu_parent is null or kd_menu_parent = 0 
//                        order by akses_menu.order";
        
        $sql="select * from(
                        select @pv:=concat(@pv,',',ifnull(tbl_baru.kd_menu_parent,0)) as kode_parent,tbl_baru.* 
                        from(
                        select *
                        from ( select * from menu order by kd_menu) as tabel 
                                join (
                                        select @pv:=(select GROUP_CONCAT(kd_menu) 
                                        from menu 
                                        where kd_menu in (
                                                        select permission.kd_menu 
                                                        from users_groups 
                                                        left join groups on users_groups.group_id = groups.id 
                                                        left join perms_groups on groups.id = perms_groups.id_groups 
                                                        left join permission on permission.kd_permission = perms_groups.kd_permission 
                                                        where users_groups.user_id = ?
                                        )
                                        )
                                )tmp
                                order by tabel.kd_menu_parent desc
                        )as tbl_baru
                        where FIND_IN_SET(tbl_baru.kd_menu, @pv) 
                        ) as akses_menu
                        where kd_menu_parent is null or kd_menu_parent = 0 
                        order by akses_menu.order";
        $bind= [$user_id];
        $query = $this->db->query($sql,$bind);
//        echo $this->db->last_query();
//        die();
        return $query;
        
    }
    public function get_menu_child_aktif_permission($user_id){
        
//        $sql="select * from(
//                    select @pv:=concat(@pv,',',ifnull(tabel.kd_menu_parent,0)) as kode_parent,tabel.* 
//                    from ( select * from menu order by kd_menu desc) as tabel
//                    join
//                    (select @pv:=(select GROUP_CONCAT(kd_menu) from menu where kd_menu in (select  permission.kd_menu
//                    from users_groups
//                    left join groups on users_groups.group_id = groups.id
//                    left join perms_groups on groups.id = perms_groups.id_groups
//                    left join permission on permission.kd_permission = perms_groups.kd_permission
//                    where users_groups.user_id = ?)))tmp
//                    where FIND_IN_SET(tabel.kd_menu, @pv)
//                    ) as akses_menu
//                    where kd_menu_parent is not null order by akses_menu.kd_menu_parent, akses_menu.order";
        $sql="select * from(
                    select @pv:=concat(@pv,',',ifnull(tbl_baru.kd_menu_parent,0)) as kode_parent,tbl_baru.* 
                        from(
                        select *
                        from ( select * from menu order by kd_menu) as tabel 
                                join (
                                        select @pv:=(select GROUP_CONCAT(kd_menu) 
                                        from menu 
                                        where kd_menu in (
                                                        select permission.kd_menu 
                                                        from users_groups 
                                                        left join groups on users_groups.group_id = groups.id 
                                                        left join perms_groups on groups.id = perms_groups.id_groups 
                                                        left join permission on permission.kd_permission = perms_groups.kd_permission 
                                                        where users_groups.user_id = ?
                                        )
                                        )
                                )tmp
                                order by tabel.kd_menu_parent desc
                        )as tbl_baru
                        where FIND_IN_SET(tbl_baru.kd_menu, @pv) 
                    ) as akses_menu
                    where kd_menu_parent is not null order by akses_menu.kd_menu_parent, akses_menu.order";
        $bind= [$user_id];
        $query = $this->db->query($sql,$bind);
        return $query;
        
    }
    public function get_menu_child_hirarki_by_parent($kd_menu_parent){
        
        $sql='select @pv:=kd_menu as kd_temp,menu.* from menu
                join
                (select @pv:='.$kd_menu_parent.')tmp
                where kd_menu_parent=@pv';
        
        $query = $this->db->query($sql);
        return $query;
    }
    public function get_menu_all($Limit=NULL,$Offset=NULL){
        
        $this->db->select("menu.*");
        $this->db->from('menu');
        $this->db->where('menu.status_show','1');
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_menu_parent($Limit=NULL,$Offset=NULL){
        
        $this->db->select("menu.*");
        $this->db->from('menu');
        $this->db->where('menu.Level','1');
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_menu_child_all($Limit=NULL,$Offset=NULL){
        
        $this->db->select("menu.*");
        $this->db->from('menu');
        $this->db->where('menu.Level >','1');
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_menu_by_code($kd_menu){
        
        $this->db->select(  "menu.kd_menu,". 
                            "menu.order,".
                            "menu.menu,".
                            "menu.level,".
                            "menu.icon,".
                            "menu.link,".
                            "menu.status_show,".
                            "menu.quick_menu,".
                            "menu.icon_quick,".
                            "menu.stat_section,".
                            "menu.kd_menu_parent as kd_menu_parent_real,".
                            "mn.level as parent_level");
        $this->db->from('menu');
        $this->db->join('menu mn','mn.kd_menu = menu.kd_menu_parent','LEFT');
        $this->db->where('menu.kd_menu',$kd_menu);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_permission_menu($user_id,$kd_permission){
        
        $this->db->select(  "permission.*");
        $this->db->from('users_groups');
        $this->db->join('groups','users_groups.group_id = groups.id','LEFT');
        $this->db->join('perms_groups','groups.id = perms_groups.id_groups','LEFT');
        $this->db->join('permission','permission.kd_permission = perms_groups.kd_permission','LEFT');
        $this->db->where('users_groups.user_id',$user_id);
        $this->db->where('permission.kd_permission',$kd_permission);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function insert_menu($data){
       $this->db->insert('menu',$data);
       return $this->db->insert_id();
    }
    
    public function update_menu($kd_menu,$data){
        $this->db->where('kd_menu',$kd_menu);
        $this->db->update('menu',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
    public function delete_menu($kd_menu){
       $this->db->where('kd_menu',$kd_menu);
       $this->db->delete('menu');
    }
}
