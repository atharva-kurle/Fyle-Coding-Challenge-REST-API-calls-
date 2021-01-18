<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// http://tsms.cybergenius.in/api/sendmsg.php?user=emsapp&pass=Excel711344&sender=EMSAPP&phone=8421310958&text=Hellothisistestsms&priority=ndnd&stype=normal
class Sms_api {

    protected $CI;
    protected $senderid = 'PVPITB';
    protected $smsuserid = 'PVPITB';
    protected $smspass = 'pvpit6269';
    //http://sms.mysukruti.com/api/sendmsg.php?user=PVPITB&pass=pvpit6269&sender=PVPITB&phone=
    protected $link = 'http://sms.mysukruti.com/api/sendmsg.php?';
    protected $smstype = "&priority=ndnd&stype=normal";

    protected $id_institute;

        function __construct()
	{
            $this->CI =& get_instance();
            $this->CI->load->library('Curl');
            $this->id_institute = $this->CI->session->userdata('uinst');
	}
        public function batch_sms($tophone,$smsmsg,$scount)
        {
            $smscount = $scount;
            $credit_check = $this->check_sms_credits($smscount);
            if($credit_check == 1)
            {
                $institute = $this->getinstitue_details($this->id_institute);
                $msg = $smsmsg . ". Call ".$institute['Ins_Name']." @ ".$institute['Ins_Phone'].".";
                $mg = $this->sendsms($tophone,$msg);
                return 1;
            }else{
                return 2;
            }
        }
        
        public function admission_add($tophone,$idstud_auth)
        {
            $this->CI->db->select('StudFullName,StudAuths_Uname,StudAuths_Pass');
            $this->CI->db->join('students','students.idstudents = student_auths.StudAuths_StudId');
            $this->CI->db->where('idstudent_auths',$idstud_auth);
            $stud = $this->CI->db->get('student_auths')->row_array();
            $msg = "Welcome to PVPIT,   ".$stud['StudFullName']." Login to http://www.pvpitsangli.edu.in goto Student Login - Your CRN is ".$stud['StudAuths_Uname']." & Password is ".$stud['StudAuths_Pass'].".";
            $mg = $this->sendsms($tophone,$msg);
        }



        public function addmission_add_sms($tophone,$idstudent,$idbatch)
        {
            $batch = $this->CI->db->get_where('batches',array('idbatches'=>$idbatch))->row_array();
            $smscount = 1;
            $credit_check = $this->check_sms_credits($smscount);
            if($credit_check == 1)
            {
                $institute = $this->getinstitue_details($this->id_institute);
                $msg = "Thanks for Enrolling, For any Query UR Enrollment ID is  # ".$idstudent.". Your batch timing is ".$batch['BatchTime'].", Thanks & Regards. Call ".$institute['Ins_Name']." @ ".$institute['Ins_Phone'].".";
                $mg = $this->sendsms($tophone,$msg);
                return 1;
            }else{
                return 2;
            }
            
        }

        public function fee_deposite($tophone,$amt,$receptno)
        {
            $smscount = 1;
            $credit_check = $this->check_sms_credits($smscount);
            if($credit_check === 1)
            {
                $institute = $this->getinstitue_details($this->id_institute);
                $msg = "Thanks for Depositing Fees of Rs".  number_format($amt)." with receipt no #".$receptno."., Thanks & Regards. Call ".$institute['Ins_Name']." @ ".$institute['Ins_Phone'].".";    
                $mg = $this->sendsms($tophone,$msg);
                return 1;
            }else{
                return 2;
            }                        
        }

        public function absent_sms_to_parent($tophone,$studName)
        {
            $smscount = 1;
            $credit_check = $this->check_sms_credits($smscount);
            if($credit_check == 1)
            {
                    $institute = $this->CI->db->get_where('institue',array('idinstitue'=>$this->id_institute))->row_array();
                    $msg = $studName.", is absent Today in batch. Thanks & Regards. For any Query Call ".$institute['Ins_Name']." @ ".$institute['Ins_Phone'].".";
                $mg = $this->sendsms($tophone,$msg);
                return 1;
            }else{
                return 2;
            }            
        }
        
        public function follow_up_sms($tophone,$idenq)
        {
            $smscount = 1;
            $credit_check = $this->check_sms_credits($smscount);
            if($credit_check == 1)
            {
                $institute = $this->getinstitue_details($this->id_institute);
                $msg = "Thanks for giving Valuable Time, We assure the best Quality of Teaching along with Jobs. For any Query UR provisional ID is  #".$idenq.". Call  ".$institute['Ins_Name']." @ ".$institute['Ins_Phone'].".";
                $mg = $this->sendsms($tophone,$msg);
                return $mg;
            }else{
                return 2;
            }
        }
        
        /*
         * SMS Credit Check/ Send / Insert / UPdate Credits - Functions
         */
                
        function check_sms_credits($smscount)
        {
            $smscheck = $this->CI->db->get_where('smscredits',array('SMSCredits_Institute'=>  $this->id_institute))->row_array();
            if($smscheck['SMSCredits_Actve'] == 1)
            {
                $availablesms = $smscheck['SMSCredits_Count'] - $smscheck['SMSCredits_Used'];
                if($availablesms >= $smscount)
                {
                    return 1;  // Credits avilable 
                }else{
                    return 2;  // Credits Not Available 
                }
            }else {
                    return 3;  // Account Inactive
            }
        }
        
        function sendsms($tophone,$msg){
 
            $mg = urlencode($msg);
            $m = $this->link."user=".$this->smsuserid."&pass=".$this->smspass."&sender=".$this->senderid."&phone=$tophone&text=$mg$this->smstype";
            $this->CI->curl->create($m);
            $this->CI->curl->option('buffersize', 10);
            $this->CI->curl->option('useragent', 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8 (.NET CLR 3.5.30729)');
            $this->CI->curl->option('returntransfer', 1);
            $this->CI->curl->option('followlocation', 1);
            $this->CI->curl->option('HEADER', true);
            $this->CI->curl->option('connecttimeout', 600);
            $sms_response = $this->CI->curl->execute();    
            // Add SMS Transaction
            return $sms_response;
        }
        
        function getinstitue_details($idinstitue)
        {
            return $this->CI->db->get_where('institue',array('idinstitue'=>$idinstitue))->row_array();
            
        }

        function send_OTP($tophone,$otp_number,$idstudents)
        {
            $this->CI->db->select('StudFullName');
            
            $this->CI->db->where('idstudents',$idstudents);
            $stud = $this->CI->db->get('students')->row_array();
            $msg = $stud['StudFullName']." Your OTP is ".$otp_number;
            $mg = $this->sendsms($tophone,$msg);

            return $mg;
        }

        function send_password($tophone,$idstudents)
        {
            $this->CI->db->select('StudFullName,student_auths.*');
            $this->CI->db->join('students','students.idstudents = student_auths.StudAuths_StudId');
            $this->CI->db->where('StudAuths_StudId',$idstudents);
            $stud = $this->CI->db->get('student_auths')->row_array();
            $msg = $stud['StudFullName']." Login to http://www.pvpitsangli.edu.in goto Student Login - Your Username is ".$stud['StudAuths_Uname']." & Password is ".$stud['StudAuths_Pass'].".";
            $mg = $this->sendsms($tophone,$msg);

            return $mg;
        }

        function send_password_change($StudPhone)
        {
            $msg = 'Your password successfully changed';
            $mg = $this->sendsms($StudPhone,$msg);
            return $mg;
        }


}

?>