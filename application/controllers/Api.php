<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Api extends MX_Controller {

    public $googleApiKey = 'AIzaSyCFPC2GbdXz-UxeaP8b0gul84e_UPaO7x0';
    public $googleMapsAddress = 'https://maps.googleapis.com/maps/api/geocode/json?key=' . 'AIzaSyAt059eRF2ThiE1WmyavE2x2mUOIUAW8xc' . '&address=';

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

    public function FavoriteProperty ($userId, $propId) {

		header('Content-Type: application/json');

        $query = $this->db->query("INSERT INTO `favorites`(user_id, property_id) VALUES ($userId,$propId)");

        echo json_encode(true);

    }


    public function AutoComplete ($query = "", $type = "rets_res") {
        header('Content-Type: application/json');
        $query = '%' . $query . '%';
        $query = $this->db->query("SELECT `AREANAME`, `photos`, `PROPTYPE`, `LISTINGID`, `COUNTY`, `address` FROM `$type` WHERE `address` LIKE REPLACE('$query', '%20', ' ') LIMIT 10");

        $result = $query->result_array();

        echo json_encode($result);
    }


    public function LatestNoGeoCodeData ($type = "rets_res") {
        header('Content-Type: application/json');

        $query = $this->db->query("SELECT * FROM `$type` WHERE `latX` = '0.00000000' order by `DTADD` DESC LIMIT 1");

        $result = $query->result_array();

        echo json_encode($resp);
    }

    public function UpdateLatestNoGeoCodeData ($type = "rets_res", $update = false) {
        header('Content-Type: application/json');
        $query = $this->db->query("SELECT * FROM `$type` WHERE `latX` = '0.00000000' order by `DTADD` DESC LIMIT 1");

        $r = $query;
        $addressToGeocode =  $r->row('STREETNUM') . ' ' . $r->row('STREET') . ' ' . $r->row('STREETTYP') . ', '. $r->row('AREANAME'). ', ' . $r->row('COUNTY') . ' ' . $r->row('STATEID') . ', '. $r->row('ZIP');

        if(!$update)
         echo json_encode($r->result_array());

        echo($addressToGeocode);

        // get the json response
        $resp_json = json_decode(file_get_contents($this->googleMapsAddress . urlencode($addressToGeocode)), true);
        $this->InsertGeoCodeData(
            $resp_json["results"][0]["geometry"]["location"]["lat"],
            $resp_json["results"][0]["geometry"]["location"]["lng"],
            $r->row('LISTINGID'),
            $type);
    }

    public function InsertGeoCodeData ($lat, $long, $listingId, $type) {
		header('Content-Type: application/json');
        if (!lat) return;

        $query = $this->db->query("UPDATE `$type` SET `latX` = '$lat', `longY` = '$long' WHERE `LISTINGID` = '$listingId'");
        echo json_encode($listingId . ' ' . $lat . ' ' . $long);
    }

    public function UnFavoriteProperty ($userId, $propId) {

        header('Content-Type: application/json');

        $query = $this->db->query("DELETE FROM `favorites` where property_id = '$propId' and user_id = '$userId'");

        echo json_encode(false);

    }


    public function GetFavorites ($userId = "0") {

		header('Content-Type: application/json');

        $query = $this->db->query("SELECT DISTINCT * FROM `rets_res` as res JOIN `favorites` as `fav` on res.LISTINGID = fav.property_id where fav.user_id = $userId");

		$result = $query->result_array();

		echo json_encode($result);
    }

    public function GetFavorite ($userId = "0", $property_id = "0") {

        header('Content-Type: application/json');

        $query = $this->db->query("SELECT * FROM `favorites` where `user_id` = $userId and `property_id` = $property_id");

        $result = $query->result_array();

        echo json_encode($result);
    }


    public function GetPropertyByRooms ($baths = "%", $bathsFull = "%", $bdrms = "%",  $limit = 10, $offset = 10) {

        header('Content-Type: application/json');

        $query = $this->db->query("SELECT * FROM `rets_res` WHERE BATHSFULL LIKE '$baths' AND BATHSPART LIKE '$bathsFull' AND BDRMS LIKE '$bdrms' order by 'DTADD' desc LIMIT $limit OFFSET $offset");

        $result = $query->result_array();

        echo json_encode($result);

    }


    public function GetTotalCounts ($type = "rets_res", $county = "", $town = "A", $bath = "A",  $bathP = "A", $bed = "A", $priceMin = 0, $priceMax = 9999999999) {

		header('Content-Type: application/json');

        if($areaName == "A") {
            $areaName = "'%%'";
        }
        else {
            $areaName = "'%" . $areaName . "%'";
        }

        if($bed == "A") {
            $bed = "%";
        }

        if($bathP == "A") {
            $bathP = "%";
        }

        if($county == "A"){
            $county = "%%";
        }

        if($bath == "A") {
            $bath = "%";
        }
        if($town == "A") {
            $town = "%%";
        }

        $query = $this->db->query("SELECT `AREANAME`, `COUNTY` FROM `$type` where `COUNTY` LIKE '$county%' AND `AREANAME` LIKE REPLACE('$town', '%20', ' ') AND `BATHSFULL` LIKE '$bath' AND `BATHSPART` LIKE '$bathP' AND BDRMS LIKE '$bed' AND PRICECURRENT BETWEEN $priceMin AND $priceMax");

        $result = $query->result_array();

        echo json_encode($result);
    }



    public function GetTotalCountsWithinDays ($type = "rets_res", $days = 1, $county = "", $town = "")  {

		header('Content-Type: application/json');

        $query = $this->db->query("SELECT id, COUNTY FROM `$type`
                                     where `COUNTY` LIKE '%$county%' AND `AREANAME` LIKE '%$town%' AND `DTADD` > NOW() - INTERVAL $days DAY
                                     UNION
                                     SELECT id, COUNTY FROM `rets_bus`
                                     where `COUNTY` LIKE '%$county%' AND `AREANAME` LIKE '%$town%' AND `DTADD` > NOW() - INTERVAL $days DAY
                                     UNION
                                     SELECT id, COUNTY FROM `rets_2to4`
                                      where `COUNTY` LIKE '%$county%' AND `AREANAME` LIKE '%$town%' AND `DTADD` > NOW() - INTERVAL $days DAY");

		$result = $query->num_rows();

		echo json_encode($result);

    }

    public function GetGrandLiveListingTotals ($agentName  = "") {

        header('Content-Type: application/json');

        $query = $this->db->query("SELECT
                                           COUNT(*) as data
                                       FROM
                                           rets_res
                                       UNION
                                       SELECT
                                           COUNT(*)
                                       FROM
                                           rets_2to4 as data
                                       UNION
                                       SELECT
                                           COUNT(*)
                                       FROM
                                           rets_cct as data
                                       UNION
                                       SELECT
                                           COUNT(*)
                                       FROM
                                           rets_bus as data
                                       UNION
                                       SELECT
                                           COUNT(*)
                                       FROM
                                           rets_mix as data");

        $result = $query->result_array();

        echo json_encode($result);
    }


    public function GetPropertiesByAgentName ($agentName  = "") {
		header('Content-Type: application/json');

        $query = $this->db->query("SELECT * FROM `rets_res` WHERE LAG1NAME = REPLACE('$agentName', '%20', ' ')");

		$result = $query->result_array();

		echo json_encode($result);
    }

    public function GetPosts ($amount = "3") {
        header('Content-Type: application/json');

        $query = $this->db->query("SELECT * FROM `posts` order by created desc");

        $result = $query->result_array();

        echo json_encode($result);
    }

    public function GetPost ($slug = "") {
        header('Content-Type: application/json');

        $query = $this->db->query("SELECT * FROM `posts` WHERE slug = '$slug'");

        $result = $query->result_array();

        echo json_encode($result);
    }

    public function GetMonths () {
        header('Content-Type: application/json');

        $query = $this->db->query("SELECT MONTH(created) as month,posts.created FROM `posts` GROUP BY year(created), month(created) order by created desc");

        $result = $query->result_array();

        echo json_encode($result);
    }

    public function GetTags () {
        header('Content-Type: application/json');

        $query = $this->db->query("SELECT DISTINCT tags.name, tags.id from `tags` JOIN posts_tags ON posts_tags.tag_id = tags.id order by name");

        $result = $query->result_array();

        echo json_encode($result);
    }

    public function getRecentPosts () {
        header('Content-Type: application/json');

        $query = $this->db->query("SELECT `title`,`id`,`slug` FROM `posts` order BY created desc LIMIT 5");

        $result = $query->result_array();

        echo json_encode($result);
    }

    public function GetCategoryPostsById($id = "1") {
        header('Content-Type: application/json');

        $query = $this->db->query("SELECT DISTINCT posts.title, posts.id, posts.body FROM `posts_categories` JOIN `posts` ON posts_categories.post_id = posts.id where posts_categories.category_id = $id order by created desc");
        $result = $query->result_array();

        echo json_encode($result);
    }

    public function GetCategoryPostsByMonth($month = "1") {
        header('Content-Type: application/json');

        $query = $this->db->query("SELECT * FROM `posts` WHERE Month(created) = $month order by created desc");
        $result = $query->result_array();

        echo json_encode($result);
    }

    public function GetCategories () {
        header('Content-Type: application/json');

        $query = $this->db->query("SELECT DISTINCT cat.name, cat.id, pc.category_id FROM `categories` as cat JOIN `posts_categories` as pc ON cat.id = pc.category_id");

        $result = $query->result_array();

        echo json_encode($result);
    }

    public function GetSoldPropertiesByAgentName ($agentName  = "") {
        header('Content-Type: application/json');

        $query = $this->db->query("SELECT * FROM `rets_res_sold` WHERE LAG1NAME = REPLACE('$agentName', '%20', ' ')");

        $result = $query->result_array();

        echo json_encode($result);
    }

    public function GetPropertiesByAgentRNTName ($agentName  = "") {
        header('Content-Type: application/json');

        $query = $this->db->query("SELECT * FROM `rets_RNT` WHERE LAG1NAME = REPLACE('$agentName', '%20', ' ')");

        $result = $query->result_array();

        echo json_encode($result);
    }

    public function GetRESPropertiesByAgentName ($agentName  = "") {
		header('Content-Type: application/json');

        $query = $this->db->query("SELECT * FROM `rets_res` WHERE `LAG1NAME` like '%$agentName%'");

		$result = $query->result_array();

		echo json_encode($result);
    }

    public function GetRNTPropertiesByAgentName ($agentName = "") {
		header('Content-Type: application/json');

        $query = $this->db->query("SELECT * FROM `rets_RNT` WHERE `LAG1NAME` like '%$agentName%'");

		$result = $query->result_array();

		echo json_encode($result);
    }

    public function GetAgentAvatar ($agentLastName  = "") {
        header('Content-Type: application/json');

        $query = $this->db->query("SELECT `user_id`, `avatar_name` FROM users INNER JOIN `users_data` ON users.id = users_data.user_id where users.last_name LIKE '%$agentLastName%'");

        $result = $query->result_array();

        echo json_encode($result);
    }

    public function GetTotalCountsWithinWeeks ($type = "rets_res", $week = 1, $county = "", $town = "")  {

		header('Content-Type: application/json');

        $query = $this->db->query("SELECT id, COUNTY FROM `$type`
                                    where `COUNTY` LIKE '%$county%' AND `AREANAME` LIKE '%$town%' AND `DTADD` > NOW() - INTERVAL $week WEEK
                                  UNION
                                  SELECT id, COUNTY FROM `rets_bus`
                                    where `COUNTY` LIKE '%$county%' AND `AREANAME` LIKE '%$town%' AND `DTADD` > NOW() - INTERVAL $week WEEK
                                  UNION
                                  SELECT id, COUNTY FROM `rets_2to4`
                                    where `COUNTY` LIKE '%$county%' AND `AREANAME` LIKE '%$town%' AND `DTADD` > NOW() - INTERVAL $week WEEK");

		$result = $query->num_rows();

		echo json_encode($result);

    }

    public function GetFunFacts ($id = "0")  {

        header('Content-Type: application/json');

        $query = $this->db->query("SELECT * FROM `users_fun_facts` WHERE `user_id` = $id");

		$result = $query->result_array();

		echo json_encode($result);

    }


    public function GetTotalCountsWithinWeeksAny ($type = "rets_res", $week = 1, $county = "", $town = "") {
        header('Content-Type: application/json');
        if ($type != "rets_rnt") {
        $query = $this->db->query("SELECT id, COUNTY FROM `$type`
                                       where `DTADD` > NOW() - INTERVAL $week WEEK
                                       UNION
                                       SELECT id, COUNTY FROM `rets_bus`
                                        where `DTADD` > NOW() - INTERVAL $week WEEK
                                       UNION
                                       SELECT id, COUNTY FROM `rets_2to4`
                                        where `DTADD` > NOW() - INTERVAL $week WEEK");
        }
        else {
            $query = $this->db->query("SELECT id, COUNTY FROM `$type` where `DTADD` > NOW() - INTERVAL $week WEEK");
        }
        $result = $query->num_rows();
		echo json_encode($result);
    }

    public function GetTotalCountsWithinWeeksSold ($type = "rets_res", $week = 1, $county = "", $town = ""){
        header('Content-Type: application/json');
        $query = $this->db->query("SELECT id, COUNTY FROM `$type` where `DATECOE` > NOW() - INTERVAL $week WEEK");

        $result = $query->num_rows();

        echo json_encode($result);

    }

    public function GetTotalCountsSoldTotal (){
        header('Content-Type: application/json');
        $query = $this->db->query("SELECT id FROM `rets_res_sold` WHERE `DATECOE` > NOW() - INTERVAL 4 WEEK");

        $result = $query->num_rows();

        echo json_encode($result);
    }

    public function GetAgents () {

		header('Content-Type: application/json');

		$query = $this->db->query("SELECT `first_name`,`last_name`,`avatar_name`, ud.user_id, ug.group_id, g.name FROM `users` as u INNER JOIN `users_data` as ud ON ud.id = u.id JOIN users_groups as ug on ug.user_id = ud.user_id JOIN groups as g on g.id = ug.group_id WHERE group_id = 2 and u.active = 1");

		$result = $query->result_array();

		echo json_encode($result);

    }


    public function GetAgentNames () {

		header('Content-Type: application/json');

		$query = $this->db->query("SELECT `first_name`,`last_name` FROM `users` as u INNER JOIN `users_data` as ud ON ud.id = u.id JOIN users_groups as ug on ug.user_id = ud.user_id JOIN groups as g on g.id = ug.group_id WHERE group_id = 2 and u.active = 1 ORDER BY `last_name` asc" );

		$result = $query->result_array();

		echo json_encode($result);

    }

    public function GetAgent ($id = "") {

        header('Content-Type: application/json');

        $query = $this->db->query("SELECT * FROM `users` as u INNER JOIN `users_data` as ud ON ud.id = u.id WHERE u.id = '$id'");

        $result = $query->result_array();

        echo json_encode($result);

    }

    public function Search ($string = "") {

		header('Content-Type: application/json');

		$query = $this->db->query("SELECT `AREANAME`, `COUNTY` FROM `rets_res_ct` WHERE `AREANAME` LIKE '%$string%' LIMIT 12");

		$result = $query->result_array();

		echo json_encode($result);

    }

    public function GetUpcomingOpenHouses () {
        header('Content-Type: application/json');

        $query = $this->db->query("SELECT `OPENDATE`, `AREANAME`, `latX`, `longY`, `BATHSFULL`, `STREETNUM`, `STREET`, `PROPTYPE`, `STREETTYP`, `BATHSPART`, `BDRMS`, `DTADD`, `COUNTY`, `LISTINGID`, `PRICECURRENT`, `STYLE`, `YEARBUILT`, `photos`  FROM `rets_2to4` where OPENDATE IS NOT NULL AND OPENDATE > CURDATE()
                                       UNION
                                       SELECT `OPENDATE`, `AREANAME`, `latX`, `longY`, `BATHSFULL`, `STREETNUM`, `STREET`, `PROPTYPE`, `STREETTYP`, `BATHSPART`, `BDRMS`, `DTADD`, `COUNTY`, `LISTINGID`, `PRICECURRENT`, `STYLE`, `YEARBUILT`, `photos`  FROM `rets_cct` where OPENDATE IS NOT NULL AND OPENDATE > CURDATE()
                                       UNION
                                       SELECT `OPENDATE`, `AREANAME`, `latX`, `longY`, `BATHSFULL`, `STREETNUM`, `STREET`, `PROPTYPE`, `STREETTYP`, `BATHSPART`, `BDRMS`, `DTADD`, `COUNTY`, `LISTINGID`, `PRICECURRENT`, `STYLE`, `YEARBUILT`, `photos` FROM `rets_res` where OPENDATE IS NOT NULL AND OPENDATE > CURDATE()
                                       UNION
                                       SELECT `OPENDATE`, `AREANAME`, `latX`, `longY`, `BATHSFULL`, `STREETNUM`, `STREET`, `PROPTYPE`, `STREETTYP`, `BATHSPART`, `BDRMS`, `DTADD`, `COUNTY`, `LISTINGID`, `PRICECURRENT`, `STYLE`, `YEARBUILT`, `photos`  FROM `rets_rnt` where OPENDATE IS NOT NULL AND OPENDATE > CURDATE()
                                       order by OPENDATE desc");

        $result = $query->result_array();

        echo json_encode($result);

    }

    public function SearchPropertyName($name)
	{

		header('Content-Type: application/json');

		$query = $this->db->query("SELECT  `STREET`, `STREETTYP`,`STREETNUM`,`LISTINGID` FROM `rets_res` WHERE `STREET` LIKE '%$name%' LIMIT 8");

		$result = $query->result_array();

		echo json_encode($result);

    }


	public function GetResidentialProperties($orderBy = "DTADD", $offset = 0, $sort = "DESC", $county = "*", $areaName, $limit = 10, $bath = "A",  $bathP = "A", $bed = "A", $priceMin = 0, $priceMax = 9999999999)

	{
		header('Content-Type: application/json');

        if($areaName == "A") {
            $areaName = "'%%'";
        }
        else {
            $areaName = "'%" . $areaName . "%'";
        }

        if($bed == "A") {
            $bed = "%";
        }

        if($bathP == "A") {
            $bathP = "%";
        }

        if($bath == "A") {
            $bath = "%";
        }

		$query = $this->db->query("SELECT `OPENDATE`, `AREANAME`, `latX`, `longY`, `BATHSFULL`, `STREETNUM`, `STREET`, `PROPTYPE`, `STREETTYP`, `BATHSPART`, `BDRMS`, `DTADD`, `COUNTY`, `LISTINGID`, `PRICECURRENT`, `STYLE`, `YEARBUILT`, `photos` FROM `rets_res`
                                    where `COUNTY` = '$county'  AND `AREANAME` LIKE REPLACE($areaName, '%20', ' ') AND `BATHSFULL` LIKE '$bath' AND `BATHSPART` LIKE '$bathP' AND BDRMS LIKE '$bed' AND PRICECURRENT BETWEEN $priceMin AND $priceMax
                                   UNION
                                   SELECT `OPENDATE`, `AREANAME`, `latX`, `longY`, `BATHSFULL`, `STREETNUM`, `STREET`, `PROPTYPE`, `STREETTYP`, `BATHSPART`, `BDRMS`, `DTADD`, `COUNTY`, `LISTINGID`, `PRICECURRENT`, `STYLE`, `YEARBUILT`, `photos` FROM `rets_cct`
                                    where `COUNTY` = '$county'  AND `AREANAME` LIKE REPLACE($areaName, '%20', ' ') AND `BATHSFULL` LIKE '$bath' AND `BATHSPART` LIKE '$bathP' AND BDRMS LIKE '$bed' AND PRICECURRENT BETWEEN $priceMin AND $priceMax
                                   UNION
                                   SELECT `OPENDATE`, `AREANAME`, `latX`, `longY`, `BATHSFULL`, `STREETNUM`, `STREET`, `PROPTYPE`, `STREETTYP`, `BATHSPART`, `BDRMS`, `DTADD`, `COUNTY`, `LISTINGID`, `PRICECURRENT`, `STYLE`, `YEARBUILT`, `photos` FROM `rets_2to4`
                                   where `COUNTY` = '$county'  AND `AREANAME` LIKE REPLACE($areaName, '%20', ' ') AND `BATHSFULL` LIKE '$bath' AND `BATHSPART` LIKE '$bathP' AND BDRMS LIKE '$bed' AND PRICECURRENT BETWEEN $priceMin AND $priceMax  ORDER BY $orderBy $sort LIMIT $limit OFFSET $offset");



		if($query !== FALSE && $query->num_rows() > 0){

			$result = $query->result_array();

			echo json_encode($result);

		} else {

			echo json_encode([]);

		}

    }



	public function GetRentalProperties($orderBy = "DTADD", $offset = 0, $sort = "DESC", $county = "*", $areaName, $limit = 10,  $bath = "A",  $bathP = "A", $bed = "A", $priceMin = 0, $priceMax = 9999999999)
	{

		header('Content-Type: application/json');

        if($areaName == "A") {
            $areaName = "'%%'";
        }
        else {
            $areaName = "'%" . $areaName . "%'";
        }


        if($bed == "A") {
            $bed = "%";
        }

        if($bathP == "A") {
            $bathP = "%";
        }

        if($bath == "A") {
            $bath = "%";
        }

		$query = $this->db->query("SELECT `AREANAME`, `latX`, `longY`, `BATHSFULL`, `STREETNUM`, `STREET`, `PROPTYPE`, `STREETTYP`, `BATHSPART`, `BDRMS`, `DTADD`, `COUNTY`, `LISTINGID`, `NUMROOMS`, `PRICECURRENT`, `STYLE`, `YEARBUILT`, `photos`, (select COUNT(*) from `rets_RNT`) AS total FROM `rets_RNT` where `COUNTY` = '$county' AND `AREANAME` LIKE REPLACE($areaName, '%20', ' ') AND `BATHSFULL` LIKE '$bath' AND `BATHSPART` LIKE '$bathP' AND BDRMS LIKE '$bed' AND PRICECURRENT BETWEEN $priceMin AND $priceMax ORDER BY $orderBy $sort LIMIT $limit OFFSET $offset");

		if($query !== FALSE && $query->num_rows() > 0){

			$result = $query->result_array();

			echo json_encode($result);

		} else {

			echo json_encode([]);

		}

    }



	public function GetRecentResidentials($amount = 2) {

		header('Content-Type: application/json');

		if(!$amount) return [];

		$query = $this->db->query("SELECT * FROM `rets_res` ORDER BY `DTADD` DESC LIMIT $amount");

        $result = $query->result_array();

		echo json_encode($result);

	}



	public function GetRecentRentals($amount = 2) {

		header('Content-Type: application/json');

		if(!$amount) return [];



		$query = $this->db->query("	SELECT * FROM `rets_RNT` ORDER BY `DTADD` DESC LIMIT $amount");

        $result = $query->result_array();

		echo json_encode($result);

	}


	public function GetGeoCodes($amount, $areaName = 0) {
		header('Content-Type: application/json');

        if(gettype ($areaName) == string && $areaName != "All%20Towns") {
            $query = $this->db->query("SELECT `DTADD`, `LISTINGID`, `photos`, `PROPTYPE`, `STREETTYP`,`STREET`,`STREETNUM`,`AREANAME` ,`latX`, `longY` FROM `rets_res`
                                        WHERE AREANAME = REPLACE('$areaName', '%20', ' ') AND `latX` <> '0.00000000'
                                        UNION
                                       SELECT `DTADD`, `LISTINGID`, `photos`, `PROPTYPE`, `STREETTYP`,`STREET`,`STREETNUM`,`AREANAME` ,`latX`, `longY` FROM `rets_cct`
                                       WHERE AREANAME = REPLACE('$areaName', '%20', ' ') AND `latX` <> '0.00000000'
                                        UNION
                                       SELECT `DTADD`, `LISTINGID`, `photos`, `PROPTYPE`, `STREETTYP`,`STREET`,`STREETNUM`,`AREANAME` ,`latX`, `longY` FROM `rets_2to4`
                                       WHERE AREANAME = REPLACE('$areaName', '%20', ' ') AND `latX` <> '0.00000000'
                                        ORDER BY DTADD DESC LIMIT $amount");
        } else {
        		$query = $this->db->query("SELECT `DTADD`, `LISTINGID`, `photos`, `PROPTYPE`, `STREETTYP`,`STREET`,`STREETNUM`,`AREANAME` ,`latX`, `longY` FROM `rets_res`
        		                            WHERE AREANAME = 0 AND `latX` <> '0.00000000'
        		                            UNION
                                           SELECT `DTADD`, `LISTINGID`, `photos`, `PROPTYPE`, `STREETTYP`,`STREET`,`STREETNUM`,`AREANAME` ,`latX`, `longY` FROM `rets_cct`
                                           WHERE AREANAME = 0 AND `latX` <> '0.00000000'
                                            UNION
                                           SELECT `DTADD`, `LISTINGID`, `photos`, `PROPTYPE`, `STREETTYP`,`STREET`,`STREETNUM`,`AREANAME` ,`latX`, `longY` FROM `rets_2to4`
                                           WHERE AREANAME = 0 AND `latX` <> '0.00000000'
        		                            ORDER BY DTADD DESC LIMIT $amount");
        }

		$result = $query->result_array();



		echo json_encode($result);

	}



	public function GetAvailableTownsByCounty($county = "*") {

		header('Content-Type: application/json');

		$query = $this->db->query("SELECT `AREANAME` FROM `rets_res_ct` WHERE COUNTY = '$county'");

		$result = $query->result_array();



		echo json_encode($result);

	}



	public function GetPropertyById($listingId, $type)

	{

		header('Content-Type: application/json');
		if ($type == 'RES' || $type == "res") {

			$query = $this->db->query("SELECT * FROM `rets_res` WHERE `LISTINGID` = $listingId");

		} else if ($type == 'RNT' || $type == 'rnt'){

			$query = $this->db->query("SELECT * FROM `rets_RNT` WHERE `LISTINGID` = $listingId");

		} else if ($type == '2to4'){
			$query = $this->db->query("SELECT * FROM `rets_2to4` WHERE `LISTINGID` = $listingId");
		}



		$result = $query->result_array();



		// break up image array

		foreach ($result as $key => $value) {

			$result[$key]['photos'] = $this->ParseImageArray($result[$key]['photos']);

		}

		echo json_encode($result);

    }

}