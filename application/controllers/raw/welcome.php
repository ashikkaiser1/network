<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
          
          $html =  file_get_contents("http://www.aliexpress.com/item/Free-Shipping-Tablet-PC-10-inch-A23-Dual-Core-1GB-RAM-8GB-ROM-10-1-Inch/1618408372.html?spm=2114.01020108.3.1.uJ3Nam&ws_ab_test=searchweb201556_10,searchweb201602_5_10017_10021_507_10022_10020_10009_10008_10018_10019_101,searchweb201603_7&btsid=9273bbf3-3cf3-43d2-92a2-949689a2fb44");
         
          echo $html;
          return 0;
            
	 $this->load->helper("simple_html_dom");
        try
        {
           // $html = file_get_html('http://www.hsbc.co.in/1/PA_ES_Content_Mgmt/content/website/personal/offers/dining_cc_offers/offers.xml');
             $html = file_get_html('http://www.diningdelights.in/Offer.aspx?id=9');
      
//            echo '<pre>';
//           
//           print_r($html);
//           echo '</pre>';
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        

        $articles = array();
// Find all article blocks
      // echo $html->find('div.innerContainer h2',0)->innertext;
       
       foreach($html->find('div.innerContainer') as $element) 
           echo $element->innertext."<br>";
       
        
        
	}
        
        public function parse() {
          $this->load->helper("parser");  
            $html = file_get_contents("http://www.hsbc.co.in/1/PA_ES_Content_Mgmt/content/website/personal/offers/dining_cc_offers/offers.xml");
            print_r($html);
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */