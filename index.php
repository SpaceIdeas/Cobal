<?php
/**
 * Created by PhpStorm.
 * User: Spaceslug
 * Date: 22/04/2015
 * Time: 17:40
 */
require_once('config.php');
require_once('libs/Smarty.class.php');
require_once('db.php');
$smarty = new Smarty();
if(isset($_GET['searchWord'])){
    $posts = Post::getAllPostsWhere($db, $_GET['searchWord']);
} else {
    $posts = Post::getAllPosts($db);
}
if (isset($_GET['verToken'])) {
    if (User::verifyUserEmail($db, $_GET ['verToken']) == 1) {
        $smarty->assign('successMessage', 'Din epost er nå bekreftet. Takk.');
    } else {
        $smarty->assign('errorMessage', 'Din epost kunne ikke bekreftes.');
    }
}
$smarty->assign('posts', $posts);

//Metoden gjør postList.tpl templeten klar til å bli kjørt
createPostList($smarty, $posts);

$smarty->assign('db', $db);
$smarty->display('index.tpl');


/**
 * Denne metoden gjør det som er nødvendig for at smarty templeten postList fungerer
 * Metoden finner ut hvor mange innlegg det er på hver måned blant innleggene i $post
 * Dette blir så assign-et til smarty
 * @param Smarty $smarty
 * @param $posts
 */
function createPostList(Smarty $smarty, $posts){
    //Blir en array av datoene til innleggene i $post
    $listPosts = array();

    foreach($posts as $post){
        //Gjør timestampet til et innlegg om til en assosiativ array med datoinformasjon
        // og legger dette inn i $listPosts
        $listPosts[] = date_parse($post->getTimeCreated());
    }
    //Blir et array med YearPostList items der YearPostList inneholder året og et
    // assosiativt array med navn på måned som key og antall innlegg denne måneden som value
    $yearPostList = array();
    //Setter $i til dette året og innkrementerer nedover
    for($i = date("Y"); $i > 2000; $i--){
        //Blir et array som inneholder de innleggsdatoene der år = $i
        $temp = array();
        foreach($listPosts as $listPost){
            //Hvis året i $listPost tilsvarer året i $i, blir det lagt til i $temp
            if($listPost['year'] == $i){
                $temp[] = $listPost;
            }
        }
        //Hvis det ikke var ingen datoer med år = $i, avbrytes loopen siden det mest
        // sannsynelig ikke er noen innlegg i et tidligere år
        if(empty($temp)){
            break;
        }
        //Lager YearPostList med året $i, og en array datoene i året $i, som parametre.
        $yearPostList[] = new YearPostList( $i, $temp);
    }
    $smarty->assign('postList', $yearPostList);
}