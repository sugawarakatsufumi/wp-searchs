<?php
$query = urlencode(htmlspecialchars($_GET['s']));
#検索したいWPで構築されたサイトを配列で入れる
$urls = ['https://www.wp-xxx1.com','https://www.wp-xxx2.com'];
if($query != ''){
  foreach($urls as $url){
    $str = json_decode(file_get_contents($url."/wp-json/wp/v2/posts?_embed&search=".$query), true);
    $searchs[]= $str;
  }
  for($i=0; $i<count($searchs); $i++){
    for($m=0; $m<count($searchs[$i]); $m++){
      $searchLink = $searchs[$i][$m]['link'];
      $searchTitle = $searchs[$i][$m]['title']['rendered'];
      $searchModified = $searchs[$i][$m]['modified'];
      $searchThumb = $searchs[$i][$m]['_embedded']['wp:featuredmedia'][0]["media_details"]["sizes"]["medium"]["source_url"];
      if(!$searchThumb){
        $searchThumb = '';
      }
      echo "<a href='$searchLink'><img src='$searchThumb'><p>$searchTitle</p><date>$searchModified</date></a><hr><br>\n";
    }
  }  
}else{
  echo '検索結果がありません';
}
?>
