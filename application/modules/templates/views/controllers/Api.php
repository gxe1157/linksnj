<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MX_Controller {

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
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

    // API METHODS WE NEED (and should be extracted to individual)
    // getPropertyByID(id)
    // getProperties(amount) <-- sorted by time desc
    // getPropertyByCounty(amount)
    // getPropertyBySoldStatus(boolean)
    
    // getRentals(boolean)
    // getRentalById(id)
    
    // getAgents(amount)

	// Loops through image string and explodes to array on "|"
    private function ParseImageArray($imageString) {
        return explode("|", $imageString);
	}
	private function ConvertToUsd($number) {
		setlocale(LC_MONETARY, 'en_US');
        return  money_format('%.2n', sprintf('%.2f', $number / 100));
	}
	private function SetRentalFlag ($termString) {
		return strpos($termString, 'Rent') !== false;
	}

    public function SearchPropertyName($name)
	{
		header('Content-Type: application/json');
		$query = $this->db->query("SELECT  `address_streetName` FROM `rets_mls` WHERE `address_streetName` LIKE '%$name%'");
		$result = $query->result_array();
		echo json_encode($result);
    }

	public function GetProperties($amount)
	{
		header('Content-Type: application/json');
		$query = $this->db->query("SELECT * FROM `rets_mls` LIMIT $amount");
        $result = $query->result_array();

		// break up image array
		foreach ($result as $key => $value) {
			$result[$key]['photos'] = $this->ParseImageArray($result[$key]['photos']);
			$result[$key]['readableListPrice'] = $this->ConvertToUsd($result[$key]['listPrice']);
			$result[$key]['isRental'] = $this->SetRentalFlag($result[$key]['terms']);		
		}

		echo json_encode($result);
    }

	public function GetPropertyById($id)
	{
		header('Content-Type: application/json');
		$query = $this->db->query("SELECT * FROM `rets_mls` WHERE id = $id");
		$result = $query->result_array();
		
		// break up image array
		foreach ($result as $key => $value) {
			$result[$key]['photos'] = $this->ParseImageArray($result[$key]['photos']);
		}
		echo json_encode($result);
    }        
}