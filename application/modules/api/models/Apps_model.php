<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class apps_model extends CI_Model{
//    protected $db;
//    
//    public function __construct(){
//        parent::__construct();
//        $this->db = $this->koneksi_db->koneksi($this->session->userdata('nama_db'));
//        //$this->searching->SetDB($this->db);
//    }
    function insert($table,$data){
        $this->db->insert($table,$data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    function update($table,$where,$id,$data){
        $this->db->where($where,$id);
        $this->db->update($table,$data);
    }

    function verify_auth($Username,$UserAuth){
        $DataUser=$this->cek_UserAuth_db($Username,$UserAuth);
        
        if ( count($DataUser) > 0 ) {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    function cek_UserAuth_by_Username($Username)
    {
        $this->db->select("user.*,user_role.UserRole,user_role.Tipe");
        $this->db->from('user');
        $this->db->join('user_role','user_role.KodeUserRole=user.KodeUserRole','LEFT');
        $this->db->where('user.Username',$Username);

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        return $query->result();
    }

    function cek_UserAuth_by_Email($Email)
    {
        $this->db->select("user.*");
        $this->db->where('user.Email',$Email);

        $query = $this->db->get('user');
        return $query->result();
    }
    
    function cek_profile_by_Username($KodeMember){

        $this->db->select("member.*,
                          CONCAT(member.Nama,' ',IFNULL( member.NamaKeluarga,'')) as NamaLengkap,
                          property.NamaProperty,
                          agama.Agama,
                          tipe_perusahaan.TipePerusahaan,
                          bidang_usaha.BidangUsaha,
                          pendidikan.Pendidikan,
                          kota.Kota,
                          kota.KodeArea,
                          kota.KodeProvinsi,
                          provinsi.Provinsi,
                          kp.Kota as KotaPerusahaan,
                          kp.KodeArea as KodeAreaPerusahaan,
                          pp.Provinsi as ProvinsiPerusahaan,
                          user.Nama as NamaInput,
                          ue.Nama as NamaEdit,
                          ur.Password,
                          ur.Salt,
                          ur.PasswordCopy,
                          ur.JmlCharPass,
                          IFNULL(TblPoint.Point,'0') Point");
        $this->db->join('property','property.KodeProperty=member.KodeProperty');
        $this->db->join('agama','agama.KodeAgama=member.KodeAgama','LEFT');
        $this->db->join('tipe_perusahaan','tipe_perusahaan.KodeTipePerusahaan=member.KodeTipePerusahaan');
        $this->db->join('bidang_usaha','bidang_usaha.KodeBidangUsaha=member.KodeBidangUsaha','LEFT');
        $this->db->join('pendidikan','pendidikan.KodePendidikan=member.KodePendidikan','LEFT');
        $this->db->join('kota','kota.KodeKota=member.KodeKotaRumah','LEFT');
        $this->db->join('kota kp','kp.KodeKota=member.KodeKotaPerusahaan','LEFT');
        $this->db->join('provinsi','member.KodeProvinsiRumah=provinsi.KodeProvinsi','LEFT');
        $this->db->join('provinsi pp','member.KodeProvinsiPerusahaan=pp.KodeProvinsi','LEFT');
        $this->db->join('user','user.Username=member.UserInput','LEFT');
        $this->db->join('user ue','ue.Username=member.UserEdit','LEFT');
        $this->db->join('user ur','ur.KodeMember=member.KodeMember','LEFT');
        $this->db->join("(select member.KodeMember,
              IFNULL(SUM(productivity.PointAktual-productivity.PointPengurang-productivity.PointPengurangReg),'0') as Point
                        from member  INNER JOIN property ON member.KodeProperty=property.KodeProperty 
                LEFT JOIN productivity ON productivity.KodeMember=member.KodeMember
                        WHERE productivity.Status_id=1 AND (productivity.PointAktual-productivity.PointPengurang-productivity.PointPengurangReg) >= 0
                        group by member.KodeMember) TblPoint",'TblPoint.KodeMember=member.KodeMember','LEFT');
        
        $this->db->order_by('member.StatusInput ASC, member.StatusAktif DESC, member.KodeMember DESC, member.Nama ASC');

        $query = $this->db->get('member');
        return $query->result();
    }

    public function update_Password($Password,$Tabel,$Field,$Value){
        $PasswordEn= password_hash($Password, PASSWORD_BCRYPT);
        $Data= array(
            'Password'      =>$PasswordEn
        );
        $this->db->where($Field,$Value);
        $this->db->update($Tabel,$Data);
    }
    public function getdata($Username,$month_today,$year_today)
    {
       $sql="SELECT member.KodeMember, member.Nama, member.TanggalJoin, member.TglExp, member.Email, member.TglLahir, member.MailingAddress, 
            member.KodeTlpHP, member.HP, member.AlamatRumah1, member.AlamatRumah2, member.AlamatPerusahaan1, member.AlamatPerusahaan2, property.NamaProperty, property.Alamat,
            IFNULL((IFNULL(prod.PointProd,0)-IFNULL(tblredeem.PointRedeem,0))+IFNULL(ProdBulanIni.PointProd,0)-IFNULL(tblredeemIni.PointRedeem,0)-IFNULL(tblPendingIni.PointPending,0),0) as Point
                    FROM user  LEFT JOIN 
                    member ON user.KodeMember = member.KodeMember  LEFT JOIN 
                    property ON property.KodeProperty = member.KodeProperty 
                    LEFT JOIN (
                        select KodeMember,SUM(Point) as PointProd from productivity
                        where TanggalPosting < CURDATE() and Status_id=1
                        group by KodeMember
                    )prod ON member.KodeMember=prod.KodeMember
                    LEFT JOIN (
                        select redeem.KodeMember, SUM(redeem_detail.Quantity*redeem_detail.Point) as PointRedeem
                        from redeem INNER JOIN redeem_detail ON redeem.KodeRedeem=redeem_detail.KodeRedeem
                        where redeem.Tanggal < CURDATE() and (StatusPengajuan = 1 or StatusPengajuan = 3)
                        group by KodeMember
                    )tblredeem ON member.KodeMember=tblredeem.KodeMember
                    LEFT JOIN (
                        select KodeMember,SUM(Point) as PointProd from productivity
                        where MONTH(TanggalPosting)= ? and YEAR(TanggalPosting)= ? and Status_id=1
                        group by KodeMember
                    ) ProdBulanIni ON member.KodeMember=ProdBulanIni.KodeMember
                    LEFT JOIN (
                        select redeem.KodeMember, SUM(redeem_detail.Quantity*redeem_detail.Point) as PointRedeem
                        from redeem INNER JOIN redeem_detail ON redeem.KodeRedeem=redeem_detail.KodeRedeem
                        where MONTH(redeem.Tanggal)= ? and YEAR(redeem.Tanggal)= ? and (StatusPengajuan = 1 or StatusPengajuan = 3)
                        group by KodeMember
                    )tblredeemIni ON member.KodeMember=tblredeemIni.KodeMember
                    LEFT JOIN (
                        select redeem.KodeMember, SUM(redeem_detail.Quantity*redeem_detail.Point) as PointPending
                        from redeem INNER JOIN redeem_detail ON redeem.KodeRedeem=redeem_detail.KodeRedeem
                        where MONTH(redeem.Tanggal)= ? and YEAR(redeem.Tanggal)= ? and StatusPengajuan = 0
                        group by KodeMember
                    )tblPendingIni ON member.KodeMember=tblPendingIni .KodeMember
            WHERE user.Username = ? ";
       $binds = array($month_today,$year_today,$month_today,$year_today,$month_today,$year_today,$Username);
       $query = $this->db->query($sql, $binds)->result();
//       echo $this->db->last_query();
//        die();
       return $query;
    }
    public function get_Banner(){
        
        $this->db->select('banner.*,tipe_banner.TipeBanner');
        $this->db->from('banner');
        $this->db->join('tipe_banner','tipe_banner.KodeTipeBanner=banner.KodeTipeBanner','LEFT');
        $this->db->where("banner.KodeTipeBanner",1);
        $this->db->where("banner.Validity<=",date("Y-m-d"));
        
//        $this->searching->SetSerching($DataSearch);
        $Data=$this->db->get();
//        echo $this->db->last_query();
//        die();
        if($Data->num_rows()>0){
            $No=0;
            foreach($Data->result() as $RowData){
                $DataArr=array(
                                'KD_BANNER'            => $RowData->KodeBanner,
                                'TIPE_BANNER'            => $RowData->TipeBanner,
                                'IMAGE'            => base_url('asset/upload/banner/'.$RowData->LinkImage)
                            );
                $List[$No]=(object)$DataArr;
                $No++;
            }
            return $List;
        }else{
            $DataArr=array(
                                'KD_BANNER'            => NULL
                            );
            $List[0]=(object)$DataArr;
            return $List;
        }
    }
    function cek_UserAuth_db($Username,$UserAuth)
    {
        $this->config->load('ion_auth', TRUE);
        $identity_column = $this->config->item('identity', 'ion_auth');
        $identity_2_column = $this->config->item('identity_secondary', 'ion_auth');
                
        $this->db->select("users.*");
        $this->db->from('users');
        //$this->db->join('user_role','user_role.KodeUserRole=user.KodeUserRole','LEFT');
        $this->db->group_start();
        $this->db->where("users.".$identity_column,$Username);
        $this->db->or_where("users.".$identity_2_column,$Username);
        $this->db->group_end();
        $this->db->where('users.user_auth',$UserAuth);

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        return $query->result();
    }
    function user_role_api()
    {
        $this->db->select("groups.id,groups.name");
        $this->db->from('groups');

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        return $query;
    }
}

