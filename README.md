# git-open-issues
Get open issues stats of any github repository with this application. Designed using basic curl commands and github api v3. 

## Code Example

git-open-issue is designed using php & helps in maintaing api of the same.
```
  $result_total = $openissue->getOpenIssue($url);
  $total = $openissue->getJson($result_total);
  ````

## Motivation

Thanks to Shippables for the challenge and also thanks to http://stackoverflow.com/questions/1975461/how-to-get-file-get-contents-work-with-https to help me when i was stuck whenever & wherever.

## Installation

Simply import getOpenIssues.php and initiate class like below
```
$classname = new OpenIssue;
```
Its simple to use and simple construct.


## Tests

```
  $url = "https://github.com/Shippable/support";
  $result_total = $openissue->getOpenIssue($url);
  $total = $openissue->getJson($result_total);
  if ($total['success'] == 0) {
    $error_msg = $total['data'];
  }else {
    $total_open_issues = $total['data']['open_issues_count'];
    echo $total_open_issues;
  }
  ```

## Contributors

I have made it on own so i certainly don't think this would be appropriate right now. But all contributors are thanked in advance.

## License

This source file is subject to version 3.01 of the PHP license that is available through the world-wide-web at the following URI: http://www.php.net/license/3_01.txt.  If you did not receive a copy of the PHP License and are unable to obtain it through the web, please send a note to license@php.net so we can mail you a copy immediately.
