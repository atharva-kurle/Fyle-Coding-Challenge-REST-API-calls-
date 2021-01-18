<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Cache file naming routine factored out to allow for manual deletion.
 *
 * Responsible for sending final output to browser
 *
 * @package        CodeIgniter
 * @subpackage    Libraries
 * @hacked-by    Bradford Mar
 */
class MY_Output extends CI_Output {
    
    function nocache()
    {
        $this->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->set_header('Pragma: no-cache');
    }
}
// END MY_Output Class

/* End of file MY_Output.php */
/* Location: ./system/application/libraries/MY_Output.php */

?>