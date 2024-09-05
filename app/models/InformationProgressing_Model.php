<?php


class InformationProgressing_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getInformationProgressing($data)
    {
 
            $lb_Lokasi = $data['lb_Lokasi'];
            $Info_Date_Start = $data['Info_Date_Start'];
            $Info_Date_End = $data['Info_Date_End'];
            $Info_Date_StartKontrak = $data['Info_Date_StartKontrak'];
            $Info_Date_StartKontrak_minsatu =Utils::getDayBeforeperiode($Info_Date_Start);
            $kd_mou = $data['kd_mou'];
            $Info_Tipe = $data['Info_Tipe']; 

            if($Info_Tipe == "1"){
                $query =    "SELECT URUT,KD_JO,KD_MOU,NM_WBS WBS_NAME,KD_WBS,SUM_QTY QTY, 
QTY_PROGRESS_MATERIAL_PREV,QTY_PROGRESS_DIRECT_PREV,
CASE WHEN A.KD_LEVEL='10' AND KET='DETIL' THEN QTY_PROG_HDR_MATERIAL ELSE QTY_PROG_DTL_MATERIAL+QTY_PROG_HDR_MATERIAL END QTY_PROGRESS_MATERIAL, 
CASE WHEN A.KD_LEVEL='10' AND KET='DETIL' THEN QTY_PROG_HDR_DIRECT ELSE QTY_PROG_DTL_DIRECT+QTY_PROG_HDR_DIRECT END QTY_PROGRESS_DIRECT,
PROGRES_QTY_MATERIAL PROGRESS_UNIT_MATERIAL,PROGRES_QTY_DIRECT PROGRESS_UNIT_DIRECT,KET
FROM GENPROGRES ('$lb_Lokasi','$Info_Date_Start','$Info_Date_End') A 
LEFT JOIN P_P_WBS_BOQ B ON A.KD_MOU=B.ID_MOU AND A.KD_TRS=B.KODE_TRANSAKSI AND A.KD_WBS=B.ID_WBS
INNER JOIN ( 

select URUT URUT_C,KD_MOU KD_MOU_C,KD_WBS KD_WBS_C,
CASE WHEN KD_LEVEL='10' AND KET='DETIL' THEN QTY_PROG_HDR_MATERIAL ELSE QTY_PROG_DTL_MATERIAL+QTY_PROG_HDR_MATERIAL END QTY_PROGRESS_MATERIAL_PREV, 
CASE WHEN KD_LEVEL='10' AND KET='DETIL' THEN QTY_PROG_HDR_DIRECT ELSE QTY_PROG_DTL_DIRECT+QTY_PROG_HDR_DIRECT END QTY_PROGRESS_DIRECT_PREV,
PROGRES_MATERIAL PROGRES_MATERIAL_PREV, PROGRES_DIRECT PROGRES_DIRECT_PREV,PROGRES_QTY_MATERIAL PROGRESS_UNIT_MATERIAL_PREV,PROGRES_QTY_DIRECT PROGRESS_UNIT_DIRECT_PREV,PAYMENT_TOTAL PAYMENT_TOTAL_PREV
FROM  GENPROGRES ('$lb_Lokasi','$Info_Date_StartKontrak','$Info_Date_StartKontrak_minsatu')) C ON C.URUT_C=A.URUT AND C.KD_WBS_C=A.KD_WBS AND C.KD_MOU_C=A.KD_MOU

WHERE KD_MOU='$kd_mou'
";
                $this->db->query($query);
                $data =  $this->db->resultSet();
                $rows = array();
                foreach ($data as $key) {
                    $pasing['URUT'] = $key['URUT'];
                    $pasing['QTY'] = $key['QTY'];
                    $pasing['KD_MOU'] = $key['KD_MOU'];
                    $pasing['KD_WBS'] = $key['KD_WBS'];
                    $pasing['WBS_NAME'] = $key['WBS_NAME'];
                    $pasing['KD_JO'] = $key['KD_JO'];
                    $pasing['QTY_PROGRESS_MATERIAL_PREV'] = $key['QTY_PROGRESS_MATERIAL_PREV'];
                    $pasing['QTY_PROGRESS_DIRECT_PREV'] = $key['QTY_PROGRESS_DIRECT_PREV'];
                    $pasing['QTY_PROGRESS_MATERIAL'] = $key['QTY_PROGRESS_MATERIAL'];
                    $pasing['QTY_PROGRESS_DIRECT'] = $key['QTY_PROGRESS_DIRECT'];
                    $pasing['PROGRESS_UNIT'] = $key['PROGRESS_UNIT_DIRECT'];
                    $pasing['KET'] = $key['KET'];
                    $pasing['PROGRESS_UNIT_MATERIAL'] = $key['PROGRESS_UNIT_MATERIAL'];
                
                    $rows[] = $pasing;
                }
                return $rows;
            } elseif ($Info_Tipe == "2") {
                $query =    "SELECT URUT,KD_JO,KD_MOU,NM_WBS WBS_NAME,KD_WBS,SUM_QTY QTY, WF_MATERIAL,WF_DIRECT,
                                PROGRES_MATERIAL_PREV,PROGRES_DIRECT_PREV, 
                                PROGRES_MATERIAL,PROGRES_DIRECT, KET
                                FROM GENPROGRES ('$lb_Lokasi','$Info_Date_Start','$Info_Date_End')  A 
                                LEFT JOIN P_P_WBS_BOQ B ON A.KD_MOU=B.ID_MOU AND A.KD_TRS=B.KODE_TRANSAKSI AND A.KD_WBS=B.ID_WBS
                                LEFT JOIN ( 
                                select URUT URUT_C,KD_MOU KD_MOU_C,KD_WBS KD_WBS_C,
                                CASE WHEN KD_LEVEL='10' AND KET='DETIL' THEN QTY_PROG_HDR_MATERIAL ELSE QTY_PROG_DTL_MATERIAL+QTY_PROG_HDR_MATERIAL END QTY_PROGRESS_MATERIAL_PREV, 
                                CASE WHEN KD_LEVEL='10' AND KET='DETIL' THEN QTY_PROG_HDR_DIRECT ELSE QTY_PROG_DTL_DIRECT+QTY_PROG_HDR_DIRECT END QTY_PROGRESS_DIRECT_PREV,
                                PROGRES_MATERIAL PROGRES_MATERIAL_PREV, PROGRES_DIRECT PROGRES_DIRECT_PREV,PROGRES_QTY_MATERIAL PROGRESS_UNIT_MATERIAL_PREV,PROGRES_QTY_DIRECT PROGRESS_UNIT_DIRECT_PREV,PAYMENT_TOTAL PAYMENT_TOTAL_PREV
                                FROM  GENPROGRES ('$lb_Lokasi','$Info_Date_StartKontrak','$Info_Date_StartKontrak_minsatu ')) C ON C.URUT_C=A.URUT AND C.KD_WBS_C=A.KD_WBS AND C.KD_MOU_C=A.KD_MOU
                                WHERE KD_MOU='$kd_mou'";
                $this->db->query($query);
                $data =  $this->db->resultSet();
                $rows = array();
                foreach ($data as $key) {
                    $pasing['URUT'] = $key['URUT'];
                    $pasing['QTY'] = $key['QTY'];
                    $pasing['KD_MOU'] = $key['KD_MOU'];
                    $pasing['KD_WBS'] = $key['KD_WBS'];
                    $pasing['WBS_NAME'] = $key['WBS_NAME'];
                    $pasing['KD_JO'] = $key['KD_JO']; 
                    $pasing['WF_MATERIAL'] = $key['WF_MATERIAL'];
                    $pasing['WF_DIRECT'] = $key['WF_DIRECT'];
                    $pasing['PROGRES_MATERIAL_PREV'] = $key['PROGRES_MATERIAL_PREV'];
                    $pasing['PROGRES_DIRECT_PREV'] = $key['PROGRES_DIRECT_PREV'];
                    $pasing['PROGRES_DIRECT'] = $key['PROGRES_DIRECT'];
                $pasing['PROGRES_MATERIAL'] = $key['PROGRES_MATERIAL']; 
                    $pasing['KET'] = $key['KET'];

                    $rows[] = $pasing;
                }
                return $rows;
            } elseif ($Info_Tipe == "3") {
            $query =    "SELECT URUT,KD_JO,KD_MOU,NM_WBS WBS_NAME,KD_WBS,SUM_QTY QTY, 
                        CASE WHEN A.KD_LEVEL='10' AND KET='DETIL' THEN GRAND_TOTAL_MATERIAL ELSE a.GRAND_TOTAL_MATERIAL+a.SUB_TOTAL_MATERIAL END PRICE_MATERIAL,
                        CASE WHEN A.KD_LEVEL='10' AND KET='DETIL' THEN GRAND_TOTAL_DIRECT ELSE a.GRAND_TOTAL_DIRECT+a.SUB_TOTAL_DIRECT END PRICE_DIRECT,
                        CASE WHEN A.KD_LEVEL='10' AND KET='DETIL' THEN GRAND_TOTAL_MATERIAL+GRAND_TOTAL_DIRECT ELSE a.GRAND_TOTAL_MATERIAL+a.SUB_TOTAL_MATERIAL+a.GRAND_TOTAL_DIRECT+a.SUB_TOTAL_DIRECT 
                        END GRAND_TOTAL,
                        PAYMENT_MATERIAL_PREV,PAYMENT_DIRECT_PREV, PAYMENT_TOTAL_PREV,
                        PAYMENT_MATERIAL,PAYMENT_DIRECT,PAYMENT_TOTAL , KET
                        FROM GENPROGRES ('$lb_Lokasi','$Info_Date_Start','$Info_Date_End') A 
                        LEFT JOIN P_P_WBS_BOQ B ON A.KD_MOU=B.ID_MOU AND A.KD_TRS=B.KODE_TRANSAKSI AND A.KD_WBS=B.ID_WBS
                        LEFT JOIN ( 
                        select URUT URUT_C,KD_MOU KD_MOU_C,KD_WBS KD_WBS_C,
                        CASE WHEN KD_LEVEL='10' AND KET='DETIL' THEN QTY_PROG_HDR_MATERIAL ELSE QTY_PROG_DTL_MATERIAL+QTY_PROG_HDR_MATERIAL END QTY_PROGRESS_MATERIAL_PREV, 
                        CASE WHEN KD_LEVEL='10' AND KET='DETIL' THEN QTY_PROG_HDR_DIRECT ELSE QTY_PROG_DTL_DIRECT+QTY_PROG_HDR_DIRECT END QTY_PROGRESS_DIRECT_PREV,
                        PROGRES_MATERIAL PROGRES_MATERIAL_PREV, PROGRES_DIRECT PROGRES_DIRECT_PREV,PROGRES_QTY_MATERIAL PROGRESS_UNIT_MATERIAL_PREV,PROGRES_QTY_DIRECT PROGRESS_UNIT_DIRECT_PREV,
                        PAYMENT_MATERIAL PAYMENT_MATERIAL_PREV,
                        PAYMENT_DIRECT PAYMENT_DIRECT_PREV,PAYMENT_TOTAL PAYMENT_TOTAL_PREV
                        FROM  GENPROGRES ('$lb_Lokasi','$Info_Date_StartKontrak','$Info_Date_StartKontrak_minsatu ')) C ON C.URUT_C=A.URUT AND C.KD_WBS_C=A.KD_WBS AND C.KD_MOU_C=A.KD_MOU
                        WHERE KD_MOU='$kd_mou'";
            $this->db->query($query);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['URUT'] = $key['URUT'];
                $pasing['QTY'] = $key['QTY'];
                $pasing['KD_MOU'] = $key['KD_MOU'];
                $pasing['KD_WBS'] = $key['KD_WBS'];
                $pasing['WBS_NAME'] = $key['WBS_NAME'];
                $pasing['KD_JO'] = $key['KD_JO'];
                $pasing['QTY'] = $key['QTY'];
                $pasing['PRICE_MATERIAL'] = $key['PRICE_MATERIAL'];
                $pasing['PRICE_DIRECT'] = $key['PRICE_DIRECT'];
                $pasing['GRAND_TOTAL'] = $key['GRAND_TOTAL'];
                $pasing['PAYMENT_MATERIAL_PREV'] = $key['PAYMENT_MATERIAL_PREV'];
                $pasing['PAYMENT_DIRECT_PREV'] = $key['PAYMENT_DIRECT_PREV'];
                $pasing['PAYMENT_TOTAL_PREV'] = $key['PAYMENT_TOTAL_PREV'];
                $pasing['PAYMENT_MATERIAL'] = $key['PAYMENT_MATERIAL'];
                $pasing['PAYMENT_DIRECT'] = $key['PAYMENT_DIRECT'];
                $pasing['PAYMENT_TOTAL'] = $key['PAYMENT_TOTAL'];
                $pasing['KET'] = $key['KET'];
                $rows[] = $pasing;
            }
            return $rows;
            } elseif ($Info_Tipe == "3") {
            $query =    "SELECT URUT,KD_JO,KD_MOU,NM_WBS WBS_NAME,KD_WBS,SUM_QTY QTY, 
                        CASE WHEN A.KD_LEVEL='10' AND KET='DETIL' THEN GRAND_TOTAL_MATERIAL ELSE a.GRAND_TOTAL_MATERIAL+a.SUB_TOTAL_MATERIAL END PRICE_MATERIAL,
                        CASE WHEN A.KD_LEVEL='10' AND KET='DETIL' THEN GRAND_TOTAL_DIRECT ELSE a.GRAND_TOTAL_DIRECT+a.SUB_TOTAL_DIRECT END PRICE_DIRECT,
                        CASE WHEN A.KD_LEVEL='10' AND KET='DETIL' THEN GRAND_TOTAL_MATERIAL+GRAND_TOTAL_DIRECT ELSE a.GRAND_TOTAL_MATERIAL+a.SUB_TOTAL_MATERIAL+a.GRAND_TOTAL_DIRECT+a.SUB_TOTAL_DIRECT 
                        END GRAND_TOTAL,
                        PAYMENT_MATERIAL_PREV,PAYMENT_DIRECT_PREV, PAYMENT_TOTAL_PREV,
                        PAYMENT_MATERIAL,PAYMENT_DIRECT,PAYMENT_TOTAL , KET
                        FROM GENPROGRES ('$lb_Lokasi','$Info_Date_Start','$Info_Date_End') A 
                        LEFT JOIN P_P_WBS_BOQ B ON A.KD_MOU=B.ID_MOU AND A.KD_TRS=B.KODE_TRANSAKSI AND A.KD_WBS=B.ID_WBS
                        LEFT JOIN ( 
                        select URUT URUT_C,KD_MOU KD_MOU_C,KD_WBS KD_WBS_C,
                        CASE WHEN KD_LEVEL='10' AND KET='DETIL' THEN QTY_PROG_HDR_MATERIAL ELSE QTY_PROG_DTL_MATERIAL+QTY_PROG_HDR_MATERIAL END QTY_PROGRESS_MATERIAL_PREV, 
                        CASE WHEN KD_LEVEL='10' AND KET='DETIL' THEN QTY_PROG_HDR_DIRECT ELSE QTY_PROG_DTL_DIRECT+QTY_PROG_HDR_DIRECT END QTY_PROGRESS_DIRECT_PREV,
                        PROGRES_MATERIAL PROGRES_MATERIAL_PREV, PROGRES_DIRECT PROGRES_DIRECT_PREV,PROGRES_QTY_MATERIAL PROGRESS_UNIT_MATERIAL_PREV,PROGRES_QTY_DIRECT PROGRESS_UNIT_DIRECT_PREV,
                        PAYMENT_MATERIAL PAYMENT_MATERIAL_PREV,
                        PAYMENT_DIRECT PAYMENT_DIRECT_PREV,PAYMENT_TOTAL PAYMENT_TOTAL_PREV
                        FROM  GENPROGRES ('$lb_Lokasi','$Info_Date_StartKontrak','$Info_Date_StartKontrak_minsatu ')) C ON C.URUT_C=A.URUT AND C.KD_WBS_C=A.KD_WBS AND C.KD_MOU_C=A.KD_MOU
                        WHERE KD_MOU='$kd_mou'";
            $this->db->query($query);
            $data =  $this->db->resultSet();
            $rows = array();
                    foreach ($data as $key) {
                        $pasing['URUT'] = $key['URUT'];
                        $pasing['QTY'] = $key['QTY'];
                        $pasing['KD_MOU'] = $key['KD_MOU'];
                        $pasing['KD_WBS'] = $key['KD_WBS'];
                        $pasing['WBS_NAME'] = $key['WBS_NAME'];
                        $pasing['KD_JO'] = $key['KD_JO'];
                        $pasing['QTY'] = $key['QTY'];
                        $pasing['PRICE_MATERIAL'] = $key['PRICE_MATERIAL'];
                        $pasing['PRICE_DIRECT'] = $key['PRICE_DIRECT'];
                        $pasing['GRAND_TOTAL'] = $key['GRAND_TOTAL'];
                        $pasing['PAYMENT_MATERIAL_PREV'] = $key['PAYMENT_MATERIAL_PREV'];
                        $pasing['PAYMENT_DIRECT_PREV'] = $key['PAYMENT_DIRECT_PREV'];
                        $pasing['PAYMENT_TOTAL_PREV'] = $key['PAYMENT_TOTAL_PREV'];
                        $pasing['PAYMENT_MATERIAL'] = $key['PAYMENT_MATERIAL'];
                        $pasing['PAYMENT_DIRECT'] = $key['PAYMENT_DIRECT'];
                        $pasing['PAYMENT_TOTAL'] = $key['PAYMENT_TOTAL'];
                        $pasing['KET'] = $key['KET'];
                        $rows[] = $pasing;
                    }
                    return $rows;
            } elseif ($Info_Tipe == "4") {
            $query =    "SELECT URUT,KD_JO,KD_MOU,NM_WBS WBS_NAME,KD_WBS,SUM_QTY QTY, 
CASE WHEN A.KD_LEVEL='10' AND KET='DETIL' THEN GRAND_TOTAL_MATERIAL ELSE a.GRAND_TOTAL_MATERIAL+a.SUB_TOTAL_MATERIAL END PRICE_MATERIAL,
CASE WHEN A.KD_LEVEL='10' AND KET='DETIL' THEN GRAND_TOTAL_DIRECT ELSE a.GRAND_TOTAL_DIRECT+a.SUB_TOTAL_DIRECT END PRICE_DIRECT,
CASE WHEN A.KD_LEVEL='10' AND KET='DETIL' THEN GRAND_TOTAL_MATERIAL+GRAND_TOTAL_DIRECT ELSE a.GRAND_TOTAL_MATERIAL+a.SUB_TOTAL_MATERIAL+a.GRAND_TOTAL_DIRECT+a.SUB_TOTAL_DIRECT 
END GRAND_TOTAL, WF_MATERIAL,WF_DIRECT,
PROGRES_MATERIAL_PREV,PROGRES_DIRECT_PREV,PAYMENT_MATERIAL_PREV,PAYMENT_DIRECT_PREV,PAYMENT_TOTAL_PREV,

PROGRES_MATERIAL,PROGRES_DIRECT,

PROGRES_MATERIAL*
((CASE WHEN A.KD_LEVEL='10' AND KET='DETIL' THEN GRAND_TOTAL_MATERIAL ELSE A.SUB_TOTAL_MATERIAL+A.GRAND_TOTAL_MATERIAL END)/100.00) PAYMENT_MATERIAL ,
PROGRES_DIRECT*
((CASE WHEN A.KD_LEVEL='10' AND KET='DETIL' THEN GRAND_TOTAL_DIRECT ELSE A.SUB_TOTAL_DIRECT+A.GRAND_TOTAL_DIRECT END)/100.00) PAYMENT_DIRECT,

(PROGRES_MATERIAL*
((CASE WHEN A.KD_LEVEL='10' AND KET='DETIL' THEN GRAND_TOTAL_MATERIAL ELSE A.SUB_TOTAL_MATERIAL+A.GRAND_TOTAL_MATERIAL END)/100.00) ) +
(PROGRES_DIRECT*
((CASE WHEN A.KD_LEVEL='10' AND KET='DETIL' THEN GRAND_TOTAL_DIRECT ELSE A.SUB_TOTAL_DIRECT+A.GRAND_TOTAL_DIRECT END)/100.00) ) PAYMENT_TOTAL,

KET
FROM GENPROGRES ('$lb_Lokasi','$Info_Date_Start','$Info_Date_End') A 
LEFT JOIN P_P_WBS_BOQ B ON A.KD_MOU=B.ID_MOU AND A.KD_TRS=B.KODE_TRANSAKSI AND A.KD_WBS=B.ID_WBS
LEFT JOIN ( 

select URUT URUT_C,KD_MOU KD_MOU_C,KD_WBS KD_WBS_C,
CASE WHEN KD_LEVEL='10' AND KET='DETIL' THEN QTY_PROG_HDR_MATERIAL ELSE QTY_PROG_DTL_MATERIAL+QTY_PROG_HDR_MATERIAL END QTY_PROGRESS_MATERIAL_PREV, 
CASE WHEN KD_LEVEL='10' AND KET='DETIL' THEN QTY_PROG_HDR_DIRECT ELSE QTY_PROG_DTL_DIRECT+QTY_PROG_HDR_DIRECT END QTY_PROGRESS_DIRECT_PREV,
PROGRES_MATERIAL PROGRES_MATERIAL_PREV, PROGRES_DIRECT PROGRES_DIRECT_PREV,
 
PROGRES_MATERIAL*
((CASE WHEN KD_LEVEL='10' AND KET='DETIL' THEN GRAND_TOTAL_MATERIAL ELSE SUB_TOTAL_MATERIAL+GRAND_TOTAL_MATERIAL END)/100.00) PAYMENT_MATERIAL_PREV ,
PROGRES_DIRECT*
((CASE WHEN KD_LEVEL='10' AND KET='DETIL' THEN GRAND_TOTAL_DIRECT ELSE SUB_TOTAL_DIRECT+GRAND_TOTAL_DIRECT END)/100.00) PAYMENT_DIRECT_PREV,

(PROGRES_MATERIAL*
((CASE WHEN KD_LEVEL='10' AND KET='DETIL' THEN GRAND_TOTAL_MATERIAL ELSE SUB_TOTAL_MATERIAL+GRAND_TOTAL_MATERIAL END)/100.00) ) +
(PROGRES_DIRECT*
((CASE WHEN KD_LEVEL='10' AND KET='DETIL' THEN GRAND_TOTAL_DIRECT ELSE SUB_TOTAL_DIRECT+GRAND_TOTAL_DIRECT END)/100.00) ) PAYMENT_TOTAL_PREV

FROM  GENPROGRES ('$lb_Lokasi','$Info_Date_StartKontrak','$Info_Date_StartKontrak_minsatu ')) C ON C.URUT_C=A.URUT AND C.KD_WBS_C=A.KD_WBS AND C.KD_MOU_C=A.KD_MOU

WHERE KD_MOU='$kd_mou'
";
            $this->db->query($query);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['URUT'] = $key['URUT'];
                $pasing['QTY'] = $key['QTY'];
                $pasing['KD_MOU'] = $key['KD_MOU'];
                $pasing['KD_WBS'] = $key['KD_WBS'];
                $pasing['WBS_NAME'] = $key['WBS_NAME'];
                $pasing['KD_JO'] = $key['KD_JO'];
                $pasing['QTY'] = $key['QTY'];
                $pasing['PRICE_MATERIAL'] = $key['PRICE_MATERIAL'];
                $pasing['PRICE_DIRECT'] = $key['PRICE_DIRECT'];
                $pasing['GRAND_TOTAL'] = $key['GRAND_TOTAL'];
                $pasing['WF_MATERIAL'] = $key['WF_MATERIAL'];
                $pasing['WF_DIRECT'] = $key['WF_DIRECT'];
                $pasing['PROGRES_MATERIAL_PREV'] = $key['PROGRES_MATERIAL_PREV'];
                $pasing['PROGRES_DIRECT_PREV'] = $key['PROGRES_DIRECT_PREV'];
                $pasing['PAYMENT_MATERIAL_PREV'] = $key['PAYMENT_MATERIAL_PREV'];
                $pasing['PAYMENT_DIRECT_PREV'] = $key['PAYMENT_DIRECT_PREV']; 
                $pasing['PAYMENT_TOTAL_PREV'] = $key['PAYMENT_TOTAL_PREV'];
                $pasing['PROGRES_MATERIAL'] = $key['PROGRES_MATERIAL'];
                $pasing['PROGRES_DIRECT'] = $key['PROGRES_DIRECT'];
                $pasing['PAYMENT_MATERIAL'] = $key['PAYMENT_MATERIAL'];
                $pasing['PAYMENT_DIRECT'] = $key['PAYMENT_DIRECT']; 
                $pasing['PAYMENT_TOTAL'] = $key['PAYMENT_TOTAL']; 
                $pasing['KET'] = $key['KET'];
                $rows[] = $pasing;
            }
            return $rows;
        } 
         
    }
    public function getInformationProgressingFooter($data)
    {

        $lb_Lokasi = $data['lb_Lokasi'];
        $Info_Date_Start = $data['Info_Date_Start'];
        $Info_Date_End = $data['Info_Date_End'];  
        $kd_mou = $data['kd_mou'];
        $Info_Tipe = $data['Info_Tipe'];

        if ($Info_Tipe == "1") {
            $query =    "SELECT SUM(QTY_PROG_DTL_MATERIAL) TOTAL_PROGRES_MATERIAL, SUM(QTY_PROG_DTL_DIRECT) TOTAL_PROGRES_DIRECT
                        , SUM(QTY_PROG_DTL_MATERIAL) + SUM(QTY_PROG_DTL_DIRECT) TOTAL_PROGRESS_UNIT
                        FROM GENPROGRES ('$lb_Lokasi','$Info_Date_Start','$Info_Date_End')
                        WHERE KD_MOU='$kd_mou' AND KET='DETIL'";
            $this->db->query($query);
            $data =  $this->db->single(); 
            $pasing['TOTAL_PROGRES_MATERIAL'] = $data['TOTAL_PROGRES_MATERIAL'];
            $pasing['TOTAL_PROGRES_DIRECT'] = $data['TOTAL_PROGRES_DIRECT'];
            $pasing['TOTAL_PROGRESS_UNIT'] = $data['TOTAL_PROGRESS_UNIT']; 
            return $pasing; 
        } elseif ($Info_Tipe == "2") {
            $query =    "SELECT SUM(PROGRES_MATERIAL) PROGRES_WF_MATERIAL, SUM(PROGRES_DIRECT) PROGRES_WF_DIRECT
                        ,SUM(PROGRES_MATERIAL) + SUM(PROGRES_DIRECT) TOTAL_PROGRESS_WF
                        FROM GENPROGRES ('$lb_Lokasi','$Info_Date_Start','$Info_Date_End')
                        WHERE KD_MOU='$kd_mou' AND KET='DETIL'";
            $this->db->query($query);
            $data =  $this->db->single();
            $pasing['PROGRES_WF_MATERIAL'] = $data['PROGRES_WF_MATERIAL'];
            $pasing['PROGRES_WF_DIRECT'] = $data['PROGRES_WF_DIRECT'];
            $pasing['TOTAL_PROGRESS_WF'] = $data['TOTAL_PROGRESS_WF'];
            return $pasing; 
        } elseif ($Info_Tipe == "3") {
            $query =    "SELECT SUM(PAYMENT_MATERIAL) PAYMENT_MATERIAL,SUM(PAYMENT_DIRECT) PAYMENT_DIRECT,
                        SUM(PAYMENT_MATERIAL) + SUM(PAYMENT_DIRECT) PAYMENT_TOTAL
                        FROM GENPROGRES ('$lb_Lokasi','$Info_Date_Start','$Info_Date_End')
                        WHERE KD_MOU='$kd_mou' AND KET='DETIL'";
            $this->db->query($query);
            $data =  $this->db->single();
            $pasing['PAYMENT_MATERIAL'] = $data['PAYMENT_MATERIAL'];
            $pasing['PAYMENT_DIRECT'] = $data['PAYMENT_DIRECT'];
            $pasing['PAYMENT_TOTAL'] = $data['PAYMENT_TOTAL'];
            return $pasing;
        }  elseif ($Info_Tipe == "4") {
            $query =    " SELECT SUM(PAYMENT_MATERIAL)PAYMENT_MATERIAL , SUM(PAYMENT_DIRECT) PAYMENT_DIRECT, SUM(PAYMENT_TOTAL)PAYMENT_TOTAL
                            FROM
                            ( SELECT
                            PROGRES_MATERIAL*
                            ((CASE WHEN KD_LEVEL='10' AND KET='DETIL' THEN GRAND_TOTAL_MATERIAL ELSE SUB_TOTAL_MATERIAL+GRAND_TOTAL_MATERIAL END)/100.00) PAYMENT_MATERIAL ,
                            PROGRES_DIRECT*
                            ((CASE WHEN KD_LEVEL='10' AND KET='DETIL' THEN GRAND_TOTAL_DIRECT ELSE SUB_TOTAL_DIRECT+GRAND_TOTAL_DIRECT END)/100.00) PAYMENT_DIRECT,

                            (PROGRES_MATERIAL*
                            ((CASE WHEN KD_LEVEL='10' AND KET='DETIL' THEN GRAND_TOTAL_MATERIAL ELSE SUB_TOTAL_MATERIAL+GRAND_TOTAL_MATERIAL END)/100.00) ) +
                            (PROGRES_DIRECT*
                            ((CASE WHEN KD_LEVEL='10' AND KET='DETIL' THEN GRAND_TOTAL_DIRECT ELSE SUB_TOTAL_DIRECT+GRAND_TOTAL_DIRECT END)/100.00) ) PAYMENT_TOTAL

                            FROM GENPROGRES ('$lb_Lokasi','$Info_Date_Start','$Info_Date_End')
                            WHERE KD_MOU='$kd_mou' AND KET='DETIL'
                            )X
                            ";
            $this->db->query($query);
            $data =  $this->db->single();
            $pasing['PAYMENT_MATERIAL'] = $data['PAYMENT_MATERIAL'];
            $pasing['PAYMENT_DIRECT'] = $data['PAYMENT_DIRECT'];
            $pasing['PAYMENT_TOTAL'] = $data['PAYMENT_TOTAL'];
            return $pasing;
        }
    }
}
