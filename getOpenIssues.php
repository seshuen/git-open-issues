<?php
/**
 * Open Issue class for shippables screening test.
 *
 * This class is used specifically for the purpose of getting open issue in past 24 hours, 7 days or longer than that.
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Git Code
 * @package    OpenIssue
 * @author     Seshu En <seshu.93@gmail.com>
 * @copyright  1997-2016 Seshu En
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    1.0.0
 * @link       http://seshuen.in
 * @refernce   http://stackoverflow.com/questions/1975461/how-to-get-file-get-contents-work-with-https for their help in curl commands
 */

/**
 * Here you can find the open issue class which shall take the @var url & parse it with @var time to get specific timeline based open issue.
 *
 */

class OpenIssue
{
  // Function to get the contents from given url
   function getContent($url)
  {
    //get the user agent from standard function of php.
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    // Initialize Curl
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    //Execute Curl
    $result = curl_exec($ch);
    curl_close($ch);

    //Decode the json in array
   $new_result=json_decode($result,true);

   //Return array
   return $new_result;
  }

//Function which works the main thing of getting the data and jsonify it.
  function getOpenIssue($url, $since = 'None')
  {
    //Break the input url in array format using explode function
    $input_url_array =  explode('/',$url);

    //Validate the input url
    if(strcmp($input_url_array[0],"https:")||strcmp($input_url_array[1],"")||strcmp($input_url_array[2],"github.com")||empty($input_url_array[3])||empty($input_url_array[4]))
    {
        $response['success'] = 0;
        $response['data'] = "Invalid Url! Please check the url entered is of following format: https://github.com/[org_name or username]/[repo_name]/";
    }

    if($since == 'None'){
      //url for the github Api, $input_url_array[3] contain organisation or username, $input_url_array[3] contain repository name
      $url = "https://api.github.com/repos/".$input_url_array[3]."/".$input_url_array[4];
      //call the function and receive the result in associative array format
      $result = $this->getContent($url);

      //encode the data into the json object
      $response['success'] = 1;
      $response['data'] = $result;
    }
    else {
      //url for the github Api with since parameter equal to time of last 24 hrs that return only issues updated at or after this time
      $url = "https://api.github.com/repos/".$input_url_array[3]."/".$input_url_array[4]."/issues?since=".$since;

      //call the function and receive the result in associative array format
      $result = $this->getContent($url);

      //encode the data into the json object
      $response['success'] = 1;
      $response['data'] = $result;
    }

    //Encode into json file and return the response
    $response = json_encode($response);
    return $response;
  }

//Function to decode the data and display.
  function getJson($result)
  {
      $result = json_decode($result,true);
      return $result;
  }

}


 ?>
