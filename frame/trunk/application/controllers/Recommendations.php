<?php
class Recommendations extends Controller {

   function index(){

      $this->load->view('Recommendations');
   }
 function bestPerformence(){
   $this->load->view('bestPerformence');
 }

 function poorPerformence (){
     $this->load->view('PoorPerformence');
 }
}
